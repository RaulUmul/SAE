@extends('layouts.plantilla')
@section('title','Crear denuncia')

@section('content')
  {{-- Componente Container --}}
  @component('components.container')
    @section('titulo_card','CREAR DENUNCIA')
    @section('contenido_card')
      <div class="col s12">
        <a class="waves-effect waves-light btn modal-trigger" href="#modal_renap">Modal</a>
      </div>

      <form >

        {{-- TABS --}}
        <div class="row">
          {{-- HEADERS TABS --}}
          <div class="cols s12">
            <ul class="tabs main">
              <li class="tab"><a id="linkPersona" href="#div-main_persona" class="active">1</a></li>
              <li class="tab"><a id="linkArma" href="#div-main_arma" class="">2</a></li>
              <li class="tab"><a id="linkHecho" href="#div-main_hecho">3</a></li>
              <li class="tab"><a id="linkSospechosos" href="#div-main_sospechosos">4</a></li>

            </ul>
          </div>

          {{-- REFERENCIAS TABS --}}

          {{-- MAIN PERSONA --}}
          <div class="cols s12" id="div-main_persona">
            @include('partials.divider',['title'=> 'Datos Personales'])
            {{-- Inputs --}}

            <div class="row">
              <div class="input-field col s12 m6 l4 ">
                <i class="material-icons prefix">chevron_right</i>
                <select  class="nacionalidad_persona" name="nacionalidad_persona" id="nacionalidad_persona" onchange="verificar_check()">
                  <option value="{{null}}" disabled selected>Nacionalidad</option>
                  <option value="Guatemalteca">Guatemalteca</option>
                  <option value="Extranjero"  >Extranjero</option>
                </select>
              </div>

              {{-- Aqui preguntamos si tiene documento o no. --}}
              <div class="input-field col s12 m6 l4" style="text-align: center">
                <span >¿Poseé documento de identificación?</span>
                <div style="display:flex; justify-content: center"> 
                    <label>
                      <input name="group1" type="radio" id="si_check" value="{{1}}"/>
                      <span>Si</span>
                    </label>
                    <label>
                      <input name="group1" type="radio"  id="no_check" value="{{0}}"/>
                      <span>No</span>
                    </label>
                </div>
              </div>

              {{-- Si tiene preguntamos que tipo de documento es. --}}

              <div class="input-field col s12 m6 l6" id="div_tipo_documento" hidden>
                <i class="material-icons prefix">chevron_right</i>
                <select name="tipo_documento" id="tipo_documento" onchange="selectTipoDocumento(value)">
                  <option value="0" selected disabled>Tipo de documento</option>
                  <option value="dpi">DPI</option>
                  <option value="pasaporte">Pasaporte</option>
                </select>
              </div>

              <div  class=" input-field col s12 m6 l6" id="div_documento_identificacion" hidden>
                  <i class="material-icons prefix">chevron_right</i>
                  <input type="text" disabled id="documento" name="documento" class="validate" value="">
                  <label for="documento" >Documento de Identificacion</label>
              </div>

            </div>

            <div class="row">
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="primer_nombre" name="primer_nombre" class="validate" value="{{old('primer_nombre')}}">
                <label for="primer_nombre" >Primer Nombre</label>
              </div>
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="segundo_nombre" name="segundo_nombre" class="validate" value="{{old('segundo_nombre')}}">
                <label for="segundo_nombre" >Segundo Nombre</label>
              </div>
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="tercer_nombre" name="tercer_nombre" class="validate" value="{{old('tercer_nombre')}}">
                <label for="tercer_nombre" >Tercer Nombre</label>
              </div>
            </div>

            <div class="row">
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="primer_apellido" name="primer_apellido" class="validate" value="{{old('primer_apellido')}}">
                <label for="primer_apellido" >Primer Apellido</label>
              </div>
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="segundo_apellido" name="segundo_apellido" class="validate" value="{{old('segundo_apellido')}}">
                <label for="segundo_apellido" >Segundo Apellido</label>
              </div>
              <div  class="input-field col s12 m6 l4" id="tercer_apellido">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="tercer_apellido" name="tercer_apellido" class="validate" value="{{old('tercer_apellido')}}">
                <label for="tercer_apellido" >Tercer Apellido</label>
              </div>
            </div>

            <div class="row">
              {{-- Aqui veremos lo de categoria item x ahora solo lo dejamo listo --}}
              <div class="input-field col s12 m6 l4 ">
                <i class="material-icons prefix">chevron_right</i>
                <select name="genero_persona" id="genero_persona">
                  <option value="{{null}}" selected>Genero</option>
                  {{-- @foreach ($generos as $key => $value)
                  <option value="{{}}" >{{}}</option>
                  @endforeach --}}
                </select>
              </div>
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="validate" value="{{old('fecha_nacimiento')}}">
                <label for="fecha_nacimiento" >Fecha nacimiento</label>
              </div>
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="number" id="telefono" name="telefono" class="validate" value="{{old('telefono')}}">
                <label for="telefono" >Telefono/Celular</label>
              </div>

            </div>

            @include('partials.divider',['title'=> 'Datos de residencia'])

            <div class="row">
              {{-- Aqui veremos lo de categoria item x ahora solo lo dejamo listo --}}
              <div class="input-field col s12 m6 l4 ">
                <i class="material-icons prefix">chevron_right</i>
                <select name="departamento_residencia" id="departamento_residencia">
                  <option value="{{null}}" selected>Departamento</option>
                  {{-- @foreach ($generos as $key => $value)
                  <option value="{{}}" >{{}}</option>
                  @endforeach --}}
                </select>
              </div>

              <div class="input-field col s12 m6 l4 ">
                <i class="material-icons prefix">chevron_right</i>
                <select name="municipio_residencia" id="municipio_residencia">
                  <option value="{{null}}" selected>Municipio</option>
                  {{-- @foreach ($generos as $key => $value)
                  <option value="{{}}" >{{}}</option>
                  @endforeach --}}
                </select>
              </div>
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="zona_residencia" name="zona_residencia" class="validate" value="{{old('zona_residencia')}}">
                <label for="zona_residencia">Zona</label>
              </div>
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="calle_residencia" name="calle_residencia" class="validate" value="{{old('calle_residencia')}}">
                <label for="calle_residencia" >Calle</label>
              </div>
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="avenida_residencia" name="avenida_residencia" class="validate" value="{{old('avenida_residencia')}}">
                <label for="avenida_residencia" >Avenida</label>
              </div>
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="numero_casa" name="numero_casa" class="validate" value="{{old('numero_casa')}}">
                <label for="numero_casa" >Numero de casa </label>
              </div>
              <div  class="input-field col s12 m6">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="direccion_residencia" name="direccion_residencia" class="validate" value="{{old('direccion_residencia')}}">
                <label for="direccion_residencia" >Dirección exacta </label>
              </div>
              <div  class="input-field col s12 m6">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="referencia_residencia" name="referencia_residencia" class="validate" value="{{old('referencia_residencia')}}">
                <label for="referencia_residencia" >Referencia </label>
              </div>

            </div>


            {{-- Fila de Botones --}}
            <div class="row">
              {{-- Boton Cancelar --}}
              <div class="col s12 form-button_cancelar">
                <div>
                  <p>Cancelar</p>
                  <a  href="{{route('denuncia.index')}}" id="index_button_cancel" class="waves-light red btn" >
                    <i class="large material-icons">cancel</i>
                  </a>
                </div>
              </div>
              {{-- Boton Siguiente  --}}
              <div class="col s12 container-button_siguiente">
                <div  class="button_siguiente">
                  <p>Siguiente</p>
                  <a id="main_arma_button" class=" waves-light btn" style="padding-left: 2rem;padding-right: 2rem;">
                    <i class="large material-icons">arrow_forward</i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          {{-- MAIN ARMA --}}
          <div class="cols s12" id="div-main_arma">
            @include('partials.divider',['title'=> 'Datos del Arma'])
            <div class="row">

             {{-- Inputs --}}
              
             {{-- Ingresamos un Tab para agregar armas --}}

             <div class="row" style="min-height: 50vh; ">
              <div class="col s12" >
                <ul class="tabs main_arma">
                  <li id="arma_asociada" class="tab col s3 active-tab z-depth-3"><a id="linkAsociada" href="#container_collapsible" class="blue-text text-darken-2 ">Armas asociadas</a></li>
                  <li id="arma_plus" class="tab col s3 deactive-tab"><a id="linkAgregar" href="#divtab_arma_plus" class="blue-text text-darken-2" ><i class="tiny material-icons">add_circle_outline</i>Agregar Arma</a></li>
                  <li class="tab col s0 m6 deactive-tab" style="min-width: 100w"></li>
                </ul>



                <div id="divtab_arma_plus" class="col s12"  style=" background-color: #93939314">
                  
                  {{-- Aqui agregar los inputs --}}

                  <div class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">chevron_right</i>
                    <select name="tipo_arma" id="tipo_arma">
                      <option value="{{null}}" selected>Tipo de arma</option>
                      {{-- @foreach ($generos as $key => $value)
                      <option value="{{}}" >{{}}</option>
                      @endforeach --}}
                    </select>
                  </div>
                  <div class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">chevron_right</i>
                    <select name="marca_arma" id="marca_arma">
                      <option value="{{null}}" selected>Tipo de arma</option>
                      {{-- @foreach ($generos as $key => $value)
                      <option value="{{}}" >{{}}</option>
                      @endforeach --}}
                    </select>
                  </div>
                  <div  class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">chevron_right</i>
                    <input type="text" id="modelo_arma" name="modelo_arma" class="validate" value="">
                    <label for="modelo_arma">Modelo </label>
                  </div>
                  <div  class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">chevron_right</i>
                    <input type="text" id="tenencia_arma" name="tenencia_arma" class="validate" value="">
                    <label for="tenencia_arma">Numero tenencia</label>
                  </div>
                  <div  class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">chevron_right</i>
                    <input type="text" id="licencia_arma" name="licencia_arma" class="validate" value="">
                    <label for="licencia_arma">Numero licencia</label>
                  </div>
                  <div  class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">chevron_right</i>
                    <input type="text" id="registro_arma" name="registro_arma" class="validate" value="">
                    <label for="registro_arma">Numero Registro / Serie</label>
                  </div>

                  <div class="input-field col s12 m6 l4 ">
                    <i class="material-icons prefix">chevron_right</i>
                    <select name="calibre_arma" id="calibre_arma">
                      <option value="{{null}}" selected>Calibre</option>
                      {{-- @foreach ($generos as $key => $value)
                      <option value="{{}}" >{{}}</option>
                      @endforeach --}}
                    </select>
                  </div>

                  <div class="input-field col s12 m6 l4 ">
                    <i class="material-icons prefix">chevron_right</i>
                    <select name="pais_fabricacion" id="pais_fabricacion">
                      <option value="{{null}}" selected>Pais fabricación</option>
                      {{-- @foreach ($generos as $key => $value)
                      <option value="{{}}" >{{}}</option>
                      @endforeach --}}
                    </select>
                  </div>
                  <div  class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">chevron_right</i>
                    <input type="number" id="cantidad_tolvas" name="cantidad_tolvas" class="validate" value="">
                    <label for="cantidad_tolvas">Cantidad de tolvas</label>
                  </div>
                  <div  class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">chevron_right</i>
                    <input type="number" id="cantidad_municion" name="cantidad_municion" class="validate" value="">
                    <label for="cantidad_municion">Cantidad de municion</label>
                  </div>

                  {{-- El bloque sig. Oculta o agrega el Input donde Se ingresa el propietario del arma --}}
                  <div class="input-field col s12 l4 " id="div_propietario">
                    <i class="material-icons prefix">chevron_right</i>
                    <select name="propietario" id="propietario" onchange="selectChangePropietario(value)">
                      <option value=""  selected>Seleccione propietarios</option>
                      <option value="Denunciante">Denunciante</option>
                      <option value="Otro"  >Otro</option>
                    </select>
                  </div>

                  {{-- Div contenedor del Input Propietario --}}
                  <div id="div_denunciante" class="input-field col s12 l8">
                  </div>

                  {{-- Boton Guardar Arma --}}
                  <div class="col s12" style="display: flex; justify-content: end;">
                          <a href="#container_collapsible" class="waves-effect waves-light btn gray"  id="addArma">+Agregar arma</a>
                  </div>


                </div>

                <div id="container_collapsible" class="col s12" style=" background-color: #93939314;">
                  
                  <div id="container_collapsible_son" class=" col s12 " style="min-width: 100%">
                  </div>

                  <div id="advice1" class=" col s12  " style="display: flex; justify-content: center; padding: 2rem; ">
                    <p id="text-advice" class="red-text">Agruegue un arma...</p>
                  </div>
                  
                  <div class=" container  col s12" >
                    <div class="divider"></div>
                  </div>

                  {{-- Boton Siguiente  --}}
                  <div class="col s12 container-button_siguiente">
                    <div  class="button_siguiente">
                      <p>Siguiente</p>
                      <a id="main_hecho_button"  class=" waves-light btn" style="padding-left: 2rem;padding-right: 2rem;" >
                        <i class="large material-icons">arrow_forward</i>
                      </a>
                    </div>
                  </div>
                </div>

              </div>
            </div>


            </div>

            {{-- Fila de Botones --}}
            <div class="row">
              {{-- Boton Cancelar --}}
              <div class="col s12 form-button_cancelar">
                <div>
                  <p>Atras</p>
                  <a   id="main_persona_button_back" class=" waves-light red btn" style="padding-left: 2rem;padding-right: 2rem;">
                    <i class="large material-icons">arrow_back</i>
                  </a>
                </div>
              </div>
              
            </div>
          </div>

          {{-- MAIN HECHO --}}
          <div class="cols s12" id="div-main_hecho">
            @include('partials.divider',['title'=> 'Datos del hecho'])
            <div class="row">

            {{-- Inputs --}}
              <div class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" name="numero_diligencia" id="numero_diligencia" class="validate" value="{{old('numero_diligencia')}}">
                <label for="numero_diligencia" class="active">Numero diligencia</label>
              </div>

              <div class="input-field col s12 m6 l4 ">
                <i class="material-icons prefix">chevron_right</i>
                <select name="tipo_hecho" id="tipo_hecho">
                  <option value="{{null}}" selected>Tipo de hecho</option>
                  {{-- @foreach ($generos as $key => $value)
                  <option value="{{}}" >{{}}</option>
                  @endforeach --}}
                </select>
              </div>

              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="date" id="fecha_hecho" name="fecha_hecho" class="validate" value="{{old('fecha_hecho')}}">
                <label for="fecha_hecho" >Fecha del hecho</label>
              </div>

              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="time" id="hora_hecho" name="hora_hecho" class="validate" value="{{old('hora_hecho')}}">
                <label for="hora_hecho" >Hora aproximada</label>
              </div>

              <div class="input-field col s12 m6 l4 ">
                <i class="material-icons prefix">chevron_right</i>
                <select name="departamento_hecho" id="departamento_hecho">
                  <option value="{{null}}" selected>Departamento</option>
                  {{-- @foreach ($generos as $key => $value)
                  <option value="{{}}" >{{}}</option>
                  @endforeach --}}
                </select>
              </div>

              <div class="input-field col s12 m6 l4 ">
                <i class="material-icons prefix">chevron_right</i>
                <select name="municipio_hecho" id="municipio_hecho">
                  <option value="{{null}}" selected>Municipio</option>
                  {{-- @foreach ($generos as $key => $value)
                  <option value="{{}}" >{{}}</option>
                  @endforeach --}}
                </select>
              </div>
            </div>

            <div class="row">
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="zona_hecho" name="zona_hecho" class="validate" value="{{old('zona_hecho')}}">
                <label for="zona_hecho" >Zona</label>
              </div>
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="calle_hecho" name="calle_hecho" class="validate" value="{{old('calle_hecho')}}">
                <label for="calle_hecho" >Calle</label>
              </div>
              <div  class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="avenida_hecho" name="avenida_hecho" class="validate" value="{{old('avenida_hecho')}}">
                <label for="avenida_hecho" >Avenida</label>
              </div>
            </div>

            <div class="row">
              <div  class="input-field col s12 m6">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="direccion_hecho" name="direccion_hecho" class="validate" value="{{old('direccion_hecho')}}">
                <label for="direccion_hecho" >Direccion exacta</label>
              </div>

              <div  class="input-field col s12 m6">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="referencia_hecho" name="referencia_hecho" class="validate" value="{{old('referencia_hecho')}}">
                <label for="referencia_hecho">Referencia </label>
              </div>

              <div  class="input-field col s12">
                <i class="material-icons prefix">chevron_right</i>
                <input type="text" id="narracion_hecho" name="narracion_hecho" class="validate" value="{{old('narracion_hecho')}}">
                <label for="narracion_hecho">Narracion del hecho </label>
              </div>

            </div>

            {{-- Fila de Botones --}}
            <div class="row">
              {{-- Boton Atras --}}
              <div class="col s12 form-button_cancelar">
                <div>
                  <p>Atras</p>
                  <a   id="main_arma_button_back" class=" waves-light red btn" style="padding-left: 2rem;padding-right: 2rem;">
                    <i class="large material-icons">arrow_back</i>
                  </a>
                </div>
              </div>
              {{-- Boton Siguiente  --}}
              <div class="col s12 container-button_siguiente">
                <div  class="button_siguiente">
                  <p>Siguiente</p>
                  <a id="main_sospechosos_button"  class=" waves-light btn" style="padding-left: 2rem;padding-right: 2rem;" >
                    <i class="large material-icons">arrow_forward</i>
                  </a>
                </div>
              </div>
            </div>
          </div>


          {{-- MAIN SOSPECHOSOS --}}
          <div class="cols s12" id="div-main_sospechosos">
            @include('partials.divider',['title'=> 'Datos de sindicados / sospechosos'])
            <div class="row" style="min-height: 50vh; ">
              <div class="col s12" >
                <ul class="tabs main_arma">
                  <li id="sospechoso_asociado" class="tab col s3 active-tab z-depth-3"><a id="linkSospechosoAsociado" href="#container_collapsible_sospechoso" class="blue-text text-darken-2 ">Sindicados/Sospechosos</a></li>
                  <li id="sospechoso_plus" class="tab col s3 deactive-tab"><a id="linkAgregarSospechoso" href="#divtab_sospechoso_plus" class="blue-text text-darken-2" ><span><i class="tiny material-icons">add_circle_outline</i>Agregar persona</span></a></li>
                  <li class="tab col s0 m6  deactive-tab" style="min-width: 100w"></li>
                </ul>

                <div id="divtab_sospechoso_plus" class="col s12"  style=" background-color: #93939314">

                  {{-- El bloque sig. modifica el input del tipo de documento segun nacionalidad --}}
                  <div class="row">
                    <br>
                    <div class="col s12">
                      <span><b>Ingrese los datos conocidos del sindicado(a)</b></span>
                    </div>

                    <div class="input-field col s12 m6 l4 ">
                      <i class="material-icons prefix">chevron_right</i>
                      <select name="nacionalidad_sindicado" id="nacionalidad_sindicado">
                        <option value="0" disabled selected>Nacionalidad</option>
                        <option value="Guatemalteca">Guatemalteca</option>
                        <option value="Extranjero"  >Extranjero</option>
                      </select>
                    </div>
      
                    <div class="input-field col s12 m6 l4">
                      <i class="material-icons prefix">chevron_right</i>
                      <input type="number" id="cui_sindicado" name="cui_sindicado" class="validate" value="">
                      <label for="cui_sindicado" class="active">No. DPI / CUI</label>
                    </div>


                    <div class="input-field col s12 m6 l4">
                      <i class="material-icons prefix">chevron_right</i>
                      <input type="text" id="pasaporte_sindicado" name="pasaporte_sindicado" class="validate" value="">
                      <label for="pasaporte_sindicado" class="active">Pasaporte</label>
                    </div>

                    <div class="input-field col s12 m6 l4">
                      <i class="material-icons prefix">chevron_right</i>
                      <input type="text" id="nombres_sindicado" name="nombres_sindicado" class="validate" value="">
                      <label for="nombres_sindicado" class="active">Nombres</label>
                    </div>

                    <div class="input-field col s12 m6 l4">
                      <i class="material-icons prefix">chevron_right</i>
                      <input type="text" id="apellidos_sindicado" name="apellidos_sindicado" class="validate" value="">
                      <label for="apellidos_sindicado" class="active">Apellidos</label>
                    </div>

                    <div class="input-field col s12 m6 l4 ">
                      <i class="material-icons prefix">chevron_right</i>
                      <select name="genero_sindicado" id="genero_sindicado">
                        <option value="{{null}}" selected>Genero</option>
                        {{-- @foreach ($generos as $key => $value)
                        <option value="{{}}" >{{}}</option>
                        @endforeach --}}
                      </select>
                    </div>

                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l4">
                      <i class="material-icons prefix">chevron_right</i>
                      <input type="number" id="edad_sindicado" name="edad_sindicado" class="validate" value="">
                      <label for="edad_sindicado" class="active">Edad</label>
                    </div>

                    <div class="input-field col s12 m6 l4">
                      <i class="material-icons prefix">chevron_right</i>
                      <input type="text" id="caracteristicas_fisicas" name="caracteristicas_fisicas" class="validate" value="">
                      <label for="caracteristicas_fisicas" class="active">Caracteristicas fisicas</label>
                    </div>

                    <div class="input-field col s12 m6 l4">
                      <i class="material-icons prefix">chevron_right</i>
                      <input type="text" id="vestimenta" name="vestimenta" class="validate" value="">
                      <label for="vestimenta" class="active">Vestimenta</label>
                    </div>

                    <div class="input-field col s12 m6 l4">
                      <i class="material-icons prefix">chevron_right</i>
                      <input type="text" id="organizacion_criminal" name="organizacion_criminal" class="validate" value="">
                      <label for="organizacion_criminal" class="active">Organización criminal</label>
                    </div>

                    {{-- Movilizacion? --}}
                    <div class="input-field col s12 m6 l4">
                      <i class="material-icons prefix">chevron_right</i>
                      <input type="text" id="movilizacion" name="movilizacion" class="validate" value="">
                      <label for="movilizacion" class="active">Movilización</label>
                    </div>

                    <div class="input-field col s12 m6 l4">
                      <i class="material-icons prefix">chevron_right</i>
                      <input type="text" id="telefono_sindicado" name="telefono_sindicado" class="validate" value="">
                      <label for="telefono_sindicado" class="active">Telefono / Celular</label>
                    </div>
                    
    
                  </div>

                  {{-- Boton Guardar Arma --}}
                  <div class="col s12" style="display: flex; justify-content: end;">
                    <a href="#divtab_sospechoso_plus" class="waves-effect waves-light btn gray"  id="addSindicado">+Agregar sindicado</a>
                  </div>
    
                </div>

                <div id="container_collapsible_sospechoso" class="col s12" style=" background-color: #93939314;">
              
                  <div id="advice2" class=" col s12  " style="display: flex; justify-content: center; padding: 2rem; ">
                    <p id="text-advice_2" class="red-text">Si existen sindicados, agregarlos...</p>
                  </div>
                  
                  <div class=" container  col s12" >
                    <div class="divider"></div>
                  </div>
                </div>

                <div class="row">
                  <div class="col s12" style="display: flex; justify-content: space-around ">
                    {{-- Boton atras --}}
                    <div  class=""  style="display: flex; flex-direction: column;backdrop-filter: blur(10px); text-align: center;">
                      <p>Atras</p>
                      <a   id="main_hecho_button_back" class=" waves-light red btn" style="padding-left: 2rem;padding-right: 2rem;">
                        <i class="large material-icons">arrow_back</i>
                      </a>
                    </div>

                    {{-- Boton Enviar --}}
                    <div class="" style="display:flex; align-self: flex-end;">
                      <button class="btn waves-effect waves-light" type="submit" name="action" id="Enviar">
                        Enviar
                        <i class="large material-icons right">send</i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </form>


      <div id="modal_renap" class="modal">
        <div class="modal-content">
          <h4>Cargando...</h4>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col s12" style="display: flex; justify-content: space-around ">
              <div class="" style="display:flex; align-self: flex-end;">
                <a  class=" modal-close waves-light red btn" style="padding-left: 2rem;padding-right: 2rem;">
                  Cancelar
                  <i class="large material-icons right">cancel</i>
                </a>
              </div>
              <div class="" style="display:flex; align-self: flex-end;">
                <a onclick="insertar_datos()"  class="waves-light btn" style="padding-left: 2rem;padding-right: 2rem;">
                  Aceptar
                  <i class="large material-icons right">check</i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

    @endsection
  @endcomponent
  {{-- Fin Componente Container --}}
@endsection

@push('scripts')
  <script src="{{asset('js/denuncia/create.js')}}"></script>
  <script>
    // Document Ready
    // Carga lo que existe en el local storage
    $(document).ready(function(){
      $('.tabs').tabs();
      if(window.location.reload){
          reload = true;
      }
      // Traemos los datos actuales
      let datosLocalStorage = JSON.parse(localStorage.getItem("data"));
      // Si hay datos en el storage, los cargamos y los volvemos a guardar.
      if(datosLocalStorage != null && reload == true ){

        $.ajax({
          url: "{{route('form_arma')}}",
          type: 'get',
          data: {
            datosLocalStorage
          },
          dataType: 'text',
          // beforeSend: mostrarImagenCargando,

          success: function (rspnse){
            $('#container_collapsible_son').append(
              rspnse
            )
            $('.collapsible').collapsible(); 
          },
          error : function(xhr, status) {
          console.log('Disculpe, existió un problema');
          },
          complete : function(xhr, status) {
          console.log('Petición realizada');
          }

        })


        
        // Agregar el input del propietario?
        $('.collapsible').collapsible(); 
        $('.dropdown-trigger').dropdown();
        $('#advice1').remove();
        
      } //Fin del if principal.
    }); //Fin ReadyDocument

    // 1. Formulario Datos Personales.

    // Verificamos que hayan ingresado 13 digitos en el CUI
    // $('#cui').on('change', function(event) {
    //   console.log(event.target.value);
    //   if (event.target.value.length == 13) {
    //     window.alert('You have reached the maximum input length.');
    //   }
    // });

    function insertar_datos(){
    };

    //  VERIFICAR CUI 
    function verificarCUI() {
      // Primero vamos a consultar.

      let cui = $('#cui').val();
      let statsCUI = checkCampos(cui);
      // var elems = document.querySelectorAll('.modal');
      // M.Modal.init(elems);
      // var instance = M.Modal.getInstance(elems);
      $('#modal_renap').html(`
        <div class="modal-content">
          <h4>Cargando...</h4>
        </div>
      `);

      if(statsCUI){
        // Si no viene vacio
        $('input#cui').removeClass('invalid');
        $('#modal_renap').modal('open');

        $.ajax({
          url: "{{route('consulta_renap')}}",
          type: "GET",
          data: {
            cui,
          },
          dataType: "json",
        success : function(rspnse) {


          if(rspnse.error != "" ){
            $('#modal_renap').html(`
            <div class="modal-content">
              <h4>Error</h4>
              <div>
                <span>Se ha encontrado un error: </span><br>
                <span>${rspnse.descripcion}</span><br>
              </div>
            </div>
            `)
            
          }else{
            console.log(rspnse);
            $('#modal_renap').html(`
            <div class="modal-content">
              <h4>Datos encontrados</h4>
              <div>
                <span>DPI: ${rspnse.dpi}</span><br>
                <span>Nombre: ${rspnse.primer_nombre} ${rspnse.segundo_nombre} ${rspnse.tercer_nombre}</span><br>
                <span>Nombre: ${rspnse.primer_apellido} ${rspnse.segundo_apellido}</span><br>
              </div>
            </div>
            <div class="modal-footer">
              <div class="row">
                <div class="col s12" style="display: flex; justify-content: space-around ">
                  <div class="" style="display:flex; align-self: flex-end;">
                    <a  class=" waves-light red btn" style="padding-left: 2rem;padding-right: 2rem;">
                      Cancelar
                      <i class="large material-icons right">cancel</i>
                    </a>
                  </div>
                  <div class="" style="display:flex; align-self: flex-end;">
                    <a  class=" waves-light btn" style="padding-left: 2rem;padding-right: 2rem;">
                      Aceptar
                      <i class="large material-icons right">check</i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            `)

          }



        },
        error : function(xhr, status) {
          console.log('Disculpe, existió un problema');
        },
          complete : function(xhr, status) {
          console.log('Petición realizada');
        }

        });

      }else{
      // Si viene vacio.
        $('input#cui').addClass('invalid');


      }

      // $.ajax({
      //   url: "{{route('consulta_renap')}}",
      //   type: "GET",
      //   data: {
      //     // Enviamos el valor del dpi
      //     // _token: '{{ csrf_token() }}'
      //   },

      //   // El dataType es el formato de lo que recibo
      //   dataType: "json",
      // })
    };


    // 2. Formulario Datos del Arma

    // Añadimos el arma
    $('#addArma').click(function(e){
          
      e.preventDefault();
      // Verificamos estado del campo registro del arma.
      let check = checkCampos($('#registro_arma').val());
      // Si han ingresado el numero de registro
      if(check){
        $('input#registro_arma').removeClass('invalid'); //Quitamos la clase invalid
        agregarArma(reload); //Mandamos el ajax.
        M.toast({html: 'Arma agregada!'}) //Notificamos que ya se agrego el arma
        borrarInput();  //Borramos los campos ya enviados.
        $('#arma_asociada').trigger('click');
        $('#linkAgregar').removeClass('active');
        $('#linkAsociada').addClass('active');
        $('.tabs').tabs();
        // Para borrar la cache.
        if(reload == true){
          setTimeout(() => {
            reload = false;
            console.log(reload);
          }, 5000);
        }
      }else{ //Si no han ingresado el numero de registro, lanzamos el focus.
        $('input#registro_arma').addClass('invalid');
        $('input#registro_arma').focus();
        return;
      }
    });


    // Funcion que ejecuta el boton para eliminar un arma en la lista de asociadas.
    function restarArma(obj) { 
      $(`#collapsible_${obj}`).remove();
      let indexReal = obj;
      // console.log('indexdata:',indexReal);
      let datosLocalStorage = JSON.parse(localStorage.getItem("data"));

      datosLocalStorage.splice(indexReal,1)
      // console.log(datosLocalStorage);
      localStorage.setItem('data',JSON.stringify(datosLocalStorage));
      // Y volvemos a pintar pa que coincida el index del collapsible con el index del local.
      let acomulacion = "";

      datosLocalStorage.map((elemento,index)=>{
          

          acomulacion += `<ul class="collapsible" id="collapsible_${index}">
            <li>
              <div class="collapsible-header deleteCollapse">
                ${index+1}. ${elemento.tipo_arma} 
                  <div>
                    <a  onclick="restarArma(${index})"><i class="material-icons right">delete</i></a>
                  </div>
              </div>
              <div class="collapsible-body">
                ${((elemento.value_tipo_arma) == "" ) ?
                `` :
                `<div class="input-field ">
                  <input type="hidden" name="arma_plus_${index}[tipo_arma]" id="tipo_arma_plus_${index}" value="${elemento.tipo_arma}">
                  <label>Tipo de Arma: ${elemento.tipo_arma}</label> 
                </div>  <br>`} 
                        
                ${((elemento.value_marca_arma) == "") ?
                `` : 
                `<div class="input-field ">
                  <input type="hidden" name="arma_plus_${index}[marca_arma]" id="marca_arma_plus_${index}" value="${elemento.marca_arma}">
                  <label>Marca: ${elemento.marca_arma}</label>
                </div> <br>`}
                        
                ${((elemento.modelo_arma) == "") ?
                `` :
                `<div class="input-field ">
                  <input type="hidden" name="arma_plus_${index}[modelo_arma]" id="modelo_arma_plus_${index}" value="${elemento.modelo_arma}">
                  <label>Modelo: ${elemento.modelo_arma}</label>
                </div>  <br>`}
                        
                ${((elemento.tenencia_arma) == "") ?
                `` :
                `<div class="input-field ">
                  <input type="hidden" name="arma_plus_${index}[tenencia_arma]" id="tenencia_arma_plus_${index}" value="${elemento.tenencia_arma}">
                  <label>Tenencia: ${elemento.tenencia_arma}</label>
                </div>  <br>`}
                        
                ${((elemento.licencia_arma) == "") ?
                `` :
                `<div class="input-field ">
                  <input type="hidden" name="arma_plus_${index}[licencia_arma]" id="licencia_arma_plus_${index}" value="${elemento.licencia_arma}">
                  <label>Licencia: ${elemento.licencia_arma}</label>
                </div>  <br>`}
                        

                <div class="input-field ">
                  <input type="hidden" name="arma_plus_${index}[registro_arma]" class="localizador" id="registro_arma_plus_${index}" value="${elemento.registro_arma}">
                  <label>Numero de registro: ${elemento.registro_arma}</label>
                </div>  <br>
                        
                ${((elemento.value_pais_fabricacion) <= 0) ?
                `` :
                `<div class="input-field ">
                  <input type="hidden" name="arma_plus_${index}[pais_fabricacion]" id="pais_fabricacion_plus_${index}" value="${elemento.pais_fabricacion}">
                  <label>Pais de fabricacion: ${elemento.pais_fabricacion}</label>
                </div>  <br>`}
                        
                ${((elemento.cantidad_tolvas) == "") ?
                `` :
                `<div class="input-field ">
                  <input type="hidden" name="arma_plus_${index}[cantidad_tolvas]" id="cantidad_tolvas_plus_${index}" value="${elemento.cantidad_tolvas}">
                  <label>Cantidad de tolvas: ${elemento.cantidad_tolvas}</label>
                </div> <br>`}

                ${((elemento.cantidad_municion) == "") ?
                `` :
                `<div class="input-field ">
                  <input type="hidden" name="arma_plus_${index}[cantidad_municion]" id="cantidad_tolvas_plus_${index}" value="${elemento.cantidad_municion}">
                  <label>Cantidad de municion: ${elemento.cantidad_municion}</label>
                </div> <br>`}
                ${((elemento.propietario) == "") ?
                `` :
                `<div class="input-field ">
                  <input type="hidden" name="arma_plus_${index}[propietario]" id="cantidad_tolvas_plus_${index}" value="${elemento.propietario}">
                  <label>Propietario: ${elemento.propietario}</label>
                </div> <br>`}
              </div>
            </li>
          </ul>`;
      })
          
      $('#container_collapsible_son').html(acomulacion);

      // Agregar el input del propietario?
      $('.collapsible').collapsible(); 
      $('.dropdown-trigger').dropdown();
      $('#advice1').remove();
      // Verificamos si existe un elemento, si no existe volvemos a poner el anuncio.
      // console.log($('#container_collapsible_son'));
      if($('#container_collapsible_son').length == 0){
        console.log('0elementos');
      }
    };


    // Funcion que ejecuta el boton addArma para asociar armas.
    function agregarArma(reloadStatus){
      let tipo_arma = $('#tipo_arma option:selected').text(),
      value_tipo_arma = $('#tipo_arma').val(),
      marca_arma = $('#marca_arma option:selected').text(),
      value_marca_arma = $('#marca_arma').val(),
      modelo_arma = $('#modelo_arma').val(),
      tenencia_arma = $('#tenencia_arma').val(),
      licencia_arma = $('#licencia_arma').val(),
      registro_arma = $('#registro_arma').val(),
      pais_fabricacion = $('#pais_fabricacion option:selected').text(),
      value_pais_fabricacion = $('#pais_fabricacion').val(),
      cantidad_tolvas = $('#cantidad_tolvas').val(),
      cantidad_municion = $('#cantidad_municion').val(),
      propietario = $('#propietario').val();
      
        
      $.ajax({
        url: "{{route('agregarArma')}}",
        type: "GET",
        data: {
          // statusReload: reloadStatus,
          registroArma: registro_arma,
          // _token: '{{ csrf_token() }}'
        },

        // El dataType es el formato de lo que recibo
        dataType: "json", 
        success : function(rspnse) {

          // Variable para validar el proceso de guardar los datos del arma.
          let registro_repetido = false;
          // Hay que evaluar que tampoco se vuelva a ingresar el mismo arma.
          let anuncio = $('#advice1');
          // Si ya no existe el anuncio, procedemos a verificar los valores de registro de arma.
          if(anuncio.length != 1){
            $('#container_collapsible_son').find('.localizador').each(function(){
              // Al recorrer el input, debemos indicar que solo necesitamos
              // El input que empieze con registro_arma_plus
              if(registro_arma==$(this).val()){
                M.toast({html: 'No se puede agregar, ya ha ingresado el arma en la denuncia.'});
                registro_repetido = true;
                return;            
              }
            });
          }

          // Cuando logremos hacer validar que no hay repetidos en la lista de asociados.
          // O cuando ingresamos un arma en la lista, retornamos el valor de la variable registro repetido a false.

          // Verificamos si el arma ya se encuentra en la DB.
          // Verificamos si el arma ya esta listada en armas asociadas.
          if(((rspnse.registro_arma).length <= 0) && (registro_repetido==false)){
            // Agregamos el arma a la DB

            // Si ingresa aca, es porque no existe en la DB, por ende, hay que empezar a guardar en el localstorage los datos
            // Para si recarga, no hay problema.- Es decir que solo con el boton cancelar del primer div se podra borrar la cache.

            // Lo que quiero meter
            let valoresIN = {
              tipo_arma,
              value_tipo_arma,
              marca_arma,
              value_marca_arma,
              modelo_arma,
              tenencia_arma,
              licencia_arma,
              registro_arma,
              pais_fabricacion,
              value_pais_fabricacion,
              cantidad_tolvas,
              cantidad_municion,
              propietario,
            }

            // Lo que traigo
            let actualizadoLocalStorage = JSON.parse(localStorage.getItem("data"));

            if(actualizadoLocalStorage == null){
              // Pero si no traigo nada, solo meto lo que quiero meter.
              // Primer ingreso
                localStorage.setItem('data',JSON.stringify([{...valoresIN}]));

            }else{
                // De lo contrario meto lo que traigo y lo que quiero meter.
                // Lo que traigo mas lo que ingreso.
                localStorage.setItem('data',JSON.stringify([{...valoresIN},...actualizadoLocalStorage]));
            }

            let masActualizado = JSON.parse(localStorage.getItem("data"));
                
            masActualizado.map((elemento,index)=>{
              // Ahora en lugar de pintar directamente, pintaremos con el local storage.


              $(`#collapsible_${index}`).remove();

              $('#container_collapsible_son').append(`
                <ul class="collapsible" id="collapsible_${index}">
                  <li>
                    <div class="collapsible-header deleteCollapse">
                      ${index+1}. ${elemento.tipo_arma} 
                      <div>
                      <a  onclick="restarArma(${index})"><i class="material-icons right">delete</i></a>
                      </div>
                    </div>

                    <div class="collapsible-body">
                      ${((elemento.value_tipo_arma) == "" ) ?
                      `` : `
                      <div class="input-field ">
                         <input type="hidden" name="arma_plus_${index}[tipo_arma]" id="tipo_arma_plus_${index}" value="${elemento.tipo_arma}">
                          <label>Tipo de Arma: ${elemento.tipo_arma}</label> 
                      </div>  <br>`} 
                        
                          ${((elemento.value_marca_arma) == "") ?
                          `` : 
                          `<div class="input-field ">
                            <input type="hidden" name="arma_plus_${index}[marca_arma]" id="marca_arma_plus_${index}" value="${elemento.marca_arma}">
                            <label>Marca: ${elemento.marca_arma}</label>
                          </div> <br>`}
                        
                          ${((elemento.modelo_arma) == "") ?
                          `` :
                          `<div class="input-field ">
                            <input type="hidden" name="arma_plus_${index}[modelo_arma]" id="modelo_arma_plus_${index}" value="${elemento.modelo_arma}">
                            <label>Modelo: ${elemento.modelo_arma}</label>
                          </div>  <br>`}
                        
                          ${((elemento.tenencia_arma) == "") ?
                          `` :
                          `<div class="input-field ">
                            <input type="hidden" name="arma_plus_${index}[tenencia_arma]" id="tenencia_arma_plus_${index}" value="${elemento.tenencia_arma}">
                            <label>Tenencia: ${elemento.tenencia_arma}</label>
                          </div>  <br>`}
                        
                          ${((elemento.licencia_arma) == "") ?
                          `` :
                          `<div class="input-field ">
                            <input type="hidden" name="arma_plus_${index}[licencia_arma]" id="licencia_arma_plus_${index}" value="${elemento.licencia_arma}">
                            <label>Licencia: ${elemento.licencia_arma}</label>
                          </div>  <br>`}
                        

                          <div class="input-field ">
                            <input type="hidden" name="arma_plus_${index}[registro_arma]" class="localizador" id="registro_arma_plus_${index}" value="${elemento.registro_arma}">
                            <label>Numero de registro: ${elemento.registro_arma}</label>
                          </div>  <br>
                        
                          ${((elemento.value_pais_fabricacion) <= 0) ?
                          `` :
                          `<div class="input-field ">
                            <input type="hidden" name="arma_plus_${index}[pais_fabricacion]" id="pais_fabricacion_plus_${index}" value="${elemento.pais_fabricacion}">
                            <label>Pais de fabricacion: ${elemento.pais_fabricacion}</label>
                          </div>  <br>`}
                        
                          ${((elemento.cantidad_tolvas) == "") ?
                          `` :
                          `<div class="input-field ">
                            <input type="hidden" name="arma_plus_${index}[cantidad_tolvas]" id="cantidad_tolvas_plus_${index}" value="${elemento.cantidad_tolvas}">
                            <label>Cantidad de tolvas: ${elemento.cantidad_tolvas}</label>
                          </div> <br>`}

                          ${((elemento.cantidad_municion) == "") ?
                          `` :
                          `<div class="input-field ">
                            <input type="hidden" name="arma_plus_${index}[cantidad_municion]" id="cantidad_tolvas_plus_${index}" value="${elemento.cantidad_municion}">
                            <label>Cantidad de municion: ${elemento.cantidad_municion}</label>
                          </div> <br>`}
                          ${((elemento.propietario) == "") ?
                          `` :
                          `<div class="input-field ">
                            <input type="hidden" name="arma_plus_${index}[propietario]" id="cantidad_tolvas_plus_${index}" value="${elemento.propietario}">
                            <label>Propietario: ${elemento.propietario}</label>
                          </div> <br>`}

                        
                        </div>
                      </li>
                    </ul>`);
            })


            // Agregar el input del propietario?
            $('.collapsible').collapsible(); 
            $('.dropdown-trigger').dropdown();
            $('#advice1').remove();

          }else{
            // Alertamos que el arma ya se encuentra con denuncia en la DB.
            console.log('El arma ya esta en la DB, ya no se puede mi compa xD');  
            M.toast({html: 'No se puede agregar, ya existe denuncia para el respectivo registro.'})            

          }

        },
          error : function(xhr, status) {
          console.log('Disculpe, existió un problema');
        },
          complete : function(xhr, status) {
          console.log('Petición realizada');
        }
      });
    };

    // 3. Formulario Sindicado.

    // Añadimos la persona.
    $('#addSindicado').click(function(e){
      e.preventDefault();
      // Verificamos que al menos exista lleno un campo.
       let  statsNacionalidad = checkCampos($('#nacionalidad_sindicado').val()),
            statsCUI  = checkCampos($('#cui_sindicado').val()), //Nice
            statsPasaporte  = checkCampos($('#pasaporte_sindicado').val()),
            statsNombres  = checkCampos($('#nombres_sindicado').val()),
            statsApellidos  = checkCampos($('#apellidos_sindicado').val()),
            statsGenero  = checkCampos($('#genero_sindicado').val()),
            statsEdad  = checkCampos($('#edad_sindicado').val()),
            statsFisicas  = checkCampos($('#caracteristicas_fisicas').val()),
            statsVestimenta  = checkCampos($('#vestimenta').val()),
            statsOrganizacion  = checkCampos($('#organizacion_criminal').val()),
            statsTelefono  = checkCampos($('#telefono_sindicado').val());

      if(!statsNacionalidad && !statsCUI && !statsPasaporte && !statsNombres && !statsApellidos && !statsGenero && !statsEdad && !statsFisicas && !statsVestimenta && !statsOrganizacion  && !statsTelefono){
         M.toast({html: 'Ingrese alguna caracteristica.'})            
      }else{
        // Agregamos sindicado.
        agregarSindicado();
      }

    });

    function agregarSindicado(){
      // Hay alguna otra forma de atrapar estos datos, para no manchar mucho nuestro codigo?
      let nacionalidad_sindicado = $('#nacionalidad_sindicado').val(),
      cui_sindicado = $('#cui_sindicado').val(),
      pasaporte_sindicado = $('#pasaporte_sindicado').val(),
      nombres_sindicado = $('#nombres_sindicado').val(),
      apellidos_sindicado = $('#apellidos_sindicado').val(),
      genero_sindicado = $('#genero_sindicado').val(),
      edad_sindicado = $('#edad_sindicado').val(),
      caracteristicas_fisicas = $('#caracteristicas_fisicas').val(),
      vestimenta = $('#vestimenta').val(),
      organizacion_criminal = $('#organizacion_criminal').val(),
      telefono_sindicado = $('#telefono_sindicado').val();

      

    }


    // Ahora hay que validar que al menos exista un arma antes de enviar. 
    $('#Enviar').click(function(e){
      let text_advice = $('#text-advice');

      if(text_advice.length == 0 ){

        console.log('Puede proceder');

      }else{
        e.preventDefault();
        console.log('Agruegue arma');
        $('html, body').animate({
        scrollTop: $("#referencia_residencia").offset().top
        }, 500);
      }

    }); 

  </script>
@endpush