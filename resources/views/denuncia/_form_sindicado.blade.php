<ul class="collapsible" id="collapsible_sindicado_{{$index}}">
  <li>
    <div class="collapsible-header deleteCollapse">
     <p> Sindicado: 
    @isset($nombres_sindicado)
          - Nombres: <b>{{$nombres_sindicado}} </b>
    @endisset
    @isset($cui_sindicado)
          - DPI: <b>{{$cui_sindicado}}</b>
    @endisset</p> 
        <div>
          <a  onclick="restarSindicado({{$index}})"><i class="material-icons right">delete</i></a>
        </div>
    </div>
    <div class="collapsible-body">
      @isset($cui_sindicado)
        <div class="input-field">
          <input type="hidden" name="sindicado_plus_{{$index}}[cui_sindicado]" id="cui_sindicado_plus_{{$index}}" value="{{$cui_sindicado}}">
          <label>DPI: {{$cui_sindicado}}</label> 
        </div>  <br>
      @endisset

      @isset($pasaporte_sindicado)
      <div class="input-field ">
        <input type="hidden" name="sindicado_plus_{{$index}}[pasaporte_sindicado]" id="pasaporte_sindicado_plus_{{$index}}" value="{{$pasaporte_sindicado}}">
        <label>Pasaporte: {{$pasaporte_sindicado}}</label>
      </div> <br>
      @endisset

      @isset($nombres_sindicado)
      <div class="input-field">
        <input type="hidden" name="sindicado_plus_{{$index}}[nombres_sindicado]" id="nombres_sindicado_plus_{{$index}}" value="{{$nombres_sindicado}}">
        <label>Nombres: {{$nombres_sindicado}}</label>
      </div>  <br>
      @endisset
      
      
      @isset($apellidos_sindicado)
      <div class="input-field">
        <input type="hidden" name="sindicado_plus_{{$index}}[apellidos_sindicado]" id="apellidos_sindicado_plus_{{$index}}" value="{{$apellidos_sindicado}}">
        <label>Apellidos: {{$apellidos_sindicado}}</label>
      </div>  <br>
      @endisset

      @isset($genero_sindicado)
      <div class="input-field ">
        <input type="hidden" name="sindicado_plus_{{$index}}[genero_sindicado]" id="genero_sindicado_plus_{{$index}}" value="{{$genero_sindicado}}">
        <label>Genero: {{$genero_sindicado}}</label>
      </div>  <br>
      @endisset
      
      @isset($edad_sindicado)
        <div class="input-field ">
          <input type="hidden" name="sindicado_plus_{{$index}}[edad_sindicado]"  id="edad_sindicado_plus_{{$index}}" value="{{$edad_sindicado}}">
          <label>Edad: {{$edad_sindicado}}</label>
        </div>  <br>
      @endisset

      @isset($caracteristicas_fisicas)
      <div class="input-field ">
        <input type="hidden" name="sindicado_plus_{{$index}}[caracteristicas_fisicas]" id="caracteristicas_fisicas_plus_{{$index}}" value="{{$caracteristicas_fisicas}}">
        <label>Caracteristicas fisicas: {{$caracteristicas_fisicas}}</label>
      </div>  <br>
      @endisset

      @isset($vestimenta)
      <div class="input-field">
        <input type="hidden" name="sindicado_plus_{{$index}}[vestimenta]" id="vestimenta_plus_{{$index}}" value="{{$vestimenta}}">
        <label>Vestimenta: {{$vestimenta}}</label>
      </div> <br>
      @endisset

      @isset($organizacion_criminal)
      <div class="input-field ">
        <input type="hidden" name="sindicado_plus_{{$index}}[organizacion_criminal]" id="organizacion_criminal_plus_{{$index}}" value="{{$organizacion_criminal}}">
        <label>Organizacion criminal: {{$organizacion_criminal}}</label>
      </div> <br>
      @endisset

      @isset($telefono_sindicado)
      <div class="input-field ">
        <input type="hidden" name="sindicado_plus_{{$index}}[telefono_sindicado]" id="telefono_sindicado_plus_{{$index}}" value="{{$telefono_sindicado}}">
        <label>Telefono: {{$telefono_sindicado}}</label>
      </div> <br>
      @endisset

    </div>
  </li>
</ul>