<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DataTable\BaseDataTableController;
use App\Models\Producto;
use App\Models\Proyecto;

class ProductoController extends BaseDataTableController
{
    protected $model = Producto::class;
    protected $keyPrimary = 'titulo';
    protected $view = 'productos.index';
    protected $columns = [
        'id',
        'titulo',
        'tipologia',
        'descripcion',
        'enlace'
    ];
    protected $searchFields = [
        'titulo',
        'descripcion'
    ];
    protected $withRelations = [
        'tipologia'
    ];

    public function __construct()
    {
        $this->filters = [
            'proyecto_id' => function ($query, $value) {
                return $query->where('proyecto_id', $value);
            }
        ];
    }

    protected function transformResults($results)
    {
        return $results->map(function($producto) {
            return [
                'id' => $producto->id,
                'titulo' => view('components.opcion-link', ['model' => $producto,'title'=>$producto->{$this->keyPrimary}, 'route' => 'productos.show', 'param'=>$producto->id])->render(),
                'tipologia' => $producto->tipologia,
                'enlace' => $producto->enlace,
                'acciones' => view('components.action-buttons', ['id_model' => $producto->id, 'is_modal' => true, 'modal' => "#modal-crear-producto"])->render()
            ];
        });
    }

    public function show(Request $request, $id)
    {
        $producto = Producto::with(['tipologia', 'autores:id,nombre'])->findOrFail($id);

        if($request->ajax()){
            return response()->json($producto);
        }

        return view('productos.show', compact('producto'));
    }

    public function create()
    {
        $tipologias = \App\Models\Tipologia::where('model_type', 'producto')->get();
        return view('productos.create', compact('tipologias'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'proyecto_id' => 'required|integer|exists:proyectos,id',
            'titulo' => 'required|string|max:255',
            'tipologia_id' => 'required|integer|exists:tipologias,id',
            'descripcion' => 'nullable|string',
            'enlace' => 'nullable|url',
            'autores_ids' => 'sometimes|array',
            'autores_ids.*' => 'nullable|integer|exists:investigadores,id',
        ]);

        $productoData = collect($validatedData)->except(['autores_ids'])->toArray();
        $producto = Producto::create($productoData);

        $producto->autores()->sync($request->input('autores_ids'));

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Producto creado exitosamente',
                'data' => $producto
            ]);
        }
        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'proyecto_id' => 'required|integer|exists:proyectos,id',
            'titulo' => 'required|string|max:255',
            'tipologia_id' => 'required|integer|exists:tipologias,id',
            'descripcion' => 'nullable|string',
            'enlace' => 'nullable|url',
            'autores_ids' => 'sometimes|array',
            'autores_ids.*' => 'nullable|integer|exists:investigadores,id',
        ]);

        $producto = Producto::findOrFail($id);
        $productoData = collect($validatedData)->except(['autores_ids'])->toArray();
        $producto->update($productoData);

        if ($request->has('autores_ids')) {
            $producto->autores()->sync($request->input('autores_ids'));
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Producto actualizado exitosamente',
                'data' => $producto
            ]);
        }

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Request $request, int $id)
    {
        $producto = Producto::findOrFail($id);
        if ($producto->archivos()->exists()) {
            if (!$request->ajax()) {
                return redirect()->back()->withErrors(['No se puede eliminar el producto porque tiene archivos asociados.']);
            }
            return response()->json([
                'error' => 'No se puede eliminar el producto porque tiene archivos asociados.'
            ], 422);
        }

        $producto->delete();

        if (!$request->ajax()) {
            return redirect()->back()->with('success', 'Producto eliminado exitosamente');
        }
        return response()->json([
            'success' => 'Producto eliminado exitosamente'
        ]);
    }
}
