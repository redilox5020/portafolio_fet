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

class ProgramaController extends BaseSelectController
{
    public function __construct()
    {
        $this->model = Programa::class;
        $this->fields = ['nombre', 'sufijo'];
        $this->columns = ['id', 'nombre','sufijo'];
        $this->view = 'selects.programa';
        $this->namePrimary = "nombre";
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'nombre'=>'required|string|max:255',
            'sufijo'=>'required|string|max:255'
        ]);
        $programa = Programa::create($validatedData);

        if($request->ajax()){
            return response()->json([
                'success'=> 'Programa creado exitosamente',
                'data'=> [
                    'id' => $programa->id,
                    'label' => $programa->nombre
                ]
            ]);
        }

        return redirect()->back()
            ->with('success', 'Programa creado exitosamente');
    }
}
