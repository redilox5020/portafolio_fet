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
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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

        $programas = Programa::all();
        $tipologias = Tipologia::all();
        $procedenciaCodigos = ProcedenciaCodigo::all();
        $search = $request->search;

        return view('proyectos.index', compact('proyectos','programas','procedenciaCodigos','tipologias', 'search'));
    }

    public function proyectosPorGrupoCodigo(Request $request){
        $validatedData = $request->validate([
            'programa_sufijo'=>'required|string',
            'procedencia_codigo_id'=>'required|integer|exists:procedencia_codigos,id',
            'tipologia_id'=>'required|integer|exists:tipologias,id',
            'anio' => 'required|integer|digits:4|min:2010|max:2100',
        ]);

        $codigo = "{$validatedData['programa_sufijo']}-{$validatedData['procedencia_codigo_id']}-{$validatedData['tipologia_id']}-{$validatedData['anio']}";

        return redirect()->route('proyectos', [
            'codigo_grupo' => $codigo,
            'draw' => 1,
            'start' => 0,
            'length' => $this->perPage
        ]);
    }

    public function proyectosPorPrograma($programaId)
    {
        $programa = Programa::select(["nombre"])->findOrFail($programaId);
        return redirect()->route('proyectos', [
            'programa' => $programaId,
            'programa_nombre' => $programa->nombre ?? null,
            'draw' => 1,
            'start' => 0,
            'length' => $this->perPage
        ]);
    }

    public function proyectosPorAnio($programaId, $anio)
    {
        $programa = Programa::select(["nombre"])->findOrFail($programaId);
        return redirect()->route('proyectos', [
            'programa' => $programaId,
            'programa_nombre' => $programa->nombre ?? null,
            'anio' => $anio,
            'draw' => 1,
            'start' => 0,
            'length' => $this->perPage
        ]);
    }

    public function proyectosPorCodigo($codigo){
        $proyecto = Proyecto::with('programa', 'procedencia', 'tipologia', 'investigadores')->findOrFail($codigo);

        return view('proyectos.mostrar_proyecto', compact('proyecto'));
    }

    public function findAll(Request $request)
    {
        if ($request->ajax()) {
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $search = $request->input('search.value');
            $orderColumn = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir');

            $query = Proyecto::with(['programa', 'procedenciaCodigo', 'tipologia', 'investigadores:nombre']);

            // Aplicar filtros existentes si están presentes

            if ($request->has('programa_id')) {
                $query->whereHas('programa', function($eq) use ($request) {
                    $eq->where('id', $request->programa_id);
                });
            }

            if ($request->has('anio')) {
                $query->where('anio', $request->anio);
            }

            if ($request->has('codigo_grupo')) {
                $query->where('codigo', 'like', $request->codigo_grupo . '%');
            }


            //
            if (!empty($search)) {
                $query->when(strlen($search) >= 4, function ($q) use ($search){
                    $q->where('nombre', 'like', "%$search%")
                    ->orWhere('objetivo_general', 'like', "%$search%")
                    ->orWhereHas('investigadores', function($q) use ($search) {
                        $q->where('nombre', 'like', "%$search%");
                    });

                });
            }

            // Ordenamiento
            $columns = ['codigo', 'nombre', 'programa.nombre', 'duracion', 'costo'];
            if (isset($columns[$orderColumn])) {
                $orderField = $columns[$orderColumn];
                if ($orderField === 'duracion') {
                    // Ordenar por la diferencia en días
                    $query->orderByRaw('DATEDIFF(fecha_fin, fecha_inicio) ' . $orderDir);
                }
                elseif (str_contains($orderField, '.')) {
                    $relation = explode('.', $orderField)[0];
                    $query->whereHas($relation, function($q) use ($orderField, $orderDir) {
                        $q->orderBy(explode('.', $orderField)[1], $orderDir);
                    });
                } else {
                    $query->orderBy($orderField, $orderDir);
                }
            }

            $total = $query->count();
            $proyectos = $query->skip($start)->take($length)->get();

            $data = $proyectos->map(function($proyecto) {
                $csrfToken = csrf_token();

                return [
                    'codigo' => $proyecto->codigo,
                    'nombre_link' => '<a href="'.route('proyecto.por.codigo', $proyecto->codigo).'">'.$proyecto->nombre.'</a>',
                    'programa' => $proyecto->programa->nombre ?? '',
                    'duracion' => $proyecto->duracion,
                    'costo_formateado' => '$'.number_format($proyecto->costo, 2, ',', '.'),
                    'acciones' => '<div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <a href="'.route('proyectos.edit', $proyecto->codigo).'" class="btn btn-success btn-circle">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a  class="btn btn-danger btn-circle delete-btn"
                                    data-id="'.$proyecto->codigo.'"
                                    data-toggle="modal"
                                    data-target="#deleteModal">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>'
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => Proyecto::count(),
                'recordsFiltered' => $total,
                'data' => $data
            ]);
        }

        $programas = Programa::all();
        $procedenciaCodigos = ProcedenciaCodigo::all();
        $tipologias = Tipologia::all();

        return view('proyectos.index', compact('programas', 'procedenciaCodigos', 'tipologias'));
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
            'pdf_file' => 'nullable|mimes:pdf|max:2048',
            'costo' => [
                'required',
                'numeric',
                'min:0',
                'regex:/^\d{1,13}(\.\d{1,2})?$/'
            ],
            'investigadores_nombres' => 'sometimes|array',
            'investigadores_nombres.*' => 'nullable|string|max:255',
        ]);

        // Validar el doble envio de la peticion
        $exists = Proyecto::where('nombre', $request->nombre)
            ->where('objetivo_general', $request->objetivo_general)
            ->where('anio', $request->anio)
            ->exists();

        if ($exists) {
            return back()->withErrors(['El proyecto ya fue registrado anteriormente.']);
        }

        // Obtener el sufjo del programa seleccionado
        $sufijoPrograma = Programa::find($validatedData['programa_id'])->sufijo;

        // Obtener el id de la opcion del campo procedencia_codigo
        $idProcedenciaCodigo = $validatedData['procedencia_codigo_id'];
        // Obtener el id de la opciion del campo tiipologia
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
        // Generar el codigo
        $validatedData['codigo']="{$baseCodigo}-{$numeroIncremental}";

        // Subir PDF
        if(isset($validatedData['pdf_file'])){
            $pdfSubido = $validatedData['pdf_file'];
            $uploadResult = Cloudinary::upload($pdfSubido->getRealPath(), [
                'folder' => 'pdfs',
                'resource_type' => 'auto',
            ]);
            $validatedData['pdf_url'] = $uploadResult->getSecurePath();
        }

        $proyectoData = collect($validatedData)->except(['investigadores_ids', 'investigadores_nombres', 'pdf_file'])->toArray();

        $proyecto = Proyecto::create($proyectoData);

        // Agregar investigadores
        $investigadoresIds = [];

        foreach ($validatedData["investigadores_nombres"] as $nombre) {
            if(!empty($nombre)){
            $investigador = Investigador::firstOrCreate(['nombre' => $nombre]);
            $investigadoresIds[] = $investigador->id;
            }
        }
        // Asociar investigadores al proyecto attach
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
            'pdf_file' => 'nullable|mimes:pdf|max:2048',
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
            // Subir PDF
            if(isset($validatedData['pdf_file'])){
                $pdfSubido = $validatedData['pdf_file'];
                $uploadResult = Cloudinary::upload($pdfSubido->getRealPath(), [
                    'folder' => 'pdfs',
                    'resource_type' => 'auto',
                ]);
                $validatedData['pdf_url'] = $uploadResult->getSecurePath();
            }
            $proyectoData = collect($validatedData)->except(['investigadores_ids', 'investigadores_nombres', 'pdf_file'])->toArray();
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

    public function destroy(String $codigo){
        DB::delete('delete from proyectos where codigo = ?', [$codigo]);
        return redirect()->route('proyectos')->with('success', "Proyecto eliminado correctamente");
    }
}
