<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TipologiaController;
use App\Http\Controllers\ProcedenciaController;
use App\Http\Controllers\ProcedenciaCodigoController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
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

Route::middleware('guest')->group(function () {
    Route::get('login', [AdminController::class, 'login'])->name('login');
    Route::post('login', [AdminController::class, 'loginPost'])->name('logging');
    Route::get('register', [AdminController::class, 'register'])->name('register');
    Route::post('register', [AdminController::class, 'registerPost'])->name('register');

    Route::get('forgot-password', [AdminController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('forgot-password', [AdminController::class, 'forgotPasswordPost'])->name('password.email');
    Route::get('reset-password/{token}', [AdminController::class, 'resetPassword'])->name('password.reset');
    Route::post('reset-password', [AdminController::class, 'resetPasswordPost'])->name('password.update');

});
Route::get('logout', [AdminController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [ProyectoController::class, 'index'])
        ->name('inicio');

    Route::prefix('/admin')->group(function () {
        Route::prefix('/proyectos')->group(function () {
            // Filters
            Route::get('/', [ProyectoController::class, 'findAll'])
                ->name('proyectos');

            Route::get('programa/{programa}', [ProyectoController::class, 'proyectosPorPrograma'])
                ->name('proyectos.por.programa');

            Route::get('codigo', [ProyectoController::class, 'proyectosPorGrupoCodigo'])
                ->name('proyectos.por.grupo.codigo');

            Route::get('buscar', [ProyectoController::class, 'buscarProyectos'])
                ->name('proyectos.busqueda');

            Route::get('programa/{programa}/anio/{anio}', [ProyectoController::class, 'proyectosPorAnio'])
                ->name('proyectos.por.anio');

            // Ruta de creacion
            Route::get('crear', [ProyectoController::class, 'create'])
                ->middleware('can:proyecto.create')
                ->name('proyectos.create');

            Route::post('crear', [ProyectoController::class, 'store'])
                ->middleware('can:proyecto.create')
                ->name('proyectos.store');
            Route::delete('/delete/{id}', [ProyectoController::class, 'destroy'])
                ->name("destroy.project");
            // Ruta dinamica "Ver"
            Route::get('{codigo}', [ProyectoController::class, 'proyectosPorCodigo'])
                ->middleware('can:proyecto.view')
                ->name('proyecto.por.codigo');

            // Ruta dinamica de actualizacion
            Route::get('{proyecto}/edit', [ProyectoController::class, 'edit'])
                ->middleware('can:proyecto.edit')
                ->name('proyectos.edit');

            Route::put('{proyecto}', [ProyectoController::class, 'update'])
                ->middleware('can:proyecto.edit')
                ->name('proyectos.update');


        });

        Route::prefix('/tipologias')->group(function () {
            Route::get('crear', [TipologiaController::class, 'create'])
                ->middleware('can:tipologia.create')
                ->name('tipologia.create');

            Route::post('crear', [TipologiaController::class, 'store'])
                ->middleware('can:tipologia.create')
                ->name('tipologia.store');
        });

        Route::prefix('/procedencias')->group(function () {
            Route::post('crear', [ProcedenciaController::class, 'store'])
                ->middleware('can:procedencia.create')
                ->name('procedencia.store');
        });

        Route::prefix('/procedencia-codigos')->group(function () {
            Route::post('crear', [ProcedenciaCodigoController::class, 'store'])
                ->middleware('can:procedencia.codigo.create')
                ->name('procedencia.codigo.store');
        });

        Route::prefix('/programas')->group(function () {
            Route::post('crear', [ProgramaController::class, 'store'])
                ->middleware('can:programa.create')
                ->name('programa.store');
        });

        Route::prefix('/users')->group(function () {
            Route::get('/', [UserController::class, "index"])
                ->name('users');

            Route::get('{user}/edit', [UserController::class, 'edit'])
                ->name('user.edit');

            Route::put('{user}', [UserController::class, 'update'])
                ->name('user.update');
        });

        Route::prefix('/roles')->group(function () {
            Route::get('/', [RoleController::class, "index"])
                ->name('roles.index');;

            Route::post('/', [RoleController::class, 'store'])
                ->name('roles.store');

            Route::put('/{role}', [RoleController::class, 'update'])
                ->name('roles.update');

        });
    });
});
