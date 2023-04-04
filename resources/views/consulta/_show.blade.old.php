@extends('layouts.plantilla')
@section('title','Consultas')


@section('content')
@component('components.container',['titlecard' =>'CONSULTA DE ARMAS DE FUEGO'])
  @slot('cardcontainer')


  <div class="container">
    <div class="col s12 offset-s2">
        
        <em>
            <h5 class="">
                <font face="Segoe UI" color="#2B0808">Datos personales: </font>
            </h5>
        </em>
    </div>
  </div>


    <div class="container">

        <table class="striped">
            <thead>
            </thead>
            <tbody>
                <tr>
                    <td>Nombres y apellidos:</td>
                    <td>
                    {{
                    $denuncias[0]->persona->primer_nombre.' '.
                    $denuncias[0]->persona->segundo_nombre.' '.
                    $denuncias[0]->persona->tercer_nombre.' '.
                    $denuncias[0]->persona->primer_apellido.' '.
                    $denuncias[0]->persona->segundo_apellido.' '.
                    $denuncias[0]->persona->tercer_apellido
                    }}
                    </td>
                </tr>
                <tr>
                    <td>Numero DPI:</td>
                    <td>
                    {{
                        $denuncias[0]->persona->no_dpi
                    }}
                    </td>
                </tr>
                <tr>
                    <td>Direccion de residencia:</td>
                    <td>
                    
                        @foreach ($departamento as $key => $value)
                            @if($value->id_departamento == ($denuncias[0]->persona->residencia->id_departamento) )
                            {{$value->departamento}}
                            @endif 
                        @endforeach
                        ,
                        @foreach ($municipio as $key => $value)
                            @if($value->id_municipio == ($denuncias[0]->persona->residencia->id_municipio) )
                            {{$value->municipio}}
                            @endif 
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        Numero de telefono:
                    </td>
                    <td>
                        {{$denuncias[0]->persona->no_telefono}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Fecha de nacimiento:
                    </td>
                    <td>
                        {{$denuncias[0]->persona->fecha_nacimiento}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Numero de tenencia:
                    </td>
                    <td>
                        {{$denuncias[0]->arma->no_tenencia}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Numero de licencia:
                    </td>
                    <td>
                        {{$denuncias[0]->arma->no_licencia}}
                    </td>
                </tr>
            </tbody>
        </table>




        
    </div>

    <div class="container">
        <div class="col s12 offset-s2">
            
            <em>
                <h5 class="">
                    <font face="Segoe UI" color="#2B0808">Denuncias: </font>
                </h5>
            </em>
        </div>
      </div>

        <br>
        <br>

        {{-- AQUI SE GENERARA LAS DENUNCIAS EN FUNCION DE LO EXISTENTE. --}}
        <div class="container">
            <ul class="collapsible expandable">
            @foreach ($denuncias as $key => $value)

                <li class="">
                    <div class="collapsible-header"> <i class="material-icons">filter_{{$key + 1}}</i>

                        <div class="col l6">
                            @foreach ($tipoArma as $keyA => $valueA)
                            @if($valueA->id_tipo_arma == ($value->arma->id_tipo_arma) )
                            {{$valueA->tipo_arma}}
                            @endif 
                            @endforeach
                        </div>

                        <div class="col l6 ">
                            Estado del arma en:
                            <em >
                                <span class="left-align" >
                                    {{-- Hay que avergiuar como se le llama cuando un arma esta en estado de solvente --}}
                                    @if($value->arma->estado_arma !== 'Solvente') 
                                    <font face="Segoe UI" class="red-text text-darken-3">
                                        "{{$value->arma->estado_arma}}"
                                    </font>
                                    @else
                                    <font face="Segoe UI" class="green-text text-darken-3">
                                        "{{$value->arma->estado_arma}}"
                                    </font>
                                    @endif
                                </span>
                            </em>
                        </div>
                    </div>


                    <div class="collapsible-body" >
                        {{-- AQUI IRAN LOS DATOS DEL ARMA --}}
                        <table class="striped">
                            <tbody>
                                <tr>
                                    <td>Tipo:</td>
                                    <td>
                                        @foreach ($tipoArma as $keyA => $valueA)
                                        @if($valueA->id_tipo_arma == ($value->arma->id_tipo_arma) )
                                        {{$valueA->tipo_arma}}
                                        @endif 
                                        @endforeach    
                                    </td>
                                </tr>
                                <tr>
                                    <td>Marca:</td>
                                    <td>
                                        @foreach ($marca as $keyA => $valueA)
                                        @if($valueA->id_marca == ($value->arma->id_marca))
                                            {{$valueA->marca}}
                                        @endif 
                                        @endforeach    
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Calibre:
                                    </td>
                                    <td>
                                        Falta incluir tabla calibre 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Pais de Fabricacion:
                                    </td>
                                    <td>
                                        @foreach ($paisFabricante as $keyA => $valueA)
                                        @if($valueA->id_pais_fabricante == ($value->arma->id_pais_fabricante))
                                            {{$valueA->pais_fabricante}}
                                        @endif 
                                        @endforeach  
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Modelo:
                                    </td>
                                    <td>
                                        {{$value->arma->modelo}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Numero de registro:
                                    </td>
                                    <td>
                                        {{$value->arma->no_registro}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Estado del arma en:
                                    </td>
                                    <td>
                                        {{$value->arma->estado_arma}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Direccion del hecho:
                                    </td>
                                    <td>
                                        {{$value->hecho->direccionhecho->referencia}}
                                        <br>
                                    @foreach ($departamento as $key => $valueDep)
                                        @if($valueDep->id_departamento == ($value->hecho->direccionhecho->id_departamento) )
                                        {{$valueDep->departamento}}
                                        @endif 
                                    @endforeach
                                    ,
                                    @foreach ($municipio as $key => $valueMuni)
                                        @if($valueMuni->id_municipio == ($value->hecho->direccionhecho->id_municipio) )
                                        {{$valueMuni->municipio}}
                                        @endif 
                                    @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hora y fecha:</td>
                                    <td>
                                        Fecha:
                                        {{date("d/m/Y",strtotime($value->hecho->fecha_hecho))}}
                                        <br>
                                        Hora: 
                                        {{date("H:i",strtotime($value->hecho->hora_hecho))}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Propietario</td>
                                    <td>
                                        @if ($value->arma->propietario == 'Denunciante')
                                            {{                   
                                            $denuncias[0]->persona->primer_nombre.' '.
                                            $denuncias[0]->persona->segundo_nombre.' '.
                                            $denuncias[0]->persona->tercer_nombre.' '.
                                            $denuncias[0]->persona->primer_apellido.' '.
                                            $denuncias[0]->persona->segundo_apellido.' '.
                                            $denuncias[0]->persona->tercer_apellido
                                            }}
                                        @else
                                            {{$value->arma->propietario}}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>

                        </table>


                    </div>
                </li>
             @endforeach
            </ul>
        </div>
    </div>


  @endslot
@endcomponent
@endsection