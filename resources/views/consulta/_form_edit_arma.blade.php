<form id="form-edit-arma" name="form-edit-arma">
  @include('partials.divider',['title'=> 'Datos del arma'])
  <input type="hidden" name="nombre_completo_denunciante" value="{{$nombre_completo_denunciante}}" >
  <input type="hidden" name="id_arma" value="{{$arma['id_arma']}}">
  <input type="hidden" name="id_denuncia" value="{{$id_denuncia}}">
  <div class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <select  id="tipo_arma" name="tipo_arma">
      @if($arma['id_tipo_arma'])
        <option value="{{$arma['id_tipo_arma']}}" selected>@foreach($tipo_arma as $value) {{ ($value->id_item) == $arma['id_tipo_arma'] ? $value->descripcion : null }} @endforeach</option>
      @else
        <option value="{{null}}" selected></option>
      @endif
      @foreach ($tipo_arma as $key => $value)
        <option value="{{$value->id_item}}" >{{$value->descripcion}}</option>
      @endforeach
    </select>
  </div>

  <div  class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <input type="text" id="modelo_arma" name="modelo_arma" class="validate" value="{{$arma['modelo_arma']?$arma['modelo_arma']:null}}">
    <label for="modelo_arma" class="{{$arma['modelo_arma'] ?'active':''}}">Modelo </label>
  </div>
  <div  class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <input type="text" id="tenencia_arma"  name="tenencia_arma" class="validate" value="{{$arma['tenencia']?$arma['tenencia']:null}}">
    <label for="tenencia_arma" class="{{$arma['tenencia'] ?'active':''}}">Numero tenencia</label>
  </div>
  <div  class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <input type="text" id="licencia_arma"  name="licencia_arma" class="validate" value="{{$arma['licencia']?$arma['licencia']:null}}">
    <label for="licencia_arma" class="{{$arma['licencia'] ?'active':''}}">Numero licencia</label>
  </div>
  <div  class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <input type="text" id="registro_arma" name="registro_arma" class="validate" value="{{$arma['registro']?$arma['registro']:null}}">
    <label for="registro_arma" class="{{$arma['registro'] ?'active':''}}">Numero Registro / Serie</label>
  </div>

  <div class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <select  id="marca_arma" name="marca_arma">
      @if($arma['id_marca_arma'])
      <option value="{{$arma['id_marca_arma']}}" selected>@foreach($marca_arma as $value) {{ ($value->id_item) == $arma['id_marca_arma'] ? $value->descripcion : null }} @endforeach</option>
        @else
        <option value="{{null}}" selected></option>
      @endif
      @foreach ($marca_arma as $key => $value)
        <option value="{{$value->id_item}}" >{{$value->descripcion}}</option>
      @endforeach
    </select>
  </div>

  <div class="input-field col s12 m6 l4 ">
    <i class="material-icons prefix">chevron_right</i>
    <select id="calibre_arma" name="calibre_arma">
      @if($arma['id_calibre'])
        <option value="{{$arma['id_calibre']}}" selected>@foreach($calibre_arma as $value) {{ ($value->id_item) == $arma['id_calibre'] ? $value->descripcion : null }} @endforeach</option>
      @else
        <option value="{{null}}" selected></option>
      @endif

      @foreach ($calibre_arma as $key => $value)
        <option value="{{$value->id_item}}">{{$value->descripcion}}</option>
      @endforeach
    </select>
  </div>

  <div  class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <input type="number" id="cantidad_tolvas" name="cantidad_tolvas" class="validate" value="{{$arma['cantidad_tolvas']?$arma['cantidad_tolvas']:null}}">
    <label for="cantidad_tolvas" class="{{$arma['cantidad_municion']?'active':''}}">Cantidad de tolvas</label>
  </div>
  <div  class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <input type="number" id="cantidad_municion"  name="cantidad_municion" class="validate" value="{{$arma['cantidad_municion']?$arma['cantidad_municion']:null}}">
    <label for="cantidad_municion" class="{{$arma['cantidad_municion']?'active':''}}">Cantidad de municion</label>
  </div>
  {{-- @dump($propietario) --}}
  @empty($arma['id_propietario'])
  <div class="input-field col s12 l4 " id="div_propietario">
    <i class="material-icons prefix">chevron_right</i>
    <select id="propietario" onchange="selectChangePropietario(value)">
      <option value=""  selected>Seleccione propietarios</option>
      <option value="Denunciante">Denunciante</option>
      <option value="Otro">Otro</option>
    </select>
  </div>

  {{-- Div contenedor del Tipo Propietario  --}}
  <div class="col s12">
    <div id="div_tipo_propietario" class="input-field col s12 m4"  style="display: none">
      <i class="material-icons prefix">chevron_right</i>
      <select id="tipo_propietario" name="tipo_propietario">
        {{-- DATO QUEMADO --}}
        <option value="369" selected>Particular</option> 
        @foreach ($tipo_propietario as $key => $value)
        <option value="{{$value->id_item}}" >{{$value->descripcion}}</option>
        @endforeach
      </select>
    </div>
    {{-- Div contenedor del Input Propietario --}}
    <div id="div_denunciante" class="input-field col s12 m8">
    </div>
  </div>
  @else
  {{-- @dump($propietario->nombre_propietario) --}}
  <div class="input-field col s12 l4 " id="div_propietario">
    <i class="material-icons prefix">chevron_right</i>
    <select id="propietario" onchange="selectChangePropietario(value)">
      <option value="">Seleccione propietarios</option>
      <option value="Denunciante"
        @if($nombre_completo_denunciante == $propietario->nombre_propietario) 
          selected 
        @endif
        >Denunciante</option>
      <option value="Otro"
        @if($nombre_completo_denunciante != $propietario->nombre_propietario) 
        selected 
        @endif
       >Otro</option>
    </select>
  </div>

    {{-- Div contenedor del Tipo Propietario  --}}
      <div class="col s12">
        <div id="div_tipo_propietario" class="input-field col s12 m4"  hidden>
          <i class="material-icons prefix">chevron_right</i>
          <select id="tipo_propietario" name="tipo_propietario">
            <option value="{{null}}" selected></option>
            @if($propietario->id_tipo_propietario)
            <option value="{{$propietario->id_tipo_propietario}}" selected>@foreach($tipo_propietario as $value) {{ ($value->id_item) == $propietario->id_tipo_propietario ? $value->descripcion : null }} @endforeach</option>
            @else
              <option value="{{null}}" selected></option>
            @endif
            @foreach ($tipo_propietario as $key => $value)
            <option value="{{$value->id_item}}" >{{$value->descripcion}}</option>
            @endforeach
          </select>
        </div>
        {{-- Div contenedor del Input Propietario --}}
        <div id="div_denunciante" class="input-field col s12 m8" hidden>
          <i class="material-icons prefix">chevron_right</i>
          <input type="text" name="propietario" id="propietario" class="validate" value="{{$propietario->nombre_propietario}}">
          <label for="propietario" class="active">Nombre</label>
        </div>
      </div>
  @endempty



  @include('partials.divider',['title'=> 'Descripcion'])

  <div class="input-field col s12">
    <i class="prefix material-icons">chevron_right</i>
    <textarea  id="descripcion_ampliacion" name="descripcion_ampliacion" class="materialize-textarea"></textarea>
    <label for="descripcion_ampliacion">Motivo de la ampliación</label>
  </div>

</form>


