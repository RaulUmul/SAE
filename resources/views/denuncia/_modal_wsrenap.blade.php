
@isset($dpi)
    
<div class="modal-content">
  <h4>Datos encontrados</h4>
  <div>
    <span>DPI: {{$dpi}}</span><br>
    <span>Nombre: 
      @isset($primer_nombre,$segundo_nombre,$tercer_nombre)
        {{$primer_nombre}} {{$segundo_nombre}} {{$tercer_nombre}}
      @endisset 
    </span><br>
    <span>Apellidos:
      @isset($primer_apellido,$segundo_apellido)
      {{$primer_apellido}} {{$segundo_apellido}}
      @endisset </span><br>
  </div>
</div>
<div class="modal-footer">
  <div class="row">
    <div class="col s12" style="display: flex; justify-content: space-around ">
      <div class="" style="display:flex; align-self: flex-end;">
        <a  class=" waves-light red btn modal-close" style="padding-left: 2rem;padding-right: 2rem;">
          Cancelar
          <i class="large material-icons right">cancel</i>
        </a>
      </div>
      <div class="" style="display:flex; align-self: flex-end;">
        <a  class="waves-light btn" style="padding-left: 2rem;padding-right: 2rem;" id="datos_aceptados">
          Aceptar
          <i class="large material-icons right">check</i>
        </a>
      </div>
    </div>
  </div>
</div>
@endisset

@isset($error)
    
<div class="modal-content">
  <h4>Ha fallado algo...</h4>
  <div>
    {{$descripcion}}
  </div>
</div>
<div class="modal-footer">
  <div class="row">
    <div class="col s12" style="display: flex; justify-content: space-around ">
      <div  style="display:flex; align-self: flex-end;">
        <a  class="waves-light btn modal-close" style="padding-left: 2rem;padding-right: 2rem;">
          Aceptar
          <i class="large material-icons right">check</i>
        </a>
      </div>
    </div>
  </div>
</div>
@endisset