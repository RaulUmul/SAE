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
{{--              @foreach ($tipo_arma as $key => $value)--}}
{{--                <option value="{{$value->id_item}}" >{{$value->descripcion}}</option>--}}
{{--              @endforeach--}}
            </select>
          </div>



          <div class=" input-field col s12 m4">
            <i class="material-icons prefix">chevron_right</i>
            <input id="filter-registro" type="text" placeholder="No. de Registro">
          </div>

        <div id="example-table">
          <ul class="pagination">
            <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
            <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
          </ul>
        </div>
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
        success: function (resp){
          console.log(resp.tipo_arma);

          var tipoArmaMutator = function (value, data, type, params, component){
            let descripcion;
            resp.tipo_arma.map((tipo)=>{
               if(value === tipo.id_item){ descripcion = tipo.descripcion};
            });
            return descripcion;
          }
          var marcaArmaMutator = function (value, data, type, params, component){
            let descripcion;
            resp.marca_arma.map((tipo)=>{
               if(value === tipo.id_item){ descripcion = tipo.descripcion};
            });
            return descripcion;
          }
          var estadoArmaMutator = function (value, data, type, params, component){
            let descripcion;
            resp.estado_arma.map((tipo)=>{
               if(value === tipo.id_item){ descripcion = tipo.descripcion};
            });
            return descripcion;
          }
          var calibreArmaMutator = function (value, data, type, params, component){
            let descripcion;
            resp.calibre_arma.map((tipo)=>{
               if(value === tipo.id_item){ descripcion = tipo.descripcion};
            });
            return descripcion;
          }
          var iconSee = function(cell, formatterParams){

            return `<a class='btn tooltipped' data-position='top' data-tooltip='Ver denuncia'><i class='material-icons'>remove_red_eye</i></a>`;
          };
          var iconRemove = function(cell, formatterParams){

            return `<a class='btn tooltipped' data-position='top' data-tooltip='Ver denuncia'><i class='material-icons'>remove_red_eye</i></a>`;
          };

          var table = new Tabulator('#example-table',{
            data:resp.armas,
            layout:"fitColumns",
            // autoColumns:true,
            pagination:true,
            paginationSize:5,
            // headerVisible:false,
            columns:[
              {title:"ID", field:"id_arma",width:75},
              {title:"TIPO", field:"id_tipo_arma",mutator:tipoArmaMutator},
              {title:"MARCA", field:"id_marca_arma",mutator:marcaArmaMutator},
              {title:"MODELO", field:"modelo_arma"},
              {title:"REGISTRO", field:"registro",widthGrow:2},
              {title:"CALIBRE", field:"id_calibre",mutator:calibreArmaMutator},
              {title:"LICENCIA", field:"licencia"},
              {title:"TENENCIA", field:"tenencia"},
              {title:"ESTATUS", field:"estado_arma",mutator:estadoArmaMutator},
              // {title:"ACCIONES",
              // headerVisible:false,
              //   columns:[
              {title:"ACCIONES",formatter:iconSee,hozAlign:"center", cellClick:function(e, cell){showDenuncias(cell._cell.row.data.id_arma);},cellMouseOver:function (e,cell){$('.tooltipped').tooltip()}},
                  // ]},
            ],
          });
          $('#filter-registro').on('keyup',function (){
            updateFiltro();
          });
          $('#tipo_arma').on('change  ',function (){
            updateFiltro();
          });

          function  updateFiltro(){
            table.setFilter(
              [{field:"id_tipo_arma", type:"like", value:$('#tipo_arma option:selected').text()}],
              [{field:"registro", type:"like", value:$('#filter-registro').val()}],
            );

            // if($('#filter-registro').val() == "" ){
            //   table.clearFilter();
            // }
          }
        },
        error: function (){
          console.log('No se pudo mi pana - showArmasReady')
        },
      });


    });

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
      console.log('Quepaso');
    }

  </script>
@endpush
