
@php
    $modulos = [
        'clientes' => 'Clientes',
        'compras' => 'Compras',
        'dashboard' => 'Panel principal',
        'empresa' => 'Empresa',
        'productos' => 'Productos',
        'proveedores' => 'Proveedores',
        'reportes' => 'Reportes',
        'roles' => 'Roles',
        'usuarios' => 'Usuarios',
        'ventas' => 'Ventas',
    ];

    $acciones = [
        'view' => 'Ver',
        'create' => 'Crear',
        'edit' => 'Editar',
        'delete' => 'Eliminar',
    ];

    $permisosAgrupados = $permisos->groupBy(function ($permiso) {
        return explode('.', $permiso->name)[0];
    });
@endphp

<div class="row">
    @foreach ($modulos as $moduloKey => $moduloNombre)
        @php
            $permisosModulo = $permisosAgrupados->get($moduloKey, collect());
        @endphp

        @if ($permisosModulo->isNotEmpty())
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card card-outline card-secondary h-100 mb-0">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">
                            {{ $moduloNombre }}
                        </h3>
                    </div>

                    <div class="card-body">
                        @foreach ($permisosModulo as $permiso)
                            @php
                                $partes = explode('.', $permiso->name);
                                $accion = $partes[1] ?? '';
                                $nombreAccion = $acciones[$accion] ?? ucfirst($accion);
                            @endphp

                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="permiso_{{ $permiso->id }}"
                                    name="permissions[]"
                                    value="{{ $permiso->id }}"
                                    {{ in_array($permiso->id, $permisosSeleccionados) ? 'checked' : '' }}
                                >

                                <label
                                    class="custom-control-label"
                                    for="permiso_{{ $permiso->id }}"
                                >
                                    {{ $nombreAccion }} {{ strtolower($moduloNombre) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
