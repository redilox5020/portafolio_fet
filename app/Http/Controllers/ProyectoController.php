<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedencia;
use App\Models\ProcedenciaCodigo;
use App\Models\Tipologia;
use App\Models\Programa;
use App\Models\Proyecto;
use App\Models\Investigador;

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
            'nombre'=>'required|string|max:255',
            'objetivo_general'=>'required|string',
            'programa_id'=>'required|integer|exists:programas,id',
            'procedencia_id'=>'required|integer|exists:procedencias,id',
            'procedencia_codigo_id'=>'required|integer|exists:procedencia_codigos,id',
            'tipologia_id'=>'required|integer|exists:tipologias,id',
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date',
            'costo' => [
                'required',
                'numeric',
                'min:0',
                'regex:/^\d{1,13}(\.\d{1,2})?$/'
            ],
            'investigadores' => 'required|array',
            'investigadores.*' => 'required|string|max:255',
        ]);

        #Obtener el sufjo del programa seleccionado
        $sufijoPrograma = Programa::find($validatedData['programa_id'])->sufijo;

        #Obtener el id de la opcion del campo procedencia_codigo
        $idProcedenciaCodigo = $validatedData['procedencia_codigo_id'];
        #Obtener el id de la opciion del campo tiipologia
        $idTipologia = $validatedData['tipologia_id'];

        $anio = date('Y');

        $baseCodigo="{$sufijoPrograma}-{$idProcedenciaCodigo}-{$idTipologia}-{$anio}";
        $ultimoProyecto = Proyecto::where("codigo", "like", "{$baseCodigo}%")->orderBy("codigo", "desc")->first();

        if($ultimoProyecto){
            $ultimoCodigo = $ultimoProyecto->codigo;
            $ultimoNumeroStr = substr($ultimoCodigo, strrpos($ultimoCodigo, '-') + 1);
            if(ctype_digit($ultimoNumeroStr)) {
                $ultimoNumero = intval($ultimoNumeroStr);
                $numeroIncremental = $ultimoNumero + 1;
            }else{
                $numeroIncremental = 1;
            }
        }else{
            $numeroIncremental = 1;
        }
        #Generar el codigo
        $validatedData['codigo']="{$baseCodigo}-{$numeroIncremental}";
        $proyecto = Proyecto::create($validatedData);

        #Agregar investigadores
        $investigadoresIds = [];

        foreach ($validatedData["investigadores"] as $nombre) {
            #Buscar o crear el investigador
            $investigador = Investigador::firstOrCreate(['nombre' => $nombre]);
            $investigadoresIds[] = $investigador->id;
        }
        #Asociar investigadores al proyecto attach
        $proyecto->investigadores()->sync($investigador->id);
    }
}
