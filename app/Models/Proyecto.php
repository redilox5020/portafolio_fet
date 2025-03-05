<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Proyecto extends Model
{
    use HasFactory;

    protected $primaryKey = "codigo";

    public $incrementing = false;

    protected $keyType = "string";

    protected $fillable = [
        'codigo',
        'nombre',
        'objetivo_general',
        'programa_id',
        'procedencia_id',
        'procedencia_codigo_id',
        'tipologia_id',
        'fecha_inicio',
        'fecha_fin',
        'anio',
        'costo',
        'pdf_url'
    ];
    public function getDuracionAttribute()
    {
        $fechaInicio = Carbon::parse($this->fecha_inicio);
        $fechaFin = Carbon::parse($this->fecha_fin);

        // Calcular la diferencia en años, meses, días, horas, minutos y segundos
        $diferencia = $fechaInicio->diff($fechaFin);

        // Construir la duración de manera dinámica
        $duracion = [];

        if ($diferencia->y > 0) {
            $duracion[] = $diferencia->y . ' año' . ($diferencia->y > 1 ? 's' : '');
        }
        if ($diferencia->m > 0) {
            $duracion[] = $diferencia->m . ' mes' . ($diferencia->m > 1 ? 'es' : '');
        }
        if ($diferencia->d > 0) {
            $duracion[] = $diferencia->d . ' día' . ($diferencia->d > 1 ? 's' : '');
        }
        if ($diferencia->h > 0) {
            $duracion[] = $diferencia->h . ' hora' . ($diferencia->h > 1 ? 's' : '');
        }
        if ($diferencia->i > 0) {
            $duracion[] = $diferencia->i . ' minuto' . ($diferencia->i > 1 ? 's' : '');
        }
        if ($diferencia->s > 0) {
            $duracion[] = $diferencia->s . ' segundo' . ($diferencia->s > 1 ? 's' : '');
        }

        // Unir las partes de la duración en una cadena legible
        return implode(', ', $duracion);
    }

    public function investigadores(): BelongsToMany
    {
        return $this->belongsToMany(Investigador::class, 'investigador_proyecto', 'proyecto_id', 'investigador_id');
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($proyecto) {
            if (empty($proyecto->anio)) {
                $proyecto->anio = date('Y');
            }
        });
    }
}
