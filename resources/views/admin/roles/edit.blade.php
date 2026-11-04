
@extends('adminlte::page')

@section('title', 'Editar rol')

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-edit mr-2"></i>
        Editar rol
    </h1>
    <p class="text-muted">Actualiza el nombre y los permisos del rol seleccionado.</p>
@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Revisa los siguientes errores:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-outline card-primary shadow-sm">

        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                <i class="fas fa-user-shield mr-2"></i>
                Información del rol
            </h3>
        </div>

        <form action="{{ route('admin.roles.update', $rol) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">
                    <label for="name">Nombre del rol <span class="text-danger">*</span></label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $rol->name) }}"
                        maxlength="100"
                        required
                    >

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                <h5 class="font-weight-bold">
                    <i class="fas fa-key mr-2"></i>
                    Permisos del rol
                </h5>

                <p class="text-muted">
                    Marca los permisos que deseas asignar a este rol.
                </p>

                @if ($permisos->isEmpty())
                    <div class="alert alert-info">
                        Todavía no hay permisos registrados.
                    </div>
                @else
                    @php
                        $permisosSeleccionados = old('permissions', $permisosAsignados);
                    @endphp

                    @include('admin.roles.partials.permisos')
                @endif

            </div>

            <div class="card-footer d-flex justify-content-between">

                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Volver
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    Actualizar rol
                </button>

            </div>

        </form>

    </div>

@stop
