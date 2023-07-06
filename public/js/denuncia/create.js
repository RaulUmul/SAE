$('.modal').modal();
// ************ SECCION DE SELECTS  *******************

$('#nacionalidad_persona').select2({
  width:'100%',
  placeholder: 'Nacionalidad ',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});

$('#tipo_documento').select2({
  width: '100%',
  placeholder: 'Tipo de documento ',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});
$('#genero_persona').select2({
  width: '100%',
  placeholder: 'Género ',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});

$('#departamento_residencia').select2({
  width: '100%',
  placeholder: 'Departamento',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});
$('#municipio_residencia').select2({
  width: '100%',
  placeholder: 'Municipio',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});

// Selects arma
$('#tipo_arma').select2({
  width: '100%',
  placeholder: 'Tipo de arma',
  allowClear: true,
});

$('#marca_arma').select2({
  width: '100%',
  placeholder: 'Marca',
  allowClear: true,
  // tags: true,
  language: {
    noResults: function() {
      return "<div style='display:flex; justify-content:space-between;'><div>No existe la categoria.</div><div><a class='btn' id='addMarca' onclick='agregarMarca()'>Agregar</a></div></div>";
   },
  },
  escapeMarkup: function (markup) {
    return markup;
  }
});

$('#calibre_arma').select2({
  width: '100%',
  placeholder: 'Calibre',
  allowClear: true,
  // tags: true,
  language: {
    noResults: function() {
      return "<div style='display:flex; justify-content:space-between;'><div>No existe la categoria.</div><div><a class='btn' id='addCalibre' onclick='agregarCalibre()'>Agregar</a></div></div>";
   },
  },
  escapeMarkup: function (markup) {
    return markup;
  }
});
$('#pais_fabricacion').select2({
  width: '100%',
  placeholder: 'Pais de fabricación',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});

$('#tipo_propietario').select2({
  width: '100%',
  placeholder: 'Tipo propietario',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});

$('#propietario').select2({
  width: '100%',
  placeholder: 'Propietario',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});



// Selects Hecho
$('#tipo_hecho').select2({
  width: '100%',
  placeholder: 'Tipo de hecho',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});
$('#departamento_hecho').select2({
  width: '100%',
  placeholder: 'Departamento',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});
$('#municipio_hecho').select2({
  width: '100%',
  placeholder: 'Municipio',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});
$('#demarcacion_hecho').select2({
  width: '100%',
  placeholder: 'Demarcacion',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});

// Selects Sospechosos

$('#nacionalidad_sindicado').select2({
  width: '100%',
  placeholder: 'Nacionalidad',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});

$('#genero_sindicado').select2({
  width: '100%',
  placeholder: 'Género',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});


//Selects residencia sospechoso

$('#departamento_sindicado').select2({
  width: '100%',
  placeholder: 'Departamento',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});
$('#municipio_sindicado').select2({
  width: '100%',
  placeholder: 'Municipio',
  allowClear: true,
  language: {
    noResults: function() {
      return "No existe la categoria.";
   }
  },
});


// Agrega la opcion de ingresar el propietario diferente al de denucniante.
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
      // Aqui nos quedamos ...
      // propietario.

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

// ************ Seccion de la verificacion del documento

function verificar_check(){

  $("#tipo_documento").val('').trigger('change')

  let val_radiobutton = $('input:radio[name=poseeDocumento]:checked').val();
  let val_nacionalidad = $('#nacionalidad_persona option:selected').text();

  // console.log('val_radiobutton: ', val_radiobutton);
  // console.log('val_nacionalidad: ', val_nacionalidad);

  if((val_nacionalidad == 'Guatemalteca') || (val_nacionalidad == 'Extranjero')){

  switch (val_radiobutton){

    case "1":
      if(val_nacionalidad == "Guatemalteca"){

        // Si la nacionalidad es guatemalteca, mostraremos el div con el DPI.
        $('#div_tipo_documento').removeAttr('hidden');
        $('#div_documento_identificacion').removeAttr('hidden');
        $('#tipo_documento option[value="dpi"]').removeAttr('disabled');
        $('#tipo_documento option[value="pasaporte"]').remove();
        $('#tipo_documento').html(`
        <option value="0" selected disabled>Tipo de documento</option>
        <option value="dpi">DPI</option>
      `);

      }else{
        $('#div_tipo_documento').removeAttr('hidden');
        $('#div_documento_identificacion').removeAttr('hidden');
        $('#tipo_documento option[value="dpi"]').attr('disabled','disabled');
        $('#tipo_documento').html(`
          <option value="0" selected disabled>Tipo de documento</option>
          <option value="pasaporte">Pasaporte</option>
        `);
      }
    break;

    case "0":
      $('#div_tipo_documento').attr('hidden','hidden');
      $('#div_documento_identificacion').attr('hidden','hidden');
    break;

    default:
      return;
  } //Fin Switch
  }else{
    $('#div_tipo_documento').attr('hidden','hidden');
    $('#div_documento_identificacion').attr('hidden','hidden');
  } //Fin If
}


// Volvemos a decirle que actualice
$('input:radio[name=poseeDocumento]').click(function () {
  verificar_check();
});


// Agrega el tipo de documento segun la nacionalidad.
function selectTipoDocumento (valor){

  // let documento = document.getElementById("div_documento_identificacion");

  if(valor == 'dpi'){
      $('#div_documento_identificacion').html(`
      <i class="material-icons prefix">chevron_right</i>
      <input type="number" id="cui" name="cui" class="" value="" oninput="validar_longitud(), inputsPersonaLimpio()" onkeyup="onKeyDPI()" data-length="13">
      <label for="cui">No. DPI / CUI</label>
      <span class="helper-text" data-error="DPI debe ser de 13 digitos" data-success="">DPI debe ser de 13 digitos</span>
      <a class="btn btn-verificar" onclick="verificarCUI()" disabled><i class="material-icons">search</i></a>
      `);
      $('input#cui').characterCounter();
  }else if(valor == 'pasaporte'){
    $('#div_documento_identificacion').html(`
    <i class="material-icons prefix">chevron_right</i>
    <input type="text" id="Pasaporte" name="pasaporte" class="validate" value="" >
    <label for="Pasaporte">No. Pasaporte</label>
    `);

  }else{
    $('#div_documento_identificacion').html(`
    <i class="material-icons prefix">chevron_right</i>
    <input type="text" disabled id="documento" name="documento"  value="">
    <label for="documento" >Documento de Identificacion</label>
    `);
  }

}

// Boton de Verificar
// Valida que el DPI del denunciante tenga 13 digitos.
function validar_longitud(){
  let actual_cui = $('#cui').val();

  switch (actual_cui.length){

    case 13:
      $('.btn-verificar').removeAttr('disabled')
      break;

    default:
      $('.btn-verificar').attr('disabled','disabled');
      break;
  }


}

// Valida que el DPI del sindicado tenga 13 digitos.
function validar_longitud_sindicado(){
  let actual_cui = $('#cui_sindicado').val();

  switch (actual_cui.length){

    case 13:
      $('.btn-verificar-sindicado').removeAttr('disabled')
      break;

    default:
      $('.btn-verificar-sindicado').attr('disabled','disabled');
      break;
  }


}


// ************* Crea el Input Municipio dependiente de Departamento.
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



// ************SECCION DE TABS  *******************
// Efecto para los tabs.  Armas
$('#arma_plus').click(function(){
  alternarClaseTab($('#arma_asociada'),$('#arma_plus'));
});

$('#arma_asociada').click(function(){
alternarClaseTab($('#arma_plus'),$('#arma_asociada'));
});
// Efecto para los tabs. Sindicados
$('#sospechoso_asociado').click(function(){
  $('#main-archivo').removeAttr('hidden');
  alternarClaseTab($('#sospechoso_plus'),$('#sospechoso_asociado'));
});

$('#sospechoso_plus').click(function(){
  $('#main-archivo').attr('hidden','hidden');
alternarClaseTab($('#sospechoso_asociado'),$('#sospechoso_plus'));
});

function alternarClaseTab(obj1,obj2){
  obj1.removeClass('active-tab z-depth-3');
  obj1.addClass('deactive-tab');
  obj2.removeClass('deactive-tab');
  obj2.addClass('active-tab z-depth-3');
}




// ************SECCION DE BOTONES  *******************
// Queda agregar las validaciones correspondientes..

// Para avanzar al sig. tab de Arma
$('#main_arma_button').click(function(){
  $('#linkPersona').removeClass('active');
  $('#linkArma').addClass('active');
  $('.tabs').tabs();
})
// // Para avanzar al sig. tab de Hecho
$('#main_hecho_button').click(function(){
    $('#linkHecho').addClass('active');
    $('#linkArma').removeClass('active');
    $('.tabs').tabs();
})
// // Para avanzar al sig. tab de Sospechosos
$('#main_sospechosos_button').click(function(){
    $('#linkHecho').removeClass('active');
    $('#linkSospechosos').addClass('active');
    $('.tabs').tabs();
})
// // Para retroceder al tab de Datos personales
$('#main_persona_button_back').click(function(){
    $('#linkArma').removeClass('active');
    $('#linkPersona').addClass('active');
    $('.tabs').tabs();
})
// // Para retroceder al tab de Datos de armas
$('#main_arma_button_back').click(function(){
    $('#linkHecho').removeClass('active');
    $('#linkArma').addClass('active');
    $('.tabs').tabs();
})
// // Para retroceder al tab de Datos del hecho
$('#main_hecho_button_back').click(function(){
    $('#linkSospechosos').removeClass('active');
    $('#linkHecho').addClass('active');
    $('.tabs').tabs();
})

// Elimina la data cuando le damos en cancelar
$('#index_button_cancel').click(function(){
  localStorage.removeItem('data');
})

// Evalua si un input esta vacio.
function checkCampos(obj){
  var camposRellenos = true;

    if(obj==null){
      camposRellenos == false;
      return false;
    }else{
      if((obj.length <= 0)){
        camposRellenos = false;
        return false;
      }
    }

    if(camposRellenos == false){
      return false;
    }else{
      return true;
    };
};
function borrarInputArma(){
  // $('#tipo_arma').val(""); // Posterior implementaremos un check que mantendra el select si el usuario  lo solicita.
  // $('#marca_arma').val("");
  $('#modelo_arma').val("");
  $('#tenencia_arma').val("");
  $('#licencia_arma').val("");
  $('#registro_arma').val("");
  $('#pais_fabricacion').val("");
  $('#pais_fabricacion').val("");
  $('#cantidad_tolvas').val("");
  $('#cantidad_municion').val("");
  $('#tipo_propietario').val("");
  $('#propietario').val("");
}

function borrarInputSindicado(){
// $('#nacionalidad_sindicado').val()
$('#cui_sindicado').val("");
$('#pasaporte_sindicado').val("");
$('#nombres_sindicado').val("");
$('#apellidos_sindicado').val("");
$('#genero_sindicado').val("");
$('#edad_sindicado').val("");
$('#departamento_sindicado').val("");
$('#municipio_sindicado').val("");
$('#zona_sindicado').val("");
$('#calle_sindicado').val("");
$('#avenida_sindicado').val("");
$('#numero_casa_sindicado').val("");
$('#direccion_residencia_sindicado').val("");
$('#referencia_residencia_sindicado').val("");
$('#caracteristicas_fisicas').val("");
$('#vestimenta').val("");
$('#organizacion_criminal').val("");
$('#telefono_sindicado').val("");
}
// Rellena los datos en el form de datos personales. Pero con la informacion de la base de datos.
function inputsPersonaLlenosDB(request){
  $('#primer_nombre').val(request.primer_nombre);
  $('#primer_nombre').attr('readonly','readonly');

  $('#segundo_nombre').val(request.segundo_nombre);
  $('#segundo_nombre').attr('readonly','readonly');

  $('#tercer_nombre').val(request.tercer_nombre);
  $('#tercer_nombre').attr('readonly','readonly');

  $('#primer_apellido').val(request.primer_apellido);
  $('#primer_apellido').attr('readonly','readonly');

  $('#segundo_apellido').val(request.segundo_apellido);
  $('#segundo_apellido').attr('readonly','readonly');

  $('#apellido_casada').val(request.apellido_casada);
  $('#apellido_casada').attr('readonly','readonly');

  $('#telefono').val(request.telefono_celular);

  if(request.id_genero == '2'){
    // Setear el valor a Masculino
    $('#genero_persona').val(2);
    $('#genero_persona').trigger('change');
    $('#genero_persona').attr('readonly','readonly');

  }else if(request.id_genero == '3'){
    // Setear el valor a Femenino
    $('#genero_persona').val(3);
    $('#genero_persona').trigger('change');
    $('#genero_persona').attr('readonly','readonly');

  }else{
    // Setear valor nulo
  }
  // Direccion
  $('#departamento_residencia').val(request.direccion.id_departamento);
  $('#departamento_residencia').trigger('change');
  $('#municipio_residencia').val(request.direccion.id_municipio);
  $('#municipio_residencia').trigger('change');
  $('#zona_residencia').val(request.direccion.zona);
  $('#calle_residencia').val(request.direccion.calle);
  $('#avenida_residencia').val(request.direccion.avenida);
  $('#numero_casa').val(request.direccion.numero_casa);
  $('#direccion_residencia').val(request.direccion.direccion_exacta);
  $('#referencia_residencia').val(request.direccion.referencia);


  let d = new Date(request.fecha_nacimiento);
  d = d.toJSON().slice(0,10);
  $('#fecha_nacimiento').val(d);
  $('#fecha_nacimiento').attr('readonly','readonly');

  M.updateTextFields();
}
// Rellena los datos en el form de datos personales.
function inputsPersonaLlenos(request){
  $('#primer_nombre').val(request.primer_nombre);
  $('#primer_nombre').attr('readonly','readonly');

  $('#segundo_nombre').val(request.segundo_nombre);
  $('#segundo_nombre').attr('readonly','readonly');

  $('#tercer_nombre').val(request.tercer_nombre);
  $('#tercer_nombre').attr('readonly','readonly');

  $('#primer_apellido').val(request.primer_apellido);
  $('#primer_apellido').attr('readonly','readonly');

  $('#segundo_apellido').val(request.segundo_apellido);
  $('#segundo_apellido').attr('readonly','readonly');

  $('#apellido_casada').val(request.apellido_casada);
  $('#apellido_casada').attr('readonly','readonly');

  if(request.genero == 'M'){
    // Setear el valor a Masculino
    $('#genero_persona').val(2);
    $('#genero_persona').trigger('change');
    $('#genero_persona').attr('readonly','readonly');

  }else if(request.genero == 'F'){
    // Setear el valor a Femenino
    $('#genero_persona').val(3);
    $('#genero_persona').trigger('change');
    $('#genero_persona').attr('readonly','readonly');

  }else{
    // Setear valor nulo
  }

  let d = new Date(request.fecha_nacimiento);
  d = d.toJSON().slice(0,10);
  $('#fecha_nacimiento').val(d);
  $('#fecha_nacimiento').attr('readonly','readonly');

  M.updateTextFields();
  $('#modal_renap').modal('close');

}

function inputsPersonaLimpio(){
  $('#primer_nombre').val("");
  $('#primer_nombre').removeAttr('readonly');

  $('#segundo_nombre').val("");
  $('#segundo_nombre').removeAttr('readonly');

  $('#tercer_nombre').val("");
  $('#tercer_nombre').removeAttr('readonly');

  $('#primer_apellido').val("");
  $('#primer_apellido').removeAttr('readonly');

  $('#segundo_apellido').val("");
  $('#segundo_apellido').removeAttr('readonly');

  $('#apellido_casada').val("");
  $('#apellido_casada').removeAttr('readonly');

  $('#fecha_nacimiento').val("");
  $('#fecha_nacimiento').removeAttr('readonly');

  $('#genero_persona').val("");
  $('#genero_persona').removeAttr('readonly');

  $('#departamento_residencia').val("");
  $('#municipio_residencia').val("");
  $('#zona_residencia').val("");
  $('#calle_residencia').val("");
  $('#avenida_residencia').val("");
  $('#numero_casa').val("");
  $('#direccion_residencia').val("");
  $('#referencia_residencia').val("");


  M.updateTextFields();

}

function inputsSindicadoLlenos(request){
  $('#primer_nombre_sindicado').val(request.primer_nombre);
  $('#primer_nombre_sindicado').attr('readonly','readonly');

  $('#segundo_nombre_sindicado').val(request.segundo_nombre);
  $('#segundo_nombre_sindicado').attr('readonly','readonly');

  $('#tercer_nombre_sindicado').val(request.tercer_nombre);
  $('#tercer_nombre_sindicado').attr('readonly','readonly');

  $('#primer_apellido_sindicado').val(request.primer_apellido);
  $('#primer_apellido_sindicado').attr('readonly','readonly');

  $('#segundo_apellido_sindicado').val(request.segundo_apellido);
  $('#segundo_apellido_sindicado').attr('readonly','readonly');

  $('#apellido_casada_sindicado').val(request.apellido_casada);
  $('#apellido_casada_sindicado').attr('readonly','readonly');

  if(request.genero == 'M'){
    // Setear el valor a Masculino
    $('#genero_sindicado').val(2);
    $('#genero_sindicado').trigger('change');
    $('#genero_sindicado').attr('readonly','readonly');
  }else if(request.genero == 'F'){
    // Setear el valor a
    $('#genero_sindicado').val(3);
    $('#genero_sindicado').trigger('change');
    $('#genero_sindicado').attr('readonly','readonly');


  }else{
    // Setear valor nulo
  }

  let d = new Date(request.fecha_nacimiento);
  d = d.toJSON().slice(0,10);
  $('#fecha_nacimiento_sindicado').val(d);
  $('#fecha_nacimiento_sindicado').attr('readonly','readonly');

  M.updateTextFields();
  $('#modal_renap').modal('close');

}

function inputsSindicadoLimpio(){
  $('#primer_nombre_sindicado').val("");
  $('#primer_nombre_sindicado').removeAttr('readonly');

  $('#segundo_nombre_sindicado').val("");
  $('#segundo_nombre_sindicado').removeAttr('readonly');

  $('#tercer_nombre_sindicado').val("");
  $('#tercer_nombre_sindicado').removeAttr('readonly');

  $('#primer_apellido_sindicado').val("");
  $('#primer_apellido_sindicado').removeAttr('readonly');

  $('#segundo_apellido_sindicado').val("");
  $('#segundo_apellido_sindicado').removeAttr('readonly');

  $('#apellido_casada_sindicado').val("");
  $('#apellido_casada_sindicado').removeAttr('readonly');

  $('#fecha_nacimiento_sindicado').val("");
  $('#fecha_nacimiento_sindicado').removeAttr('readonly');

  $('#genero_sindicado').val("");
  $('#genero_sindicado').removeAttr('readonly');


  M.updateTextFields();

}
