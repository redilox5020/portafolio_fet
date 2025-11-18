<?php

namespace App\Http\Controllers;

use App\Models\ProcedenciaDetalle;

class ProcedenciaDetalleController extends BaseSelectController
{
    protected $formFieldValidated = [
        'opcion' => 'required|string|max:255',
        'procedencia_id' => 'required|string|max:8',
    ];

    public function __construct()
    {
        $this->model = ProcedenciaDetalle::class;
        parent::__construct();
        $this->columns[] = 'procedencia_id';
    }
}
