@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

    <div class="dashboard-header">

        <div>
            <h1>Dashboard</h1>
            <p>Resumen general de tu negocio</p>
        </div>

        <div class="dashboard-date">
            <i class="far fa-calendar-alt"></i>
            {{ now()->format('d/m/Y') }}
        </div>

    </div>

@stop


@section('content')

    {{-- =====================================================
         TARJETAS PRINCIPALES
    ====================================================== --}}

    <div class="row dashboard-cards">

        {{-- VENTAS --}}
        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="card-icon sales-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>

                <div class="card-info">
                    <h3>S/ 0.00</h3>
                    <p>Ventas del día</p>
                </div>

            </div>

        </div>


        {{-- CLIENTES --}}
        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="card-icon clients-icon">
                    <i class="fas fa-users"></i>
                </div>

                <div class="card-info">
                    <h3>0</h3>
                    <p>Clientes registrados</p>
                </div>

            </div>

        </div>


        {{-- PRODUCTOS --}}
        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="card-icon products-icon">
                    <i class="fas fa-box"></i>
                </div>

                <div class="card-info">
                    <h3>0</h3>
                    <p>Productos registrados</p>
                </div>

            </div>

        </div>


        {{-- STOCK --}}
        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="card-icon stock-icon">
                    <i class="fas fa-warehouse"></i>
                </div>

                <div class="card-info">
                    <h3>0</h3>
                    <p>Productos con stock bajo</p>
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         SEGUNDA FILA
    ====================================================== --}}

    <div class="row">

        {{-- RESUMEN DE VENTAS --}}
        <div class="col-lg-8">

            <div class="dashboard-panel">

                <div class="panel-header">

                    <div>
                        <i class="fas fa-chart-line panel-title-icon"></i>
                        <span class="panel-title">
                            Resumen de ventas
                        </span>
                    </div>

                    <button class="period-button">
                        Este mes
                        <i class="fas fa-chevron-down ml-1"></i>
                    </button>

                </div>


                <div class="chart-placeholder">

                    <div class="chart-message">

                        <i class="fas fa-chart-bar chart-icon"></i>

                        <p>
                            Aquí se mostrará el resumen de ventas
                        </p>

                        <small>
                            Cuando registres ventas aparecerán los datos.
                        </small>

                    </div>

                </div>

            </div>

        </div>


        {{-- STOCK BAJO --}}
        <div class="col-lg-4">

            <div class="dashboard-panel">

                <div class="panel-header">

                    <div>
                        <i class="fas fa-exclamation-triangle panel-title-icon"></i>

                        <span class="panel-title">
                            Stock bajo
                        </span>
                    </div>

                    <button class="view-button">
                        Ver todo
                    </button>

                </div>


                <div class="empty-state">

                    <i class="fas fa-box-open empty-icon"></i>

                    <p>
                        No hay productos con stock bajo.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         ÚLTIMAS VENTAS
    ====================================================== --}}

    <div class="row">

        <div class="col-12">

            <div class="dashboard-panel">

                <div class="panel-header">

                    <div>
                        <i class="fas fa-receipt panel-title-icon"></i>

                        <span class="panel-title">
                            Últimas ventas
                        </span>
                    </div>

                    <button class="view-button">
                        Ver todas
                    </button>

                </div>


                <div class="table-responsive">

                    <table class="dashboard-table">

                        <thead>

                            <tr>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Comprobante</th>
                                <th>Total</th>
                                <th>Estado</th>
                            </tr>

                        </thead>


                        <tbody>

                            <tr>

                                <td colspan="5" class="table-empty">

                                    <i class="fas fa-receipt mr-2"></i>

                                    Todavía no hay ventas registradas.

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@stop


@section('css')

    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">

@stop


@section('js')

<script>

    console.log('Dashboard del Sistema de Ventas');

</script>

@stop