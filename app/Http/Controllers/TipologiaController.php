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

class TipologiaController extends BaseSelectController
{
    public function __construct()
    {
        $this->model = Tipologia::class;
        $this->view = 'selects.tipologia';
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'opcion'=>'required|string'
        ]);
        $tipologia = Tipologia::create($validatedData);

        if($request->ajax()){
            return response()->json([
                'seccess'=> 'Tipologia creada exitosamente',
                'data'=> $tipologia->opcion
            ]);
        }

        return redirect()->back()
            ->with('success', 'Tipologia creada exitosamente');
    }

    public function destroy(string $id)
    {
        $tipologia = Tipologia::findOrFail($id);

        $tipologia->delete();

        return redirect()->back()->with('success', "Opcion tipologia eliminada correctamente");
    }
}
