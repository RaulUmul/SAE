@extends('layouts.plantilla')
@section('title','Historial')


@section('content')
  @component('components.container')
    @section('titulo_card','Historial / Registro')
    @section('contenido_card')
      @csrf
      <ul class="collection with-header">
        <li class="collection-header"><h4>Arma Registro No. {{$registro}}</h4></li>
        @foreach($historial as $evento)
        <li class="collection-item">
          <div class="row">
            <div class="col s12">
              @foreach ( $tipo_procedimiento as  $tipo )
                @if( $tipo->id_item == ($evento->id_tipo_procedimiento) )
                  Procedimiento: {{$tipo->descripcion}}
                @endif
              @endforeach
            </div>
            @isset($evento->numero_documento)
            <div class="col s12">
              Documento No. {{$evento->numero_documento}}
            </div>
            @endisset
            <div class="col s12">

              @foreach($usuarios as $usuario)
                @if($usuario->id_user == $evento->id_autor)
                  Autor: {{ucwords( $usuario->user )}}
                @endif
              @endforeach
            </div>
            <div class="col s12">
              Descripcion: {{$evento->descripcion}}
            </div>
            <div class="col s12">
              Fecha registro: {{date('d/m/Y',strtotime($evento->fecha_creacion))}}
              Hora: {{date('H:i:s'), strtotime($evento->fecha_creacion)  }}
            </div>
            @foreach ( $tipo_procedimiento as  $tipo )
              @if( $tipo->id_item == ($evento->id_tipo_procedimiento) )
                 @if($tipo->descripcion == 'Registro de recuperacion')
                   <div class="col s12">
                    <a onclick="modalDetalleRecuperacion({{$arma_recuperada}})">Ver detalle</a>
                     {{$arma_recuperada}}
                   </div>
                @endif
              @endif
            @endforeach
          </div>
        </li>
        @endforeach
      </ul>

      <div id="modDetalleRecuperacion" class="modal">

        <div class="modal-content">

          <h4>Modal Header</h4>

          <p>A bunch of text</p>

        </div>

        <div class="modal-footer">

          <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>

        </div>

      </div>

    @endsection
  @endcomponent
@endsection

@push('scripts')

  <script>

    $(document).ready(function(){
      $('.modal').modal();
    });
    function modalDetalleRecuperacion(recuperacion){

      $('#modDetalleRecuperacion>modal-content').html('Hola');

    $('#modDetalleRecuperacion').modal('open');

    }


  </script>

@endpush
