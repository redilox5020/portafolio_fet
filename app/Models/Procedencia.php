<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Procedencia extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'opcion'
    ];

    public function detalles()
    {
        return $this->hasMany(ProcedenciaDetalle::class);
    }

    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class);
    }
}
