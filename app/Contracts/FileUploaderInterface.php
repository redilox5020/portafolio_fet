<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;
use App\Models\Proyecto;

interface FileUploaderInterface
{
    /**
     * Sube un archivo al almacenamiento externo.
     *
     * @param UploadedFile $archivo
     * @param Proyecto $proyecto
     * @return array datos del archivo subido.
     */
    public function subir(UploadedFile $archivo, Proyecto $proyecto): array;

    /**
     * Obtiene los datos del archivo a partir de su URL.
     *
     * @param string $url
     * @return array{nombre: mixed, descripcion: mixed, tamaño: mixed, url: string|string[], tipo: string} Datos del archivo.
     */
    public function getDataFile(string $url): array;

    /**
     * Renombra un archivo en el almacenamiento externo.
     *
     * @param string $urlActual URL actual del archivo.
     * @param string $nuevoNombre Nuevo nombre para el archivo.
     */
    public function renombrarArchivo(string $urlActual, string $nuevoNombre): string;

    public function eliminar(string $publicId): void;
}
