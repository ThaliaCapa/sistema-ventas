
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

    <div class="login-container">

        {{-- El logo permanece oculto hasta encontrar el de la empresa --}}
        <div class="login-brand" id="companyBrand" style="display: none;">
            <img
                id="companyLogo"
                src=""
                alt="Logo de la empresa"
                class="login-logo">
        </div>

        <div class="login-card-custom">

            <h2 class="login-title">
                Restablecer contraseña
            </h2>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group-custom">

                    <label for="email" class="login-label">
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

                    @error('email')
                        <span class="login-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                @if (session('status'))
                    <div class="login-success">
                        {{ session('status') }}
                    </div>
                @endif

                <button type="submit" class="login-button">
                    ENVIAR ENLACE
                </button>

            </form>

            <div class="back-to-login">
                <a href="{{ route('login') }}" class="forgot-password">
                    Volver a iniciar sesión
                </a>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const emailInput = document.getElementById('email');
            const companyLogo = document.getElementById('companyLogo');
            const companyBrand = document.getElementById('companyBrand');

            const logoUrl = @json(route('empresa.logo-por-correo'));

            let logoTimer = null;
            let requestController = null;
            let ultimaConsulta = '';

            function ocultarLogo() {
                companyBrand.style.display = 'none';
                companyLogo.removeAttribute('src');
            }

            function cargarLogoEmpresa() {

                const email = emailInput.value.trim();

                if (requestController) {
                    requestController.abort();
                    requestController = null;
                }

                if (
                    !email ||
                    !emailInput.checkValidity() ||
                    !emailInput.value.includes('@')
                ) {
                    ultimaConsulta = '';
                    ocultarLogo();
                    return;
                }

                ultimaConsulta = email;
                const emailConsultado = email;

                requestController = new AbortController();

                fetch(
                    logoUrl + '?email=' + encodeURIComponent(email),
                    {
                        headers: {
                            'Accept': 'application/json'
                        },
                        cache: 'no-store',
                        signal: requestController.signal
                    }
                )
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Error consultando el logo.');
                    }

                    return response.json();
                })
                .then(function (data) {

                    // Ignorar respuestas de correos anteriores.
                    if (emailInput.value.trim() !== emailConsultado) {
                        return;
                    }

                    // El servidor debe devolver null si no existe un logo.
                    if (!data.logo) {
                        ocultarLogo();
                        return;
                    }

                    const imagenTemporal = new Image();

                    imagenTemporal.onload = function () {

                        if (emailInput.value.trim() !== emailConsultado) {
                            return;
                        }

                        companyLogo.src = data.logo;
                        companyBrand.style.display = 'block';
                    };

                    imagenTemporal.onerror = function () {
                        ocultarLogo();
                        console.error('No se pudo cargar el logo de la empresa.');
                    };

                    imagenTemporal.src = data.logo;
                })
                .catch(function (error) {
                    if (error.name !== 'AbortError') {
                        ocultarLogo();
                        console.error('Error consultando el logo:', error);
                    }
                });
            }

            emailInput.addEventListener('input', function () {
                clearTimeout(logoTimer);
                ocultarLogo();

                logoTimer = setTimeout(cargarLogoEmpresa, 400);
            });

            emailInput.addEventListener('change', cargarLogoEmpresa);
            emailInput.addEventListener('blur', cargarLogoEmpresa);

            if (emailInput.value.trim() !== '') {
                cargarLogoEmpresa();
            }
        });
    </script>

</body>
</html>
