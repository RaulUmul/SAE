@extends('layouts.plantilla')
@section('title','Consultas')


@section('content')
  @component('components.container')
    @section('titulo_card','AJUSTES')
    @section('contenido_card')

    <form action="{{route('denuncia.delete',['id_denuncia'=>$id])}}" method="POST" id="deleteForm">
      @csrf
      @method('post')
    </form>
    <div class="col s12 m6">
      <div class="row">
        <div class="col s12">
          <span><em><h6>Datos Generales</h6></em></span>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <ul>
            <li>
              <span>Denuncia No. <b> {{$id}}</b></span>
            </li>
            <li>Armas asociadas: <b> {{count(json_decode($denuncia->id_armas))}} </b></li>
            <li>Sindicados / sospechosos:</li>
            <li>Estado:</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col s12 m6">
      <div class="row">
        <div class="col s12 center-align">
          <span><b>Acciones</b></span>
        </div>
        <div class="col s12 center-align">
          <a href="#!" class="red-text" onclick="event.preventDefault();document.getElementById('deleteForm').submit();">
            <i class="material-icons left">delete</i>
            Eliminar denuncia
          </a>
        </div>
      </div>
    </div>


    @endsection
  @endcomponent
@endsection