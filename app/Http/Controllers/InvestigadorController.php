<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investigador;

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

}
