<ul class="collapsible" id="collapsible_{{$index}}">
  <li>
    <div class="collapsible-header deleteCollapse">
     <p> {{$index+1}}. Registro: <b>{{$registro_arma}}</b> / Tipo: <b>{{$tipo_arma}}</b> </p> 
        <div>
          <a  onclick="restarArma({{$index}})"><i class="material-icons right">delete</i></a>
        </div>
    </div>

    <div class="collapsible-body">
      @isset($tipo_arma)
        <div class="input-field">
          <input type="hidden" name="arma_plus_{{$index}}[tipo_arma]" id="tipo_arma_plus_{{$index}}" value="{{$value_tipo_arma}}">
          <label>Tipo de Arma: {{$tipo_arma}}</label> 
        </div>  <br>
      @endisset

      @isset($marca_arma)
      <div class="input-field ">
        <input type="hidden" name="arma_plus_{{$index}}[marca_arma]" id="marca_arma_plus_{{$index}}" value="{{$value_marca_arma}}">
        <label>Marca: {{$marca_arma}}</label>
      </div> <br>
      @endisset

      @isset($modelo_arma)
      <div class="input-field ">
        <input type="hidden" name="arma_plus_{{$index}}[modelo_arma]" id="modelo_arma_plus_{{$index}}" value="{{$modelo_arma}}">
        <label>Modelo: {{$modelo_arma}}</label>
      </div>  <br>
      @endisset
      
      
      @isset($tenencia_arma)
      <div class="input-field">
        <input type="hidden" name="arma_plus_{{$index}}[tenencia_arma]" id="tenencia_arma_plus_{{$index}}" value="{{$tenencia_arma}}">
        <label>Tenencia: {{$tenencia_arma}}</label>
      </div>  <br>
      @endisset

      @isset($licencia_arma)
      <div class="input-field ">
        <input type="hidden" name="arma_plus_{{$index}}[licencia_arma]" id="licencia_arma_plus_{{$index}}" value="{{$licencia_arma}}">
        <label>Licencia: {{$licencia_arma}}</label>
      </div>  <br>
      @endisset
      
      @isset($registro_arma)
        <div class="input-field ">
          <input type="hidden" name="arma_plus_{{$index}}[registro_arma]" class="localizador" id="registro_arma_plus_{{$index}}" value="{{$registro_arma}}">
          <label>Numero de registro: {{$registro_arma}}</label>
        </div>  <br>
      @endisset

      @isset($calibre_arma)
      <div class="input-field ">
        <input type="hidden" name="arma_plus_{{$index}}[calibre_arma]"  id="registro_arma_plus_{{$index}}" value="{{$calibre_arma}}">
        <label>Calibre: {{$calibre_arma}}</label>
      </div>  <br>
      @endisset

      @isset($pais_fabricacion)
      <div class="input-field ">
        <input type="hidden" name="arma_plus_{{$index}}[pais_fabricacion]" id="pais_fabricacion_plus_{{$index}}" value="{{$value_pais_fabricacion}}">
        <label>Pais de fabricacion: {{$pais_fabricacion}}</label>
      </div>  <br>
      @endisset

      @isset($cantidad_tolvas)
      <div class="input-field">
        <input type="hidden" name="arma_plus_{{$index}}[cantidad_tolvas]" id="cantidad_tolvas_plus_{{$index}}" value="{{$cantidad_tolvas}}">
        <label>Cantidad de tolvas: {{$cantidad_tolvas}}</label>
      </div> <br>
      @endisset

      @isset($cantidad_municion)
      <div class="input-field ">
        <input type="hidden" name="arma_plus_{{$index}}[cantidad_municion]" id="cantidad_municion_plus_{{$index}}" value="{{$cantidad_municion}}">
        <label>Cantidad de municion: {{$cantidad_municion}}</label>
      </div> <br>
      @endisset

      @isset($tipo_propietario)
      <div class="input-field ">
        <input type="hidden" name="arma_plus_{{$index}}[tipo_propietario]" id="tipo_propietario_plus_{{$index}}" value="{{$value_tipo_propietario}}">
        <label>Tipo propietario: {{$tipo_propietario}}</label>
      </div> <br>
      @endisset
      
      @isset($propietario)
      <div class="input-field ">
        <input type="hidden" name="arma_plus_{{$index}}[propietario]" id="propietario_plus_{{$index}}" value="{{$propietario}}">
        <label>Propietario: {{$propietario}}</label>
      </div> <br>
      @endisset

    </div>
  </li>
</ul>