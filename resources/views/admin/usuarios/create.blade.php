
@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
    <h1>
        <i class="fas fa-user-plus mr-2"></i>
        Registrar Usuario
    </h1>
@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Revisa los siguientes campos:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-outline card-primary">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-edit mr-1"></i>
                Datos del usuario
            </h3>
        </div>

        <form action="{{ route('admin.usuarios.store') }}" method="POST">
            @csrf

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nombre completo</label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Ingrese el nombre completo"
                                required
                            >

                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="ejemplo@correo.com"
                                required
                            >

                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Contraseña</label>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Mínimo 8 caracteres"
                                required
                            >

                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">
                                Confirmar contraseña
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control"
                                placeholder="Repita la contraseña"
                                required
                            >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rol_id">Asignar rol</label>

                            <select
                                name="rol_id"
                                id="rol_id"
                                class="form-control @error('rol_id') is-invalid @enderror"
                                required
                            >
                                <option value="">Seleccione un rol</option>

                                @foreach ($roles as $rol)
                                    <option
                                        value="{{ $rol->id }}"
                                        {{ old('rol_id') == $rol->id ? 'selected' : '' }}
                                    >
                                        {{ $rol->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('rol_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>

                @if ($roles->isEmpty())
                    <div class="alert alert-warning mb-0">
                        No existen roles registrados. Primero debes crear un rol
                        para poder asignarlo al usuario.
                    </div>
                @endif

            </div>

            <div class="card-footer">
                <button
                    type="submit"
                    class="btn btn-primary"
                    {{ $roles->isEmpty() ? 'disabled' : '' }}
                >
                    <i class="fas fa-save mr-1"></i>
                    Guardar usuario
                </button>

                <a href="{{ route('admin.usuarios.index') }}"
                   class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Regresar
                </a>
            </div>

        </form>

    </div>

@stop
