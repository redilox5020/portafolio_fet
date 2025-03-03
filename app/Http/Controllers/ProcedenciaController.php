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

class ProcedenciaController extends Controller
{
    public function create(){
        $select = 'Procedencia';
        return view('selects.index', compact("select"));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'opcion'=>'required|string'
        ]);
        Procedencia::create($validatedData);

        return redirect()->back()
            ->with('success', 'Procedencia creada exitosamente');
    }
}
