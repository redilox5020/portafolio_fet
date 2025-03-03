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

class TipologiaController extends Controller
{
    public function create(){
        $select = 'Tipologia';
        return view('selects.index', compact("select"));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'opcion'=>'required|string'
        ]);
        Tipologia::create($validatedData);

        return redirect()->back()
            ->with('success', 'Tipologia creada exitosamente');
    }
}
