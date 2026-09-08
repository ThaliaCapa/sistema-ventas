<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Restablecer contraseña | Sistema de Ventas</title>


    <!-- GOOGLE FONTS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">


    <!-- FONT AWESOME -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <!-- CSS PERSONALIZADO -->
    <link
        rel="stylesheet"
        href="{{ asset('css/login.css') }}">

</head>


<body class="login-page-custom">


    <!-- CONTENEDOR PRINCIPAL -->
    <div class="login-container">


        <!-- LOGO -->
        <div class="login-brand">

            <img
                src="{{ asset('vendor/adminlte/dist/img/Logo_BITEK_1.png') }}"
                alt="Logo Sistema de Ventas"
                class="login-logo">

        </div>


        <!-- TARJETA -->
        <div class="login-card-custom">


            <!-- TÍTULO -->
            <h2 class="login-title">
                Restablecer contraseña
            </h2>


            <!-- FORMULARIO -->
            <form method="POST" action="{{ route('password.update') }}">

                @csrf


                <!-- TOKEN DE SEGURIDAD -->
                <input
                    type="hidden"
                    name="token"
                    value="{{ $token }}">


                <!-- CORREO ELECTRÓNICO -->
                <div class="form-group-custom">
                    <label
                        for="email"
                        class="login-label">
                        Correo electrónico
                    </label>


                    <div class="login-input-group">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ $email ?? old('email') }}"
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


                <!-- NUEVA CONTRASEÑA -->
                <div class="form-group-custom">
                    <label
                        for="password"
                        class="login-label">
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


                        <!-- MOSTRAR CONTRASEÑA -->
                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>


                    @error('password')
                        <span class="login-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <!-- CONFIRMAR CONTRASEÑA -->
                <div class="form-group-custom">

                    <label
                        for="password-confirm"
                        class="login-label">

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


                        <!-- MOSTRAR CONTRASEÑA -->
                        <button
                            type="button"
                            class="password-toggle"
                            id="toggleConfirmPassword">

                            <i class="fas fa-eye"></i>

                        </button>

                    </div>

                </div>


                <!-- BOTÓN -->
                <button
                    type="submit"
                    class="login-button">

                    RESTABLECER CONTRASEÑA

                </button>
            </form>
        </div>
    </div>


    <!-- JAVASCRIPT MOSTRAR CONTRASEÑAS -->
    <script>

        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        const toggleConfirmPassword =
            document.getElementById('toggleConfirmPassword');

        const confirmPassword =
            document.getElementById('password-confirm');


        togglePassword.addEventListener('click', function () {

            const type = password.getAttribute('type') === 'password'
                ? 'text'
                : 'password';

            password.setAttribute('type', type);

            const icon = this.querySelector('i');

            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');

        });


        toggleConfirmPassword.addEventListener('click', function () {

            const type =
                confirmPassword.getAttribute('type') === 'password'
                    ? 'text'
                    : 'password';

            confirmPassword.setAttribute('type', type);

            const icon = this.querySelector('i');

            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');

        });

    </script>


</body>

</html>