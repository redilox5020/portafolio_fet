<?php

namespace App\Services;

use App\Contracts\FileUploaderInterface;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocalStorageUploaderService implements FileUploaderInterface
{
    protected string $folder;
    protected int $maxSize;
    protected string $disk;

    public function __construct(string $folder = 'pdfs', int $maxSizeMB = 10, string $disk = 'public')
    {
        $this->folder = $folder;
        $this->maxSize = $maxSizeMB * 1024 * 1024;
        $this->disk = $disk;
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

        $rutaAlmacenamiento = $this->folder . '/' . strtolower($modelName) . '/' . $model->getKey();

        $nombreOriginal = $archivo->getClientOriginalName();
        $nombreArchivo = pathinfo($nombreOriginal, PATHINFO_FILENAME) . '_' . time() . '.' . $archivo->getClientOriginalExtension();

        $path = $archivo->storeAs($rutaAlmacenamiento, $nombreArchivo, $this->disk);

        $url = Storage::disk($this->disk)->url($path);

        return [
            'driver' => 'local',
            'nombre_original' => $nombreOriginal,
            'file_id' => $path,
            'url' => $url,
            'mime_type' => $archivo->getClientMimeType(),
            'tamanio' => $archivo->getSize(),
            'descripcion' => $model->nombre ?? 'Archivo subido a ' . $modelName . ' #' . $model->getKey(),
            'subido_por' => auth()->id()
        ];
    }

    public function getDataFile(string $url, $archivoModel = null, $modelId = null): array
    {
        $path = $this->getPathFromUrl($url);
        if ($archivoModel) {
            $datos = [
                'id' => $archivoModel->id,
                'nombre' => $archivoModel->nombre_original,
                'descripcion' => $archivoModel->descripcion,
                'tamaño' => Str::toReadableSize($archivoModel->tamanio),
                'url' => $archivoModel->url,
                'tipo' => $this->getMimeTypeCategory($archivoModel->mime_type),
                'driver' => 'local'
            ];

            // Verifica que el archivo siga existiendo físicamente
            if (Storage::disk($this->disk)->exists($archivoModel->file_id)) {
                $datos['last_modified'] = Storage::disk($this->disk)->lastModified($archivoModel->file_id);
                $datos['existe'] = true;
            } else {
                $datos['existe'] = false;
            }

            return $datos;
        }

        if (!Storage::disk($this->disk)->exists($path)) {
            throw new Exception("El archivo no existe en el almacenamiento local.");
        }

        $fileSize = Storage::disk($this->disk)->size($path);
        $nombreOriginal = basename($path);
        $mimeType = Storage::disk($this->disk)->mimeType($path);

        return [
            'nombre' => $nombreOriginal,
            'descripcion' => 'Archivo local',
            'tamaño' => Str::toReadableSize($fileSize),
            'url' => Storage::disk($this->disk)->url($path),
            'tipo' => $this->getMimeTypeCategory($mimeType),
            'driver' => 'local',
            'last_modified' => Storage::disk($this->disk)->lastModified($path)
        ];
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

    public function getPathFromUrl(string $url): string
    {
        return str_replace('/storage/', '', parse_url($url, PHP_URL_PATH));
    }

    public function renombrarArchivo(string $pathActual, string $nuevoNombre): string
    {
        if (!Storage::disk($this->disk)->exists($pathActual)) {
            throw new Exception("El archivo no existe en el almacenamiento local.");
        }

        $directorioActual = dirname($pathActual);
        $extension = pathinfo($pathActual, PATHINFO_EXTENSION);
        $nuevoPath = $directorioActual . '/' . $nuevoNombre . '.' . $extension;

        // Verificar que el nuevo nombre no exista ya
        if (Storage::disk($this->disk)->exists($nuevoPath)) {
            throw new Exception("Ya existe un archivo con ese nombre en el mismo directorio.");
        }

        // Renombrar archivo (copiar y eliminar)
        Storage::disk($this->disk)->copy($pathActual, $nuevoPath);
        Storage::disk($this->disk)->delete($pathActual);

        return Storage::disk($this->disk)->url($nuevoPath);
    }

    public function eliminar(string $path): void
    {
        if (!Storage::disk($this->disk)->exists($path)) {
            throw new Exception("El archivo no existe o ya fue eliminado del almacenamiento local.");
        }

        Storage::disk($this->disk)->delete($path);
    }
}
