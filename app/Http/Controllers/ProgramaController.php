<?php

namespace App\Http\Controllers;

use App\Models\Programa;

class ProgramaController extends BaseSelectController
{
    public function __construct()
    {
        $this->model = Programa::class;
        $this->searchFields = ['nombre', 'sufijo'];
        $this->columns = ['id', 'nombre','sufijo'];
        $this->namePrimary = "nombre";
        $this->formFieldValidated = [
            'nombre' => 'required|string|max:255',
            'sufijo' => 'required|string|max:255'
        ];
        parent::__construct();
    }
}
