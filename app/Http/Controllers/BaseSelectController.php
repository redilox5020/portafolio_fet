<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseSelectController extends Controller
{
    protected $model;
    protected $fields = 'opcion';
    protected $columns = ['id', 'opcion'];
    protected $view;

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
                'acciones' => '<a  class="btn btn-danger btn-circle delete-btn"
                                    data-id="'.$item->id.'"
                                    data-toggle="modal"
                                    data-target="#deleteModal">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>'
            ];
        });

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $this->model::count(),
            'recordsFiltered' => $total,
            'data' => $data
        ]);
    }
}
