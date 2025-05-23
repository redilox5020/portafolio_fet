<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FileDriver;

class Archivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver',
        'nombre_original',
        'file_id',
        'url',
        'mime_type',
        'tamanio',
        'descripcion',
        'archivable_type',
        'archivable_id',
        'subido_por'
    ];

    protected $casts = [
        'driver' => FileDriver::class,
    ];

    public function getStorageDriver(): FileDriver
    {
        return $this->driver;
    }

    public function archivable()
    {
        return $this->morphTo();
    }

    public function subidoPor()
    {
        return $this->belongsTo(User::class, 'subido_por');
    }
}
