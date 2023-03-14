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

      @isset($departamento_sindicado)
        <div class="input-field ">
          <input type="hidden" name="sindicado_plus_{{$index}}[departamento_sindicado]"  id="departamento_sindicado_plus_{{$index}}" value="{{$departamento_sindicado}}">
          <label>Departamento: {{$departamento_sindicado}}</label> {{--Hay que cambiar el value por la descripcion--}}
        </div>  <br>
      @endisset

      @isset($municipio_sindicado)
        <div class="input-field ">
          <input type="hidden" name="sindicado_plus_{{$index}}[municipio_sindicado]"  id="municipio_sindicado_plus_{{$index}}" value="{{$municipio_sindicado}}">
          <label>Municipio: {{$municipio_sindicado}}</label> {{--Hay que cambiar el value por la descripcion--}}
        </div>  <br>
      @endisset

      @isset($zona_sindicado)
        <div class="input-field ">
          <input type="hidden" name="sindicado_plus_{{$index}}[zona_sindicado]"  id="zona_sindicado_plus_{{$index}}" value="{{$zona_sindicado}}">
          <label>Zona: {{$zona_sindicado}}</label> {{--Hay que cambiar el value por la descripcion--}}
        </div>  <br>
      @endisset

      @isset($calle_sindicado)
        <div class="input-field ">
          <input type="hidden" name="sindicado_plus_{{$index}}[calle_sindicado]"  id="calle_sindicado_plus_{{$index}}" value="{{$calle_sindicado}}">
          <label>Calle: {{$calle_sindicado}}</label> {{--Hay que cambiar el value por la descripcion--}}
        </div>  <br>
      @endisset

      @isset($avenida_sindicado)
        <div class="input-field ">
          <input type="hidden" name="sindicado_plus_{{$index}}[avenida_sindicado]"  id="avenida_sindicado_plus_{{$index}}" value="{{$avenida_sindicado}}">
          <label>Avenida: {{$avenida_sindicado}}</label> {{--Hay que cambiar el value por la descripcion--}}
        </div>  <br>
      @endisset

      @isset($numero_casa_sindicado)
        <div class="input-field ">
          <input type="hidden" name="sindicado_plus_{{$index}}[numero_casa_sindicado]"  id="numero_casa_sindicado_plus_{{$index}}" value="{{$numero_casa_sindicado}}">
          <label>Numero de casa: {{$numero_casa_sindicado}}</label> {{--Hay que cambiar el value por la descripcion--}}
        </div>  <br>
      @endisset

      @isset($direccion_residencia_sindicado)
        <div class="input-field ">
          <input type="hidden" name="sindicado_plus_{{$index}}[direccion_residencia_sindicado]"  id="direccion_residencia_sindicado_plus_{{$index}}" value="{{$direccion_residencia_sindicado}}">
          <label>Direccion exacta: {{$direccion_residencia_sindicado}}</label> {{--Hay que cambiar el value por la descripcion--}}
        </div>  <br>
      @endisset

      @isset($referencia_residencia_sindicado)
        <div class="input-field ">
          <input type="hidden" name="sindicado_plus_{{$index}}[referencia_residencia_sindicado]"  id="referencia_residencia_sindicado_plus_{{$index}}" value="{{$referencia_residencia_sindicado}}">
          <label>Referencia: {{$referencia_residencia_sindicado}}</label> {{--Hay que cambiar el value por la descripcion--}}
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