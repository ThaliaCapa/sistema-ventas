
@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>
        <i class="fas fa-user-edit mr-2"></i>
        Editar Usuario
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
                <i class="fas fa-user mr-1"></i>
                Datos del usuario
            </h3>
        </div>

        <form action="{{ route('admin.usuarios.update', $usuario->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nombre completo</label>

                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $usuario->name) }}"
                                   required>

                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>

                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $usuario->email) }}"
                                   required>

                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Nueva contraseña</label>

                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Dejar vacío para conservar la actual">

                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">
                                Confirmar nueva contraseña
                            </label>

                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control"
                                   placeholder="Repita la nueva contraseña">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rol_id">Rol asignado</label>

                            <select name="rol_id"
                                    id="rol_id"
                                    class="form-control @error('rol_id') is-invalid @enderror"
                                    required>

                                <option value="">Seleccione un rol</option>

                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}"
                                        {{ old('rol_id', $rolAsignado) == $rol->id ? 'selected' : '' }}>
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
                    <div class="alert alert-warning">
                        No existen roles disponibles para asignar.
                    </div>
                @endif

            </div>

            <div class="card-footer">

                <button type="submit"
                        class="btn btn-primary"
                        {{ $roles->isEmpty() ? 'disabled' : '' }}>
                    <i class="fas fa-save mr-1"></i>
                    Actualizar usuario
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
