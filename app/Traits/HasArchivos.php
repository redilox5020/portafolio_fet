<?php

namespace App\Traits;

use App\Models\Archivo;

trait HasArchivos
{
    /**
     * Relación polimórfica con los archivos
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivable');
    }

    /**
     * Obtener los archivos PDF asociados al modelo
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function pdfs()
    {
        return $this->archivos()->where('mime_type', 'application/pdf')->get();
    }

    /**
     * Obtener los archivos de imagen asociados al modelo
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function imagenes()
    {
        return $this->archivos()->where('mime_type', 'like', 'image/%')->get();
    }

    /**
     * Obtener archivos por tipo MIME
     *
     * @param string $mimeType El tipo MIME a buscar
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function archivosPorTipo(string $mimeType)
    {
        return $this->archivos()->where('mime_type', 'like', $mimeType)->get();
    }
}
