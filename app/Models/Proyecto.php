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

    public function generarCodigo()
    {
        // Obtener sufijo del programa
        $sufijoPrograma = $this->programa->sufijo ?? Programa::find($this->programa_id)->sufijo;

        // Obtener año desde fecha_inicio
        $anio = Carbon::parse($this->fecha_inicio)->year;

        $this->codigo = self::generarCodigoUnico(
            $sufijoPrograma,
            $this->procedencia_codigo_id,
            $this->tipologia_id,
            $anio
        );
    }

    public static function generarCodigoUnico($programaSufijo, $procedenciaCodigoId, $tipologiaId, $anio)
    {
        $baseCodigo = "{$programaSufijo}-{$procedenciaCodigoId}-{$tipologiaId}-{$anio}";

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

    public function agregarInvestigadoresPorNombre(array $nombres, array $idsActivos): void
    {
        $idsActivosFiltrados = array_filter(
            $idsActivos,
            fn($id) => is_numeric($id) && $id > 0
        );
        $nombresNuevos = array_filter(
            $nombres ?? [],
            fn($nombre) => !is_null($nombre) && trim($nombre) !== ''
        );
        foreach ($nombresNuevos as $nombre) {
            $this->agregarInvestigadorConRestauracionInteligente($nombre, $idsActivosFiltrados);
        }
    }

    /**
     * Agrega un investigador al proyecto, restaurando el vínculo si fue eliminado hace poco.
     *
     * @param string $nombre Nombre del investigador a agregar.
     * @param array $idsActivos IDs de investigadores activos para evitar duplicados.
     */
    public function agregarInvestigadorConRestauracionInteligente(string $nombre, array $investigadoresIds): void
    {
        $nombre = trim($nombre);

        $investigador = Investigador::firstOrCreate(['nombre' => $nombre]);

        if (in_array($investigador->id, $investigadoresIds)) {
            return;
        }
        $vinculoEliminado = InvestigadorProyecto::withTrashed()
            ->where('proyecto_id', $this->id)
            ->where('investigador_id', $investigador->id)
            ->whereNotNull('deleted_at')
            ->latest('deleted_at')
            ->first();

        if ($vinculoEliminado && $vinculoEliminado->deleted_at->gt(now()->subMinutes(10))) {
            $vinculoEliminado->restore();
        } else {
            InvestigadorProyecto::create([
                'proyecto_id' => $this->id,
                'investigador_id' => $investigador->id,
                'created_at' => now(),
            ]);
        }

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
            ->withPivot('created_at', 'deleted_at')
            ->wherePivotNotNull('deleted_at')
            ->orderByPivot('created_at', 'asc');
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
            if (empty($proyecto->anio) && !empty($proyecto->fecha_inicio)) {
                $proyecto->anio = Carbon::parse($proyecto->fecha_inicio)->year;
            }
        });

        static::updating(function ($proyecto) {
            if ($proyecto->isDirty('fecha_inicio')) {
                $proyecto->anio = Carbon::parse($proyecto->fecha_inicio)->year;
            }
        });
    }
}
