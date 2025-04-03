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

class ProcedenciaCodigoController extends BaseSelectController
{
    public function __construct()
    {
        $this->model = ProcedenciaCodigo::class;
        $this->view = 'selects.procedencia_codigo';
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'opcion'=>'required|string'
        ]);
        ProcedenciaCodigo::create($validatedData);

        return redirect()->back()
            ->with('success', 'Procedencia Codigo creada exitosamente');
    }

    public function destroy(string $id)
    {
        $procedenciaCodigo = ProcedenciaCodigo::findOrFail($id);

        $procedenciaCodigo->delete();

        return redirect()->back()->with('success', "Opcion de Procedencia Codigo eliminada correctamente");
    }
}
