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
     * @return string URL segura del archivo subido.
     */
    public function subir(UploadedFile $archivo, Proyecto $proyecto): string;
}
