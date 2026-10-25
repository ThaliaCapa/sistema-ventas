
@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@php
    $passEmailUrl = View::getSection('password_email_url')
        ?? config('adminlte.password_email_url', 'password/email');

    if (config('adminlte.use_route_url', false)) {
        $passEmailUrl = $passEmailUrl ? route($passEmailUrl) : '';
    } else {
        $passEmailUrl = $passEmailUrl ? url($passEmailUrl) : '';
    }

    $logoPredeterminado = asset('images/sistema_ventas.png');
    $logoEmpresaUrl = route('empresa.logo-por-correo');
@endphp

{{-- Logo personalizado en la sección de autenticación --}}
@section('auth_logo')
    <a href="{{ url('/') }}" class="brand-link text-center">
        <img
            id="companyLogo"
            src="{{ $logoPredeterminado }}"
            alt="Logo de la empresa"
            style="max-width: 180px; max-height: 120px; object-fit: contain; display: block; margin: 0 auto;"
        >
    </a>
@stop

@section('auth_header', __('adminlte::adminlte.password_reset_message'))

@section('auth_body')

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ $passEmailUrl }}" method="post">
        @csrf

        {{-- Campo de correo electrónico --}}
        <div class="input-group mb-3">
            <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                placeholder="{{ __('adminlte::adminlte.email') }}"
                autocomplete="email"
                autofocus
                required
            >

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Botón para enviar el enlace --}}
        <button
            type="submit"
            class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}"
        >
            <span class="fas fa-share-square"></span>
            {{ __('adminlte::adminlte.send_password_reset_link') }}
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}">
            Volver a iniciar sesión
        </a>
    </div>

@stop

@section('adminlte_js')
    @parent

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const companyLogo = document.getElementById('companyLogo');
            const defaultLogo = @json($logoPredeterminado);
            const logoUrl = @json($logoEmpresaUrl);

            if (!companyLogo) {
                return;
            }

            fetch(logoUrl, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('No se pudo consultar el logo.');
                }

                return response.json();
            })
            .then(function (data) {
                if (!data.logo) {
                    companyLogo.src = defaultLogo;
                    return;
                }

                const imagen = new Image();

                imagen.onload = function () {
                    companyLogo.src = data.logo;
                };

                imagen.onerror = function () {
                    companyLogo.src = defaultLogo;
                    console.error('No se pudo cargar el logo de la empresa.');
                };

                imagen.src = data.logo;
            })
            .catch(function (error) {
                companyLogo.src = defaultLogo;
                console.error('Error al consultar el logo:', error);
            });
        });
    </script>
@stop
