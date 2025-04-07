<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface FileUploaderInterface
{
    /**
     * Sube un archivo al almacenamiento externo.
     *
     * @param UploadedFile $archivo
     * @return string URL segura del archivo subido.
     */
    public function subir(UploadedFile $archivo): string;
}
