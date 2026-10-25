
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Restablecer contraseña | Sistema de Ventas</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body class="login-page-custom">

    @php
        $correoRecuperacion = old('email', $email ?? request()->query('email', ''));
        $empresaLogo = null;
        $logoEmpresa = null;

        if (
            $correoRecuperacion &&
            filter_var($correoRecuperacion, FILTER_VALIDATE_EMAIL)
        ) {
            $usuarioLogo = \App\Models\User::with('empresa')
                ->where('email', $correoRecuperacion)
                ->first();

            $empresaLogo = $usuarioLogo?->empresa;

            if (
                $empresaLogo &&
                !empty($empresaLogo->logo) &&
                \Illuminate\Support\Facades\Storage::disk('public')->exists($empresaLogo->logo)
            ) {
                $logoEmpresa = asset('storage/' . $empresaLogo->logo);
            }
        }
    @endphp

    <div class="login-container">

        {{-- LOGO DE LA EMPRESA REGISTRADA --}}
        @if ($logoEmpresa)
            <div class="login-brand">
                <img
                    id="companyLogo"
                    src="{{ $logoEmpresa }}"
                    alt="{{ $empresaLogo->nombre_empresa }}"
                    class="login-logo">
            </div>
        @endif

        <div class="login-card-custom">

            <h2 class="login-title">
                Restablecer contraseña
            </h2>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input
                    type="hidden"
                    name="token"
                    value="{{ $token }}">

                {{-- CORREO ELECTRÓNICO --}}
                <div class="form-group-custom">

                    <label for="email" class="login-label">
                        Correo electrónico
                    </label>

                    <div class="login-input-group">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ $correoRecuperacion }}"
                            class="login-input @error('email') is-invalid @enderror"
                            placeholder="usuario@email.com"
                            required
                            autocomplete="email"
                            autofocus>
                    </div>

                    @error('email')
                        <span class="login-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                {{-- NUEVA CONTRASEÑA --}}
                <div class="form-group-custom">

                    <label for="password" class="login-label">
                        Nueva contraseña
                    </label>

                    <div class="login-input-group">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="login-input @error('password') is-invalid @enderror"
                            placeholder="Ingresa tu nueva contraseña"
                            required
                            autocomplete="new-password">

                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword"
                            aria-label="Mostrar u ocultar contraseña">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    @error('password')
                        <span class="login-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                {{-- CONFIRMAR CONTRASEÑA --}}
                <div class="form-group-custom">

                    <label for="password-confirm" class="login-label">
                        Confirmar contraseña
                    </label>

                    <div class="login-input-group">
                        <input
                            id="password-confirm"
                            type="password"
                            name="password_confirmation"
                            class="login-input"
                            placeholder="Confirma tu nueva contraseña"
                            required
                            autocomplete="new-password">

                        <button
                            type="button"
                            class="password-toggle"
                            id="toggleConfirmPassword"
                            aria-label="Mostrar u ocultar confirmación">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                </div>

                {{-- BOTÓN --}}
                <button type="submit" class="login-button">
                    RESTABLECER CONTRASEÑA
                </button>

            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');

            const toggleConfirmPassword =
                document.getElementById('toggleConfirmPassword');

            const confirmPassword =
                document.getElementById('password-confirm');

            function configurarVisibilidad(boton, campo) {
                boton.addEventListener('click', function () {
                    const mostrar = campo.type === 'password';

                    campo.type = mostrar ? 'text' : 'password';

                    const icono = this.querySelector('i');
                    icono.classList.toggle('fa-eye', !mostrar);
                    icono.classList.toggle('fa-eye-slash', mostrar);
                });
            }

            configurarVisibilidad(togglePassword, password);
            configurarVisibilidad(toggleConfirmPassword, confirmPassword);

        });
    </script>

</body>
</html>
