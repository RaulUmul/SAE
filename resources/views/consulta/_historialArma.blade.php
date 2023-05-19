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
            Autor: Raul Umul
            </div>
            <div class="col s12">
              Descripcion: {{$evento->descripcion}}
            </div>
            <div class="col s12">
              Fecha registro: {{date('d/m/Y',strtotime($evento->fecha_creacion))}}
              Hora: {{date('H:i:s'), strtotime($evento->fecha_creacion)  }}
            </div>
          </div>
        </li>
        @endforeach
      </ul>
    @endsection
  @endcomponent
@endsection

@push('scripts')

@endpush
