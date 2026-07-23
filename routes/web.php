<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| Ruta principal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('home');
    }

    return redirect()->route('login');

});

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/

Auth::routes();

/*
|--------------------------------------------------------------------------
| Rutas públicas (Instalación)
|--------------------------------------------------------------------------
*/

Route::get('/crear-empresa', [EmpresaController::class, 'create'])
    ->name('admin.empresas.create');

Route::post('/crear-empresa', [EmpresaController::class, 'store'])
    ->name('admin.empresas.store');

Route::get('/buscar-ruc/{ruc}', [EmpresaController::class, 'buscarRuc']);

Route::get('/get-estados/{id}', [EmpresaController::class, 'buscar_pais']);
Route::get('/get-ciudades/{id}', [EmpresaController::class, 'buscar_ciudad']);
Route::get('/get-distritos/{id}', [EmpresaController::class, 'buscar_distrito']);

/*
|--------------------------------------------------------------------------
| Rutas protegidas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    // Usuarios
    Route::get('/crear-usuario', [UsuarioController::class, 'create'])
        ->name('admin.usuarios.create');

    Route::post('/crear-usuario', [UsuarioController::class, 'store'])
        ->name('admin.usuarios.store');

});