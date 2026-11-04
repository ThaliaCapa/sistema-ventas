@extends('adminlte::page')

@section('title', 'Listado de Roles')

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-user-shield mr-2"></i>
        Listado de Roles
    </h1>
@stop

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-1"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="card card-outline card-primary shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="card-title font-weight-bold">
                <i class="fas fa-list mr-2"></i>
                Roles registrados
            </h3>

            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i>
                Crear nuevo
            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 90px;">Nro.</th>
                            <th>Nombre del rol</th>
                            <th class="text-center" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($roles as $rol)

                            <tr>

                                <td class="text-center">
                                    {{ $roles->firstItem() + $loop->index }}
                                </td>

                                <td class="font-weight-bold">
                                    {{ $rol->name }}
                                </td>

                                <td class="text-center">

                                    <a href="{{ route('admin.roles.show', $rol) }}"
                                       class="btn btn-info btn-sm"
                                       title="Ver rol">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.roles.edit', $rol) }}"
                                       class="btn btn-warning btn-sm"
                                       title="Editar rol">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.roles.destroy', $rol) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Estás segura de que deseas eliminar este rol?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Eliminar rol">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fas fa-user-shield fa-2x mb-2"></i>
                                    <p class="mb-0">Todavía no hay roles registrados.</p>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $roles->links() }}
            </div>

        </div>

    </div>

@stop