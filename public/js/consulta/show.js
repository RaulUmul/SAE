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

  // Select Unidad Especializada recupera
  $('#unidad_recupera').select2({
    width: '100%',
    placeholder: 'Unidad Especializada',
    allowClear: true,
    dropdownParent: $("#modEstadoArma"),
    language: {
      noResults: function() {
        return "No existe la categoria.";
      }
    },
  })
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

function validarDetenido(value){

  let cantDetenido = $('#detenidos_row').children().length;

  value == 1
    // Si existe deteneido devolvemos el form dinamico...
    ?
    // Obtenemos el valor de los nodos de detenidos.
    $('#personas_raiz').html(`
      <div class="col s12 right-align" style="padding-right: 2rem; padding-top: 1rem">
      <a class="btn" onclick="agregarFormDetenido($('#detenidos_row').children().length)"><i class="material-icons left">add_box</i>Agregar persona</a>
      </div>
      <div  id="detenidos_row">
          <div class="row" id="row_${cantDetenido}">
              <div class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input class="" id="cui_detenido_${cantDetenido}" name="cui_detenido_${cantDetenido}[cui_detenido]" type="number">
                <label for="cui_detenido_${cantDetenido}">DPI</label>
              </div>
              <div class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input class="" id="nombres_detenido_${cantDetenido}" name="nombres_detenido_${cantDetenido}[nombres_detenido]" type="text">
                <label for="nombres_detenido_${cantDetenido}">Nombres</label>
              </div>
              <div class="input-field col s12 m6 l4">
                <i class="material-icons prefix">chevron_right</i>
                <input class="" id="apellidos_detenido_${cantDetenido}" name="apellidos_detenido_${cantDetenido}][apellidos_detenido]" type="text">
                <label for="apellidos_detenido_${cantDetenido}">Apellidos</label>
              </div>
              <div class="col s12  right-align " style="padding-right: 4rem">
                <a class="btn red" onclick="eliminarDetenido(${cantDetenido})">
                    <i class="material-icons left">close</i>
                    Eliminar
                </a>
              </div>
          </div>
      </div>`)
    : $('#personas_raiz').html('');


}


function agregarFormDetenido(cantDetenido){

  $('#detenidos_row').prepend(`
             <div class="row" id="row_${cantDetenido}">
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="cui_detenido_${cantDetenido}" name="cui_detenido_${cantDetenido}[cui_detenido]" type="number">
                  <label for="cui_detenido_${cantDetenido}">DPI</label>
                </div>
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="nombres_detenido_${cantDetenido}" name="nombres_detenido_${cantDetenido}[nombres_detenido]" type="text">
                  <label for="nombres_detenido_${cantDetenido}">Nombres</label>
                </div>
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="apellidos_detenido_${cantDetenido}" name="apellidos_detenido_${cantDetenido}[apellidos_detenido]" type="text">
                  <label for="apellidos_detenido_${cantDetenido}">Apellidos</label>
                </div>
              <div class="col s12  right-align" style="padding-right: 4rem">
                <a class="btn red" onclick="eliminarDetenido(${cantDetenido})">
                    <i class="material-icons left">close</i>
                    Eliminar
                </a>
              </div>
             </div>
                `);

}

function eliminarDetenido(cantDetenido){
  $(`#row_${cantDetenido}`).remove();
}
