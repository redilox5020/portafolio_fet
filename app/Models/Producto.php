<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasArchivos;

class Producto extends Model
{
    use HasFactory, HasArchivos;

    protected $fillable = [
        'codigo',
        'proyecto_id',
        'titulo',
        'tipologia_id',
        'descripcion',
        'enlace'
    ];

public function generarCodigo()
    {
        $tipologiaProducto = $this->tipologia_id;
        $codigoProyectoOriginal = $this->proyecto->codigo ?? '000000';
        $codigoProyecto = str_replace('-', '', $codigoProyectoOriginal);
        $ultimoProducto = self::where('proyecto_id', $this->proyecto_id)
                            ->whereNotNull('codigo')
                            ->latest('id')
                            ->first();
        $consecutivo = 1;
        if ($ultimoProducto) {
            $partes = explode('-', $ultimoProducto->codigo);
            $ultimoNumero = end($partes);
            $consecutivo = is_numeric($ultimoNumero) ? $ultimoNumero + 1 : 1;
        }
        $secuencia = str_pad($consecutivo, 2, '0', STR_PAD_LEFT);
        $baseCodigo = "{$tipologiaProducto}-{$codigoProyecto}-{$secuencia}";
        $this->codigo = $baseCodigo;

        return $baseCodigo;
    }

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($producto) {
            if (empty($producto->codigo)) {
                $producto->generarCodigo();
            }
        });
    }
}
