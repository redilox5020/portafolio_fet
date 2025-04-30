<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investigador;
use App\Models\InvestigadorProyecto;
use App\Models\Proyecto;

class InvestigadorController extends BaseSelectController
{
    public function __construct()
    {
        $this->model = Investigador::class;
        $this->searchFields = ['nombre'];
        $this->columns = ['id', 'nombre', 'proyectos_count'];
        $this->namePrimary = "nombre";
        parent::__construct();
    }

    protected function buildBaseQuery()
    {
        return parent::buildBaseQuery()
            ->withCount('proyectos');
    }

    public function getBaseData($item)
    {
        return array_map(function($field) use ($item) {
            if($field !== 'nombre'){
                return $item->$field ?? null;
            }
            return view('components.opcion-link', ['model' => $item, 'route' => 'proyectos', 'param'=>['search'=>$item->$field]])->render();
        }, $this->columns);
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
