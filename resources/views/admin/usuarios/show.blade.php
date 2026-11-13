
@extends('adminlte::page')

@section('title', 'Consultar Usuario')

@section('content_header')
    <h1>
        <i class="fas fa-user mr-2"></i>
        Consultar Usuario
    </h1>
@stop

@section('content')

    <div class="card card-outline card-primary">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-id-card mr-1"></i>
                Información del usuario
            </h3>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre completo</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $usuario->name }}"
                               readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $usuario->email }}"
                               readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Rol asignado</label>

                        <div class="form-control" style="height:auto; min-height:38px;">
                            @forelse ($usuario->roles as $rol)
                                <span class="badge badge-info">
                                    {{ $rol->name }}
                                </span>
                            @empty
                                <span class="badge badge-secondary">
                                    Sin rol asignado
                                </span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha de registro</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : 'No disponible' }}"
                               readonly>
                    </div>
                </div>

            </div>

        </div>

        <div class="card-footer">

            <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
               class="btn btn-warning">
                <i class="fas fa-edit mr-1"></i>
                Editar usuario
            </a>

            <a href="{{ route('admin.usuarios.index') }}"
               class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i>
                Regresar
            </a>

        </div>

    </div>

@stop
