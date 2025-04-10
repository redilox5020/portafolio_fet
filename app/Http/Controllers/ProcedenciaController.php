<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedencia;
use App\Models\ProcedenciaCodigo;
use App\Models\Tipologia;
use App\Models\Programa;
use App\Models\Proyecto;
use App\Models\Investigador;
use DB;

class ProcedenciaController extends BaseSelectController
{
    public function __construct()
    {
        $this->model = Procedencia::class;
        $this->view = 'selects.procedencia';
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'opcion'=>'required|string'
        ]);
        $procedencia = Procedencia::create($validatedData);

        if($request->ajax()){
            return response()->json([
                'success'=> 'Procedencia creada exitosamente',
                'data'=> [
                    'id' => $procedencia->id,
                    'label' => $procedencia->opcion
                ]
            ]);
        }

        return redirect()->back()
            ->with('success', 'Procedencia creada exitosamente');
    }
}
