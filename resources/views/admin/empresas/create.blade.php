@extends('adminlte::master')

@php
    $authType = $authType ?? 'login';
    $dashboardUrl = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home');

    if (config('adminlte.use_route_url', false)) {
        $dashboardUrl = $dashboardUrl ? route($dashboardUrl) : '';
    } else {
        $dashboardUrl = $dashboardUrl ? url($dashboardUrl) : '';
    }

    $bodyClasses = "{$authType}-page";

    if (! empty(config('adminlte.layout_dark_mode', null))) {
        $bodyClasses .= ' dark-mode';
    }
@endphp

@section('classes_body'){{ $bodyClasses }}@stop

@section('body')
<div class="container">

    <br>
    <center>
        <img src="{{ asset('images/sistema_ventas.png') }}" width="250px">
    </center>
    <br>

    <div class="card card-outline card-primary" style="box-shadow: 5px 5px 5px #ccc;">

        <div class="card-header text-center">
            <b>Registro de una nueva empresa</b>
        </div>

        <div class="card-body">

            {{-- MENSAJE DE ÉXITO --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('admin.empresas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <!-- LOGO -->
                    <div class="col-md-3">
                        <label>Logo</label>
                        <input type="file" id="logo" name="logo" class="form-control">
                        <br>
                        <center><output id="list"></output></center>
                    </div>

                    <!-- DATOS -->
                    <div class="col-md-9">

                        <!-- UBICACIÓN -->
                        <div class="row">

                            <div class="col-md-3">
                                <label>País</label>
                                <select name="pais_id" id="select_pais" class="form-control">
                                    @foreach ($paises as $paise)
                                        <option value="{{ $paise->id }}" {{ $paise->name == 'Peru' ? 'selected' : '' }}>
                                            {{ $paise->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Departamento</label>
                                <select name="estado_id" id="select_estado" class="form-control">
                                    <option value="">-- Cargando... --</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Provincia</label>
                                <select name="ciudad_id" id="select_ciudad" class="form-control">
                                    <option value="">-- Seleccione departamento --</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Distrito</label>
                                <select name="distrito_id" id="select_distrito" class="form-control">
                                    <option value="">-- Seleccione provincia --</option>
                                </select>
                            </div>

                        </div>

                        <br>

                        <!-- RUC Y DATOS EMPRESA -->
                        <div class="row">

                            <div class="col-md-3">
                                <label>RUC</label>
                                <div class="input-group">
                                    <input type="text" name="ruc" id="ruc" class="form-control" maxlength="11" placeholder="Ingrese RUC">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info" id="btn_buscar_ruc">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <small id="ruc_mensaje"></small>
                            </div>

                            <div class="col-md-5">
                                <label>Nombre / Razón Social</label>
                                <input type="text" name="nombre_empresa" id="nombre_empresa" class="form-control" placeholder="Se completa automáticamente">
                            </div>

                            <div class="col-md-4">
                                <label>Tipo de Empresa</label>
                                <input type="text" name="tipo_empresa" id="tipo_empresa" class="form-control" placeholder="Se completa automáticamente">
                            </div>

                        </div>

                        <br>

                        <!-- MONEDA Y CONTACTO -->
                        <div class="row">

                            <div class="col-md-2">
                                <label>Moneda</label>
                                <select name="moneda" class="form-control">
                                    <option value="PEN">PEN - Soles</option>
                                    <option value="USD">USD - Dólares</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Teléfono</label>
                                <input type="text" name="telefono" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Correo</label>
                                <input type="email" name="correo" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label>Código Postal</label>
                                <input type="text" name="codigo_postal" class="form-control" value="+51">
                            </div>

                        </div>

                        <br>

                        <!-- DIRECCIÓN -->
                        <div class="row">
                            <div class="col-md-12">
                                <label>Dirección</label>
                                <input id="pac-input" class="form-control" name="direccion" type="text" placeholder="Se completa automáticamente con el RUC">
                            </div>
                        </div>

                    </div>
                </div>

                <br>

                <button type="submit" class="btn btn-primary float-right">
                    <i class="fas fa-save"></i> Guardar Empresa
                </button>

            </form>

        </div>
    </div>
</div>
@stop

@section('adminlte_js')

<script>
document.getElementById('logo').addEventListener('change', function (e) {
    var reader = new FileReader();
    reader.onload = function (e) {
        document.getElementById("list").innerHTML =
            '<img src="' + e.target.result + '" style="max-height:200px">';
    };
    reader.readAsDataURL(e.target.files[0]);
});
</script>

<script>
$(document).ready(function () {

    // BUSCAR RUC
    $('#btn_buscar_ruc').on('click', function () {
        var ruc = $('#ruc').val().trim();

        if (ruc.length !== 11) {
            $('#ruc_mensaje').html('<span class="text-danger">El RUC debe tener 11 dígitos.</span>');
            return;
        }

        $('#ruc_mensaje').html('<span class="text-info"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>');
        $('#btn_buscar_ruc').prop('disabled', true);

        $.ajax({
            url: "{{ url('/buscar-ruc') }}/" + ruc,
            type: 'GET',
            success: function (data) {
                $('#ruc_mensaje').html('<span class="text-success"><i class="fas fa-check"></i> RUC encontrado.</span>');
                $('#nombre_empresa').val(data.razon_social ?? '');
                $('#tipo_empresa').val(data.estado ?? '');
                $('#pac-input').val(data.direccion ?? '');
                $('#btn_buscar_ruc').prop('disabled', false);
            },
            error: function (xhr) {
                if (xhr.status === 404) {
                    $('#ruc_mensaje').html('<span class="text-danger">RUC no encontrado.</span>');
                } else {
                    $('#ruc_mensaje').html('<span class="text-danger">Error al consultar el RUC.</span>');
                }
                $('#btn_buscar_ruc').prop('disabled', false);
            }
        });
    });

    $('#ruc').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#btn_buscar_ruc').click();
        }
    });

    // País → Departamentos
    $('#select_pais').on('change', function () {
        var pais_id = $(this).val();

        $('#select_estado').html('<option value="">-- Cargando... --</option>');
        $('#select_ciudad').html('<option value="">-- Seleccione departamento --</option>');
        $('#select_distrito').html('<option value="">-- Seleccione provincia --</option>');

        if (pais_id) {
            $.ajax({
                url: "{{ url('/get-estados') }}/" + pais_id,
                type: 'GET',
                success: function (data) {
                    $('#select_estado').html('<option value="">-- Seleccione --</option>');
                    $.each(data, function (key, value) {
                        $('#select_estado').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                },
                error: function () {
                    $('#select_estado').html('<option value="">Error al cargar</option>');
                }
            });
        }
    });

    // Departamento → Provincias
    $('#select_estado').on('change', function () {
        var estado_id = $(this).val();

        $('#select_ciudad').html('<option value="">-- Cargando... --</option>');
        $('#select_distrito').html('<option value="">-- Seleccione provincia --</option>');

        if (estado_id) {
            $.ajax({
                url: "{{ url('/get-ciudades') }}/" + estado_id,
                type: 'GET',
                success: function (data) {
                    $('#select_ciudad').html('<option value="">-- Seleccione --</option>');
                    $.each(data, function (key, value) {
                        $('#select_ciudad').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                },
                error: function () {
                    $('#select_ciudad').html('<option value="">Error al cargar</option>');
                }
            });
        }
    });

    // Provincia → Distritos
    $('#select_ciudad').on('change', function () {
        var ciudad_id = $(this).val();

        $('#select_distrito').html('<option value="">-- Cargando... --</option>');

        if (ciudad_id) {
            $.ajax({
                url: "{{ url('/get-distritos') }}/" + ciudad_id,
                type: 'GET',
                success: function (data) {
                    $('#select_distrito').html('<option value="">-- Seleccione --</option>');
                    $.each(data, function (key, value) {
                        $('#select_distrito').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                },
                error: function () {
                    $('#select_distrito').html('<option value="">Error al cargar</option>');
                }
            });
        }
    });

    // Cargar departamentos de Perú automáticamente
    $('#select_pais').trigger('change');

});
</script>

@stop