<?php

namespace App\Http\Controllers;

use App\Models\Procedencia;

class ProcedenciaController extends BaseSelectController
{
    public function __construct()
    {
        $this->model = Procedencia::class;
        parent::__construct();
    }
}
