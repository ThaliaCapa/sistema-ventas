
@extends('adminlte::page')

@section('title', 'Consultar Rol')

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-eye mr-2"></i>
        Consultar Rol
    </h1>
@stop

@section('content')

    <div class="card card-outline card-primary shadow-sm">

        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                Información del rol
            </h3>
        </div>

        <div class="card-body">

            <div class="form-group">
                <label>Nombre del rol</label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $rol->name }}"
                    readonly
                >
            </div>

            <hr>

            <h5 class="font-weight-bold">
                <i class="fas fa-key mr-2"></i>
                Permisos asignados
            </h5>

            @php
                $permisos = $rol->permissions;
                $permisosSeleccionados = $permisos->pluck('id')->all();
            @endphp

            @if ($permisos->isEmpty())
                <div class="alert alert-info">
                    Este rol todavía no tiene permisos asignados.
                </div>
            @else
                <div class="row">
                    @include('admin.roles.partials.permisos')
                </div>
            @endif

        </div>

        <div class="card-footer">

            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i>
                Volver
            </a>

            <a href="{{ route('admin.roles.edit', $rol) }}" class="btn btn-warning">
                <i class="fas fa-edit mr-1"></i>
                Editar rol
            </a>

        </div>

    </div>

@stop
