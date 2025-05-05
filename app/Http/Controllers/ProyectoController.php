<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedencia;
use App\Models\ProcedenciaCodigo;
use App\Models\Tipologia;
use App\Models\Programa;
use App\Models\Proyecto;
use App\Http\Controllers\DataTable\BaseDataTableController;
use DB;
use Carbon\Carbon;
use App\Contracts\FileUploaderInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class ProyectoController extends BaseDataTableController
{
    public $perPage = 10;

    public function __construct()
    {
        $this->model = Proyecto::class;
        $this->view = 'proyectos.index';
        $this->keyPrimary = 'codigo';
        $this->perPage = 10;

        $this->columns = [
            'codigo',
            'nombre',
            'programa.nombre',
            'duracion',
            'costo_formateado',
            'created_at'
        ];

        $this->searchFields = [
            'nombre',
            'objetivo_general',
            'investigadores.nombre',
            'programa.nombre',
        ];

        $this->withRelations = [
            'programa',
            'procedenciaCodigo',
            'tipologia',
            'investigadores:nombre'
        ];

        $this->filters = [
            'programa_id' => function($query, $value) {
                $query->whereHas('programa', fn($q) => $q->where('id', $value));
            },
            'anio' => fn($query, $value) => $query->where('anio', $value),
            'codigo_grupo' => fn($query, $value) => $query->where('codigo', 'like', $value . '%')
        ];
    }

    protected function customOrderBy($query, $field, $direction)
    {
        if ($field === 'duracion') {
            $query->orderByRaw('DATEDIFF(fecha_fin, fecha_inicio) ' . $direction);
        }elseif ($field === 'costo_formateado') {
            $query->orderBy('proyectos.costo', $direction);
        }else {
            parent::applyCustomOrder($query, $field, $direction);
        }
    }

/*     public function getBaseData($item)
    {
        return array_map(function($field) use ($item) {
            switch ($field) {
                case 'programa':
                    return $item->programa->nombre ?? null;
                case 'costo_formateado':
                    return '$'.number_format($item->costo, 2, ',', '.');
                case 'created_at':
                    return $item->created_at->format('d/m/Y');
                case 'nombre_link':
                    return view('components.opcion-link', ['model' => $item, 'route' => 'proyectos', 'param'=>['search'=>$item->codigo]])->render();
                case 'acciones':
                    return '<div class="d-flex flex-wrap gap-1 justify-content-center">
                        <a href="'.route('proyectos.edit', $item->codigo).'" class="btn btn-success btn-circle">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        '.$this->getActionButtons($item).'
                    </div>';
                default:
                    return $item->$field ?? null;
            }
        }, $this->columns);
    }
 */
    protected function transformResults($results)
    {
        return $results->map(function($proyecto) {
            return [
                'codigo' => $proyecto->codigo,
                'nombre_link' => view('components.opcion-link', ['model' => $proyecto, 'route' => 'proyecto.por.codigo', 'param'=>$proyecto->codigo])->render(),
                'programa' => $proyecto->programa_nombre ?? ($proyecto->programa->nombre ?? ''),
                'duracion' => $proyecto->duracion,
                'costo_formateado' => '$'.number_format($proyecto->costo, 2, ',', '.'),
                'created_at' => $proyecto->created_at->format('d/m/Y'),
                'acciones' => view('components.action-buttons', ['id_model' => $proyecto->{$this->keyPrimary}, 'route' => 'proyectos'])->render()
            ];
        });
    }

    protected function getViewData()
    {
        return [
            'programas' => Programa::all(),
            'procedenciaCodigos' => ProcedenciaCodigo::all(),
            'tipologias' => Tipologia::all()
        ];
    }


    public function agruparProyectosPorProgramaAnio()
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

    public function proyectosPorCodigo(Request $request, $codigo){
        $proyecto = Proyecto::with('programa', 'procedencia', 'tipologia', 'investigadores', 'investigadoresHistoricos')->where('codigo', $codigo)->firstOrFail();
        $investigadoresPaginados = $proyecto->investigadores()->paginate(8);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'tarjetas' => View::make('proyectos.partials.investigadores', [
                    'investigadores' => $investigadoresPaginados
                ])->render(),
                'paginacion' => View::make('proyectos.partials.paginacion', [
                    'paginator' => $investigadoresPaginados
                ])->render(),
            ]);
        }
        $fechaActual = Carbon::now();

        $estadoColor = 'red';

        if ($fechaActual->greaterThan($proyecto->fecha_fin)) {
            $estadoColor = 'green';
        } elseif ($fechaActual->between($proyecto->fecha_inicio, $proyecto->fecha_fin)) {
            $estadoColor = 'yellow';
        }

        return view('proyectos.mostrar_proyecto', compact('proyecto', 'investigadoresPaginados', 'estadoColor'));
    }

    public function investigadoresParciales($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $investigadores = $proyecto->investigadores()->paginate(8);

        return response()->json([
            'tarjetas' => View::make('proyectos.partials.investigadores', [
                'investigadores' => $investigadores
            ])->render(),
            'paginacion' => View::make('proyectos.partials.paginacion', [
                'paginator' => $investigadores
            ])->render(),
        ]);

    }

    public function obtenerMetadatosPdf(Request $request, FileUploaderInterface $uploader){
        $pdfUrl = $request->header('X-PDF-Url');

        if (!$pdfUrl) {
            return response()->json(['error' => 'URL no proporcionada'], 400);
        }

            $data = null;

            try {
                $data = $uploader->getDataFile($pdfUrl);
            } catch (\Exception $e) {
                \Log::warning("Error al acceder al PDF en Cloudinary: " . $e->getMessage());

                $data = [
                    'nombre' => 'No disponible',
                    'descripcion' => $e->getMessage(),
                    'tamaño' => 'N/A',
                    'url'=>$pdfUrl
                ];
            }
            return response()->json($data);
    }


    public function create(){
        $procedencias = Procedencia::all();
        $procedenciaCodigos = ProcedenciaCodigo::all();
        $tipologias = Tipologia::all();
        $programas = Programa::all();


        return view('proyectos.crear_proyecto', compact('procedencias', 'procedenciaCodigos', 'tipologias', 'programas'));
    }

    public function store(Request $request, FileUploaderInterface $uploader){
        $validatedData = $request->validate([
            'nombre'=>'required|string|max:255',
            'objetivo_general'=>'required|string|max:2000',
            'programa_id'=>'required|integer|exists:programas,id',
            'procedencia_id'=>'required|integer|exists:procedencias,id',
            'procedencia_codigo_id'=>'required|integer|exists:procedencia_codigos,id',
            'tipologia_id'=>'required|integer|exists:tipologias,id',
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date|after:fecha_inicio',
            'pdf_file' => 'nullable|file',
            'costo' => [
                'required',
                'numeric',
                'min:0',
                'regex:/^\d{1,13}(\.\d{1,2})?$/'
            ],
            'investigadores_nombres' => 'sometimes|array',
            'investigadores_nombres.*' => 'nullable|string|max:255',
        ]
    );

        // Calcular el año a partir de la fecha de inicio
        $anio = Carbon::parse($validatedData['fecha_inicio'])->year;

        // Validar el doble envio de la peticion
        $exists = Proyecto::where('nombre', $request->nombre)
            ->where('objetivo_general', $request->objetivo_general)
            ->where('anio', $anio)
            ->exists();

        if ($exists) {
            return back()->withErrors(['El proyecto ya fue registrado anteriormente.']);
        }

        // Eliminar anio en caso de se inserte fuera del frontend
        unset($validatedData['anio']);

        $proyectoData = collect($validatedData)->except(['investigadores_ids', 'investigadores_nombres', 'pdf_file'])->toArray();
        $proyecto = new Proyecto($proyectoData);
        $proyecto->generarCodigo();

        // Subir PDF
        if (isset($validatedData['pdf_file'])) {
            try {
                $validatedData['pdf_url'] = $uploader->subir($validatedData['pdf_file'], $proyecto);
            } catch (\Exception $e) {
                return back()->withErrors(['pdf_file' => $e->getMessage()])->withInput();
            }
        }
        $proyecto->save();

        // Agregar investigadores
        $nuevosInvestigadores = $validatedData["investigadores_nombres"] ?? [];

        $proyecto->agregarInvestigadoresPorNombre($nuevosInvestigadores, []);

        return redirect()->back()
            ->with('success', 'Proyecto creado exitosamente');
    }
    public function edit($codigo){
        $proyecto = Proyecto::with('investigadores')->where('codigo', $codigo)->firstOrFail();
        $procedencias = Procedencia::all();
        $procedenciaCodigos = ProcedenciaCodigo::all();
        $tipologias = Tipologia::all();
        $programas = Programa::all();


        return view('proyectos.crear_proyecto', compact('procedencias', 'procedenciaCodigos', 'tipologias', 'programas', 'proyecto'));
    }
    public function update(Request $request, Proyecto $proyecto, FileUploaderInterface $uploader){
        $validatedData = $request->validate([
            'nombre'=>'required|string|max:255',
            'objetivo_general'=>'required|string|max:2000',
            'programa_id'=>'required|integer|exists:programas,id',
            'procedencia_id'=>'required|integer|exists:procedencias,id',
            'procedencia_codigo_id'=>'required|integer|exists:procedencia_codigos,id',
            'tipologia_id'=>'required|integer|exists:tipologias,id',
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date|after:fecha_inicio',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
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
            if (isset($validatedData['pdf_file'])) {
                try {
                    $validatedData['pdf_url'] = $uploader->subir($validatedData['pdf_file'],  $proyecto);
                } catch (\Exception $e) {
                    return back()->withErrors(['pdf_file' => $e->getMessage()])->withInput();
                }
            }

            $proyectoData = collect($validatedData)->except(['investigadores_ids', 'investigadores_nombres', 'pdf_file'])->toArray();

            $proyecto->fill($proyectoData);

            if ($proyecto->isDirty('fecha_inicio') || $proyecto->isDirty('programa_id') ||
                $proyecto->isDirty('procedencia_codigo_id') || $proyecto->isDirty('tipologia_id')) {
                $proyecto->generarCodigo(); // Regenerar el código
                $proyecto->pdf_url = $proyecto->pdf_url ? $uploader->renombrarArchivo($proyecto->pdf_url, $proyecto->codigo): null;
            }
            $proyecto->update();

            $idsActivos = $validatedData['investigadores_ids'] ?? [];
            $nuevosInvestigadores = $validatedData['investigadores_nombres'] ?? [];

            $proyecto->eliminarInvestigadoresRemovidos($idsActivos);

            $proyecto->agregarInvestigadoresPorNombre($nuevosInvestigadores, $idsActivos);

            DB::commit();

            return redirect()->route('proyectos.edit', ['proyecto' => $proyecto->codigo])
                ->with('success', 'Proyecto actualizado exitosamente');

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
