<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;

abstract class BaseJoinDataTableController extends Controller
{
    protected $model;
    protected $view;
    protected $columns = [];
    protected $selectFields = [];
    protected $joins = [];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->buildBaseQuery();

            $this->applySearch($query, $request->input('search.value'));
            $this->applyOrdering($query, $request);

            $total = $query->count();
            $data = $query->skip($request->start ?? 0)
                        ->take($request->length ?? 10)
                        ->get();

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $this->model::count(),
                'recordsFiltered' => $total,
                'data' => $this->transformResults($data),
            ]);
        }

        return view($this->view);
    }

    protected function buildBaseQuery()
    {
        $query = $this->model::query()->select($this->selectFields);

        foreach ($this->joins as $join) {
            $query->leftJoin(...$join);
        }

        return $query;
    }

    protected function applySearch(Builder $query, $search)
    {
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                foreach ($this->selectFields as $field) {
                    if (str_contains($field, ' as ')) {
                        $field = explode(' as ', $field)[0];
                    }
                    $q->orWhere($field, 'like', "%$search%");
                }
            });
        }
    }

    protected function applyOrdering(Builder $query, Request $request)
    {
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir', 'asc');

        if (isset($this->columns[$orderColumn])) {
            $query->orderBy($this->columns[$orderColumn], $orderDir);
        }
    }

    abstract protected function transformResults($data);
}
