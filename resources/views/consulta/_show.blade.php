@extends('layouts.plantilla')
@section('title','Consultas')


@section('content')
  @component('components.container')
    @section('titulo_card','RESULTADO DE LA BUSQUEDA')
    @section('contenido_card')

      {{-- Aqui presentaremos los resultados satisfactorios de la busqueda. --}}
      {{-- Como? T.T --}}
      {{-- Por cada arma recuperada verdad... o no? --}}
      {{-- @foreach ($collection as $item) --}}

      <div class="row">
        <div class="col s12  ">
          <a class="btn right" href="{{route('consulta.create')}}">Nueva Consulta</a>
        </div>
      </div>

      <div class="row">
        {{-- Foreach --}}

        @foreach ($i_denuncia as $denuncia)

          <div class="col s12">
            <ul class="collapsible">
              <li>
                <div class="collapsible-header">
                  Denuncia No.<b> {{$denuncia['denunciante']->id_denuncia}}</b>
                </div>
                <div class="collapsible-body">

                <div class="row divs-datos-resultado">
                  <div class="col s12 white opos">
                    <h3 class="center-align">Denunciante</h3>

                    <table class="centered highlight ">
                      <thead>
                        <tr>
                          {{-- Todos evaluaran ifset --}}
                          <th>Nombre</th>
                          <th>Apellidos</th>
                          <th>CUI</th>
                          <th>Pasaporte</th>
                          <th>Telefono</th>
                          <th>Edad</th>
                          <th>Fecha de nacimiento</th>
                          <th>Genero</th>
                          <th>Direccion residencia</th>
                        </tr>

                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            {{-- Nombres --}}
                          {{isset($denuncia['denunciante']->persona->primer_nombre) ? $denuncia['denunciante']->persona->primer_nombre : null}}
                          {{isset($denuncia['denunciante']->persona->segundo_nombre) ? $denuncia['denunciante']->persona->segundo_nombre : null}}
                          {{isset($denuncia['denunciante']->persona->tercer_nombre) ? $denuncia['denunciante']->persona->tercer_nombre : null}}

                          </td>
                          <td>
                            {{-- Apellidos --}}
                          {{isset($denuncia['denunciante']->persona->primer_apellido) ? $denuncia['denunciante']->persona->primer_apellido : null}}
                          {{isset($denuncia['denunciante']->persona->segundo_apellido) ? $denuncia['denunciante']->persona->segundo_apellido : null}}
                          {{isset($denuncia['denunciante']->persona->apellido_casada) ? $denuncia['denunciante']->persona->apellido_casada : null}}
                          </td>
                          <td>
                            {{-- CUI --}}
                          {{isset($denuncia['denunciante']->persona->cui) ? $denuncia['denunciante']->persona->cui : 'N/I'}}

                          </td>
                          <td>
                            {{-- Pasaporte --}}
                          {{isset($denuncia['denunciante']->persona->pasaporte) ? $denuncia['denunciante']->persona->pasaporte : 'N/I'}}
                          </td>
                          <td>
                            {{-- Telefono Celular --}}
                            {{isset($denuncia['denunciante']->persona->telefono_celular) ? $denuncia['denunciante']->persona->telefono_celular : 'N/I'}}
                          </td>
                          <td>
                            {{-- Edad --}}
                            {{isset($denuncia['denunciante']->persona->edad) ? $denuncia['denunciante']->persona->edad : 'N/I'}}
                          </td>
                          <td>
                            {{-- Fecha nacimiento --}}
                            {{isset($denuncia['denunciante']->persona->fecha_nacimiento) ? $denuncia['denunciante']->persona->fecha_nacimiento : 'N/I'}}
                          </td>
                          <td>
                            {{-- Genero --}}
                            @isset($denuncia['denunciante']->persona->id_genero)
                                @foreach ( $genero as  $value )
                                  @if( $value->id_item == ($denuncia['denunciante']->persona->id_genero) )
                                  {{$value->descripcion}}
                                  @endif
                                @endforeach
                              @else
                              N/I
                            @endisset
                          </td>
                          <td>
                            {{--  Direccion--}}
                            @isset($denuncia['denunciante']->persona->direccion)
                              @foreach($denuncia['denunciante']->persona->direccion as $direccion)
                                {{-- Calle --}} {{-- o Avenida--}}
                                {{isset($direccion->calle) ? "$direccion->calle calle":null}}
                                {{isset($direccion->avenida) ? "$direccion->avenida Av.":null}}
                                {{-- Casa --}}
                                {{isset($direccion->numero_casa) ? "$direccion->numero_casa ,":null}}

                                {{-- Zona --}}
                                {{isset($direccion->zona) ? "Zona $direccion->zona":null   }}
                                {{-- Municipio --}}
                                @foreach ( $municipio as  $municip )
                                  @if( $municip->id_municipio == ($direccion->id_municipio) )
                                    {{$municip->municipio}},
                                  @endif
                                @endforeach

                                {{-- Departamento --}}
                                  @foreach ( $departamento as  $depto )
                                    @if( $depto->id_departamento == ($direccion->id_departamento) )
                                      {{$depto->departamento}}
                                    @endif
                                  @endforeach

                                <br>
                                {{-- Departamento --}}
                              @endforeach
                            @endisset
                          </td>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                  <div class="col s12 white opos">
                    <h3 class="center-align">Hecho</h3>
                    <table class="centered highlight">
                      <thead>
                        <tr>
                          {{-- Todos evaluaran ifset --}}
                          <th>No. Diligencia</th>
                          <th>Dirección</th>
                          <th>Tipo del hecho</th>
                          <th>Fecha</th>
                          <th>Hora</th>
                          <th>Narracion</th>
                        </tr>

                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            {{-- No.Diligencia --}}
                          {{isset($denuncia['hecho']->numero_diligencia) ? $denuncia['hecho']->numero_diligencia : 'N/I'}}
                          </td>
                          <td>
                            {{-- Direccion --}}
                              {{-- Calle --}} {{-- o Avenida--}}
                              {{isset($denuncia['hecho']->direccion->calle) ? $denuncia['hecho']->direccion->calle. " calle":null}}
                              {{isset($denuncia['hecho']->direccion->avenida) ? $denuncia['hecho']->direccion->avenida. " avenida":null}}
                              {{-- Casa --}}
                              {{isset($denuncia['hecho']->direccion->numero_casa) ? $denuncia['hecho']->direccion->numero_casa:null}}
                              {{-- Zona --}}
                              {{isset($denuncia['hecho']->direccion->zona) ? "Zona ".$denuncia['hecho']->direccion->zona:null}}
                              {{-- Municipio --}}
                              @foreach ( $municipio as  $municip )
                                @if( $municip->id_municipio == ($denuncia['hecho']->direccion->id_municipio) )
                                  {{$municip->municipio}},
                                @endif
                              @endforeach
                              {{-- Departamento --}}
                              @foreach ( $departamento as  $depto )
                                @if( $depto->id_departamento == ($denuncia['hecho']->direccion->id_departamento) )
                                  {{$depto->departamento}}
                                @endif
                            @endforeach
                          </td>
                          <td>
                            {{-- Tipo del hecho --}}
                            @isset($denuncia['hecho']->id_tipo_hecho)
                              @foreach ( $tipo_denuncia as  $value )
                                @if( $value->id_item == ($denuncia['hecho']->id_tipo_hecho) )
                                  {{$value->descripcion}}
                                @endif
                              @endforeach
                            @else
                              N/I
                            @endisset
                          </td>
                          <td>
                            {{-- Fecha --}}
                            {{isset($denuncia['hecho']->fecha_hecho) ? date("d/m/Y",strtotime($denuncia['hecho']->fecha_hecho)) : 'N/I'}}
                          </td>
                          <td>
                            {{-- Hora --}}
                            {{isset($denuncia['hecho']->hora_hecho) ? date("H:i",strtotime($denuncia['hecho']->hora_hecho)) : 'N/I'}}
                          </td>
                          <td>
                            {{-- Narracion --}}
                            {{isset($denuncia['hecho']->narracion) ? $denuncia['hecho']->narracion : 'N/I'}}
                          </td>
                        </tr>
                      </tbody>
                    </table>

                  </div>

                  <div class="col s12 white opos ">
                    <h3 class="center-align">Sindicado(s)</h3>
                    {{--
                    @if ( $denuncia['sindicados']   )
                        {{'toyvacio'}}
                    @endif --}}

                    <table class="centered highlight">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Apellidos</th>
                          <th>CUI</th>
                          <th>Pasaporte</th>
                          <th>Telefono</th>
                          <th>Edad</th>
                          <th>Fecha de nacimiento</th>
                          <th>Genero</th>
                          <th>Direccion</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach ($denuncia['sindicados'] as $sindicado)
                          <tr>
                            <td>
                              {{-- Nombres --}}
                            {{isset($sindicado->persona->primer_nombre) ? $sindicado->persona->primer_nombre : null}}
                            {{isset($sindicado->persona->tercer_nombre) ? $sindicado->persona->tercer_nombre : null}}
                            {{isset($sindicado->persona->segundo_nombre) ? $sindicado->persona->segundo_nombre : null}}
                            {{(!isset($sindicado->persona->primer_nombre) && !isset($sindicado->persona->segundo_nombre)  && !isset($sindicado->persona->tercer_nombre))? 'N/I' : null}}

                            </td>
                            <td>
                              {{-- Apellidos  --}}
                            {{isset($sindicado->persona->primer_apellido) ? $sindicado->persona->primer_apellido : null}}
                            {{isset($sindicado->persona->segundo_apellido) ? $sindicado->persona->segundo_apellido : null}}
                            {{isset($sindicado->persona->apellido_casada) ? $sindicado->persona->apellido_casada : null}}
                            {{!isset($sindicado->persona->primer_apellido)  && !isset($sindicado->persona->segundo_apellido) && !isset($sindicado->persona->apellido_casada) ?'N/I' : null}}
                            </td>
                            <td>
                              {{-- CUI --}}
                            {{isset($sindicado->persona->cui) ? $sindicado->persona->cui : 'N/I'}}
                            </td>
                            <td>
                              {{-- Pasaporte --}}
                            {{isset($sindicado->persona->pasaporte) ? $sindicado->persona->cui : 'N/I'}}
                            </td>
                            <td>
                              {{-- Telefono --}}
                            {{isset($sindicado->persona->telefono_celular) ? $sindicado->persona->telefono_celular : 'N/I'}}
                            </td>
                            <td>
                              {{--  Edad --}}
                            {{isset($sindicado->persona->edad) ? $sindicado->persona->edad : 'N/I'}}
                            </td>
                            <td>
                              {{--  Fecha nacimiento --}}
                            {{isset($sindicado->persona->fecha_nacimiento) ? $sindicado->persona->fecha_nacimiento : 'N/I'}}
                            </td>
                            <td>
                              {{-- Genero --}}
                              @isset($sindicado->persona->id_genero)
                                @foreach ( $genero as  $value )
                                  @if( $value->id_item == ($sindicado->persona->id_genero) )
                                  {{$value->descripcion}}
                                  @endif
                                @endforeach
                                  @else
                                  N/I
                              @endisset
                            </td>
                            <td>
                              {{-- Direccion --}}
                              @isset($sindicado['persona']->direccion)
                                @foreach($sindicado['persona']->direccion as $direc)
{{--                                  {{$direc}}--}}
                                  {{-- Calle --}} {{-- o Avenida--}}
                                  {{isset($direc->calle) ? $direc->calle. " calle":null}}
                                  {{isset($direc->avenida) ? $direc->avenida. " Av. ":null}}
                                  {{-- Casa --}}
                                  {{isset($direc->numero_casa) ? $direc->numero_casa:null}}
                                  {{-- Zona --}}
                                  {{isset($direc->zona) ? "Zona ".$direc->zona:null}}
                                  {{-- Municipio --}}
                                  @foreach ( $municipio as  $municip )
                                    @if( $municip->id_municipio == ($direc->id_municipio) )
                                      {{$municip->municipio}},
                                    @endif
                                  @endforeach
                                  {{-- Departamento --}}
                                  @foreach ( $departamento as  $depto )
                                    @if( $depto->id_departamento == ($direc->id_departamento) )
                                      {{$depto->departamento}}
                                    @endif
                                  @endforeach
                                  <br>
                                @endforeach
                              @endisset

                            </td>
                          </tr>
                        @endforeach


                      </tbody>
                    </table>


                  </div>
                  <div class="col s12 white opos">
                    <h3 class="center-align">Arma</h3>

                    <table  class="centered highlight">
                      <thead>
                        <tr>
                          <th>Tipo</th>
                          <th>Marca</th>
                          <th>Modelo</th>
                          <th>Registro</th>
                          <th>No.Licencia</th>
                          <th>No.Tenencia</th>
                          <th>Calibre</th>
                          <th>Cant. Tolvas</th>
                          <th>Cant. Municion</th>
                          <th>Propietario</th>
                          <th>Estatus</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($denuncia['armas'] as $arma)
                        <tr>
                          <td>
                            {{-- Tipo Arma --}}
                            @isset($arma->id_tipo_arma)
                            @foreach ( $tipo_arma as  $value )
                              @if( $value->id_item == ($arma->id_tipo_arma) )
                              {{$value->descripcion}}
                              @endif
                            @endforeach
                              @else
                              N/I
                          @endisset
                          </td>
                          <td>
                            {{-- Marca Arma --}}
                            @isset($arma->id_marca_arma)
                            @foreach ( $marca_arma as  $value )
                              @if( $value->id_item == ($arma->id_marca_arma) )
                              {{$value->descripcion}}
                              @endif
                            @endforeach
                              @else
                              N/I
                          @endisset
                          </td>
                          <td>
                            {{isset($arma->modelo_arma) ? $arma->modelo_arma : 'N/I'}}
                          </td>
                          <td>
                            {{isset($arma->registro) ? $arma->registro : 'N/I'}}
                          </td>
                          <td>
                            {{isset($arma->licencia) ? $arma->licencia : 'N/I'}}
                          </td>
                          <td>
                            {{isset($arma->tenencia) ? $arma->tenencia : 'N/I'}}
                          </td>
                          <td>
                            {{-- Calibre --}}
                            @isset($arma->id_calibre)
                            @foreach ( $calibre_arma as  $value )
                              @if( $value->id_item == ($arma->id_calibre) )
                              {{$value->descripcion}}
                              @endif
                            @endforeach
                              @else
                              N/I
                          @endisset
                          </td>
                          <td>
                            {{isset($arma->cantidad_tolvas) ? $arma->cantidad_tolvas : 'N/I'}}
                          </td>
                          <td>
                            {{isset($arma->cantidad_municion) ? $arma->cantidad_municion : 'N/I'}}
                          </td>
                          <td>
                            {{-- Hay que indicar quien es el propietario --}}
                            {{isset($arma->propietario) ? $arma->propietario : 'N/I'}}
                          </td>
                          <td>
                            {{-- Estatus --}}
                            @isset($arma->estado_arma)
                            @foreach ( $estado_arma as  $value )
                              @if( $value->id_item == ($arma->estado_arma) )
                              {{$value->descripcion}}
                              @endif
                            @endforeach
                              @else
                              N/I
                          @endisset
                          </td>
                          <td>
                            <a href="#modEstadoArma" class="btn tooltipped modal-trigger" data-position="top" data-tooltip="Editar" onclick="editStatus({{$arma}})" >
                              <i class="material-icons">create</i>
                            </a>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>

                </div>
                </div>
              </li>
            </ul>
          </div>
        @endforeach

      </div>

    {{-- Modal modificar estado arma --}}
      <div id="modEstadoArma" class="modal valign-wrapper">
        <div class="modal-content center-align">
          <h4>Modificar</h4>
          <div id="modificar-estado">
          </div>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat"><i class="material-icons left">cancel</i>Cancelar</a>
        </div>
      </div>

      {{-- Modal Confirmar --}}
      <div id="modConfirmEstado" class="modal" style="height:fit-content; width: fit-content; margin-top: 8% ">
        <a href="#" class="btn btn-large"  id="confirmStatus">Confirmar<i class="material-icons right">check</i></a>
      </div>
      {{-- Modal Success --}}
      <div id="modSuccess" class="modal valign-wrapper">
        <div class="modal-content center-align">
          <h4>Modificado con exito <i class="material-icons right">check</i></h4>
        </div>
      </div>

    @endsection

  @endcomponent
@endsection

@push('scripts')
  <script>
    $(document).ready(function(){
     $('.collapsible').collapsible();
     $('.modal').modal();
     $('.tooltipped').tooltip();
    });
  //   Empezamos con el espagueti :(
  //   Tengo que aprender hacer las cosas ome!
      let var_id_arma;

      function editStatus(content){
        let id_arma = content.id_arma;
        let estado_arma = content.estado_arma;
        $.ajax({
          url: "{{route('showStatusArma')}}",
          type: "GET",
          data: {id_arma,estado_arma},
          dataType: "text",
          success : function(rspnse) {

            $('#modificar-estado').html(rspnse);
            $('#modEstadoArma').modal('open');
            // console.log(rspnse);

          },
          error : function (xhr,status){},
          complete : function (xhr,status){
            console.log('Peticion-realizada - ')
          },
        })
      }


      function showModalConfirm(id_arma){
        $('#modConfirmEstado').modal('open');
          var_id_arma = id_arma;
      }

      $('#confirmStatus').click( function (){
        console.log('El id del arma es: '+var_id_arma);
        $.ajax({
          url: "{{route('editStatusArma')}}",
          type: "GET",
          data: {id_arma: var_id_arma},
          dataType: 'text',
          success:function(rspnse){

            $('#modSuccess').modal('open');
            $('#modConfirmEstado').modal('close');
            $('#modEstadoArma').modal('close');
            // evaluamos si la rspnse fue exitosa.

            setTimeout(() => {
              location.reload();
            }, 2000);

          },
          error:function(xhr,status){
            console.log('Error en la peticion - editStatus ')
          },
          complete:function(xhr,status){
            console.log('Peticion realizada - editStatus')
          },

        })
      })

  </script>
@endpush
