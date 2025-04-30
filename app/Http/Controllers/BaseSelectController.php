<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DataTable\BaseDataTableController;
use Illuminate\Support\Str;

abstract class BaseSelectController extends BaseDataTableController
{
    protected $namePrimary = 'id';
    protected $formFieldValidated = [
        'opcion' => 'required|string|max:255'
    ];

    public function __construct()
    {
        if (empty($this->columns)) {
            $this->columns = ['id', 'opcion'];
        }
        if (empty($this->searchFields)) {
            $this->searchFields = ['opcion'];
        }
        if (empty($this->model)) {
            throw new \LogicException('El modelo no ha sido definido en el controlador hijo.');
        }
        if (empty($this->namePrimary)) {
            throw new \LogicException('El nombre de la columna primaria no ha sido definido en el controlador hijo.');
        }
        $this->view = $this->view ?? 'selects.' . Str::snake(class_basename($this->model));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate($this->formFieldValidated);

        $item = $this->model::create($validatedData);

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Registro creado exitosamente',
                'data' => [
                    'id' => $item->id,
                    'label' => $item->opcion
                ]
            ]);
        }

        return redirect()->back()
            ->with('success', 'Registro creado exitosamente');
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
