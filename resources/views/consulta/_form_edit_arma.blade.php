<form>
  @include('partials.divider',['title'=> 'Datos del arma'])
  <div class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <select  id="tipo_arma">
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
    <input type="text" id="modelo_arma"  class="validate" value="{{$arma['modelo_arma']?$arma['modelo_arma']:null}}">
    <label for="modelo_arma" class="{{$arma['modelo_arma'] ?'active':''}}">Modelo </label>
  </div>
  <div  class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <input type="text" id="tenencia_arma"  class="validate" value="{{$arma['tenencia']?$arma['tenencia']:null}}">
    <label for="tenencia_arma" class="{{$arma['tenencia'] ?'active':''}}">Numero tenencia</label>
  </div>
  <div  class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <input type="text" id="licencia_arma" class="validate" value="{{$arma['licencia']?$arma['licencia']:null}}">
    <label for="licencia_arma" class="{{$arma['licencia'] ?'active':''}}">Numero licencia</label>
  </div>
  <div  class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <input type="text" id="registro_arma" class="validate" value="{{$arma['registro']?$arma['registro']:null}}">
    <label for="registro_arma" class="{{$arma['registro'] ?'active':''}}">Numero Registro / Serie</label>
  </div>

  <div class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <select  id="marca_arma">
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
    <select id="calibre_arma">
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
    <input type="number" id="cantidad_tolvas" class="validate" value="{{$arma['cantidad_tolvas']?$arma['cantidad_tolvas']:null}}">
    <label for="cantidad_tolvas" class="{{$arma['cantidad_municion']?'active':''}}">Cantidad de tolvas</label>
  </div>
  <div  class="input-field col s12 m6 l4">
    <i class="material-icons prefix">chevron_right</i>
    <input type="number" id="cantidad_municion" class="validate" value="{{$arma['cantidad_municion']?$arma['cantidad_municion']:null}}">
    <label for="cantidad_municion" class="{{$arma['cantidad_municion']?'active':''}}">Cantidad de municion</label>
  </div>


  @include('partials.divider',['title'=> 'Descripcion'])

  <div class="input-field col s12">
    <i class="prefix material-icons">chevron_right</i>
    <textarea  id="descripcion_ampliacion" name="descripcion_ampliacion" class="materialize-textarea"></textarea>
    <label for="descripcion_ampliacion">Motivo de la ampliación</label>
  </div>

</form>
