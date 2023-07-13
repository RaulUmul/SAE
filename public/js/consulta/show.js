//  Se inyecta.

// Selects

// Select Departamento
$(document).ready(function (){
  $('#departamento_hecho_recuperacion').select2({
  width: '100%',
  placeholder: 'Departamento',
  allowClear: true,
  dropdownParent: $("#modEstadoArma"),
  language: {
    noResults: function() {
      return "No existe la categoria.";
    }
  },
  })
  // Select Municipio
  $('#municipio_hecho_recuperacion').select2({
  width: '100%',
  placeholder: 'Municipio',
  allowClear: true,
  dropdownParent: $("#modEstadoArma"),
  language: {
    noResults: function() {
      return "No existe la categoria.";
    }
  },
  })

  $('#demarcacion_hecho').select2({
  width: '100%',
  placeholder: 'Demarcacion',
  allowClear: true,
  dropdownParent: $("#modEstadoArma"),
  language: {
    noResults: function() {
      return "No existe la categoria.";
    }
  },
  })

  // Select Unidad Especializada recupera / apoyo
  // $('#unidad_especial').select2({
  //   width: '100%',
  //   placeholder: 'Unidad Especializada',
  //   allowClear: true,
  //   dropdownParent: $("#modEstadoArma"),
  //   language: {
  //     noResults: function() {
  //       return "No existe la categoria.";
  //     }
  //   },
  // })
  // Unidad Movil que recupera
  $('#unidad_recupera').select2({
    width: '100%',
    placeholder: 'Unidad que recupera',
    allowClear: true,
    dropdownParent: $("#modEstadoArma"),
    language: {
      noResults: function() {
        return "No existe la categoria.";
      }
    },
  })

  // function onCurrentSelectPropietario(){
  //   $('#propietario').val(); 
  //   console.log($('#propietario').val());
  // }

});



// Select Municipio dependiente de Departamento
function selectMunicipio(departamento,municipios,root){
  let selectmunicipio = document.getElementById(root);
  let allMuni="";
  municipios.map(({municipio,id_departamento,id_municipio})=>{
    if(departamento == id_departamento){
      allMuni += `<option value="${id_municipio}" >${municipio}</option>`;
    }
  });
  selectmunicipio.innerHTML= `${allMuni}`;
}







$('input:radio[name=existeDetenido]').click(function () {
    validarDetenido($('input:radio[name=existeDetenido]:checked').val());
});


//Valida -> Si existe detenido.

  var cantDetenido = 0;
function validarDetenido(value){


  if (value == 1) {
    $('#personas_raiz').html(`
      <div class="col s12 right-align" style="padding-right: 2rem; padding-top: 1rem">
      <a class="btn" onclick="agregarFormDetenido()"><i class="material-icons left">add_box</i>Agregar persona</a>
      </div>
      <div  id="detenidos_row">
          <div class="row" id="row_${cantDetenido}">
              <div class="input-field col s12 m6 l4 ">
                <i class="material-icons prefix">chevron_right</i>
                <select data-posicion="${cantDetenido}" name="detenido_${cantDetenido}[nacionalidad_detenido]" id="nacionalidad_detenido_${cantDetenido}" onchange="nacionalidadDoc(value,this.dataset.posicion)">
                  <option value="{{null}}" disabled selected>Nacionalidad</option>
                  <option value="1">Guatemalteca</option>
                  <option value="Extranjero"  >Extranjero</option>
                </select>
              </div>
              <div class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input class="" id="cui_detenido_${cantDetenido}" name="detenido_${cantDetenido}[cui_detenido]" type="number">
                <label for="cui_detenido_${cantDetenido}">DPI</label>
              </div>
              <div class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input class="" id="nombres_detenido_${cantDetenido}" name="detenido_${cantDetenido}[nombres_detenido]" type="text">
                <label for="nombres_detenido_${cantDetenido}">Nombres</label>
              </div>
              <div class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input class="" id="apellidos_detenido_${cantDetenido}" name="detenido_${cantDetenido}[apellidos_detenido]" type="text">
                <label for="apellidos_detenido_${cantDetenido}">Apellidos</label>
              </div>
              <div class="col s12  right-align " style="padding-right: 4rem">
                <a class="btn red" onclick="eliminarDetenido(${cantDetenido})">
                    <i class="material-icons left">close</i>
                    Eliminar
                </a>
              </div>
          </div>
      </div>`);
  } else {
    $('#personas_raiz').html('');
    cantDetenido = 0;
  }

  $(`#nacionalidad_detenido_${cantDetenido}`).formSelect();



}


function agregarFormDetenido(){
  cantDetenido++;
  $('#detenidos_row').prepend(`
            <div class="row" id="row_${cantDetenido}">
                <div class="input-field col s12 m6 l4 ">
                  <i class="material-icons prefix">chevron_right</i>
                  <select  data-posicion="${cantDetenido}" name="detenido_${cantDetenido}[nacionalidad_detenido]" id="nacionalidad_detenido_${cantDetenido}" onchange="nacionalidadDoc(value,this.dataset.posicion)">
                    <option value="{{null}}" disabled selected>Nacionalidad</option>
                    <option value="1">Guatemalteca</option>
                    <option value="Extranjero"  >Extranjero</option>
                  </select>
                </div>
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="cui_detenido_${cantDetenido}" name="detenido_${cantDetenido}[cui_detenido]" type="number">
                  <label for="cui_detenido_${cantDetenido}">DPI</label>
                </div>
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="nombres_detenido_${cantDetenido}" name="detenido_${cantDetenido}[nombres_detenido]" type="text">
                  <label for="nombres_detenido_${cantDetenido}">Nombres</label>
                </div>
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="apellidos_detenido_${cantDetenido}" name="detenido_${cantDetenido}[apellidos_detenido]" type="text">
                  <label for="apellidos_detenido_${cantDetenido}">Apellidos</label>
                </div>
              <div class="col s12  right-align" style="padding-right: 4rem">
                <a class="btn red" onclick="eliminarDetenido(${cantDetenido})">
                    <i class="material-icons left">close</i>
                    Eliminar
                </a>
              </div>
            </div>`);

  $(`#nacionalidad_detenido_${cantDetenido}`).formSelect();


}

function eliminarDetenido(cantDetenido){
  $(`#row_${cantDetenido}`).remove();
}


function nacionalidadDoc(val,valDetenido){
  // console.log(val);
  // console.log(data);

  // let selectData = document.getElementById('')
  if(val  == 'Extranjero'){
    let detenido = $(`#cui_detenido_${valDetenido}`);
    detenido.attr('id',`pasaporte_detenido_${valDetenido}`);
    detenido.attr('name',`detenido_${valDetenido}[pasaporte_detenido]`);
    let etiqueta = $(`label[ for="cui_detenido_${valDetenido}"]`);
    etiqueta.attr('for',`pasaporte_detenido_${valDetenido}`);
    etiqueta.html('Pasaporte');
  }else if(val == 1){

    let detenido = $(`#pasaporte_detenido_${valDetenido}`);
    detenido.attr('id',`cui_detenido_${valDetenido}`);
    detenido.attr('name',`detenido_${valDetenido}[cui_detenido]`);
    let etiqueta = $(`label[ for="pasaporte_detenido_${valDetenido}"]`);
    etiqueta.attr('for',`cui_detenido_${valDetenido}`);
    etiqueta.html('DPI');
  }
}

function onCurrentSelectPropietario(){
  $('#propietario').val(); 
  if($('#propietario').val() == 'Otro'){
    console.log($('#propietario').val());
    // Si esta por defecto en otro entonces habilitamos los divs correspondientes para que la informacion pueda colocarse debidamente.
    $('#div_propietario select').removeAttr('name');
    $('#div_propietario select').removeAttr('id');
    $('#div_tipo_propietario').removeAttr('hidden');
    $('#div_denunciante').removeAttr('hidden');
  }
 }


function selectChangePropietario (valor){
let denunciante = document.getElementById("div_denunciante");
let propietario = document.getElementById("div_tipo_propietario");

if(valor == 'Otro'){
  $('#div_propietario select').removeAttr('name');
  $('#div_propietario select').removeAttr('id');
  $('#div_denunciante').removeAttr('hidden');


denunciante.innerHTML = `
  <i class="material-icons prefix">chevron_right</i>
  <input type="text" name="propietario" id="propietario" class="validate" value="">
  <label for="propietario" class="active">Nombre</label>
  `;
$('#div_tipo_propietario').removeAttr('hidden');
propietario.style.display = '';

}else if(valor=='Denunciante'){
  $('#div_propietario select').attr('name','propietario');
  $('#div_propietario select').attr('id','propietario');

    denunciante.innerHTML="";
    $('#div_denunciante').removeAttr('hidden');
    propietario.style.display = 'none';


}else{
  $('#div_denunciante').attr('hidden','hidden');
  $('#div_tipo_propietario').attr('hidden','hidden');
}
}
