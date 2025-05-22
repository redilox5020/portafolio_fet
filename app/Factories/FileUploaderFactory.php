<?php

namespace App\Factories;


use App\Contracts\FileUploaderInterface;
use App\Services\CloudinaryUploaderService;
use App\Services\LocalStorageUploaderService;
use Illuminate\Support\Facades\App;
use App\Enums\FileDriver;

class FileUploaderFactory
{
    /**
     * Crea una instancia del servicio de carga de archivos según el tipo especificado
     *
     * @param string $type Tipo de almacenamiento ('cloudinary' o 'local')
     * @return FileUploaderInterface
     */
    public static function create(FileDriver $type): FileUploaderInterface
    {
        return match($type) {
            FileDriver::CLOUDINARY => App::make(CloudinaryUploaderService::class),
            FileDriver::LOCAL => App::make(LocalStorageUploaderService::class),
            default => throw new \InvalidArgumentException("Tipo de almacenamiento no válido: {$type}")
        };
    }
}
