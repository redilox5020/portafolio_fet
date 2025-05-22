<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

interface FileUploaderInterface
{
    /**
     * Sube un archivo al servicio de almacenamiento
     *
     * @param UploadedFile|null $archivo El archivo a subir
     * @param Model $model El modelo al que se asociará el archivo
     * @return array Datos del archivo subido
     */
    public function subir(?UploadedFile $archivo, Model $model): array;

    /**
     * Obtiene los metadatos de un archivo
     *
     * @param string $url URL del archivo
     * @param mixed $archivoModel Instancia del modelo Archivo (opcional)
     * @param int|null $modelId ID del modelo relacionado (opcional)
     * @return array Datos del archivo
     */
    public function getDataFile(string $url, $archivoModel = null, $modelId = null): array;

    /**
     * Renombra un archivo
     *
     * @param string $pathActual Ruta o URL actual del archivo
     * @param string $nuevoNombre Nuevo nombre para el archivo
     * @return string Nueva URL del archivo
     */
    public function renombrarArchivo(string $pathActual, string $nuevoNombre): string;

    /**
     * Elimina un archivo
     *
     * @param string $path Ruta o identificador del archivo a eliminar
     * @return void
     */
    public function eliminar(string $path): void;
}
