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
use App\Models\Proyecto;

class PdfUploaderService implements FileUploaderInterface
{
    protected string $folder;
    protected int $maxSize;

    public function __construct(string $folder = 'pdfs', int $maxSizeMB = 10)
    {
        $this->folder = $folder;
        $this->maxSize = $maxSizeMB * 1024 * 1024;
    }

    public function subir(?UploadedFile $archivo, Proyecto $proyecto): string
    {
        if (!$archivo->isValid()) {
            throw new Exception("El archivo PDF no es válido o está dañado.");
        }

        if ($archivo->getMimeType() !== 'application/pdf') {
            throw new Exception("El archivo debe ser un PDF.");
        }

        if ($archivo->getSize() > $this->maxSize) {
            throw new Exception("El archivo excede el tamaño máximo de " . ($this->maxSize / 1048576) . "MB.");
        }

        $uploadResult = Cloudinary::upload($archivo->getPathname(), [
            'folder' => $this->folder,
            'resource_type' => 'auto',
            'public_id'=> $proyecto->codigo,
            'context' => ['descripcion' => $proyecto->nombre]
        ]);

        return $uploadResult->getSecurePath();
    }

    public function getDataFile(string $url): array
    {
        try{
            $publicId = $this->extractPublicIdFromUrl($url);
            $data = Cache::remember("cloudinary_pdf_{$publicId}", now()->addHours(12), function () use ($publicId) {
                $resource = Cloudinary::Admin()->asset($publicId);
                $originalFilename = $resource['original_filename'] ?? basename($publicId);
                $downloadUrl = str_replace('upload/', "upload/fl_attachment:{$originalFilename}/", $resource['secure_url']);
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


    private function extractPublicIdFromUrl($url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $parts = explode('/', $path);
        $filename = end($parts);
        $publicId = substr($filename, 0, strrpos($filename, '.'));
        return implode('/', array_slice($parts, -2, 1)) . '/' . $publicId;
    }
}
