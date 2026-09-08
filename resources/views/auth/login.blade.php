<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión | Sistema de Ventas</title>


    <!-- GOOGLE FONTS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">


    <!-- FONT AWESOME -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <!-- CSS PERSONALIZADO DEL LOGIN -->
    <link
        rel="stylesheet"
        href="{{ asset('css/login.css') }}">

</head>


<body class="login-page-custom">


    <!-- CONTENEDOR PRINCIPAL -->
    <div class="login-container">


        <!-- IDENTIDAD DEL SISTEMA -->
        <div class="login-brand">
            <!-- LOGO -->
            <img
                src="{{ asset('vendor/adminlte/dist/img/Logo_BITEK_1.png') }}"
                alt="Logo BITEK"
                class="login-logo">
        </div>


        <!-- TARJETA DEL LOGIN -->
        <div class="login-card-custom">
            <!-- TITULO -->
            <h2 class="login-title">
                Iniciar sesión
            </h2>
            
            <!-- SUBTITULO -->
            <p class="login-subtitle">
                Ingresa tus credenciales para continuar
            </p>

            <!-- FORMULARIO LOGIN -->
            <form method="POST" action="{{ route('login') }}">

                @csrf


                <!-- ============================= -->
                <!-- CORREO ELECTRÓNICO -->
                <!-- ============================= -->

                <div class="form-group-custom">

                    <label
                        for="email"
                        class="login-label">

                        Correo electrónico

                    </label>


                    <div class="login-input-group">

                        <!-- INPUT -->
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


                    <!-- ERROR EMAIL -->
                    @error('email')

                        <span class="login-error">

                            {{ $message }}

                        </span>

                    @enderror

                </div>



                <!-- ============================= -->
                <!-- CONTRASEÑA -->
                <!-- ============================= -->

                <div class="form-group-custom">

                    <label
                        for="password"
                        class="login-label">

                        Contraseña

                    </label>


                    <div class="login-input-group">

                        <!-- INPUT PASSWORD -->
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="login-input @error('password') is-invalid @enderror"
                            placeholder="Ingresa tu contraseña"
                            required
                            autocomplete="current-password">


                        <!-- BOTÓN MOSTRAR CONTRASEÑA -->
                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword">

                            <i class="fas fa-eye"></i>

                        </button>


                    </div>


                    <!-- ERROR PASSWORD -->
                    @error('password')

                        <span class="login-error">

                            {{ $message }}

                        </span>

                    @enderror

                </div>



                <!-- ============================= -->
                <!-- RECORDAR / OLVIDÉ CONTRASEÑA -->
                <!-- ============================= -->

                <div class="login-options">


                    <!-- RECORDARME -->
                    <label class="remember-container">

                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <span>
                            Recordarme
                        </span>

                    </label>



                    <!-- OLVIDASTE CONTRASEÑA -->
                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="forgot-password">

                            ¿Olvidaste tu contraseña?

                        </a>

                    @endif


                </div>



                <!-- ============================= -->
                <!-- BOTÓN LOGIN -->
                <!-- ============================= -->

                <button
                    type="submit"
                    class="login-button">
                    INICIAR SESIÓN
                </button>
                
                    <!-- SEPARADOR Y COPYRIGHT -->
                    <div class="login-footer">
                        <div class="login-footer-line"></div>
                        <span>
                            © 2026 Sistema de Ventas
                        </span>
                    </div>

            </form>
        </div>
    </div>



    <!-- ============================= -->
    <!-- JAVASCRIPT MOSTRAR CONTRASEÑA -->
    <!-- ============================= -->

    <script>

        const togglePassword = document.getElementById('togglePassword');

        const password = document.getElementById('password');


        togglePassword.addEventListener('click', function () {


            const type = password.getAttribute('type') === 'password'
                ? 'text'
                : 'password';


            password.setAttribute('type', type);


            const icon = this.querySelector('i');


            icon.classList.toggle('fa-eye');

            icon.classList.toggle('fa-eye-slash');


        });

    </script>


</body>

</html>