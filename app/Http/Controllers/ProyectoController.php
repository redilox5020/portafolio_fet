<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedencia;
use App\Models\ProcedenciaCodigo;
use App\Models\Tipologia;
use App\Models\Programa;

class ProyectoController extends Controller
{
    public function create(){
        $procedencias = Procedencia::all();
        $procedenciaCodigos = ProcedenciaCodigo::all();
        $tipologias = Tipologia::all();
        $programas = Programa::all();


        return view('crearProyecto', compact('procedencias', 'procedenciaCodigos', 'tipologias', 'programas'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([

        ]);
        #Generar el codigo

        #Obtener el sufjo del programa seleccionado

        #Obtener el id de la opcion del campo procedencia_codigo

        #Obtener el id de la opciion del campo tiipologia
    }
}
