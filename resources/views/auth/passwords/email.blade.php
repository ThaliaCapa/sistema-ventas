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


    <!-- CSS DEL LOGIN -->
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
                alt="Logo BITEK"
                class="login-logo">

        </div>


        <!-- TARJETA RESTABLECER CONTRASEÑA -->
        <div class="login-card-custom">


            <!-- TÍTULO -->
            <h2 class="login-title">
                Restablecer contraseña
            </h2>

            <!-- FORMULARIO -->
            <form
                method="POST"
                action="{{ route('password.email') }}">

                @csrf


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
                            value="{{ old('email') }}"
                            class="login-input @error('email') is-invalid @enderror"
                            placeholder="usuario@email.com"
                            required
                            autocomplete="email"
                            autofocus>

                    </div>


                    <!-- ERROR -->
                    @error('email')

                        <span class="login-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <!-- MENSAJE DE ÉXITO -->
                @if (session('status'))

                    <div class="login-success">
                        {{ session('status') }}
                    </div>

                @endif


                <!-- BOTÓN -->
                <button
                    type="submit"
                    class="login-button">

                    ENVIAR ENLACE

                </button>


            </form>


            <!-- VOLVER AL LOGIN -->
            <div class="back-to-login">

                <a
                    href="{{ route('login') }}"
                    class="forgot-password">
                    
                    Volver a iniciar sesión

                </a>

            </div>
        </div>
    </div>

</body>

</html>