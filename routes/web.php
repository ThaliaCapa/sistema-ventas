
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Empresa;
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
| Ruta pública para consultar el logo de la empresa
|--------------------------------------------------------------------------
|
| Busca al usuario mediante el correo ingresado y obtiene
| el logo de la empresa asociada a su cuenta.
|
*/

Route::get('/empresa/logo-por-correo', function (\Illuminate\Http\Request $request) {

    $email = trim((string) $request->query('email', ''));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return response()->json([
            'logo' => null,
        ]);
    }

    $usuario = User::with('empresa')
        ->where('email', $email)
        ->first();

    $empresa = $usuario?->empresa;

    if (!$empresa || empty($empresa->logo)) {
        return response()->json([
            'logo' => null,
        ]);
    }

    if (!Storage::disk('public')->exists($empresa->logo)) {
        return response()->json([
            'logo' => null,
        ]);
    }

    return response()->json([
        'logo' => asset('storage/' . $empresa->logo),
    ]);

})->name('empresa.logo-por-correo');

/*
|--------------------------------------------------------------------------
| Rutas públicas - Registro de empresa
|--------------------------------------------------------------------------
*/

// Mostrar formulario de creación de empresa.
Route::get('/crear-empresa', [EmpresaController::class, 'create'])
    ->name('admin.empresas.create');

// Guardar empresa y usuario administrador.
Route::post('/crear-empresa', [EmpresaController::class, 'store'])
    ->name('admin.empresas.store');

// Buscar empresa por RUC.
Route::get('/buscar-ruc/{ruc}', [EmpresaController::class, 'buscarRuc'])
    ->name('admin.empresas.buscar-ruc');

// Buscar estados o departamentos.
Route::get('/get-estados/{id}', [EmpresaController::class, 'buscar_pais'])
    ->name('admin.empresas.estados');

// Buscar ciudades o provincias.
Route::get('/get-ciudades/{id}', [EmpresaController::class, 'buscar_ciudad'])
    ->name('admin.empresas.ciudades');

// Buscar distritos.
Route::get('/get-distritos/{id}', [EmpresaController::class, 'buscar_distrito'])
    ->name('admin.empresas.distritos');

/*
|--------------------------------------------------------------------------
| Rutas protegidas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    /*
    |--------------------------------------------------------------------------
    | EMPRESA ACTUAL
    |--------------------------------------------------------------------------
    */

    // Ver mi empresa.
    Route::get('/mi-empresa', [EmpresaController::class, 'show'])
        ->name('admin.empresas.show');

    // Formulario para editar mi empresa.
    Route::get('/mi-empresa/editar', [EmpresaController::class, 'edit'])
        ->name('admin.empresas.edit');

    // Actualizar mi empresa.
    Route::put('/mi-empresa', [EmpresaController::class, 'update'])
        ->name('admin.empresas.update');

    /*
    |--------------------------------------------------------------------------
    | USUARIOS
    |--------------------------------------------------------------------------
    */

    // Listar usuarios de mi empresa.
    Route::get('/usuarios', [UsuarioController::class, 'index'])
        ->name('admin.usuarios.index');

    // Mostrar formulario para crear usuario.
    Route::get('/crear-usuario', [UsuarioController::class, 'create'])
        ->name('admin.usuarios.create');

    // Guardar usuario.
    Route::post('/crear-usuario', [UsuarioController::class, 'store'])
        ->name('admin.usuarios.store');

    // Ver usuario.
    Route::get('/usuarios/{usuario}', [UsuarioController::class, 'show'])
        ->name('admin.usuarios.show');

    // Mostrar formulario para editar usuario.
    Route::get('/usuarios/{usuario}/editar', [UsuarioController::class, 'edit'])
        ->name('admin.usuarios.edit');

    // Actualizar usuario.
    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])
        ->name('admin.usuarios.update');

    // Eliminar usuario.
    Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])
        ->name('admin.usuarios.destroy');

});

/*
|--------------------------------------------------------------------------
| RUTAS FUTURAS
|--------------------------------------------------------------------------
|
| Productos
| Categorías
| Clientes
| Proveedores
| Compras
| Ventas
| Caja
| Inventario
| Reportes
| Facturación electrónica
| Comprobantes
| Notas de crédito
| Notas de débito
| Devoluciones
| Gastos
| Cuentas por cobrar
| Cuentas por pagar
| Conciliación bancaria
| IA
|
|--------------------------------------------------------------------------
*/
