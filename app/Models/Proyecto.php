<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasArchivos;

class Proyecto extends Model
{
    use HasFactory, HasArchivos;

    protected $fillable = [
        'codigo',
        'nombre',
        'objetivo_general',
        'programa_id',
        'procedencia_id',
        'procedencia_detalle_id',
        'tipologia_id',
        'fecha_inicio',
        'fecha_fin',
        'anio',
        'costo',
        'registered_by_name',
        'registered_by_email',
        'last_modified_by_name',
        'last_modified_by_email',
        'pdf_url'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    public function getDuracionAttribute()
    {
        // Calcular la diferencia en años, meses, días, horas, minutos y segundos
        $diferencia = $this->fecha_inicio->diff($this->fecha_fin);

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

    public function generarCodigo()
    {
        // Obtener sufijo del programa
        $sufijoPrograma = $this->programa->sufijo ?? Programa::find($this->programa_id)->sufijo;

        // Obtener año desde fecha_inicio
        $anio = $this->fecha_inicio->format('y');

        $this->codigo = self::generarCodigoUnico(
            $sufijoPrograma,
            $this->procedencia_id,
            $this->tipologia_id,
            $anio
        );
    }

    public static function generarCodigoUnico($programaSufijo, $procedenciaId, $tipologiaId, $anio)
    {
        $baseCodigo = $programaSufijo . $procedenciaId . $tipologiaId . $anio;

        // Buscar el último código que empiece igual
        $ultimoProyecto = self::where("codigo", "like", "{$baseCodigo}-%")
                            ->orderBy("codigo", "desc")
                            ->first();

        if ($ultimoProyecto) {
            $ultimoNumeroStr = substr($ultimoProyecto->codigo, strrpos($ultimoProyecto->codigo, '-') + 1);
            $numeroIncremental = is_numeric($ultimoNumeroStr) ? intval($ultimoNumeroStr) + 1 : 1;
        } else {
            $numeroIncremental = 1;
        }

        // Generar y verificar unicidad
        $nuevoCodigo = "{$baseCodigo}-{$numeroIncremental}";

        while (self::where('codigo', $nuevoCodigo)->exists()) {
            $numeroIncremental++;
            $nuevoCodigo = "{$baseCodigo}-{$numeroIncremental}";
        }

        return $nuevoCodigo;
    }

    public function agregarORestaurarInvestigador(int $investigadorId)
    {
        // 1. Verificar si ya existe un vínculo activo
        $isAttached = $this->investigadores()->where('investigador_id', $investigadorId)->exists();
        if ($isAttached) {
            return null; // Ya está activo, no hacer nada
        }

        // 2. Buscar un vínculo eliminado recientemente
        $vinculoEliminado = InvestigadorProyecto::withTrashed()
            ->where('proyecto_id', $this->id)
            ->where('investigador_id', $investigadorId)
            ->whereNotNull('deleted_at')
            ->latest('deleted_at')
            ->first();

        // 3. Restaurar si fue eliminado hace menos de 24 horas
        if ($vinculoEliminado && $vinculoEliminado->deleted_at->gt(now()->subHours(24))) {
            $vinculoEliminado->restore();
            return [ 'restore' => true, 'investigador_id' => $investigadorId ];
        }

        // 4. Crear un nuevo vínculo si no se pudo restaurar
        $nuevoVinculo = InvestigadorProyecto::create([
            'proyecto_id' => $this->id,
            'investigador_id' => $investigadorId,
            'created_at' => now(),
        ]);

        return [ 'restore' => false, 'investigador_id' => $investigadorId, 'pivot_id' => $nuevoVinculo->id ];
    }

    public function eliminarInvestigadoresRemovidos(array $idsActivos): void
    {
        $idsFiltrados = array_filter($idsActivos, fn($id) => is_numeric($id) && $id > 0);

        InvestigadorProyecto::where('proyecto_id', $this->id)
            ->whereNull('deleted_at')
            ->when(!empty($idsFiltrados), fn($query) =>
                $query->whereNotIn('investigador_id', $idsFiltrados)
            )
            ->get()
            ->each
            ->delete();
    }


    public function investigadores(): BelongsToMany
    {
        return $this->belongsToMany(Investigador::class)
            ->using(InvestigadorProyecto::class)
            ->withPivot('created_at', 'deleted_at')
            ->wherePivotNull('deleted_at');
    }

    public function investigadoresHistoricos(): belongsToMany
    {
        return $this->belongsToMany(Investigador::class)
            ->using(InvestigadorProyecto::class)
            ->withPivot('id','created_at', 'deleted_at')
            ->wherePivotNotNull('deleted_at')
            ->orderByPivot('created_at', 'asc');
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function actualizador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by');
    }

    public function programa():  BelongsTo
    {
        return $this->belongsTo(Programa::class);
    }

    public function procedencia(): BelongsTo
    {
        return $this->belongsTo(Procedencia::class);
    }

    public function procedenciaDetalle()
    {
        return $this->belongsTo(ProcedenciaDetalle::class);
    }

    public function tipologia(): BelongsTo
    {
        return $this->belongsTo(Tipologia::class);
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($producto) {
            if (empty($producto->codigo)) {
                $producto->generarCodigo();
            }
        });

        static::creating(function ($proyecto) {
            if (empty($proyecto->anio) && !empty($proyecto->fecha_inicio)) {
                $proyecto->anio = $proyecto->fecha_inicio->year;
            }
        });

        static::updating(function ($proyecto) {
            if ($proyecto->isDirty('fecha_inicio')) {
                $proyecto->anio = $proyecto->fecha_inicio->year;
            }
        });
    }
}
