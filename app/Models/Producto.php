<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasArchivos;

class Producto extends Model
{
    use HasFactory, HasArchivos;

    protected $fillable = [
        'proyecto_id',
        'titulo',
        'tipologia_id',
        'descripcion',
        'enlace'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    public function tipologia()
    {
        return $this->belongsTo(Tipologia::class);
    }
    public function autores()
    {
        return $this->belongsToMany(Investigador::class, 'investigador_producto');
    }
    public function getAutores()
    {
        return $this->autores()->count() ? $this->autores() : $this->proyecto->investigadores();
    }
}
