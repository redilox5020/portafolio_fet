<?php

namespace App\Http\Controllers;

use App\Models\ProcedenciaCodigo;

class ProcedenciaCodigoController extends BaseSelectController
{
    public function __construct()
    {
        $this->model = ProcedenciaCodigo::class;
        parent::__construct();
    }
}
