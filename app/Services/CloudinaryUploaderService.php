<?php

namespace App\Services;
use Illuminate\Support\Str;
use Cloudinary;
use Cloudinary\Api\Exception\NotFound;
//use Cloudinary\Api\Admin\AdminApi;
use Illuminate\Http\UploadedFile;
use Exception;
use App\Contracts\FileUploaderInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FileDriver;
use App\Models\Archivo;

class CloudinaryUploaderService implements FileUploaderInterface
{
    protected string $folder;
    protected int $maxSize;

    public function __construct(string $folder = 'pdfs', int $maxSizeMB = 10)
    {
        $this->folder = $folder;
        $this->maxSize = $maxSizeMB * 1024 * 1024;
    }

    public function subir(?UploadedFile $archivo, Model $model): array
    {
        if (!$archivo->isValid()) {
            throw new Exception("El archivo no es válido o está dañado.");
        }

        if ($archivo->getSize() > $this->maxSize) {
            throw new Exception("El archivo excede el tamaño máximo de " . ($this->maxSize / 1048576) . "MB.");
        }

        $modelName = class_basename($model);

        $cloudinaryFolder = $this->folder . '/' . strtolower($modelName) . '/' . $model->getKey();

        $uploadResult = Cloudinary::upload($archivo->getPathname(), [
            'folder' => $cloudinaryFolder,
            'resource_type' => 'auto',
            'context' => [
                'descripcion' => $archivo->getClientOriginalName(),
                'model_type' => $modelName,
                'model_id' => $model->getKey()
            ]
        ]);

        return [
            'driver' => 'cloudinary',
            'nombre_original' => $archivo->getClientOriginalName(),
            'file_id' => $uploadResult->getPublicId(),
            'url' => $uploadResult->getSecurePath(),
            'mime_type' => $archivo->getClientMimeType(),
            'tamanio' => $archivo->getSize(),
            'descripcion' => $model->nombre ?? 'Archivo subido a ' . $modelName . ' #' . $model->getKey(),
            'subido_por' => auth()->id()
        ];
    }

    public function getDataFile(string $url, $archivoModel = null, $modelId = null): array
    {
        if ($archivoModel) {
            $originalFilename = pathinfo($archivoModel->nombre_original, PATHINFO_FILENAME);
            //$downloadUrl = str_replace('upload/', "upload/fl_attachment:{$originalFilename}/", $archivoModel->url);
            return [
                'id' => $archivoModel->id,
                'nombre' => $archivoModel->nombre_original,
                'descripcion' => $archivoModel->descripcion,
                'tamaño' => Str::toReadableSize($archivoModel->tamanio),
                'url' => $archivoModel->url,
                'tipo' => $this->getMimeTypeCategory($archivoModel->mime_type),
                'driver' => 'cloudinary'
            ];
        }
        try{
            $publicId = $this->extractPublicIdFromUrl($url);
            $data = Cache::remember("cloudinary_pdf_{$publicId}", now()->addHours(12), function () use ($publicId, $modelId) {
                $resource = Cloudinary::Admin()->asset($publicId);
                $originalFilename = $resource['original_filename'] ?? basename($publicId);
                $downloadUrl = str_replace('upload/', "upload/fl_attachment:{$originalFilename}/", $resource['secure_url']);
                Archivo::create([
                    'driver' => FileDriver::CLOUDINARY,
                    'nombre_original' => $originalFilename,
                    'file_id' => $publicId,
                    'url' => $resource['secure_url'],
                    'mime_type' => 'application/pdf',
                    'tamanio' => $resource['bytes'],
                    'descripcion' => $resource['context']['custom']['descripcion'] ?? 'Sin descripción',
                    'archivable_type' => 'App\Models\Proyecto',
                    'archivable_id' => $modelId ?? 1,
                    'subido_por' => auth()->id()
                ]);
                return [
                    'nombre' => $originalFilename,
                    'descripcion' => $resource['context']['custom']['descripcion'] ?? 'Sin descripción',
                    'tamaño' => Str::toReadableSize($resource['bytes']),
                    'url' => $downloadUrl,
                    'tipo' => 'image'
                ];
            });
            return $data;
        } catch (NotFound $e) {
            throw new \Exception("El archivo ya no existe en Cloudinary.");
        } catch (\Exception $e) {
            throw new \Exception("Error al obtener el recurso desde Cloudinary: " . $e->getMessage());
        }
    }

    public function renombrarArchivo(string $urlActual, string $nuevoNombre): string
    {
        try {
            $publicIdActual = $this->extractPublicIdFromUrl($urlActual);

            $partes = explode('/', $publicIdActual);
            $carpeta = count($partes) > 1 ? $partes[0] : $this->folder;
            $nuevoPublicId = "{$carpeta}/{$nuevoNombre}";

            $resultado = Cloudinary::rename($publicIdActual, $nuevoPublicId);

            return $resultado['secure_url'];
        } catch (NotFound $e) {
            throw new \Exception("El archivo no existe y no se puede renombrar.");
        } catch (\Exception $e) {
            throw new \Exception("Error al renombrar el archivo: " . $e->getMessage());
        }
    }

    public function eliminar(string $publicId): void
    {
        try {
            Cloudinary::destroy($publicId, [
                'invalidate' => true
            ]);
        } catch (NotFound $e) {
            throw new \Exception("El archivo no existe o ya fue eliminado de Cloudinary.");
        } catch (\Exception $e) {
            throw new \Exception("Error al eliminar el archivo en Cloudinary: " . $e->getMessage());
        }
    }

    public function getPathFromUrl(string $url): string
    {
        return parse_url($url, PHP_URL_PATH);
    }

    private function extractPublicIdFromUrl($url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $parts = explode('/', $path);
        $filename = end($parts);
        $publicId = substr($filename, 0, strrpos($filename, '.'));
        return implode('/', array_slice($parts, -2, 1)) . '/' . $publicId;
    }

    protected function getMimeTypeCategory(string $mimeType): string
    {
        if (strpos($mimeType, 'image/') === 0) {
            return 'image';
        } elseif (strpos($mimeType, 'video/') === 0) {
            return 'video';
        } elseif (strpos($mimeType, 'audio/') === 0) {
            return 'audio';
        } elseif ($mimeType === 'application/pdf') {
            return 'pdf';
        } elseif (strpos($mimeType, 'text/') === 0) {
            return 'text';
        } else {
            return 'document';
        }
    }
}
