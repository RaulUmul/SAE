{{--@extends('layouts.plantilla')--}}
@extends('layouts.plantilla')
@section('title','Administracion de archivo')


@section('content')
  @component('components.container')
    @section('titulo_card','ADMINISTRACION DE ARCHIVO')
    @section('contenido_card')

    @if (session('success'))
        <div id="modal_success" class="modal">
          <div class="modal-content center">
            <h4>{{ session('success') }}</h4>
          </div>
          <div class="modal-footer">
            <div class="col s12" style="display: flex; justify-content: space-around;">
                <a  class="waves-light btn modal-close">
                  Aceptar
                  <i class="large material-icons right">check</i>
                </a>
            </div>
          </div>
        </div>
        @push('scripts')
          <script>
            $('.modal').modal();
            $('#modal_success').modal('open');
          </script>
        @endpush
      @endif


      @if (session('error'))
        <div id="modal_success" class="modal">
          <div class="modal-content center">
            <h4>{{ session('error') }}</h4>
          </div>
          <div class="modal-footer">
            <div class="col s12" style="display: flex; justify-content: space-around;">
                <a  class="waves-light btn modal-close">
                  Aceptar
                  <i class="large material-icons right">check</i>
                </a>
            </div>
          </div>
        </div>
        @push('scripts')
          <script>
            $('.modal').modal();
            $('#modal_success').modal('open');
          </script>
        @endpush
      @endif

    <div class="col s12">
    </div>
    @empty($archivo)
      {{-- Si no hubiera archivo, se da esta opcion --}}
      <form action="{{route('archivo.store')}}" enctype="multipart/form-data" method="post">
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
        <input type="hidden" value="{{$id_denuncia}}" name="id_denuncia">  
        <div class="row">
          <div class="col s12">
            <button class="btn" name="action" type="submit">Enviar <i class="material-icons right">send</i></button>
          </div>
        </div>
      </form>

    @else
    <form action="{{route('archivo.update')}}" enctype="multipart/form-data" method="post">
      @csrf
      @method("post")
      <div class="row valign-wrapper">
        <div class="col s8 file-field input-field">
          <div class="btn">
            <span>Archivo</span>
            <input type="file" name="file" id="file" accept=".pdf">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text" id="filePath"  value="{{$archivo->nombre}}">
          </div>
        </div>
        <input type="hidden" value="{{$id_denuncia}}" name="id_denuncia">  
        <div class="col s2">
          <button class="btn" name="action" type="submit">Guardar<i class="material-icons right">save</i></button>
        </div>
        <div class="col s2">
          <a class="btn"  href="#!" onclick="deletePDF()"><span>Eliminar</span><i class="material-icons left">clear</i>
          </a>
        </div>
      </div>
    </form>
    <div class="row">
      <div class="col s12">

        <a href="{{route('archivo.show',['name'=>$archivo->nombre,'nombre_hash'=>$archivo->nombre_hash])}}" class="btn" target="_blank">Ver documento</a>

        {{-- <iframe  --}}
        {{-- src="data:application/pdf;base64,{{base64_encode(\Storage::get($archivo->nombre_hash))}}#toolbar=0"  --}}
        {{-- type="application/pdf" --}}
        {{-- frameborder="0" --}}
        {{-- width="100%" --}}
        {{-- height="500px" --}}
        {{-- id="archivoCargado" --}}
        {{-- name="archivoCargado" --}}
        {{-- ></iframe> --}}
  
      </div>
    </div>
    @endempty

    @endsection
  @endcomponent
@endsection


@push('scripts')
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
      reader.readAsDataURL(file);
    }


  </script>
@endpush