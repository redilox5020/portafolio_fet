<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class BaseDataTableController extends Controller
{
    protected $model;
    protected $view;
    protected $columns = [];
    protected $searchFields = [];
    protected $keyPrimary = 'id';
    protected $withRelations = [];
    protected $filters = [];
    protected $defaultOrder = ['column' => 0, 'dir' => 'asc'];
    protected $perPage = 10;

    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return $this->nonAjaxResponse($request);
        }

        $query = $this->buildBaseQuery();
        $this->applyCustomFilters($query, $request);
        $this->applySearch($query, $request->input('search.value'));
        $this->applyOrdering($query, $request);

        $total = $query->count();
        $results = $this->getPaginatedResults($query, $request);

        $data = $this->transformResults($results);

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $this->getTotalRecords(),
            'recordsFiltered' => $total,
            'data' => $data
        ]);
    }

    protected function nonAjaxResponse()
    {
        if (!empty($this->view)) {
            return view($this->view, $this->getViewData());
        }
        abort(403, 'Acceso denegado');
    }

    protected function buildBaseQuery()
    {
        return $this->model::query()->with($this->withRelations);
    }

    protected function applyCustomFilters($query, Request $request)
    {
        foreach ($this->filters as $filter => $callback) {
            if ($request->has($filter)) {
                call_user_func($callback, $query, $request->$filter, $request);
            }
        }
    }

    protected function applySearch($query, $search)
    {
        if (!is_array($this->searchFields)) return;
        if (empty($search) || empty($this->searchFields)) return;

        $query->where(function($q) use ($search) {
            foreach ($this->searchFields as $i => $field) {
                if (str_contains($field, '.')) {
                    $this->applyRelationSearch($q, $field, $search, $i === 0);
                } else {
                    $i === 0
                        ? $q->where($field, 'like', "%$search%")
                        : $q->orWhere($field, 'like', "%$search%");
                }
            }
        });


    }

    protected function applyRelationSearch($query, $field, $search, $isFirst)
    {
        [$relation, $column] = explode('.', $field);
        $method = $isFirst ? 'whereHas' : 'orWhereHas';

        $query->$method($relation, function($q) use ($column, $search) {
            $q->where($column, 'like', "%$search%");
        });
    }

    protected function applyOrdering($query, Request $request)
    {
        $orderColumn = $request->input('order.0.column', $this->defaultOrder['column']);
        $orderDir = $request->input('order.0.dir', $this->defaultOrder['dir']);

        if (isset($this->columns[$orderColumn])) {
            $orderField = $this->columns[$orderColumn];
            if (method_exists($this, 'customOrderBy')) {
                $this->customOrderBy($query, $orderField, $orderDir);
                return;
            }
            $this->applyCustomOrder($query, $orderField, $orderDir);
        }
    }

    protected function applyCustomOrder($query, $field, $direction)
    {
        if (str_contains($field, '.')) {
            $this->orderByRelation($query, $field, $direction);
        } else {
            $query->orderBy($field, $direction);
        }
    }

    protected function orderByRelation($query, $field, $direction)
    {
        [$relation, $column] = explode('.', $field);

        $model = new $this->model();
        if (!method_exists($model, $relation)) {
            return;
        }
        $relationInstance = $model->{$relation}();

        $related = $relationInstance->getRelated();
        $foreignKey = $relationInstance->getQualifiedForeignKeyName();
        $ownerKey = $relationInstance->getQualifiedOwnerKeyName();

        return $query->orderBy(
            $related::select($column)
                ->whereColumn($ownerKey, $foreignKey),
            $direction
        );
    }



    protected function getPaginatedResults($query, Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', $this->perPage);
        return $query->skip($start)->take($length)->get();
    }

    protected function getTotalRecords()
    {
        return $this->model::count();
    }

    protected function transformResults($results)
    {
        return $results->map(function ($item) {
            $values = $this->getBaseData($item);
            return array_combine(
                $this->columns,
                $values
            ) + [
                'acciones' => $this->getActionButtons($item)
            ];
        });
    }

    protected function getBaseData($item)
    {
        return array_map(function($field) use ($item) {
            return $item->$field ?? null;
        }, $this->columns);
    }

    protected function getActionButtons($item)
    {
        return !$this->hasDependencies($item)
            ? $this->getDeleteButton($item->{$this->keyPrimary})
            : $this->getDisabledDeleteButton($item->{$this->keyPrimary});
    }

    protected function hasDependencies($item)
    {
        return method_exists($item, 'proyectos') ? $item->proyectos()->exists() : false;
    }

    protected function getDeleteButton($id)
    {
        return '<a class="btn btn-danger btn-circle delete-btn"
                data-id="'.$id.'"
                data-toggle="modal"
                data-target="#deleteModal">
                <i class="fa-solid fa-trash"></i>
            </a>';
    }

    protected function getDisabledDeleteButton($id)
    {
        return '<span class="d-inline-block"
                tabindex="0" data-toggle="tooltip" data-placement="top"
                title="No se puede eliminar porque está asociado a uno o más proyectos">
                <a class="btn btn-danger btn-circle" style="pointer-events: none; opacity: 0.5">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </span>';
    }

    protected function getViewData()
    {
        return [];
    }

    protected function beforeQuery($query) {}
    protected function afterQuery($query) {}
}
