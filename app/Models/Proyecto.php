<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $primaryKey = "codigo";

    public $incrementing = false;

    protected $keyType = "string";

    protected $fillable = [
        'nombre',
        'objetivo_general',
        'programa_id',
        'procedencia_id',
        'procedencia_codigo_id',
        'tipologia_id',
        'fecha_inicio',
        'fecha_fin',
        'costo'
    ];

    public function investigadores(): BelongsToMany{
        return $this->belongsToMany(Investigador::class, 'investigador_proyecto', 'investigador_id', 'proyecto_id');
    }

    public function programa():  BelongsTo
    {
        return $this->belongsTo(Programa::class);
    }

    public function procedencia(): BelongsTo
    {
        return $this->belongsTo(Procedencia::class);
    }

    public function procedenciaCodigo(): BelongsTo
    {
        return $this->belongsTo(ProcedenciaCodigo::class);
    }

    public function tipologia(): BelongsTo
    {
        return $this->belongsTo(Tipologia::class);
    }
}
