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
                <div class="collapsible-header deleteCollapse">
                  <div>
                  Denuncia No.<b> {{$denuncia['denunciante']->id_denuncia}}</b>
                  </div>
                  <div style="text-align: center">
                  Estado de la denuncia
                  <br>
                  @foreach ($tipo_estatus_denuncia as $tipo_estatus)
                    @if ($tipo_estatus->id_item == $denuncia['no_denuncia']->estatus_denuncia[0]->id_estatus_denuncia)
                        {{$tipo_estatus->descripcion}}
                    @endif
                  @endforeach
                  </div>
                  <div>
                  <a class="btn" href="{{route('impresionDenuncia',[
                    'denuncia'=>json_encode($denuncia),
                    'departamento' => json_encode($departamento),
                    'municipio' =>json_encode($municipio),
                    'genero' =>json_decode($genero),
                    'tipo_arma' =>json_decode($tipo_arma),
                    'marca_arma' =>json_encode($marca_arma),
                    'calibre_arma' =>json_encode($calibre_arma),
                    'estado_arma' =>json_decode($estado_arma),
                    'tipo_denuncia' => json_decode($tipo_denuncia)
                    ])}}" target="_blank"><i class="material-icons left">local_printshop</i> Imprimir denuncia </a>

                    <a href="{{route('archivo.index',['id_denuncia'=>$denuncia['denunciante']->id_denuncia])}}" class="btn">
                      <i class="material-icons left">
                        picture_as_pdf
                      </i>
                      <span>Visualizar documento</span>
                    </a>
                  </div>
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
                            {{isset($denuncia['no_denuncia']->numero_documento) ? $denuncia['no_denuncia']->numero_documento : 'N/I'}}
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
                          <th>Nombres</th>
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
                              {{isset($sindicado->persona->segundo_nombre) ? $sindicado->persona->segundo_nombre : null}}
                              {{isset($sindicado->persona->tercer_nombre) ? $sindicado->persona->tercer_nombre : null}}
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
                              {{isset($sindicado->persona->pasaporte) ? $sindicado->persona->pasaporte : 'N/I'}}
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

                      <table class="centered highlight">
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
                              {{isset($arma->propietario) ? $arma->propietario->nombre_propietario : 'N/I'}}
                            </td>
                            <td>
                              {{-- Estatus --}}
                              @isset($arma->id_estatus_arma)
                                @foreach ( $estado_arma as  $value )
                                  @if( $value->id_item == ($arma->id_estatus_arma) )
                                    {{$value->descripcion}}
                                  @endif
                                @endforeach
                              @else
                                N/I
                              @endisset
                            </td>
                            <td>
                              @isset($arma->id_estatus_arma)
                                @foreach ( $estado_arma as  $value )
                                @if( $value->id_item == ($arma->id_estatus_arma) )
                                  @if($value->descripcion == 'Recuperada')
                                    <a class="btn tooltipped disabled" data-position="top" data-tooltip="Ampliar"
                                       onclick="editArma({{$arma}})">
                                      <i class="material-icons">zoom_out_map</i>
                                    </a>
                                    <a class="btn tooltipped disabled" data-position="top" data-tooltip="Registrar Recuperacion"
                                       onclick="editStatus({{$arma}},{{$denuncia['no_denuncia']->id_denuncia}})">
                                      <i class="material-icons">create</i>
                                    </a>
                                  @else
                                    <a class="btn tooltipped" data-position="top" data-tooltip="Ampliar"
                                       onclick="editArma({{$arma}})">
                                      <i class="material-icons">zoom_out_map</i>
                                    </a>
                                    <a class="btn tooltipped " data-position="top" data-tooltip="Registrar Recuperacion"
                                       onclick="editStatus({{$arma}},{{$denuncia['no_denuncia']->id_denuncia}})">
                                      <i class="material-icons">create</i>
                                    </a>

                                  @endif
                                @endif
                                @endforeach
                              @endisset
                                <a class="btn tooltipped" data-position="top" data-tooltip="Historial" onclick="showHistorial({{$arma}})">
                                  <i class="material-icons">description</i>
                                </a>
                            </td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                    <div class="col s12 center-align">
                      <span class="red-text"><a href="{{route('ajustesDenuncia',$denuncia['denunciante']->id_denuncia)}}"><i class="material-icons">settings</i> Ajustes de la denuncia</a></span>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        @endforeach

      </div>

      {{-- Modal modificar estado arma --}}
      <div id="modEstadoArma" class="modal valign-wrapper modal-fixed-footer" >
        <div class="modal-content " >
          <h4 class="center-align">Registrar recuperacion del arma"</h4>
          <div id="form-recuperacion" class="" style="overflow-x: hidden">
            <form id="recuperacion_arma" name="recuperacion_arma">
              {{--  Existe detenido  --}}
              {{--  Generamos la funcion verdad? --}}
              <input type="hidden" id="id_arma" name="id_arma" value="">
              <input type="hidden" id="id_denuncia" name="id_denuncia" value="">
              <div class="row row" style="box-shadow: 0px 10px 5px 1px rgba(0, 0, 0, 0.1)">

                <div class="input-field col s12 m4 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <select name="tipo_documento" id="tipo_documento">
                    <option value="{{null}}" selected>Tipo documento</option>
                    @foreach ($tipo_documento as $value)
                      <option value="{{$value->id_item}}" >{{$value->descripcion}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="input-field col s12 m4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="numero_documento" name="numero_documento" type="text">
                  <label for="numero_documento">Numero documento</label>
                </div>

                <div class="input-field col s12 m4 " style="text-align: center">
                  <span>¿Hay personas detenidas?</span>
                  <div style="display:flex; justify-content: center">
                    <label>
                      <input name="existeDetenido" type="radio" id="si_check" value="{{1}}"/>
                      <span>Si</span>
                    </label>
                    <label>
                      <input name="existeDetenido" type="radio" id="no_check" value="{{0}}" checked/>
                      <span>No</span>
                    </label>
                  </div>
                </div>
              </div>
              <div id="personas_raiz" class="row z-depth-0" style=" background-color: #93939314;">

              </div>

              <div class="row">
                @include('partials.divider',['title'=> 'Hecho'])

                <div  class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input type="date" id="fecha_hecho" name="fecha_hecho" class="validate" value="">
                  <label for="fecha_hecho">Fecha de la recuperacion</label>
                </div>
                <div  class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input type="time" id="hora_hecho" name="hora_hecho" class="validate" value="">
                  <label for="hora_hecho" >Hora aproximada</label>
                </div>

                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="dependencia_policial" name="dependencia_policial" type="text">
                  <label for="dependencia_policial">Dependencia policial</label>
                </div>
              </div>

              <div class="row">
                @include('partials.divider',['title'=> 'Direccion del hecho'])
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <select name="departamento_hecho_recuperacion" id="departamento_hecho_recuperacion" onchange="selectMunicipio(value,{{$municipio}},'municipio_hecho_recuperacion')">
                    <option value="{{null}}" selected>Departamento</option>
                    @foreach ($departamento as $key => $value)
                      <option value="{{$value->id_departamento}}" >{{$value->departamento}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="input-field col s12 m6 l4 ">
                  <i class="material-icons prefix">chevron_right</i>
                  <select name="municipio_hecho_recuperacion" id="municipio_hecho_recuperacion">
                    <option value="{{null}}" selected>Municipio</option>
                  </select>
                </div>
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <select name="demarcacion_hecho" id="demarcacion_hecho">
                    <option value="{{null}}" selected>Demarcacion</option>
                    @foreach ($demarcacion as $key => $value)
                      <option value="{{$value->id_item}}" >{{$value->descripcion}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="input-field col s12 ">
                  <i class="material-icons prefix">chevron_right</i>
                  <input type="text" name="direccion_hecho" id="direccion_hecho">
                  <label for="direccion_hecho">Direccion completa</label>
                </div>

              </div>

              <div class="row">
                @include('partials.divider',['title'=> 'Descripcion del hecho'])

                <div class="input-field col s12">
                  <i class="prefix material-icons">chevron_right</i>
                  <textarea id="descripcion_hecho" name="descripcion_hecho" class="materialize-textarea"></textarea>
                  <label for="descripcion_hecho">Descripcion/Reseña</label>
                </div>

              </div>


            </form>
          </div>
        </div>
        <div class="modal-footer">
          <a class="btn" id="enviar_form" onclick="registrarRecuperacion()"><i class="material-icons left">check</i>Guardar</a>
          <a href="#!" class="modal-close waves-effect waves-green btn-flat"><i class="material-icons left">cancel</i>Cancelar</a>
        </div>
      </div>


        {{-- Eliminar, sin uso --}}
      {{-- Modal Form Recuperacion --}}
      <div id="modRecuperacion" class="modal valign-wrapper">
        <div class="modal-content center-align">
          <h4>Aqui iran los forms correspondientes :) </h4>
        </div>
      </div>

      {{-- Modal Ampliacion --}}
      <div id="modAmpliacion" class="modal valign-wrapper modal-fixed-footer">
        <div class="modal-content">
          <h4 class="center-align">Registro de ampliacion</h4>
          <div id="div_form-edit-arma">

          </div>
        </div>
        <div class="modal-footer ">
          <a class="btn" onclick="updateSend()"><i class="material-icons left">done</i>Guardar</a>
          <a class="modal-close waves-effect waves-green btn-flat"><i class="material-icons left">cancel</i>Cancelar</a>
        </div>
      </div>

      {{-- Modal Confirmar --}}
      <div id="modConfirmEstado" class="modal" style="height:fit-content; width: fit-content; margin-top: 8% ">
        <a href="#" class="btn btn-large" id="confirmStatus">Confirmar<i class="material-icons right">check</i></a>
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
  <script src="{{asset('js/consulta/show.js')}}"></script>
  <script>
    $(document).ready(function () {
      $('.tooltipped').tooltip();
      $('.collapsible').collapsible();
      $('.modal').modal();
    });



    let var_id_arma;

    // Muestra el historial del arma.
    function showHistorial(arma){
      $.ajax({
        url: "{{route('showHistorial')}}",
        type: 'POST',
        data:{
          arma,
          _token: '{{ csrf_token() }}'
        },
        dataType:'text',
        beforeSend: function (){},
        success: function (response){
          $('body').html(response);
        },
        error: function (response){

        }
      })
    }


    // Funcion para Ampliar Registros de las armas. (Cambiar a post)
    function editArma(arma) {
      // console.log(arma);

      //   Con una consulta ajax nos traemos todos los datos del arma para que sean modificados.
      $.ajax({
        url: "{{route('editArma')}}",
        type: "get",
        data: {
          {{--_token: '{{ csrf_token() }}'--}}
            arma
        },
        dataType: 'text',
        beforeSend: function () {
          $('.all-the-ground').show();
        },
        success: function (resp) {
          $('.all-the-ground').hide();
          $('#div_form-edit-arma').html(resp);

          $('#tipo_arma').select2({
            width: '100%',
            placeholder: 'Tipo de arma',
            allowClear: true,
            dropdownParent: $("#modAmpliacion"),
          });

          $('#marca_arma').select2({
            width: '100%',
            placeholder: 'Marca',
            allowClear: true,
            // tags: true,
            dropdownParent: $("#modAmpliacion"),
            language: {
              noResults: function () {
                return "<div style='display:flex; justify-content:space-between;'><div>No existe la categoria.</div><div><a class='btn' id='addMarca' onclick='agregarMarca()'>Agregar</a></div></div>";
              },
            },
            escapeMarkup: function (markup) {
              return markup;
            }
          });

          $('#calibre_arma').select2({
            width: '100%',
            placeholder: 'Calibre',
            allowClear: true,
            dropdownParent: $("#modAmpliacion"),
            // tags: true,
            language: {
              noResults: function () {
                return "<div style='display:flex; justify-content:space-between;'><div>No existe la categoria.</div><div><a class='btn' id='addCalibre' onclick='agregarCalibre()'>Agregar</a></div></div>";
              },
            },
            escapeMarkup: function (markup) {
              return markup;
            }
          });
          $('#modAmpliacion').modal('open');

        },
        error: function (xhr, status) {
          console.log(status, xhr);
        }
      })
    }

    function updateSend(){
      let data = $('#form-edit-arma').serialize();
      console.log(data);

      $.ajax({
        url: "{{route('updateArma')}}",
        type: "POST",
        dataType:"json",
        data: {
          data,
          _token: '{{ csrf_token() }}'
        },
        beforeSend:function (){},
        success: function (response){
          // console.log(response);
          $('#modSuccess').modal('open');
          $('#modAmpliacion').modal('close');
          setTimeout(() => {
            location.reload();
          }, 2000);
        },
        error:function (response,status){
          if(response.responseJSON.message == undefined){
            let errores = Object.values(response.responseJSON);
            errores.map(error => {
                M.toast({html: error });
              }
            )
          }
          if(response.responseJSON.message != ""){
            console.log('Hubo un erro, intente mas tardecito');
          }
        }
      })
    }

    // PENDIENTE -> Eliminar, sin uso.
    function showModalConfirm(id_arma) {
      // Ahora en lugar de que confirme, vamos a tener que mostrar un nuevo Modal.
      // Modal Form Pal registro de recuperada.

      $('#modRecuperacion').modal('open');
      $('#modConfirmEstado').modal('open');
      var_id_arma = id_arma;
    }
    // PENDIENTE -> Eliminar, sin uso.
    $('#confirmStatus').click(function () {
      // console.log('El id del arma es: '+var_id_arma);
      $.ajax({
        url: "{{route('editStatusArma')}}",
        type: "GET",
        data: {id_arma: var_id_arma},
        dataType: 'text',
        success: function (rspnse) {

          $('#modSuccess').modal('open');
          $('#modConfirmEstado').modal('close');
          $('#modEstadoArma').modal('close');
          // evaluamos si la rspnse fue exitosa.

          setTimeout(() => {
            location.reload();
          }, 2000);

        },
        error: function (xhr, status) {
          console.log('Error en la peticion - editStatus ')
        },
        complete: function (xhr, status) {
          console.log('Peticion realizada - editStatus')
        },

      })
    })




    // Editar Arma a Recuperada -Modals
    function editStatus(arma,id_denuncia) {
      $('#id_arma').attr('value',arma.id_arma);
      $('#id_denuncia').attr('value',id_denuncia);
      $('#modEstadoArma').modal('open');
    }
    // Registro de la recuperacion
    function registrarRecuperacion(){
       let datos = $('#recuperacion_arma').serialize();


      $.ajax({
        url: '{{route("registroRecuperacion")}}',
        type: "POST",
        data: {
          datos,
         _token: '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function (response) {
          console.log(response)
          $('#modSuccess').modal('open');
          setTimeout(() => {
            location.reload();
          }, 2000);
        },
        error: function (response, status) {
          if(response.responseJSON.message == undefined){
            let errores = Object.values(response.responseJSON);
            errores.map(error => {
                M.toast({html: error });
              }
            )
          }
        },
        complete: function (xhr, status) {
          console.log('Petición realizada');
        }
      });
    };

    function agregarMarca() {
      let marcaArma = $('input.select2-search__field').val().trim();
      let marcaArmaSelect = $('#marca_arma');
      $('#addMarca').addClass('disabled', 'disabled');
      $.ajax({
        url: '{{route("agregarMarca")}}',
        type: "GET",
        data: {marcaArma},
        dataType: "json",
        success: function (rspnse) {
          let {id_item, descripcion} = rspnse
          let option = new Option(descripcion, id_item, true, true);
          marcaArmaSelect.append(option).trigger('change');
          $('.select2-search__field').val('');
        },
        error: function (xhr, status) {
          console.log('Disculpe, existió un problema-agregarMarca');
        },
        complete: function (xhr, status) {
          console.log('Petición realizada');
        }
      });
    }

    function agregarCalibre() {
      let calibreArma = $('input.select2-search__field').val().trim();
      let calibreArmaSelect = $('#calibre_arma');
      $('#addCalibre').addClass('disabled', 'disabled');
      $.ajax({
        url: '{{route("agregarCalibre")}}',
        type: "GET",
        data: {calibreArma},
        dataType: "json",
        success: function (rspnse) {
          let {id_item, descripcion} = rspnse
          let option = new Option(descripcion, id_item, true, true);
          calibreArmaSelect.append(option).trigger('change');
          $('.select2-search__field').val('');
        },
        error: function (xhr, status) {
          console.log('Disculpe, existió un problema-agregarCalibre');
        },
        complete: function (xhr, status) {
          console.log('Petición realizada');
        }
      });
    }

    $('#tipo_documento').select2({
      width: '100%',
      placeholder: 'Tipo documento',
      allowClear: true,
      dropdownParent: $("#modEstadoArma"),
    });

  </script>
@endpush
