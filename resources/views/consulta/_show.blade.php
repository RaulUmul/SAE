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
                  Denuncia No.<b> {{$denuncia['denunciante']->id_denuncia}}</b> {{' '}}  / Registro Arma 
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
                          <th>Direccion</th>
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
                          <td>Faltante</td>
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
                            {{-- Hay que ver como transformar los datos que vienen de direccion. --}}
                          {{-- {{isset($denuncia['hecho']->direccion->id_departamento) ? $denuncia['hecho']->direccion->id_departamento : 'N/I'}} --}}
                          </td>
                          <td>
                            {{-- Tipo del hecho --}}
                            {{isset($denuncia['hecho']->id_tipo_hecho) ? $denuncia['hecho']->id_tipo_hecho : 'N/I'}}
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
                            {{(!isset($sindicado->persona->primer_nombre) && !isset($sindicado->persona->segundo_nombre)  && !isset($sindicado->persona->tercer_nombre))? 'N/I' : null;}}
                            
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
                              {{-- Ver como integrar la direccion --}}
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
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            {{-- Tipo Arma --}}
                            @isset($denuncia['arma']->id_tipo_arma)
                            @foreach ( $tipo_arma as  $value )
                              @if( $value->id_item == ($denuncia['arma']->id_tipo_arma) )
                              {{$value->descripcion}}
                              @endif 
                            @endforeach 
                              @else
                              N/I
                          @endisset
                          </td>
                          <td>
                            {{-- Marca Arma --}}
                            @isset($denuncia['arma']->id_marca_arma)
                            @foreach ( $marca_arma as  $value )
                              @if( $value->id_item == ($denuncia['arma']->id_marca_arma) )
                              {{$value->descripcion}}
                              @endif 
                            @endforeach 
                              @else
                              N/I
                          @endisset
                          </td>
                          <td>
                            {{isset($denuncia['arma']->modelo_arma) ? $denuncia['arma']->modelo_arma : 'N/I'}}
                          </td>
                          <td>
                            {{isset($denuncia['arma']->registro) ? $denuncia['arma']->registro : 'N/I'}}
                          </td>
                          <td>
                            {{isset($denuncia['arma']->licencia) ? $denuncia['arma']->licencia : 'N/I'}}
                          </td>
                          <td>
                            {{isset($denuncia['arma']->tenencia) ? $denuncia['arma']->tenencia : 'N/I'}}
                          </td>
                          <td>
                            {{-- Calibre --}}
                            @isset($denuncia['arma']->id_calibre)
                            @foreach ( $calibre_arma as  $value )
                              @if( $value->id_item == ($denuncia['arma']->id_calibre) )
                              {{$value->descripcion}}
                              @endif 
                            @endforeach 
                              @else
                              N/I
                          @endisset
                          </td>
                          <td>
                            {{isset($denuncia['arma']->cantidad_tolvas) ? $denuncia['arma']->cantidad_tolvas : 'N/I'}}
                          </td>
                          <td>
                            {{isset($denuncia['arma']->cantidad_municion) ? $denuncia['arma']->cantidad_municion : 'N/I'}}
                          </td>
                          <td>
                            {{-- Hay que indicar quien es el propietario --}}
                            {{isset($denuncia['arma']->propietario) ? $denuncia['arma']->propietario : 'N/I'}}
                          </td>
                          <td>
                            {{-- Estatus --}}
                            @isset($denuncia['arma']->estado_arma)
                            @foreach ( $estado_arma as  $value )
                              @if( $value->id_item == ($denuncia['arma']->estado_arma) )
                              {{$value->descripcion}}
                              @endif 
                            @endforeach 
                              @else
                              N/I
                          @endisset
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    
                  </div>
                  <div class="col s12 white opos">
                    <h3 class="center-align">Accion</h3>
                   
                  </div>
  
                </div>
                </div>
              </li>
            </ul>
          </div>
        @endforeach

      </div>
          

    @endsection

  @endcomponent
@endsection

@push('scripts')
  <script>
    $(document).ready(function(){
     $('.collapsible').collapsible();
    });
  </script>
@endpush