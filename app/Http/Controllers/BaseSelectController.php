<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseSelectController extends Controller
{
    protected $model;
    protected $fields = 'opcion';           // campos de busqueda
    protected $columns = ['id', 'opcion'];  // campos de filtrado
    protected $view;
    protected $namePrimary = "opcion";      // campo de atributo nombre principal del registro

    public function index(Request $request)
    {
        $view = $this->view;
        if (!$request->ajax()){
            if(!empty($view)) return view($view);
            abort(403, 'Acceso denegado');
        };

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $search = $request->input('search.value');
        $orderColumn = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');

        $query = $this->model::query();


        $columns = $this->columns;
        if (!is_array($columns) || empty($columns)) {
            throw new \Exception('La variable $columns no está definida o no es un array válido.');
        }
        $fields = $this->fields;
        if ( empty($fields)){
            throw new \Exception('La variable $field no está definida o no es un tipo válido.');
        }

        if (!empty($search)) {
            if(is_string($fields)) $query->where($fields, 'like', "%$search%");
            elseif(is_array($fields)){
                for ($i=0; $i < count($fields) ; $i++) {
                    $field = $fields[$i];
                    if ($i == 0)  $query->where($field, 'like', "%$search%");
                    else $query->orWhere($field, 'like', "%$search%");
                }
            }
        }

        if (!empty($columns) && isset($columns[$orderColumn])) {
            $orderField = $columns[$orderColumn];
            $query->orderBy($orderField, $orderDir);
        }

        $total = $query->count();
        $registros = $query->skip($start)->take($length)->get();

        $data = $registros->map(function ($item) use ($columns) {
            $csrfToken = csrf_token();
            $values = array_map(fn($field) => $item->$field ?? null, $columns);

            return array_combine(
                $columns,
                $values
            ) + [
                'acciones' => !$item->proyectos()->exists() ? '
                <a  class="btn btn-danger btn-circle delete-btn"
                    data-id="'.$item->id.'"
                    data-toggle="modal"
                    data-target="#deleteModal">
                    <i class="fa-solid fa-trash"></i>
                </a>' : '
                <span class="d-inline-block"
                      tabindex="0" data-toggle="tooltip" data-placement="top"
                      title="No se puede eliminar '.$item->{$this->namePrimary}.' porque está asociado a uno o más proyectos">
                      <a class="btn btn-danger btn-circle" style="pointer-events: none; opacity: 0.5">
                          <i class="fa-solid fa-trash"></i>
                      </a>
                </span>'
            ];
        });

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $this->model::count(),
            'recordsFiltered' => $total,
            'data' => $data
        ]);
    }

    public function destroy(string $id)
    {
        $model = $this->model::findOrFail($id);

        $name = $model->{$this->namePrimary} ;

        if ($model->proyectos()->exists()) {
            return redirect()->back()->withErrors(['error' => "No se puede eliminar {$name} porque está asociado a uno o más proyectos."]);
        }

        $model->delete();

        return redirect()->back()->with('success', class_basename($model) . " '{$name}' eliminado correctamente");
    }
}
