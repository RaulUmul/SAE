@extends('layouts.plantilla')
@section('title','Denuncias')

@section('content')
  {{-- Componente Container --}}
  @component('components.container')
    @section('titulo_card','DENUNCIAS DE ARMA DE FUEGO');
    @section('contenido_card')

      {{--Mensaje para registro guardado exitosamente--}}
      @if (session('success'))
        <div id="modal_success" class="modal">
          <div class="modal-content center">
            <h4>{{ session('success') }}</h4>
          </div>
          <div class="modal-footer">
            <div class="col s12" style="display: flex; justify-content: space-around;">
                <a  class="waves-light btn modal-close">
                  Aceptar
                  <i class="large material-icons right">check</i>
                </a>
            </div>
          </div>
        </div>
        @push('scripts')
          <script>
            $('.modal').modal();
            $('#modal_success').modal('open');
          </script>
        @endpush
      @endif
      {{--Mensaje de errores, no guardado.--}}
      

      <div class="row">
        <div class="col s12">
          <em>
              <h5 class="center">
                  <font face="Segoe UI" color="#2B0808">Ingresar una nueva denuncia: </font>
                  <a href="{{route('denuncia.create')}}">Generar nueva denuncia</a>
              </h5>
          </em>
        </div>
      </div>
          
    @endsection
  @endcomponent
  {{-- Fin Componente Container --}}
@endsection
    