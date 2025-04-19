<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
class InvestigadorProyecto extends Pivot
{
    use SoftDeletes;

    protected $table = 'investigador_proyecto';

    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = ['proyecto_id', 'investigador_id', 'created_at'];
    protected $dates = ['created_at', 'deleted_at'];

    public function investigador() {
        return $this->belongsTo(Investigador::class);
    }
    public function proyecto() {
        return $this->belongsTo(Proyecto::class);
    }
}
