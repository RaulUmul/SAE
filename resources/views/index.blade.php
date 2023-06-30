{{--@extends('layouts.plantilla')--}}
@extends('layouts.plantilla')
@section('title','Consultas')


@section('content')
  @component('components.container')
    @section('titulo_card','SISTEMA DE ARMAS Y EXPLOSIVOS - SAE')
    @section('contenido_card')

    {{-- <form action="{{route('archivo.store')}}" enctype="multipart/form-data" method="post">
      @csrf
      @method("post")
      <div class="row valign-wrapper">
        <div class="col s10 file-field input-field">
          <div class="btn">
            <span>Archivo</span>
            <input type="file" name="file" id="file" accept=".pdf">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text" id="filePath">
          </div>
        </div>
        <div class="col s2">
          <a class="btn"  href="#!" onclick="deletePDF()"><span>Eliminar</span><i class="material-icons left">clear</i>
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col s12">
          <button class="btn" name="action" type="submit">Enviar <i class="material-icons right">send</i></button>
        </div>
      </div>
    </form>

    <div class="row">
      <div class="col s12">
        <embed
        alt=""
        width="100%"
        height="600px"
        id="archivoCargado"
        type="application/pdf"
        >
    </div> --}}

      <div class="row">
        <a href="#!" class="btn" onclick="cargarLinks()">Cargar Links</a>
        <a href="#!" class="btn" onclick="cargarData()">Cargar Data</a>

        <div class="col s12">
          Lista de anclas
          <ul id="href-items">

          </ul>
        </div>
      </div>


    @endsection
  @endcomponent
@endsection

{{--          Script para mi amigo Sirin--}}

      @push('scripts')

      <script>

        function cargarLinks(){

          let arrHref = [1,2,3,4,5];
          console.log(arrHref);
          let contenido = arrHref.map(el=>{
            // Le asigno un elemento del arreglo como data-id.
            return `<li><a href"" class="btn" data-id="${el}" id="link_${el}"> ${el} </a></li>`;
          })
          $('#href-items').html(contenido);

        }

        // Podemos obtener la data(id) de cada elemento.
        function cargarData(){

          let contenedores = document.getElementById('link_1');
          console.log(contenedores.dataset.id);
          console.log(contenedores)


        }

      </script>
      @endpush


{{-- @push('scripts')
  <script>
    $('#file').on('change',function(event){
      let archivo = event.target.files[0];
      if(event.target.files.length != 0){
        readPDF(archivo);
      }else{
        deletePDF();
      }
    });

    function deletePDF(){
      $('#file').val('');
      $('#archivoCargado').attr('src','');
      $('#filePath').val('');
    }

    function readPDF(file){
      let iframe = document.getElementById('archivoCargado');
      const reader = new FileReader();

      reader.addEventListener('load', (event) => {
        iframe.src = event.target.result;
      });

      // reader.addEventListener('progress', (event) => {
      //   if (event.loaded && event.total) {
      //     const percent = (event.loaded / event.total) * 100 ;
      //     // setInterval(() => {
      //     //   console.log('Loaded:  ', event.loaded);
      //     //   console.log('Total:  ', event.total);
      //     //   console.log(`Progress: ${percent}`);
      //     // }, 2000);
      //   }
      // });

      reader.readAsDataURL(file);
    }
  </script>
@endpush --}}
