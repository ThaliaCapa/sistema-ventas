@extends('adminlte::page')

@section('title', 'Editar Empresa')

@section('content_header') <h1> <i class="fas fa-building"></i>
Mi Empresa </h1>
@stop

@section('content')

<div class="row justify-content-center">

```
<div class="col-md-10">

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>

            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ERRORES --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>
                <i class="fas fa-exclamation-triangle"></i>
                Corrige los siguientes errores:
            </strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
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


        {{-- ========================= --}}
        {{-- INFORMACIÓN GENERAL --}}
        {{-- ========================= --}}

        <div class="card card-outline card-primary">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-building"></i>
                    Información de la Empresa
                </h3>

            </div>


            <div class="card-body">

                <div class="row">


                    {{-- LOGO --}}
                    <div class="col-md-3 text-center">

                        <label>Logo de la empresa</label>

                        <br>

                        @if($empresa->logo)

                            <img id="preview-logo"
                                 src="{{ asset('storage/' . $empresa->logo) }}"
                                 class="img-fluid img-thumbnail"
                                 style="max-height:180px;">

                        @else

                            <img id="preview-logo"
                                 src="{{ asset('images/sin_logo.png') }}"
                                 class="img-fluid img-thumbnail"
                                 style="max-height:180px;">

                        @endif

                        <br><br>

                        <input type="file"
                               name="logo"
                               id="logo"
                               class="form-control"
                               accept="image/*">

                    </div>


                    {{-- DATOS --}}
                    <div class="col-md-9">

                        <div class="row">

                            {{-- NOMBRE --}}
                            <div class="col-md-8">

                                <label>Nombre / Razón Social</label>

                                <input type="text"
                                       name="nombre_empresa"
                                       class="form-control"
                                       value="{{ old('nombre_empresa', $empresa->nombre_empresa) }}"
                                       required>

                            </div>


                            {{-- RUC --}}
                            <div class="col-md-4">

                                <label>RUC</label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $empresa->nit }}"
                                       readonly>

                                <small class="text-muted">
                                    El RUC no puede modificarse.
                                </small>

                            </div>

                        </div>


                        <br>


                        <div class="row">

                            {{-- TIPO EMPRESA --}}
                            <div class="col-md-6">

                                <label>Tipo de Empresa</label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $empresa->tipo_empresa }}"
                                       readonly>

                            </div>


                            {{-- MONEDA --}}
                            <div class="col-md-6">

                                <label>Moneda</label>

                                <select name="moneda"
                                        class="form-control">

                                    <option value="PEN"
                                        {{ $empresa->moneda == 'PEN' ? 'selected' : '' }}>
                                        PEN - Soles
                                    </option>

                                    <option value="USD"
                                        {{ $empresa->moneda == 'USD' ? 'selected' : '' }}>
                                        USD - Dólares
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================= --}}
        {{-- CONTACTO --}}
        {{-- ========================= --}}

        <div class="card card-outline card-success">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="fas fa-address-book"></i>

                    Información de Contacto

                </h3>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- TELÉFONO --}}
                    <div class="col-md-6">

                        <label>Teléfono</label>

                        <input type="text"
                               name="telefono"
                               class="form-control"
                               value="{{ old('telefono', $empresa->telefono) }}"
                               required>

                    </div>


                    {{-- CORREO --}}
                    <div class="col-md-6">

                        <label>Correo electrónico</label>

                        <input type="email"
                               name="correo"
                               class="form-control"
                               value="{{ old('correo', $empresa->correo) }}"
                               required>

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================= --}}
        {{-- UBICACIÓN --}}
        {{-- ========================= --}}

        <div class="card card-outline card-warning">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="fas fa-map-marker-alt"></i>

                    Dirección

                </h3>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- DIRECCIÓN --}}
                    <div class="col-md-8">

                        <label>Dirección</label>

                        <input type="text"
                               name="direccion"
                               class="form-control"
                               value="{{ old('direccion', $empresa->direccion) }}"
                               required>

                    </div>


                    {{-- CÓDIGO POSTAL --}}
                    <div class="col-md-4">

                        <label>Código Postal</label>

                        <input type="text"
                               name="codigo_postal"
                               class="form-control"
                               value="{{ old('codigo_postal', $empresa->codigo_postal) }}">

                    </div>

                </div>

            </div>

        </div>



        {{-- BOTONES --}}

        <div class="text-right mb-4">

            <a href="{{ url()->previous() }}"
               class="btn btn-secondary">

                <i class="fas fa-times"></i>
                Cancelar

            </a>


            <button type="submit"
                    class="btn btn-primary">

                <i class="fas fa-save"></i>
                Guardar Cambios

            </button>

        </div>


    </form>

</div>
```

</div>

@stop

@section('js')

<script>

document.getElementById('logo').addEventListener('change', function(e) {

    const archivo = e.target.files[0];

    if (archivo) {

        const reader = new FileReader();

        reader.onload = function(e) {

            document.getElementById('preview-logo').src = e.target.result;

        }

        reader.readAsDataURL(archivo);

    }

});

</script>

@stop
