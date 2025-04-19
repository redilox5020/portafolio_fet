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
