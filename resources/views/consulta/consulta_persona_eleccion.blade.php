@extends('layouts.plantilla')
@section('title','Consultas')


@section('content')
  @component('components.container')
    @section('titulo_card','RESULTADOS')
    @section('contenido_card')
    @csrf

    {{-- Vamos a mostrar un LOADER <3 --}}





    <ul class="collection with-header">
        <li class="collection-header"><h4>Coincidencias</h4></li>
        @foreach ($datos as $persona )
        <li class="collection-item"><div>{{$persona['nombre_completo']}}<a href="#!" class="secondary-content" onclick="setIdForm({{$persona['id']}})"><i class="material-icons">send</i></a></div></li>
        @endforeach
    </ul>
            

@endsection
@endcomponent
@endsection
        

  @push('scripts')
  <script>
    $(document).ready(function(){
    });

    function setIdForm(id){

      // Colocamos un ajax que nos retorna la vista como siempre. Probemos juaz juaz.
      console.log(id);

      $.ajax({
        type: "POST",
        url: "{{route('consulta.show')}}",
        data: {
          id_persona: id,
          _token: '{{ csrf_token() }}'
        },
        dataType: 'text',
        beforeSend: function(){
          $('.all-the-ground').show();
        },
        success: function (response) {
          $('.all-the-ground').hide();
          $('body').html(response);
        }
      });
    }
  </script>
  @endpush