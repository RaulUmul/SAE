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
  tags: true,
});

$('#calibre_arma').select2({
  width: '100%',
  placeholder: 'Calibre',
  allowClear: true,
  tags: true,
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



// Agrega la opcion de ingresar el propietario diferente al de denucniante.
function selectChangePropietario (valor){

  let denunciante = document.getElementById("div_denunciante");

    if(valor == 'Otro'){
      $('#div_propietario select').removeAttr('name');
      $('#div_propietario select').removeAttr('id');
      $('#div_denunciante').removeAttr('hidden');

        
      denunciante.innerHTML = `
        <i class="material-icons prefix">chevron_right</i>
        <input type="text" name="propietario" id="propietario" class="validate" value="">
        <label for="propietario" class="active">Indique</label>
        `;
    }else if(valor=='Denunciante'){
      $('#div_propietario select').attr('name','propietario');
      $('#div_propietario select').attr('id','propietario');

        denunciante.innerHTML="";
        $('#div_denunciante').removeAttr('hidden');

    }else{
      $('#div_denunciante').attr('hidden','hidden');
    }


}

// ************ Seccion de la verificacion del documento

function verificar_check(){

  $("#tipo_documento").val('').trigger('change')

  let val_radiobutton = $('input:radio[name=group1]:checked').val();
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


// Volvemos a decirle que 
$('input:radio[name=group1]').click(function () {
  verificar_check();
});


// Agrega el tipo de documento segun la nacionalidad.
function selectTipoDocumento (valor){

  // let documento = document.getElementById("div_documento_identificacion");
  
  if(valor == 'dpi'){
      $('#div_documento_identificacion').html(`
      <i class="material-icons prefix">chevron_right</i>
      <input type="number" id="cui" name="cui" class="" value="" oninput="validar_longitud()" data-length="13">
      <label for="cui">No. DPI / CUI</label>
      <span class="helper-text" data-error="DPI debe ser de 13 digitos" data-success="">DPI debe ser de 13 digitos</span>
      <a class="btn btn-verificar" onclick="verificarCUI()" disabled><i class="material-icons">check</i></a>
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
// Valida que el DPI tenga 13 digitos.
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
  alternarClaseTab($('#sospechoso_plus'),$('#sospechoso_asociado'));
});

$('#sospechoso_plus').click(function(){
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
function borrarInput(){
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
  $('#propietario').val("");
}

// Rellena los datos en el form de datos personales.
function inputsPersonaLlenos(request){
  $('#primer_nombre').val(request.primer_nombre);
  $('#primer_nombre').attr('disabled','disabled');

  $('#segundo_nombre').val(request.segundo_nombre);
  $('#segundo_nombre').attr('disabled','disabled');

  $('#tercer_nombre').val(request.tercer_nombre);
  $('#tercer_nombre').attr('disabled','disabled');

  $('#primer_apellido').val(request.primer_apellido);
  $('#primer_apellido').attr('disabled','disabled');

  $('#segundo_apellido').val(request.segundo_apellido);
  $('#segundo_apellido').attr('disabled','disabled');

  $('#apellido_casada').val(request.apellido_casada);
  $('#apellido_casada').attr('disabled','disabled');

  if(request.genero == 'M'){
    // Setear el valor a Masculino
    $('#genero_persona').val('Masculino');
  }else if(request.genero == 'F'){
    // Setear el valor a 
    $('#genero_persona').val('Femenino');
  }else{
    // Setear valor nulo
  }

  let d = new Date(request.fecha_nacimiento);
  d = d.toJSON().slice(0,10);
  $('#fecha_nacimiento').val(d);
  $('#fecha_nacimiento').attr('disabled','disabled');

  M.updateTextFields();
  $('#modal_renap').modal('close');

}

function inputsPersonaLimpio(){
  $('#primer_nombre').val("");
  $('#primer_nombre').removeAttr('disabled');

  $('#segundo_nombre').val("");
  $('#segundo_nombre').removeAttr('disabled');

  $('#tercer_nombre').val("");
  $('#tercer_nombre').removeAttr('disabled');

  $('#primer_apellido').val("");
  $('#primer_apellido').removeAttr('disabled');

  $('#segundo_apellido').val("");
  $('#segundo_apellido').removeAttr('disabled');

  $('#apellido_casada').val("");
  $('#apellido_casada').removeAttr('disabled');

  $('#fecha_nacimiento').val("");
  M.updateTextFields();

}