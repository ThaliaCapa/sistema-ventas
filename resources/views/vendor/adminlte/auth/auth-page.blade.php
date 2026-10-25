
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

    if (!empty(config('adminlte.layout_dark_mode', null))) {
        $bodyClasses .= ' dark-mode';
    }
@endphp

@section('adminlte_css')
    @stack('css')
    @yield('css')
    
    <style>
    .login-page .login-box > img {
        width: 240px !important;
        height: auto !important;
    }
</style>
@stop

@section('classes_body')
    {{ $bodyClasses }}
@stop

@section('body')
    <div class="{{ $authType }}-box">

        {{-- Mostrar el logo definido por cada página de autenticación --}}
        @hasSection('auth_logo')
            @yield('auth_logo')
        @endif

        {{-- Logo original de AdminLTE conservado como referencia --}}
        {{--
        <div class="{{ $authType }}-logo">
            <a href="{{ $dashboardUrl }}">
                @if (config('adminlte.auth_logo.enabled', false))
                    <img
                        src="{{ asset('/images/logo.png') }}"
                        alt="{{ config('adminlte.auth_logo.img.alt') }}"
                        @if (config('adminlte.auth_logo.img.class', null))
                            class="{{ config('adminlte.auth_logo.img.class') }}"
                        @endif
                        @if (config('adminlte.auth_logo.img.width', null))
                            width="{{ config('adminlte.auth_logo.img.width') }}"
                        @endif
                        @if (config('adminlte.auth_logo.img.height', null))
                            height="{{ config('adminlte.auth_logo.img.height') }}"
                        @endif
                    >
                @else
                    <img
                        src="{{ asset('/images/logo.png') }}"
                        alt="{{ config('adminlte.logo_img_alt') }}"
                        height="50"
                    >
                @endif

                {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
            </a>
        </div>
        --}}

        {{-- Card Box --}}
        <div
            class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}"
            style="box-shadow: 5px 5px 5px 5px #cccccc;"
        >

            {{-- Card Header --}}
            @hasSection('auth_header')
                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                    <h3 class="card-title float-none text-center">
                        @yield('auth_header')
                    </h3>
                </div>
            @endif

            {{-- Card Body --}}
            <div class="card-body {{ $authType }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                @yield('auth_body')
            </div>

            {{-- Card Footer --}}
            @hasSection('auth_footer')
                <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                    @yield('auth_footer')
                </div>
            @endif

        </div>
    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
