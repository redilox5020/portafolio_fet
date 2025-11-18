<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Investigador extends Model
{
    use HasFactory;

    protected $table = 'investigadores';

    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'email',
        'tipo_documento',
        'documento',
        'telefono',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function proyectos(): BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class)
            ->using(InvestigadorProyecto::class)
            ->withPivot('created_at', 'deleted_at')
            ->wherePivotNull('deleted_at');
    }

    public function proyectosHistoricos()
    {
        return $this->belongsToMany(Proyecto::class)
            ->using(InvestigadorProyecto::class)
            ->withPivot('created_at', 'deleted_at')
            ->wherePivotNotNull('deleted_at');
    }
}
