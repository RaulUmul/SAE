{{--@extends('layouts.plantilla')--}}
@extends('layouts.plantilla')
@section('title','Consultas')


@section('content')
  @component('components.container')
    @section('titulo_card','SISTEMA DE ARMAS Y EXPLOSIVOS - SAE')
    @section('contenido_card')

      <div class="row">
        {{-- LOGOTIPOS --}}
        <div class="col s12" id="cabecera-logos">
          {{-- PNC --}}
          <lottie-player
            autoplay
            loop
            mode="normal"
            src="{{asset('img/testlottie/PNC.json')}}"
            style="
            width: 100px;
            margin-right: -20px
            "
          >
          </lottie-player>
          {{-- DIDAE --}}
          <lottie-player
            autoplay
            loop
            mode="normal"
            src="{{asset('img/testlottie/DIDAE.json')}}"
            style="width: 90px"
          >
          </lottie-player>
        </div>
        {{-- TITULO PRINCIPAL --}}
        <div class="col s12 center-align">
          <span><strong>SISTEMA DE ARMAS Y EXPLOSIVOS - SAE</strong></span>
        </div>
      </div>
      {{-- Tabs --}}
      <div class="row">
        <div class="col s12">
          <ul class="tabs main">
            <li class="tab col s3"><a id="linkIntroduccion" href="#introduccion" class="active"></a></li>
            <li class="tab col s3"><a id="linkDocumentacion" href="#documentacion"></a></li>
          </ul>
        </div>

        <div id="introduccion" class="col s12">
          <div class="col s12  center-align" style="min-height: 45vh;padding: 3rem">
            <span>BIENVENIDO</span>
            <br><br>
            <div class="col s12 m12 l12">
              <p class="justify">
                <div style="font:Segoe UI" color="#09092E">
                  Este sistema lleva acabo distintas actividades que unifican la información que tiene a cargo DIDAE, con el fin de incorporar trabajo investigativo y operativo en un solo sistema, haciendo accesible la información que se necesite en cualquier horario.
                  </br></br>
                  Su principal objetivo son las consultas de armas de fuego de las cuales se tendrá la información necesaria por medio del almacenamiento de las denuncias de robo, hurto y extravío de las armas de fuego, incautaciones y explosivos.
                </div>
              </p>
            </div>
          </div>
          <div style="position: absolute;right: 5%;top: 60%" >
            <a href="#!" id="div_documentacion"><i class="material-icons">arrow_forward_ios</i></a>
          </div>
        </div>

        <div id="documentacion" class="col s12">
          <div class="col s1" style="position: absolute;left: 5%;top: 60%">
            <a href="#!" id="div_introduccion"><i class="material-icons">arrow_back_ios</i></a>
          </div>
          <div class="col s12">
            <div class="col s12 center-align" style="padding: 1rem">
              <em>
                <span>CONTENIDO GUIA</span>
                <p>En esta seccion, encontrara documentacion de soporte relacionado al sistema SAE</p>
              </em>
            </div>
            <div class="col s12 right-align container-manuales">
              <a href="#!">
                <img src="{{asset('img/manual_uno.png')}}" style="height:250px;width: 90%;object-fit: contain" alt="manual_denuncias_consultas">
              </a>
            </div>
          </div>
        </div>

      </div>


    @endsection
  @endcomponent
@endsection

@push('scripts')
<script>
  $('.tabs').tabs();


$('#div_documentacion').click(function(){
  $('#linkIntroduccion').removeClass('active');
  $('#linkDocumentacion').addClass('active');
  $('.tabs').tabs();
})
$('#div_introduccion').click(function(){
  $('#linkDocumentacion').removeClass('active');
  $('#linkIntroduccion').addClass('active');
  $('.tabs').tabs();
})

</script>
@endpush

