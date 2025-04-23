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
use App\Http\Controllers\RouteController;
use App\Http\Controllers\InvestigadorController;
use Illuminate\Support\Facades\Auth;
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
    Route::get('/home', [ProyectoController::class, 'agruparProyectosPorProgramaAnio'])
        ->name('inicio');

    Route::prefix('/admin')->group(function () {
        Route::prefix('/proyectos')->group(function () {
            Route::get('/pdf/metadatos', [ProyectoController::class, 'obtenerMetadatosPdf'])
                ->name('pdf.metadatos');
            // Filters
            Route::get('/', [ProyectoController::class, 'index'])
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
                ->middleware('can:proyecto.delete')
                ->name("proyectos.delete");

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

            Route::post('{proyecto}/reactivar-investigadores', [InvestigadorController::class, 'reactivarInvestigadores'])
                ->name('investigadores.historicos.reactivar');

        });

        Route::prefix('/tipologias')->group(function () {
            Route::get('/', [TipologiaController::class, 'index'])
                ->name('tipologia.index');

            Route::get('crear', [TipologiaController::class, 'create'])
                ->middleware('can:tipologia.create')
                ->name('tipologia.create');

            Route::post('crear', [TipologiaController::class, 'store'])
                ->middleware('can:tipologia.create')
                ->name('tipologia.store');

            Route::delete('/delete/{tipologia_id}', [TipologiaController::class, 'destroy'])
                ->middleware('can:tipologia.delete')
                ->name('tipologia.delete');
        });

        Route::prefix('/procedencias')->group(function () {
            Route::get('/', [ProcedenciaController::class, 'index'])
                ->name('procedencia.index');

            Route::post('crear', [ProcedenciaController::class, 'store'])
                ->middleware('can:procedencia.create')
                ->name('procedencia.store');

            Route::delete('/delete/{procedencia_id}', [ProcedenciaController::class, 'destroy'])
                ->middleware('can:procedencia.delete')
                ->name('procedencia.delete');
        });

        Route::prefix('/procedencia-codigos')->group(function () {
            Route::get('/', [ProcedenciaCodigoController::class, 'index'])
                ->name('procedencia.codigo.index');

            Route::post('crear', [ProcedenciaCodigoController::class, 'store'])
                ->middleware('can:procedencia.codigo.create')
                ->name('procedencia.codigo.store');

            Route::delete('/delete/{procedencia_codigo_id}', [ProcedenciaCodigoController::class, 'destroy'])
                ->middleware('can:procedencia.codigo.delete')
                ->name('procedencia.codigo.delete');
        });

        Route::prefix('/programas')->group(function () {
            Route::get('/', [ProgramaController::class, 'index'])
                ->name('programa.index');

            Route::post('crear', [ProgramaController::class, 'store'])
                ->middleware('can:programa.create')
                ->name('programa.store');

            Route::delete('/delete/{programa_id}', [ProgramaController::class, 'destroy'])
            ->middleware('can:programa.delete')
            ->name('programa.delete');
        });

        Route::prefix('/users')->group(function () {
            Route::get('/', [UserController::class, "index"])
                ->name('users');

            Route::get('{user}/edit', [UserController::class, 'edit'])
                ->name('user.edit');

            Route::put('{user}', [UserController::class, 'update'])
                ->name('user.update');

            Route::delete('/delete/{user_id}', [UserController::class, 'destroy'])
                ->name('user.delete');
        });

        Route::prefix('/investigadores')->group(function () {
            Route::get('/', [InvestigadorController::class, "index"])
                ->name('investigador.index');

            Route::delete('/delete/{investigador_id}', [InvestigadorController::class, 'destroy'])
                ->name('investigador.delete');

            Route::delete('/investigador-historico', [InvestigadorController::class, 'destroyItemPivot'])
                ->name('investigadores.historicos.delete');
        });

        Route::prefix('/roles')->group(function () {
            Route::get('/', [RoleController::class, "index"])
                ->name('roles.index');;

            Route::post('/', [RoleController::class, 'store'])
                ->name('roles.store');

            Route::put('/{role}', [RoleController::class, 'update'])
                ->name('roles.update');

            Route::delete('/delete/{rol_id}', [RoleController::class, 'destroy'])
                ->middleware('can:admin-access')
                ->name('roles.delete');
        });

        Route::prefix('/routes')->group(function () {
            Route::get('/', [RouteController::class, 'index'])
                ->middleware('can:admin-access')
                ->name('routes.index');

            Route::put('/update-permissions', [RouteController::class, 'updatePermissions'])
                ->middleware('can:admin-access')
                ->name('routes.update-permissions');
        });
    });
});

Route::fallback(function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    abort(404);
});
