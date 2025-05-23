<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Tipologia extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable= [
        'opcion',
        'model_type'
    ];

    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class);
    }
}
