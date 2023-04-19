@extends('layouts.plantilla')
@section('title','Consultas')


@section('content')
@component('components.container')
  @section('titulo_card','CONSULTA DE ARMAS')
  @section('contenido_card')




              <div class="row">
                  <div class="col s12">
                      <em>
                          <h5 class="center">
                              <font face="Segoe UI" color="#2B0808">Ingrese el dato del tipo de búsqueda que desea realizar: </font>
                          </h5>
                      </em>
              </div>

              <div class="container">

                <div class="col s6 m6 l6">
                  <div class="background" style="background: linear-gradient(60deg, #00599f, #23b9f5)">
                    <div class="card-content white-text">
                      <span class="card-title center-align">CONSULTA A <br>PNC</span>
                      <br>
                      <p >Para consultar datos de denuncias en base de datos de PNC seleccione en Buscar:</p>
                        <br>
                        <div class="container center-align">
                          <div class="row">
                            <a href="{{route('consulta.create')}}" class="btn white-text"><i class="material-icons right white-text">search</i>BUSCAR</a>
                          </div>
                          <br>
                        </div>


                    </div>
                  </div>
                </div>




                <div class="col s6 m6 l6">
                  <div class="background" style="background: linear-gradient(60deg, #494c4e, #6b6f70)"">
                    <div class="card-content white-text">
                      <span class="card-title center-align">CONSULTA A <br>DIGECAM</span>
                      <br>
                      <p>Para consultar datos de denuncias en base de datos de DIGECAM seleccione en Buscar:</p>
                        <br>

                        <div class="container center-align">
                          <div class="row">
                              <a href="#" class=" btn white-text disabled"><i class="material-icons right white-text">search</i>BUSCAR</a>
                          </div>
                          <br>
                        </div>


                    </div>
                  </div>
                </div>



              </div>




  @endsection
@endcomponent
@endsection

