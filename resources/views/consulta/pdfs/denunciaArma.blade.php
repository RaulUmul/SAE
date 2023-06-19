<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{public_path('css/materialize.min.css')}}">
  <style>
    header{
      position: fixed;
      top: 0cm;
      left: 0cm;
      right: 0cm;
      /* height: 10cm; */
      /* color: white; */
      /* text-align: center; */
      /* line-height: 30px; */
    }
    h1{
      font-size: 1.5rem;
      margin-bottom: 0px; 
    }
    main{
			position: relative;
			top: 1cm;
		}
    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 1cm;
        text-align: right;
        /* line-height: 35px; */
    }

  </style>
</head>
<body>
  <header>
    <div class="row" >
        <div class="col s6">
          <span>Denuncia</span> 
        </div>
        <div class="col s5 right-align"  >
          <span>SAE</span>
        </div>
    </div>
    <hr style="position: relative; top: -15px">

  </header>

  <main>
    <div class="row center-align">
      <h1><b>Denuncia #{{$denuncia->denunciante->id_denuncia}}</b></h1>
    </div>
    <div class="row">
      <div class="col s12" style="">
          <div>
            <img src="{{public_path('img/persona.svg')}}" style="margin-bottom:-0.1cm">
            <span style="margin-bottom:0.1cm;">Datos del denunciante</span>
          </div>
          <div class="divider"></div>
      </div>
    </div>
    <div class="row">
      <div class="col s12">
          {{-- @dump($denuncia) --}}
          {{-- @dump($genero) --}}
        <table class="striped" id="tabla-denunciante">
          <tr>
            <th class="right-align">Primer nombre</th>
            <td>{{$denuncia->denunciante->persona->primer_nombre}}</td>
            <th class="right-align">Segundo nombre</th>
            <td>{{$denuncia->denunciante->persona->segundo_nombre}}</td>
            <th class="right-align">Tercer nombre</th>
            <td class="center-align">
            {{isset($denuncia->denunciante->persona->tercer_nombre) ? $denuncia->denunciante->persona->tercer_nombre :  "-" }}
            </td>
          </tr>
          <tr>
            <th class="right-align">Primer apellido</th>
            <td>{{$denuncia->denunciante->persona->primer_apellido}}</td>
            <th class="right-align">Segundo apellido</th>
            <td>{{$denuncia->denunciante->persona->segundo_apellido}}</td>
            <th class="right-align">Apellido casada</th>
            <td class="center-align">
              {{isset($denuncia->denunciante->persona->apellido_casada) ? $denuncia->denunciante->persona->apellido_casada :  "-" }}
              </td>
          </tr>
          <tr>
            <th class="right-align">CUI</th>
            <td class="center-align">
              {{isset($denuncia->denunciante->persona->cui) ? $denuncia->denunciante->persona->cui :  "-" }}
            </td>
            <th class="right-align">Pasaporte</th>
            <td class="center-align">
              {{isset($denuncia->denunciante->persona->pasaporte) ? $denuncia->denunciante->persona->pasaporte :  "-" }}
            </td>
            <th class="right-align">Telefono</th>
            <td class="center-align">
              {{isset($denuncia->denunciante->persona->telefono_celular) ? $denuncia->denunciante->persona->telefono_celular :  "-" }}
            </td>  
          </tr>
          <tr>
            <th class="right-align">Genero</th>
            @isset($denuncia->denunciante->persona->id_genero)
              @foreach ( $genero as  $value )
                @if( $value['id_item'] == ($denuncia->denunciante->persona->id_genero) )
                  <td>{{$value['descripcion']}}</td>
                  {{-- <td>{{$denuncia->denunciante->persona->id_genero}}</td> --}}
                @endif
              @endforeach
            @else
            <td class="center-align"> - </td>
            @endisset
            <th class="right-align">Fecha de nacimiento</th>
            <td class="center-align">
              {{isset($denuncia->denunciante->persona->fecha_nacimiento) ? $denuncia->denunciante->persona->fecha_nacimiento :  "-" }}
            </td>
            {{-- No esta funcionando la residencia aun --}}
            <th class="right-align">Residencia</th>
              @isset($denuncia->denunciante->persona->direccion->id_departamento) 
                @foreach ($departamento as $value)
                  @if($value['id_item'] == ($denuncia->denunciante->persona->direccion->id_departamento))
                    <td>{{$value['descripcion']}}</td>
                  @endif
                @endforeach
              @else
                <td class="center-align"> - </td>
              @endisset 
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col s12" style="">
          <div>
            <img src="{{public_path('img/descripcion.svg')}}" style="margin-bottom:-0.1cm">
            <span style="margin-bottom:0.1cm;">Datos del hecho</span>
          </div>
          <div class="divider"></div>
      </div>
    </div>
    <div class="row">
      <div class="col s12">
        <table class="striped" id="tabla-hecho">
          <tr>
            <th class="right-align">No. Diligencia</th>
            <td>{{$denuncia->hecho->numero_diligencia}}</td>
            <th class="right-align">Direccion del hecho</th>
            <td class="center-align">
              {{-- Direccion --}}
              {{-- Calle --}} {{-- o Avenida--}}
              {{isset($denuncia->hecho->direccion->calle) ? $denuncia->hecho->direccion->calle. " calle":null}}
              {{isset($denuncia->hecho->direccion->avenida) ? $denuncia->hecho->direccion->avenida. " avenida":null}}
              {{-- Casa --}}
              {{isset($denuncia->hecho->direccion->numero_casa) ? $denuncia->hecho->direccion->numero_casa:null}}
              {{-- Zona --}}
              {{isset($denuncia->hecho->direccion->zona) ? "Zona ".$denuncia->hecho->direccion->zona:null}}
              {{-- Municipio --}}
              @foreach ( $municipio as  $municip )
                @if( $municip->id_municipio == ($denuncia->hecho->direccion->id_municipio) )
                  {{$municip->municipio}},
                @endif
              @endforeach
              {{-- Departamento --}}
              @foreach ( $departamento as  $depto )
                @if( $depto->id_departamento == ($denuncia->hecho->direccion->id_departamento) )
                  {{$depto->departamento}}
                @endif
              @endforeach
            </td>
            <th class="right-align">Tipo del hecho</th>
            <td class="center-align">
              {{-- Tipo del hecho --}}
              @isset($denuncia->hecho->id_tipo_hecho)
                @foreach ( $tipo_denuncia as  $value )
                  @if( $value['id_item'] == ($denuncia->hecho->id_tipo_hecho) )
                    {{$value['descripcion']}}
                  @endif
                @endforeach
              @else
                -
              @endisset
            </td>
          </tr>
          <tr>
            <th class="right-align">Fecha</th>
            <td class="center-align">
              {{-- Fecha --}}
              {{isset($denuncia->hecho->fecha_hecho) ? date("d/m/Y",strtotime($denuncia->hecho->fecha_hecho)) : '-'}}
            </td>
            <th class="right-align">Hora</th>
            <td class="center-align">
              {{-- Hora --}}
              {{isset($denuncia->hecho->hora_hecho) ? date("H:i",strtotime($denuncia->hecho->hora_hecho)) : '-'}}
            </td>
            <th class="right-align">Narracion</th>
            <td class="center-align">
              {{-- Narracion --}}
              {{isset($denuncia->hecho->narracion) ? $denuncia->hecho->narracion : '-'}}
            </td>
          </tr>
        </table>
      </div>
    </div>
    @empty(!$denuncia->sindicados)
    <div class="row">
      <div class="col s12" style="">
          <div>
            <img src="{{public_path('img/personas.svg')}}" style="margin-bottom:-0.1cm">
            <span style="margin-bottom:0.1cm;">Datos de sindicado(s)</span>
          </div>
          <div class="divider"></div>
      </div>
    </div>
    @foreach ($denuncia->sindicados as $sindicado)
      <div class="row">
        <div class="col s12 tabla-sindicados">
          <table class="striped">
            <tr>
              <th class="right-align">Nombres</th>
              <td class="center-align">
                {{-- Nombres --}}
                {{isset($sindicado->persona->primer_nombre) ? $sindicado->persona->primer_nombre : null}}
                {{isset($sindicado->persona->segundo_nombre) ? $sindicado->persona->segundo_nombre : null}}
                {{isset($sindicado->persona->tercer_nombre) ? $sindicado->persona->tercer_nombre : null}}
                {{(!isset($sindicado->persona->primer_nombre) && !isset($sindicado->persona->segundo_nombre)  && !isset($sindicado->persona->tercer_nombre))? 'N/I' : null}}
              </td>
              <th class="right-align">Apellidos</th>
              <td class="center-align">
                {{-- Apellidos  --}}
                {{isset($sindicado->persona->primer_apellido) ? $sindicado->persona->primer_apellido : null}}
                {{isset($sindicado->persona->segundo_apellido) ? $sindicado->persona->segundo_apellido : null}}
                {{isset($sindicado->persona->apellido_casada) ? $sindicado->persona->apellido_casada : null}}
                {{!isset($sindicado->persona->primer_apellido)  && !isset($sindicado->persona->segundo_apellido) && !isset($sindicado->persona->apellido_casada) ?'N/I' : null}}
              </td>
              <th class="right-align">CUI</th>
              <td class="center-align">
                {{-- CUI --}}
                {{isset($sindicado->persona->cui) ? $sindicado->persona->cui : '-'}}
              </td>
            </tr>
            <tr>
              <th class="right-align">Pasaporte</th>
              <td class="center-align">
                {{-- Pasaporte --}}
                {{isset($sindicado->persona->pasaporte) ? $sindicado->persona->pasaporte : '-'}}
              </td>
              <th class="right-align">Telefono</th>
              <td class="center-align">
                {{-- Telefono --}}
                {{isset($sindicado->persona->telefono_celular) ? $sindicado->persona->telefono_celular : '-'}}
              </td>
              <th class="right-align">Edad</th>
              <td class="center-align">
                {{--  Edad --}}
                {{isset($sindicado->persona->edad) ? $sindicado->persona->edad : '-'}}
              </td>
            </tr>
            <tr>
              <th class="right-align">Fecha de nacimiento</th>
              <td class="center-align">
                {{--  Fecha nacimiento --}}
                {{isset($sindicado->persona->fecha_nacimiento) ? $sindicado->persona->fecha_nacimiento : '-'}}
              </td>
              <th class="right-align">Genero</th>
              <td class="center-align">
                {{-- Genero --}}
                @isset($sindicado->persona->id_genero)
                  @foreach ( $genero as  $value )
                    @if( $value['id_item'] == ($sindicado->persona->id_genero) )
                      {{$value['descripcion']}}
                    @endif
                  @endforeach
                @else
                  -
                @endisset
              </td>
              <th class="right-align">Direccion</th>
              <td class="center-align">
                {{-- Direccion --}}
                @empty(!$sindicado->persona->direccion)
                  @foreach($sindicado->persona->direccion as $direc)
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
                        {{$municip->municipio}}
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

                @else
                  -
                @endempty
              </td>
            </tr>
          </table>
          <div class="row" style="width: 100%"><div class="col s12"><div class="divider"></div></div></div>
        </div>
      </div>
    @endforeach
    @endempty
    <div class="row">
      <div class="col s12" style="">
          <div>
            <img src="{{public_path('img/warning.svg')}}" style="margin-bottom:-0.1cm">
            <span style="margin-bottom:0.1cm;">Arma(s)</span>
          </div>
          <div class="divider"></div>
      </div>
    </div>
    @foreach ($denuncia->armas as $arma)
    <div class="row tabla-armas">
      <div class="col s12">
        <table class="striped">
            <tr>
              <th class="right-align">Tipo de arma</th>
              <td class="center-align">
                {{-- Tipo Arma --}}
                @isset($arma->id_tipo_arma)
                  @foreach ( $tipo_arma as  $value )
                    @if( $value['id_item'] == ($arma->id_tipo_arma) )
                      {{$value['descripcion']}}
                    @endif
                  @endforeach
                @else
                  -
                @endisset
              </td>
              <th class="right-align">Marca de arma</th>
              <td class="center-align">
                {{-- Marca Arma --}}
                @isset($arma->id_marca_arma)
                  @foreach ( $marca_arma as  $value )
                    @if( $value->id_item == ($arma->id_marca_arma) )
                      {{$value->descripcion}}
                    @endif
                  @endforeach
                @else
                  -
                @endisset
              </td>
              <th class="right-align">Modelo</th>
              <td class="center-align">
                {{isset($arma->modelo_arma) ? $arma->modelo_arma : '-'}}
              </td>
            </tr>
            <tr>
              <th class="right-align">Registro</th>
              <td class="center-align">
                {{isset($arma->registro) ? $arma->registro : '-'}}
              </td>
              <th class="right-align">Licencia</th>
              <td class="center-align">
                {{isset($arma->licencia) ? $arma->licencia : '-'}}
              </td>
              <th class="right-align">Tenencia</th>
              <td class="center-align">
                {{isset($arma->tenencia) ? $arma->tenencia : 'N/I'}}
              </td>
            </tr>
            <tr>
              <th class="right-align">Calibre</th>
              <td class="center-align">
                {{-- Calibre --}}
                @isset($arma->id_calibre)
                  @foreach ( $calibre_arma as  $value )
                    @if( $value->id_item == ($arma->id_calibre) )
                      {{$value->descripcion}}
                    @endif
                  @endforeach
                @else
                  -
                @endisset
              </td>
              <th class="right-align">Cant. Tolvas</th>
              <td class="center-align">
                {{isset($arma->cantidad_tolvas) ? $arma->cantidad_tolvas : 'N/I'}}
              </td>
              <th class="right-align">Cant. Municion</th>
              <td class="center-align">
                {{isset($arma->cantidad_municion) ? $arma->cantidad_municion : 'N/I'}}
              </td>
            </tr>
          </table>
          <div class="row" style="width: 100%">
            <div class="col s12 right-align" style="font-size:0.4cm">
              Estado actual:
              @foreach ($estado_arma as  $estado)
                  @if($estado['id_item'] == ($arma->estado_arma))
                    <b>{{$estado['descripcion']}}<b>
                  @endif
              @endforeach
            </div>
          </div>
          <div class="row" style="width: 100%"><div class="col s12"><div class="divider"></div></div></div>
        </div>
      </div>
    @endforeach
  </main>

  <footer>
    <div class="row">
      <div class="col s12">
        <hr style="position: relative; top: 10px">
        Fecha impresion: {{date('d/m/Y H:i')}}
      </div>
    </div>
  </footer>
</body>
</html>

