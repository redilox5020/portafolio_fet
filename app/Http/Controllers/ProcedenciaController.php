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
        Procedencia::create($validatedData);

        return redirect()->back()
            ->with('success', 'Procedencia creada exitosamente');
    }

    public function destroy(string $id)
    {
        $procedencia = Procedencia::findOrFail($id);

        $procedencia->delete();

        return redirect()->back()->with('success', "Opcion de procedencia eliminada correctamente");
    }
}
