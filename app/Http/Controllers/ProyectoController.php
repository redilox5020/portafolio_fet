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

class ProyectoController extends Controller
{
    public $perPage = 10;
    public function index()
    {
        // Obtener los datos de los programas y proyectos agrupados por programa y año
        $datos = Proyecto::with('programa')
            ->selectRaw('programa_id, anio, COUNT(*) as cuenta_de_programa')
            ->groupBy('programa_id', 'anio')
            ->orderBy('programa_id')
            ->orderBy('anio')
            ->get();

        // Calcular el total acumulado por programa
        $totalesPorPrograma = [];
        foreach ($datos as $dato) {
            if (!isset($totalesPorPrograma[$dato->programa_id])) {
                $totalesPorPrograma[$dato->programa_id] = 0;
            }
            $totalesPorPrograma[$dato->programa_id] += $dato->cuenta_de_programa;
        }

        $totalGeneral = Proyecto::count();
        $procedenciaCodigos = ProcedenciaCodigo::all();
        $tipologias = Tipologia::all();
        $programas = Programa::all();

        return view('programas.index', compact('datos', 'totalesPorPrograma', 'totalGeneral', 'procedenciaCodigos','tipologias','programas'));
    }

    public function buscarProyectos(Request $request){
        $proyectos = Proyecto::withOnly(['investigadores:nombre'])
            ->when($request->search && strlen($request->search) >= 4, function ($query) use ($request){
                $query->where('nombre', 'like', "%{$request->search}%")
                    ->orWhere('objetivo_general', 'like', "%{$request->search}%")
                    ->orWhereHas('investigadores', function ($query) use ($request){
                        $query->where('nombre', 'like', "%{$request->search}%");
                    });
            })
            ->paginate($this->perPage);

            return view('proyectos.index', compact('proyectos'));
    }

    public function proyectosPorGrupoCodigo(Request $request){
        $validatedData = $request->validate([
            'programa_sufijo'=>'required|string',
            'procedencia_codigo_id'=>'required|integer|exists:procedencia_codigos,id',
            'tipologia_id'=>'required|integer|exists:tipologias,id',
            'anio' => 'required|integer|digits:4|min:2010|max:2100',
        ]);

        $codigo = "{$validatedData['programa_sufijo']}-{$validatedData['procedencia_codigo_id']}-{$validatedData['tipologia_id']}-{$validatedData['anio']}";
        $proyectos = Proyecto::where("codigo", "like", "{$codigo}%")
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);

        $proyectos->withQueryString();

        return view('proyectos.index', compact('proyectos'));
    }

    public function proyectosPorPrograma($programaId)
    {
        $programa = Programa::findOrFail($programaId);
        $proyectos = $programa->proyectos()->paginate($this->perPage);

        return view('proyectos.index', compact('programa', 'proyectos'));
    }

    public function proyectosPorAnio($programaId, $anio)
    {
        $programa = Programa::findOrFail($programaId);
        $proyectos = $programa->proyectos()
            ->where('anio', $anio)
            ->paginate($this->perPage);

        return view('proyectos.index', compact('programa', 'proyectos', 'anio'));
    }

    public function proyectosPorCodigo($codigo){
        $proyecto = Proyecto::with('programa', 'procedencia', 'tipologia', 'investigadores')->findOrFail($codigo);

        return view('proyectos.mostrar_proyecto', compact('proyecto'));
    }

    public function findAll(){
        $proyectos = Proyecto::orderBy('codigo', 'desc')->paginate($this->perPage);

        return view('proyectos.index', compact('proyectos'));
    }

    public function create(){
        $procedencias = Procedencia::all();
        $procedenciaCodigos = ProcedenciaCodigo::all();
        $tipologias = Tipologia::all();
        $programas = Programa::all();


        return view('proyectos.crear_proyecto', compact('procedencias', 'procedenciaCodigos', 'tipologias', 'programas'));
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
            'fecha_fin'=>'required|date|after:fecha_inicio',
            'anio' => 'required|integer|digits:4|min:2010|max:2100',
            'costo' => [
                'required',
                'numeric',
                'min:0',
                'regex:/^\d{1,13}(\.\d{1,2})?$/'
            ],
            'investigadores_nombres' => 'sometimes|array',
            'investigadores_nombres.*' => 'nullable|string|max:255',
        ]);

        #Obtener el sufjo del programa seleccionado
        $sufijoPrograma = Programa::find($validatedData['programa_id'])->sufijo;

        #Obtener el id de la opcion del campo procedencia_codigo
        $idProcedenciaCodigo = $validatedData['procedencia_codigo_id'];
        #Obtener el id de la opciion del campo tiipologia
        $idTipologia = $validatedData['tipologia_id'];

        $anio = $validatedData['anio'];

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

        foreach ($validatedData["investigadores_nombres"] as $nombre) {
            if(!empty($nombre)){
            $investigador = Investigador::firstOrCreate(['nombre' => $nombre]);
            $investigadoresIds[] = $investigador->id;
            }
        }
        #Asociar investigadores al proyecto attach
        $proyecto->investigadores()->sync($investigadoresIds);

        return redirect()->back()
            ->with('success', 'Proyecto creado exitosamente');
    }
    public function edit($codigo){
        $proyecto = Proyecto::with('investigadores')->findOrFail($codigo);
        $procedencias = Procedencia::all();
        $procedenciaCodigos = ProcedenciaCodigo::all();
        $tipologias = Tipologia::all();
        $programas = Programa::all();


        return view('proyectos.crear_proyecto', compact('procedencias', 'procedenciaCodigos', 'tipologias', 'programas', 'proyecto'));
    }
    public function update(Request $request, Proyecto $proyecto){
        $validatedData = $request->validate([
            'nombre'=>'required|string|max:255',
            'objetivo_general'=>'required|string',
            'programa_id'=>'required|integer|exists:programas,id',
            'procedencia_id'=>'required|integer|exists:procedencias,id',
            'procedencia_codigo_id'=>'required|integer|exists:procedencia_codigos,id',
            'tipologia_id'=>'required|integer|exists:tipologias,id',
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date|after:fecha_inicio',
            'anio' => 'required|integer|digits:4|min:2010|max:2100',
            'costo' => [
                'required',
                'numeric',
                'min:0',
                'regex:/^\d{1,13}(\.\d{1,2})?$/'
            ],
            'investigadores_ids' => 'sometimes|array',
            'investigadores_ids.*' => 'nullable|integer|exists:investigadores,id',
            'investigadores_nombres' => 'sometimes|array',
            'investigadores_nombres.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $proyectoData = $request->except(['investigadores_ids', 'investigadores_nombres']);
            $proyecto->update($proyectoData);

            $investigadoresIds = $validatedData['investigadores_ids'] ?? [];
            $proyecto->investigadores()->sync($investigadoresIds);

            $nuevosInvestigadores = $validatedData['investigadores_nombres'] ?? [];
            foreach ($nuevosInvestigadores as $nombre) {
                if(!empty($nombre)){
                    $investigador = Investigador::firstOrCreate(['nombre' => $nombre]);
                    $proyecto->investigadores()->attach($investigador->id);
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Proyecto actualizado exitosamente');
        } catch (\Exception $e) {

            dd($e);
            DB::rollback();
            return redirect()->back()->with('error', 'Error al actualizar el proyecto: ' . $e->getMessage());
        }
    }
}
