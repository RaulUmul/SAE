@extends('layouts.plantilla')
@section('title','Denuncias')

@section('content')
  {{-- Componente Container --}}
  @component('components.container')
    @section('titulo_card','DENUNCIAS DE ARMA DE FUEGO');
    @section('contenido_card')


      @if (session('success'))
        {{--Mensaje para registro guardado exitosamente o que esta bien--}}

          <div id="modalGuardadoArma" class="modal">
            <div class="modal-content">
              <h4>{{ session('success') }}</h4>
            </div>
            <div class="modal-footer">
              <div class="row">
                <div class="col s12" style="display: flex; justify-content: space-around ">
                  <div  style="display:flex; align-self: flex-end;">
                    <a  class="waves-light btn modal-close" style="padding-left: 2rem;padding-right: 2rem;">
                      Aceptar
                      <i class="large material-icons right">check</i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        @push('scripts')
        <script>
          $('.modal').modal();
          $('#modalGuardadoArma').modal('open');
        </script>
        @endpush
      @endif


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
    