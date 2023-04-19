
@if($solvente == false)
  <p class="center-align ">
    <div class="row valign-wrapper">
      <div class="col s12 m5">
        <p>Estado actual</p>
        <a href="#" class="btn red">{{$descripcion}}</a>
      </div>
      <div class="col s12 m2" >
        <i class="material-icons ">arrow_forward</i>
      </div>
      <div class="col s12 m5">
        <p>Cambiar a</p>
        <a href="#" class="btn" onclick="showModalConfirm({{$id_arma}})">Solvente</a>
      </div>
    </div>
  </p>

@elseif($solvente == true)
  <p class="center-align ">
    <div class="row valign-wrapper">
      <div class="col s12">
        <p>Estado actual</p>
        <a href="#" class="btn">{{$descripcion}}</a>
      </div>
    </div>
  </p>
@endif
