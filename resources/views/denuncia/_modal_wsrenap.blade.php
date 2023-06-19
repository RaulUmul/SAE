
@isset($dpi)
  <div class="modal-content">
    <h4>Datos encontrados</h4>

    <div class="card horizontal">
      
      <div class="card-stacked">
        <div class="card-content valign-wrapper" style="padding-left: 10%;padding-right:10%">
          
            <table class=" highlight">
              <tbody>
                <tr>
                  <td>DPI:</td>
                  <td>{{$dpi}}</td>
                </tr>
                <tr>
                  <td>Nombres:</td>
                  <td>
                    @isset($primer_nombre,$segundo_nombre,$tercer_nombre)
                      {{$primer_nombre}} {{$segundo_nombre}} {{$tercer_nombre}}
                    @endisset
                  </td>
                </tr>
                <tr>
                  <td>Apellidos:</td>
                  <td>
                    @isset($primer_apellido,$segundo_apellido)
                    {{$primer_apellido}} {{$segundo_apellido}}
                    @endisset
                    @if ($apellido_casada != "")
                      {{$apellido_casada}}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>Genero:</td>
                  <td>
                    @if ($genero == 'M')
                      Masculino  
                    @else
                      Femenino
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>Fecha nacimiento:</td>
                  <td>{{date('d/m/Y', strtotime($fecha_nacimiento) )}}</td>
                </tr>
              </tbody>
            </table>
        </div>
      </div>

      <div class="card-image " style="max-width: 25%; max-height: 10%">
        <img class="materialboxed" src="{{$foto}}">
      </div>
    </div>
    
  </div>

  <div class="modal-footer">
    <div class="row">
      <div class="col s12" style="display: flex; justify-content: space-around ">
        <div class="" style="display:flex; align-self: flex-end;">
          <a  class=" waves-light red btn modal-close" style="">
            Cancelar
            <i class="large material-icons right">cancel</i>
          </a>
        </div>
        <div class="" style="display:flex; align-self: flex-end;">
          <a  class="waves-light btn" style="" id="datos_aceptados">
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

@push('scripts')
  <script>
    $(document).ready(function () {
      $('.materialboxed').materialbox();
    });
  </script>
@endpush
