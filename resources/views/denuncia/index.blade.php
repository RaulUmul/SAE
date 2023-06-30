@extends('layouts.plantilla')
@section('title','Denuncias')

@section('content')
  {{-- Componente Container --}}
  @component('components.container')
    @section('titulo_card','DENUNCIAS DE ARMA DE FUEGO');
    @section('contenido_card')

      {{--Mensaje para registro guardado exitosamente--}}
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
      {{--Mensaje de errores, no guardado.--}}


      <div class="row">
        <div class="col s12">
          <em>
              <h5 class="center">
                  <font face="Segoe UI" color="#2B0808">Ingresar una nueva denuncia: </font>
                  <a href="{{route('denuncia.create')}}">Generar nueva denuncia</a>
              </h5>
          </em>
        </div>
      </div>
      <div class="row">
        <div class="col s12">
          <em>
              <h5 class="center">
                  <font face="Segoe UI" color="#2B0808">Armas agregadas </font>
              </h5>
          </em>
        </div>
      </div>
    {{--      Tabla de armas, hay que paginarlas--}}
      <div class="row">
        <div class="col s12">

          <div class="col s12">
            @include('partials.divider',['title'=> 'Filtrar resultados'])
          </div>

          <div class="input-field col s12 m6 l4">
            <i class="material-icons prefix">chevron_right</i>
            <select  id="tipo_arma">
              <option value="{{null}}" selected>N/I</option>
              @foreach ($tipo_arma as $key => $value)
                <option value="{{$value->id_item}}" >{{$value->descripcion}}</option>
              @endforeach
            </select>
          </div>
          <div class="input-field col s12 m6 l4">
            <i class="material-icons prefix">chevron_right</i>
            <select  id="estado_arma">
              <option value="{{null}}" selected>N/I</option>
              @foreach ($estado_arma as $key => $value)
                <option value="{{$value->id_item}}" >{{$value->descripcion}}</option>
              @endforeach
            </select>
          </div>



          <div class=" input-field col s12 m4">
            <i class="material-icons prefix">chevron_right</i>
            <input id="filter-registro" type="text" placeholder="No. de Registro">
          </div>

            <table id="table-armas"  style="width: 100%">
              <thead>
              <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Calibre</th>
                <th>Licencia</th>
                <th>Tenencia</th>
                <th>Registro</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
              </thead>
            </table>
        </div>
      </div>

    @endsection
  @endcomponent
  {{-- Fin Componente Container --}}
@endsection

@push('scripts')
  <script>
    $(document).ready(function(){

      $('#tipo_arma').select2({
        width: '100%',
        placeholder: 'Tipo de arma',
        allowClear: true,
      });
      $('#estado_arma').select2({
        width: '100%',
        placeholder: 'Estatus',
        allowClear: true,
      });


      $.ajax({
      //   Vamos a consultar la data de armas.
        url:"{{route('showArmas')}}",
        type: 'get',
        dataType: 'json',
        data:{},
        beforeSend: function (){},
        success: function (resp) {
          console.log(resp.armas);
          // let { data } = resp.armas;
          console.log({data:resp.armas});
          var tablaArmas = $('#table-armas').addClass('nowrap').DataTable({
            responsive: true,
            "order": [ 0, 'desc' ],
            data: resp.armas,
            columns: [
              {data: 'id_arma'},
              {data: 'id_tipo_arma',render: function (data){
                let descripcion;
                resp.tipo_arma.map((tipo)=>{
                  if(data === tipo.id_item){descripcion = tipo.descripcion};
                });
                return descripcion;
              }},
              {data: 'id_marca_arma', render: function (data){
                  let descripcion;
                  resp.marca_arma.map((tipo)=>{
                    if(data === tipo.id_item){descripcion = tipo.descripcion};
                  });
                  return descripcion;
                }},
              {data: 'modelo_arma'},
              {data: 'id_calibre', render: function (data){
                let descripcion;
                resp.calibre_arma.map((tipo)=>{
                  if(data === tipo.id_item){descripcion = tipo.descripcion}
                });
                return descripcion;
              }},
              {data: 'licencia'},
              {data: 'tenencia'},
              {data: 'registro'},
              {data: 'estado_arma',render: function (data){
                  let descripcion;
                  resp.estado_arma.map((tipo)=>{
                    if(data === tipo.id_item){descripcion = tipo.descripcion}
                  });
                  return descripcion;
                }},
              null
            ],
            select: true,
            dom: 'Brtip',
            columnDefs:[
              {target: 7 ,responsivePriority: 1},
              {
              responsivePriority: 2,
              target: -1,
              visible: true,
              data: 'id_arma',
              orderable: false,
              render: function ( data, type, row, meta ) {
               return  `<a class="btn" onclick="showDenuncias(${data})"> <i class="material-icons">visibility</i></a>`;
              }
            }],
            // "bDestroy": true
          });

          $('#filter-registro').on('keyup',function (){
            tablaArmas.columns(7).search(this.value).draw(); // Columna 8 -> registro arma
          });

          $('#tipo_arma').on('change',function (){
            let tipo_arma = $('#tipo_arma option:selected').text();
            if(tipo_arma == "N/I"){
              tipo_arma = "";
            }
            tablaArmas.columns(1).search(tipo_arma).draw();
          });

          $('#estado_arma').on('change',function (){
            let estado_arma = $('#estado_arma option:selected').text();
            if(estado_arma == "N/I"){
              estado_arma = "";
            }
            tablaArmas.columns(8).search(estado_arma).draw(); //Columna 8 -> estado arma
          });

        },
        error: function (){
          console.log('No se pudo mi pana - showArmasReady')
        },
      });


    });


    // Para mostrar la denuncia del Arma.
    function showDenuncias(id_arma){

      $.ajax({
        url:"{{route('consulta.show')}}",
        type:"post",
        data:{
          id_arma,
          _token: '{{ csrf_token() }}'
        },
        dataType:'text',
        success:function (resp){
          $('body').html(resp);
        },
        error:function (xhr,status){
          console.log(xhr)
          console.log('Nosepudocuas - showDenunciaIndexDenuncia');
        }
      })
    }

  </script>
@endpush
