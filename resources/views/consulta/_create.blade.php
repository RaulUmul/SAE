@extends('layouts.plantilla')
@section('title','Consultas')


@section('content')
    @component('components.container')
      @section('titulo_card','CONSULTA DE ARMAS PNC')


        @section('contenido_card')


            {{--Mensaje para registro guardado exitosamente--}}
            @if (session('error'))
              <div id="modal_error" class="modal">
                <div class="modal-content center">
                  <h4>{{ session('error') }}</h4>
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
                  $('#modal_error').modal('open');
                </script>
              @endpush
            @endif
            {{--Mensaje de errores, no guardado.--}}

            {{-- @if (session('error')) --}}
            {{-- <div class="col-sm-12">Mensaje indica que algo salio mal y manda a volar el restro del base de datos- --}}
                {{-- <div class="alert  alert-danger alert-dismissible fade show" role="alert"> --}}
                    {{-- {{ session('error') }} --}}
                        {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"> --}}
                            {{-- <span aria-hidden="true">&times;</span> --}}
                        {{-- </button> --}}
                {{-- </div> --}}
            {{-- </div> --}}
            {{-- @endif --}}

            <div class="row">
                <div class="col s12">
                    <em>
                        <h5 class="center">
                            <font face="Segoe UI" color="#2B0808">Seleccione el filtro de la busqueda: </font>
                        </h5>
                    </em>
            </div>


            <div class="container" id="info">


                <ul class="collapsible popout">
                    <li>
                        <div class="collapsible-header"><i class="material-icons">person_pin</i>DPI</div>
                        <div class="collapsible-body" >
                            <form action="{{route('consulta.show')}}" method="POST" >
                                @csrf
                                @method('post')
                                <div class="row ">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">chevron_right</i>
                                        <input type="number" name="numero_cui" class="validate" value="" id="numero_cui">
                                        <label for="numero_cui" class="active">Ingrese número de DPI</label>
                                        @error('numero_cui')
                                        <span class="helper-text red-text" data-error="" data-success="">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="center">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">
                                        Buscar
                                        <i class="material-icons right">search</i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li class="active">
                        <div class="collapsible-header"><i class="material-icons">keyboard</i>Número de registro</div>
                        <div class="collapsible-body" >
                            <form action="{{route('consulta.show')}}" method="POST"  >
                                @csrf
                                @method('post')
                                <div class="row ">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">chevron_right</i>
                                        <input type="text" id="numero_registro" name="numero_registro" class="validate" value="">
                                        <label for="numero_registro" class="active">Ingrese número de serie/registro</label>
                                        @error('numero_registro')
                                        <span class="helper-text red-text" data-error="" data-success="">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="center">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">
                                        Buscar
                                        <i class="material-icons right">search</i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">keyboard</i>Número de licencia </div>
                        <div class="collapsible-body" >
                            <form action="{{route('consulta.show')}}" method="POST">
                                @csrf
                                @method('post')
                                <div class="row ">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">chevron_right</i>
                                        <input type="number" name="numero_licencia" id="numero_licencia" class="validate" value="" disabled>
                                        <label for="numero_licencia" class="active">Ingrese número de licencia</label>
                                        @error('numero_licencia')
                                        <span class="helper-text red-text" data-error="" data-success="">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="center">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">
                                        Buscar
                                        <i class="material-icons right">search</i>
                                    </button>
                                </div>
                            </form>
                        </div>
                     </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">keyboard</i>Número de tenencia </div>
                        <div class="collapsible-body" >
                            <form action="{{route('consulta.show')}}" method="POST" >
                                @csrf
                                @method('post')
                                <div class="row ">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">chevron_right</i>
                                        <input type="number" name="numero_tenencia" id="numero_tenencia" class="validate" value="" disabled>
                                        <label for="numero_tenencia" class="active">Ingrese número de tenencia</label>
                                        @error('numero_tenencia')
                                        <span class="helper-text red-text" data-error="" data-success="">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="center">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">
                                        Buscar
                                        <i class="material-icons right">search</i>
                                    </button>
                                </div>
                            </form>
                        </div>
                     </li>
                </ul>

            </div>


        @endsection
    @endcomponent
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.collapsible').collapsible();
        });
    </script>














@endpush
