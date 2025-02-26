<?php

class ProyectoService
{


    public function registrar($validateData)
    {
        Proyecto::create($validateData);
    }
}
