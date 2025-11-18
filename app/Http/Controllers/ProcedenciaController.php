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

    public function opciones()
    {
        $procedencias = Procedencia::select('id', 'opcion')
            ->orderBy('opcion')
            ->get();

        return response()->json($procedencias);
    }
}
