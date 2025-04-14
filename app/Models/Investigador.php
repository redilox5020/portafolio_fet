<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Investigador extends Model
{
    use HasFactory;

    protected $table = 'investigadores';

    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    public function proyectos(): BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class, 'investigador_proyecto', 'investigador_id', 'proyecto_id');
    }
}
