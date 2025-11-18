<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investigador;
use App\Models\InvestigadorProyecto;
use App\Models\Proyecto;
use Illuminate\Validation\Rule;

class InvestigadorController extends BaseSelectController
{
    public function __construct()
    {
        $this->model = Investigador::class;
        $this->searchFields = ['nombre', 'documento', 'email', 'telefono'];
        $this->columns = ['id', 'nombre', 'documento', 'email','telefono', 'proyectos_count'];
        $this->namePrimary = "nombre";
        $this->formFieldValidated = [
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:investigadores,email',
            'tipo_documento' => 'nullable|string|max:8',
            'documento' => 'nullable|string|max:50|unique:investigadores,documento',
            'telefono' => 'nullable|string|max:20',
        ];
        parent::__construct();
    }

    protected function buildBaseQuery()
    {
        return parent::buildBaseQuery()
            ->withCount('proyectos');
    }


    protected function transformResults($results)
    {
        return $results->map(function ($investigador) {
            $data = [];

            foreach ($this->columns as $field) {
                if ($field === "documento") {
                    $data[$field] = $investigador['tipo_documento'] . ' ' . $investigador['documento'];
                } elseif ($field === "nombre") {
                    $data[$field] = view('components.opcion-link', [
                        'model' => $investigador,
                        'route' => 'proyectos',
                        'param' => ['search' => $investigador->$field]
                    ])->render();
                } else {
                    $data[$field] = $investigador->$field ?? null;
                }
            }

            $data['acciones'] = view('components.action-buttons', [
                'id_model' => $investigador->id,
                'is_modal' => true,
                'modal' => '#modal-crear-investigador'
            ])->render();

            return $data;
        });
    }

    /**
     * Busca investigadores para Select2.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);

        if (!$term) {
            return response()->json(['results' => [], 'pagination' => ['more' => false]]);
        }

        $query = Investigador::query()
            ->where('nombre', 'LIKE', '%' . $term . '%')
            ->orWhere('documento', 'LIKE', '%' . $term . '%');

        /** @var \Illuminate\Pagination\LengthAwarePaginator $investigadores */
        $investigadores = $query->paginate(10, ['id', 'nombre', 'tipo_documento', 'documento'], 'page', $page);

        // Formatear la respuesta para Select2
        $results = $investigadores->map(function ($investigador) {
            return [
                'id' => $investigador->id,
                'text' => $investigador->nombre . ' (' . $investigador->tipo_documento .' - '. $investigador->documento . ')'
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => $investigadores->hasMorePages()
            ]
        ]);
    }

    public function show(Request $request, $id)
    {
        $investigador = $this->model::findOrFail($id);

        if($request->ajax()){
            return response()->json($investigador);
        }

        //return view('investigador.show', compact('investigador'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('investigadores', 'email')->ignore($id),
            ],
            'tipo_documento' => 'nullable|string|max:8',
            'documento' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('investigadores', 'documento')->ignore($id),
            ],
            'telefono' => 'nullable|string|max:20',
        ]);


        $investigador = $this->model::findOrFail($id);
        $investigador->update($validatedData);

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Investigador actualizado exitosamente',
                'data' => $investigador
            ]);
        }

        return redirect()->route('investigador.index')
            ->with('success', 'Investigador actualizado exitosamente');
    }


    public function destroyItemPivot(Request $request)
    {
        $selectedIds = $request->input('selectedIds');

        if (empty($selectedIds)) {
            return response()->json(['success' => false, 'message' => 'No se seleccionó ningún investigador.'], 400);
        }
        $ids = array_map('intval', $selectedIds);
        $investigadorProyecto = InvestigadorProyecto::withTrashed()->whereIn('id', $ids)->get();
        if ($investigadorProyecto->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No se encontraron investigadores.'], 404);
        }
        foreach ($investigadorProyecto as $investigador) {
            //$investigador->forceDelete();
        }
        return response()->json(
            [
                'success' => true,
                'ids' => $ids,
                'message' => 'Registros Historicos eliminados correctamente.'
            ]
        );
    }

    public function reactivarInvestigadores(Request $request, Proyecto $proyecto)
    {
        $selectedIds = $request->input('selectedIds', []);

        if (empty($selectedIds)) {
            return response()->json(['success' => false, 'message' => 'No se seleccionó ningún investigador.'], 400);
        }

        $ids = array_map('intval', $selectedIds);

        $investigadoresRestaurados = [];
        $errores = [];

        foreach ($ids as $id) {
            $restaurado = $proyecto->agregarInvestigadorConRestauracionInteligente(
                null,
                $proyecto->investigadores()->pluck('investigadores.id')->toArray(),
                $id
            );
            if ($restaurado) {
                $investigadoresRestaurados[] = $restaurado;
            }else{
                $investigador = $proyecto->investigadores()->find($id);
                $errores[] = $investigador
                    ? "{$investigador->nombre} ya fue revinculado con antelación."
                    : "El investigador con ID {$id} no se encuentra vinculado al proyecto.";
            }
        }
        return response()->json(
            [
                'success' => true,
                'ids' => $ids,
                'investigadoresRestaurados' => $investigadoresRestaurados,
                'errores' => $errores,
                'message' => empty($errores)
                    ? 'Investigadores reactivados correctamente.'
                    : 'Algunos investigadores no pudieron ser reactivados.',
            ]
        );
    }
}
