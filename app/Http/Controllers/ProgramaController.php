<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedencia;
use App\Models\ProcedenciaCodigo;
use App\Models\Tipologia;
use App\Models\Programa;
use App\Models\Proyecto;
use App\Models\Investigador;
use DB;

class ProgramaController extends BaseSelectController
{
    public function __construct()
    {
        $this->model = Programa::class;
        $this->fields = ['nombre', 'sufijo'];
        $this->columns = ['id', 'nombre','sufijo'];
        $this->view = 'selects.programa';
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'nombre'=>'required|string|max:255',
            'sufijo'=>'required|string'
        ]);
        Programa::create($validatedData);

        return redirect()->back()
            ->with('success', 'Programa creado exitosamente');
    }

    public function destroy(string $id)
    {
        $programa = Programa::findOrFail($id);

        $programa->delete();

        return redirect()->back()->with('success', "Programa eliminado correctamente");
    }
}
