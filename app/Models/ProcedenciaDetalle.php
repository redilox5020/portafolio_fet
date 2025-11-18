<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcedenciaDetalle extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'procedencia_id',
        'opcion'
    ];

    public function procedencia(): BelongsTo
    {
        return $this->belongsTo(Procedencia::class);
    }

    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class);
    }
}
