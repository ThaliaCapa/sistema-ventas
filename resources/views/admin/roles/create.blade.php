
@extends('adminlte::page')

@section('title', 'Crear rol')

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-user-shield mr-2"></i>
        Crear rol
    </h1>
    <p class="text-muted">Registra un rol y selecciona los permisos que tendrá.</p>
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

        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <div class="card-body">

                <div class="form-group">
                    <label for="name">Nombre del rol <span class="text-danger">*</span></label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Ejemplo: Administrador, Vendedor, Almacenero"
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
                    Selecciona los permisos que tendrá este rol.
                </p>

                @if ($permisos->isEmpty())
                    <div class="alert alert-info">
                        Todavía no hay permisos registrados.
                    </div>
                @else
                    @php
                        $permisosSeleccionados = old('permissions', []);
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
                    Guardar rol
                </button>

            </div>

        </form>

    </div>

@stop
