
@extends('layouts.plantilla')
@section('title','Historial')

@section('content')
  @component('components.container')
    @section('titulo_card','Historial / Registro')
    @section('contenido_card')
      @csrf
      <ul class="collection with-header" id="historial-frame" >
        <li class="collection-header row valign-wrapper">
          <div class="col s12 m6">
            <h4>Arma Registro No. {{$registro}}</h4>
          </div>
          <div class="col s12 m6" style="display:flex;justify-content: center;">
            <a id="impresionHistorialBtn" class="btn" href="{{route('impresionHistorial',[
              'arma'=>$arma,
              'historial'=>json_decode($historial),
              'tipo_procedimiento'=>json_decode($tipo_procedimiento),
              'registro'=>$registro,
              'usuarios'=>json_decode($usuarios)])}}"
              target="preview_historial"
            >
            <i class="material-icons left">local_printshop</i> IMPRIMIR / DESCARGAR</a>
          </div>
        </li>
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
                  Responsable: {{ucwords( $usuario->user )}}
                @endif
              @endforeach
            </div>
            <div class="col s12">
              Descripcion: {{$evento->descripcion}}
            </div>
            <div class="col s12">
              Fecha registro: {{date('d/m/Y',strtotime($evento->fecha_creacion))}}
              Hora: {{date('H:i:s', strtotime($evento->fecha_creacion))  }}
            </div>
            @foreach ( $tipo_procedimiento as  $tipo )
              @if( $tipo->id_item == ($evento->id_tipo_procedimiento) )
                 @if($tipo->descripcion == 'Registro de recuperacion')
                   <div class="col s12">
                     @foreach ($arma_recuperada as $arma )
                     @if($evento->numero_documento == $arma->numero_documento )
                     <a href="#!" onclick="modalDetalleRecuperacion({{$arma}})">Ver detalle</a>
                    @endif
                    @endforeach
                   </div>
                @endif
              @endif
            @endforeach
          </div>
        </li>
        @endforeach
        <iframe
         class="col s12"
         style="width: 100%; min-height: 500px;height: 100%;max-height: 800px;border:none;"
         name="preview_historial"
         id="preview_historial"
         hidden
         >
        </iframe>

      </ul>


      <div id="modDetalleRecuperacion" class="modal">

        <div class="modal-content">
          <h4>Detalle</h4>
          <div class="contenido_denuncia">

          </div>
        </div>

        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
        </div>

      </div>

    @endsection
  @endcomponent
@endsection

@push('styles')
  <link rel="stylesheet" href="{{asset('css/mediaPrint/printHistorial.css')}}" media="print">
@endpush

@push('scripts')

  <script>

    $(document).ready(function(){
      $('.modal').modal();
    });

    function modalDetalleRecuperacion(recuperacion){
      //Modifica el contenido del modal DetallRecuperacion
      $.ajax({
        type: "get", //OJOAQUI
        url: "{{route('detalleRecuperacion')}}",
        data: {recuperacion},
        dataType: "text",
        success: function (response) {
          console.log(response);
        $('.contenido_denuncia').html(response);
        $('#modDetalleRecuperacion').modal('open');

        },
        error: function(response){

        }
      });
      // console.log(recuperacion);
      // Falta realizar una consulta ajax para traernos la vista y pegarla en el modal.
      // $('.contenido_denuncia').html(JSON.stringify(recuperacion));
      // $('#modDetalleRecuperacion').modal('open');
    }

    $('#impresionHistorialBtn').on('click',function () {
      $('#preview_historial').removeAttr('hidden');
    })

  </script>


@endpush
