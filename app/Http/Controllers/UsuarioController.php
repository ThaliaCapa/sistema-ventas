<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    /**
     * Listar usuarios de la empresa actual.
     */
    public function index()
    {
        $usuarios = User::with('roles')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Mostrar formulario para crear usuario.
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('admin.usuarios.create', compact('roles'));
    }

    /**
     * Registrar usuario.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'rol_id' => [
                'required',
                Rule::exists('roles', 'id')
                    ->where('guard_name', 'web'),
            ],
        ]);

        $usuario = User::create([
            'name' => $datos['name'],
            'email' => $datos['email'],
            'password' => $datos['password'],
            'empresa_id' => auth()->user()->empresa_id,
        ]);

        $rol = Role::where('id', $datos['rol_id'])
            ->where('guard_name', 'web')
            ->firstOrFail();

        $usuario->syncRoles([$rol]);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    /**
     * Mostrar información del usuario.
     */
    public function show(string $id)
    {
        $usuario = User::with('roles')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->findOrFail($id);

        return view('admin.usuarios.show', compact('usuario'));
    }

    /**
     * Mostrar formulario para editar usuario.
     */
    public function edit(string $id)
    {
        $usuario = User::with('roles')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->findOrFail($id);

        $roles = Role::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        $rolAsignado = $usuario->roles->first()?->id;

        return view('admin.usuarios.edit', compact(
            'usuario',
            'roles',
            'rolAsignado'
        ));
    }

    /**
     * Actualizar usuario.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::where('empresa_id', auth()->user()->empresa_id)
            ->findOrFail($id);

        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($usuario->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'rol_id' => [
                'required',
                Rule::exists('roles', 'id')
                    ->where('guard_name', 'web'),
            ],
        ]);

        $usuario->name = $datos['name'];
        $usuario->email = $datos['email'];

        if (!empty($datos['password'])) {
            $usuario->password = $datos['password'];
        }

        $usuario->save();

        $rol = Role::where('id', $datos['rol_id'])
            ->where('guard_name', 'web')
            ->firstOrFail();

        $usuario->syncRoles([$rol]);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario.
     */
    public function destroy(string $id)
    {
        $usuario = User::where('empresa_id', auth()->user()->empresa_id)
            ->findOrFail($id);

        if ($usuario->id === auth()->id()) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
