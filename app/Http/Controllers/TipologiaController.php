<?php

namespace App\Http\Controllers;

use App\Models\Tipologia;

class TipologiaController extends BaseSelectController
{
    protected $model = Tipologia::class;

    protected $formFieldValidated = [
        'opcion' => 'required|string|max:255',
        'model_type' => 'required|string|max:8',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->columns[] = 'model_type';
    }

}
