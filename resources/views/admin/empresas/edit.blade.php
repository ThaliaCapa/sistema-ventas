
@extends('adminlte::page')

@section('title', 'Datos de la Empresa')

@section('content_header')
    <div class="company-heading">
        <div>
            <h1><i class="fas fa-building mr-2"></i>Datos de la empresa</h1>
            <p>Administra la información de tu empresa desde un solo lugar.</p>
        </div>
        <span class="company-heading-icon">
            <i class="fas fa-sliders-h"></i>
        </span>
    </div>
@stop

@section('content')

<div class="company-settings">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong><i class="fas fa-exclamation-circle mr-2"></i>
                Revisa la información ingresada.</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.empresas.update') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- INFORMACIÓN GENERAL --}}
        <div class="card company-card">
            <div class="card-header">
                <div class="section-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <h3 class="card-title">Información general</h3>
                    <small>Identificación y presentación de tu empresa</small>
                </div>
            </div>

            <div class="card-body">
                <div class="row">

                    {{-- LOGO --}}
                    <div class="col-lg-3 col-md-4 mb-4">
                        <div class="logo-panel">
                            <label class="field-label">Logo de la empresa</label>

                            <div class="logo-preview-container">
                                <img
                                    id="preview-logo"
                                    src="{{ !empty($empresa->logo) && $empresa->logo !== 'sin_logo.png' ? asset('storage/' . $empresa->logo) : asset('images/sin_logo.png') }}"
                                    alt="Logo de la empresa"
                                    class="company-logo-preview">
                            </div>

                            <label for="logo" class="btn btn-outline-primary btn-block mt-3">
                                <i class="fas fa-cloud-upload-alt mr-1"></i>
                                Cambiar logo
                            </label>

                            <input type="file"
                                   name="logo"
                                   id="logo"
                                   class="d-none"
                                   accept=".jpg,.jpeg,.png,image/jpeg,image/png">

                            <small class="text-muted d-block text-center mt-2">
                                JPG o PNG. Máximo 2 MB.
                            </small>
                        </div>
                    </div>

                    {{-- DATOS PRINCIPALES --}}
                    <div class="col-lg-9 col-md-8">
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label class="field-label" for="nombre_empresa">
                                    Nombre / Razón social
                                </label>
                                <input type="text"
                                       id="nombre_empresa"
                                       name="nombre_empresa"
                                       class="form-control"
                                       value="{{ old('nombre_empresa', $empresa->nombre_empresa) }}"
                                       maxlength="255"
                                       required>
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="field-label" for="ruc">RUC</label>
                                <input type="text"
                                       id="ruc"
                                       class="form-control readonly-field"
                                       value="{{ $empresa->ruc }}"
                                       readonly>
                                <small class="form-text text-muted">
                                    No editable.
                                </small>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="field-label" for="tipo_empresa">
                                    Tipo de empresa / estado
                                </label>
                                <input type="text"
                                       id="tipo_empresa"
                                       class="form-control readonly-field"
                                       value="{{ $empresa->tipo_empresa }}"
                                       readonly>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="field-label" for="moneda">Moneda</label>
                                <select name="moneda" id="moneda" class="form-control" required>
                                    <option value="PEN"
                                        {{ old('moneda', $empresa->moneda) == 'PEN' ? 'selected' : '' }}>
                                        PEN - Soles
                                    </option>
                                    <option value="USD"
                                        {{ old('moneda', $empresa->moneda) == 'USD' ? 'selected' : '' }}>
                                        USD - Dólares
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- CONTACTO --}}
        <div class="card company-card">
            <div class="card-header">
                <div class="section-icon section-icon-green">
                    <i class="fas fa-address-book"></i>
                </div>
                <div>
                    <h3 class="card-title">Información de contacto</h3>
                    <small>Medios de contacto de tu empresa</small>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group mb-md-0">
                        <label class="field-label" for="telefono">Teléfono</label>
                        <input type="text"
                               id="telefono"
                               name="telefono"
                               class="form-control"
                               value="{{ old('telefono', $empresa->telefono) }}"
                               maxlength="30"
                               required>
                    </div>

                    <div class="col-md-6 form-group mb-0">
                        <label class="field-label" for="correo">Correo electrónico</label>
                        <input type="email"
                               id="correo"
                               name="correo"
                               class="form-control"
                               value="{{ old('correo', $empresa->correo) }}"
                               maxlength="255"
                               required>
                    </div>
                </div>
            </div>
        </div>

        {{-- DIRECCIÓN --}}
        <div class="card company-card">
            <div class="card-header">
                <div class="section-icon section-icon-orange">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <h3 class="card-title">Dirección</h3>
                    <small>Ubicación registrada de la empresa</small>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 form-group mb-md-0">
                        <label class="field-label" for="direccion">Dirección fiscal</label>
                        <input type="text"
                               id="direccion"
                               name="direccion"
                               class="form-control"
                               value="{{ old('direccion', $empresa->direccion) }}"
                               maxlength="255"
                               required>
                    </div>

                    <div class="col-md-4 form-group mb-0">
                        <label class="field-label" for="codigo_postal">Código postal</label>
                        <input type="text"
                               id="codigo_postal"
                               name="codigo_postal"
                               class="form-control"
                               value="{{ old('codigo_postal', $empresa->codigo_postal) }}"
                               maxlength="20">
                    </div>
                </div>
            </div>
        </div>

        {{-- ACCIONES --}}
        <div class="company-actions">
            <a href="{{ route('home') }}" class="btn btn-light border">
                <i class="fas fa-times mr-1"></i>
                Cancelar
            </a>

            <button type="submit" class="btn btn-save-company">
                <i class="fas fa-save mr-2"></i>
                Guardar cambios
            </button>
        </div>

    </form>
</div>
@stop

@section('css')
<style>
    .content-wrapper {
        background: #f1f5f9 !important;
    }

    .content-header {
        padding: 24px 24px 8px;
    }

    .company-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .company-heading h1 {
        color: #142b4a;
        font-size: 25px;
        font-weight: 700;
        margin: 0;
    }

    .company-heading p {
        color: #718096;
        margin: 7px 0 0;
        font-size: 14px;
    }

    .company-heading-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #e1eaf7;
        color: #244c7c;
        font-size: 20px;
        flex-shrink: 0;
    }

    .company-settings {
        max-width: 1250px;
        margin: 12px auto 30px;
    }

    .company-card {
        border: 1px solid #e0e7f0;
        border-radius: 10px;
        box-shadow: 0 3px 12px rgba(15, 35, 65, .045);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .company-card .card-header {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 17px 22px;
        background: #fff;
        border-bottom: 1px solid #e8edf4;
    }

    .company-card .card-title {
        float: none;
        color: #193553;
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .company-card .card-header small {
        color: #8290a3;
        font-size: 12px;
    }

    .company-card .card-body {
        padding: 24px;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 10px;
        background: #e7effb;
        color: #24558e;
        font-size: 16px;
    }

    .section-icon-green {
        background: #e4f6ed;
        color: #21845a;
    }

    .section-icon-orange {
        background: #fff1df;
        color: #b66b13;
    }

    .field-label {
        color: #34445a;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control {
        height: 42px;
        border: 1px solid #d6dfeb;
        border-radius: 6px;
        color: #26384e;
        font-size: 13px;
        box-shadow: none;
    }

    .form-control:focus {
        border-color: #4b79b7;
        box-shadow: 0 0 0 3px rgba(54, 104, 166, .11);
    }

    .readonly-field {
        background: #f0f3f7 !important;
        color: #64748b;
    }

    .logo-panel {
        height: 100%;
        padding: 18px;
        border: 1px dashed #d4deeb;
        border-radius: 9px;
        background: #f9fbfe;
    }

    .logo-preview-container {
        height: 170px;
        padding: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 1px solid #e5ebf3;
        border-radius: 8px;
    }

    .company-logo-preview {
        max-width: 100%;
        max-height: 145px;
        object-fit: contain;
    }

    .btn-outline-primary {
        border-color: #315b91;
        color: #244c7c;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-outline-primary:hover {
        background: #244c7c;
        border-color: #244c7c;
        color: #fff;
    }

    .company-actions {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 10px;
        padding: 4px 0 20px;
    }

    .company-actions .btn {
        min-height: 42px;
        padding: 11px 20px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-save-company {
        color: #fff;
        background: #244c7c;
        border: 1px solid #244c7c;
        box-shadow: 0 3px 7px rgba(36, 76, 124, .18);
    }

    .btn-save-company:hover {
        color: #fff;
        background: #193858;
        border-color: #193858;
    }

    @media (max-width: 767.98px) {
        .content-header {
            padding: 18px 15px 8px;
        }

        .company-heading h1 {
            font-size: 21px;
        }

        .company-heading-icon {
            width: 40px;
            height: 40px;
        }

        .company-settings {
            margin-top: 10px;
        }

        .company-card .card-body {
            padding: 17px;
        }

        .logo-panel {
            max-width: 320px;
            margin: 0 auto 8px;
        }

        .company-actions {
            flex-direction: column-reverse;
        }

        .company-actions .btn {
            width: 100%;
        }
    }
</style>
@stop

@section('js')
<script>
    document.getElementById('logo').addEventListener('change', function (event) {
        const archivo = event.target.files[0];

        if (!archivo) {
            return;
        }

        const tiposPermitidos = ['image/jpeg', 'image/png'];

        if (!tiposPermitidos.includes(archivo.type)) {
            alert('Selecciona una imagen JPG o PNG.');
            event.target.value = '';
            return;
        }

        if (archivo.size > 2 * 1024 * 1024) {
            alert('La imagen no debe superar los 2 MB.');
            event.target.value = '';
            return;
        }

        const lector = new FileReader();

        lector.onload = function (e) {
            document.getElementById('preview-logo').src = e.target.result;
        };

        lector.readAsDataURL(archivo);
    });
</script>
@stop
