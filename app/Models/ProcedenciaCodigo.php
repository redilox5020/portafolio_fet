<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedenciaCodigo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'opcion'
    ];

    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class);
    }
}
