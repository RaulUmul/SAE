<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  {{-- CDN Materialize --}}
  <link rel="stylesheet" href="{{asset('css/materialize.min.css')}}">
  {{-- CDN Select --}}
  <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
  {{-- GOOGLE Fonts --}}
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  {{-- Favicon de la App --}}
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/pnc.ico') }}">
  {{-- Style de Select2 --}}
  <link rel="stylesheet" href="{{asset('css/select2.css')}}">
  {{-- Style de SweetAlert2 --}}
  <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
  {{-- Style de Tabulator  --}}
  <link rel="stylesheet" href="{{asset('css/tabulator.min.css')}}">
  {{-- Styles de la App --}}
  @vite(['resources/css/app.css','resources/js/app.js'])
  {{-- Nombre de Titulo --}}
  <title>@yield('title')</title>
</head>

<body>

  <div id="particles-js"></div>
  <style>
    .all-the-ground{
      position: absolute;
      z-index: 1000;
      height: 100%;
      width: 100%;
       /*border: 1px solid yellow;*/
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: rgba(0, 0, 0, 0.2);
      /* display: none; */
    }


    .preloader-wrapper{
      justify-content: center;
      align-items: center;
    }
  </style>

  <div class="all-the-ground">
    {{-- <div class="preloader-wrapper big  active"> --}}
      <img src="{{asset('img/cargando.svg')}}" alt="">
    {{-- </div> --}}
  </div>

  <div class="row">

    {{-- Cabecera --}}
    {{-- @auth --}}
    <header class="col s0 l3">
        @include('partials.navbar')
    </header>
    {{-- @endauth --}}


    {{-- Contenido --}}
    <main class="col s12 m12 l9 container ">
      {{-- Boton del menu hamburguesa --}}
      {{-- @auth --}}
      <a id="button_open-menu-sidenav" href="#" data-target="slide-out" class="sidenav-trigger white-text pulse"><i class="material-icons">menu</i></a>
      {{-- @endauth --}}
      {{-- Contenido --}}
      @yield('content')

    </main>

    <footer class=" col s12  center-align" style="">
      @include('partials.footer')
    </footer>

  </div>






{{-- Scripts Jquery --}}
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
{{-- Script Materialize  --}}
<script src="{{asset('js/materialize.min.js')}}"></script>
{{-- Script Select2 --}}
<script src="{{asset('js/select2.full.min.js')}}"></script>
{{-- Script Particles JS --}}
<script src="{{ asset('js/particles.min.js') }}"></script>
<script src="{{ asset('js/particles.inc.js') }}"></script>
{{-- Script SweetAlert2 --}}
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
{{-- Script Tabulator--}}
<script src="{{ asset('js/tabulator.min.js') }}"></script>
{{-- Scripts de cada Modulo --}}
{{-- <script src="{{asset('js/app.js')}}"></script> --}}
@stack('scripts')

<script>
  $(document).ready(function () {

     $('.all-the-ground').hide();

  });
</script>


</body>
</html>
