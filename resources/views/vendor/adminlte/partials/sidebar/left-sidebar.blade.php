
<aside class="main-sidebar sidebar-dark-primary elevation-4"
       style="background-color: #0F172A;">

    {{-- Logo de la empresa registrada --}}
    @php
        $empresa = auth()->check()
            ? auth()->user()->empresa
            : null;
    @endphp

    @if($empresa && $empresa->logo && $empresa->logo !== 'sin_logo.png')

        <a href="{{ url('/home') }}"
           class="brand-link text-center"
           style="
               background-color: #0F172A;
               min-height: 75px;
               padding: 10px 8px;
               display: flex;
               align-items: center;
               justify-content: center;
               border-bottom: 1px solid #263449;
           ">

            <img src="{{ asset('storage/' . $empresa->logo) }}"
                 alt="{{ $empresa->nombre_empresa }}"
                 style="
                     display: block;
                     max-width: 190px;
                     max-height: 55px;
                     width: auto;
                     height: auto;
                     object-fit: contain;
                 ">

        </a>

    @else

        {{-- Logo predeterminado de AdminLTE --}}
        @if(config('adminlte.logo_img_xl'))
            @include('adminlte::partials.common.brand-logo-xl')
        @else
            @include('adminlte::partials.common.brand-logo-xs')
        @endif

    @endif

    {{-- Menú lateral --}}
    <div class="sidebar"
         style="background-color: #0F172A;">

        <nav class="pt-2">

            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview"
                role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>

                {{-- Mantener las opciones actuales del sistema --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')

            </ul>

        </nav>

    </div>

</aside>
```