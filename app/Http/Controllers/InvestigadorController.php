<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investigador;
use App\Models\InvestigadorProyecto;

class InvestigadorController extends BaseSelectController
{
    public function __construct()
    {
        $this->model = Investigador::class;
        $this->fields = ['nombre'];
        $this->columns = ['id', 'nombre'];
        $this->view = 'selects.investigador';
        $this->namePrimary = "nombre";
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
            $investigador->forceDelete();
        }
        return response()->json(
            [
                'success' => true,
                'ids' => $ids,
                'message' => 'Registros Historicos eliminados correctamente.'
            ]
        );
    }

    /* try {
            foreach ($selectedIds as $id) {
                $investigadorProyecto = InvestigadorProyecto::find($id);
                if ($investigadorProyecto) {
                    $investigadorProyecto->delete();
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'Investigador eliminado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el investigador: ' . $e->getMessage(),
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Error al eliminar el investigador',
        ]); */
}
