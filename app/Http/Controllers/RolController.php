<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')
            ->where('guard_name', 'web')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permisos = Permission::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('admin.roles.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[\pL\pN\s_-]+$/u',
                Rule::unique('roles', 'name')
                    ->where('guard_name', 'web'),
            ],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [
                'integer',
                Rule::exists('permissions', 'id')
                    ->where('guard_name', 'web'),
            ],
        ]);

        $rol = Role::create([
            'name' => $datos['name'],
            'guard_name' => 'web',
        ]);

        $rol->syncPermissions(
            Permission::where('guard_name', 'web')
                ->whereIn('id', $datos['permissions'] ?? [])
                ->get()
        );

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol creado correctamente.');
    }

    public function show(Role $rol)
    {
        abort_unless($rol->guard_name === 'web', 404);

        $rol->load('permissions');

        return view('admin.roles.show', compact('rol'));
    }

    public function edit(Role $rol)
    {
        abort_unless($rol->guard_name === 'web', 404);

        $permisos = Permission::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        $permisosAsignados = $rol->permissions->pluck('id')->all();

        return view('admin.roles.edit', compact(
            'rol',
            'permisos',
            'permisosAsignados'
        ));
    }

    public function update(Request $request, Role $rol)
    {
        abort_unless($rol->guard_name === 'web', 404);

        $datos = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[\pL\pN\s_-]+$/u',
                Rule::unique('roles', 'name')
                    ->where('guard_name', 'web')
                    ->ignore($rol->id),
            ],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [
                'integer',
                Rule::exists('permissions', 'id')
                    ->where('guard_name', 'web'),
            ],
        ]);

        $rol->update([
            'name' => $datos['name'],
        ]);

        $rol->syncPermissions(
            Permission::where('guard_name', 'web')
                ->whereIn('id', $datos['permissions'] ?? [])
                ->get()
        );

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Role $rol)
    {
        abort_unless($rol->guard_name === 'web', 404);

        if ($rol->users()->exists()) {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'No puedes eliminar un rol que está asignado a usuarios.');
        }

        $rol->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol eliminado correctamente.');
    }
}