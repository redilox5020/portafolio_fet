<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TipologiaController;
use App\Http\Controllers\ProcedenciaController;
use App\Http\Controllers\ProcedenciaCodigoController;
use App\Http\Controllers\ProgramaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/proyectos/crear', [ProyectoController::class, 'create'])
    ->name('proyectos.create');

Route::post('/proyectos/crear', [ProyectoController::class, 'store'])
    ->name('proyectos.store');

Route::get('/tipologias/crear', [TipologiaController::class, 'create'])
    ->name('tipologia.create');

Route::post('/tipologias/crear', [TipologiaController::class, 'store'])
    ->name('tipologia.store');

Route::post('/procedencias/crear', [ProcedenciaController::class, 'store'])
    ->name('procedencia.store');

Route::post('/programas/crear', [ProgramaController::class, 'store'])
    ->name('programa.store');

Route::post('/procedencia-codigos/crear', [ProcedenciaCodigoController::class, 'store'])
    ->name('procedencia.codigo.store');

Route::get('/', [ProyectoController::class, 'index'])
    ->name('inicio');

Route::get('/proyectos/programa/{programa}', [ProyectoController::class, 'proyectosPorPrograma'])
    ->name('proyectos.por.programa');

Route::get('/proyectos/codigo/', [ProyectoController::class, 'proyectosPorGrupoCodigo'])
    ->name('proyectos.por.grupo.codigo');

Route::get('/proyectos/buscar', [ProyectoController::class, 'buscarProyectos'])
    ->name('proyectos.busqueda');

Route::get('/proyectos/programa/{programa}/anio/{anio}', [ProyectoController::class, 'proyectosPorAnio'])
    ->name('proyectos.por.anio');

Route::get('/proyectos', [ProyectoController::class, 'findAll'])
    ->name('proyectos');

Route::get('/proyectos/{codigo}', [ProyectoController::class, 'proyectosPorCodigo'])
    ->name('proyecto.por.codigo');


    Route::get('/proyectos/{proyecto}/edit', [ProyectoController::class, 'edit'])->name('proyectos.edit');
    Route::put('/proyectos/{proyecto}', [ProyectoController::class, 'update'])->name('proyectos.update');
