
@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">
            <i class="fas fa-users mr-2"></i> Gestión de Usuarios
        </h1>

        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Crear nuevo
        </a>
    </div>
@stop

@section('content')

    {{-- Mensajes --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-outline card-primary">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list mr-1"></i> Listado de Usuarios
            </h3>
        </div>

        <div class="card-body table-responsive p-0">

            <table class="table table-hover text-nowrap mb-0">

                <thead class="thead-light">
                    <tr>
                        <th style="width: 70px;">N.º</th>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Rol asignado</th>
                        <th class="text-center" style="width: 180px;">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($usuarios as $usuario)

                        <tr>
                            <td>
                                {{ $usuarios->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $usuario->name }}
                            </td>

                            <td>
                                {{ $usuario->email }}
                            </td>

                            <td>
                                @forelse ($usuario->roles as $rol)
                                    <span class="badge badge-info">
                                        {{ $rol->name }}
                                    </span>
                                @empty
                                    <span class="badge badge-secondary">
                                        Sin rol asignado
                                    </span>
                                @endforelse
                            </td>

                            <td class="text-center">

                                <a href="{{ route('admin.usuarios.show', $usuario->id) }}"
                                   class="btn btn-info btn-sm"
                                   title="Ver usuario">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                                   class="btn btn-warning btn-sm"
                                   title="Editar usuario">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if ($usuario->id !== auth()->id())

                                    <form
                                        action="{{ route('admin.usuarios.destroy', $usuario->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Eliminar usuario">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                @endif

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <p class="mb-0">
                                    No hay usuarios registrados.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($usuarios->hasPages())
            <div class="card-footer clearfix">
                {{ $usuarios->links() }}
            </div>
        @endif

    </div>

@stop
