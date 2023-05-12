//  Se inyecta.


$('input:radio[name=existeDetenido]').click(function () {
    validarDetenido($('input:radio[name=existeDetenido]:checked').val());
});


//Valida -> Si existe detenido.

function validarDetenido(value){
  value == 1
    // Si existe deteneido devolvemos el form dinamico...
    ? $('#personas_raiz').html(`
                <div class="col s12"><a class="btn" onclick="agregarFormDetenido()"><i class="material-icons left">add_box</i>Agregar persona</a></div>
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="cui_detenido_0" name="cui_detenido_0" type="number">
                  <label for="cui_detenido_0">DPI</label>
                </div>
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="nombres_detenido_0" name="nombres_detenido_0" type="text">
                  <label for="nombres_detenido_0">Nombres</label>
                </div>
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="apellidos_detenido_0" name="apellidos_detenido_0" type="text">
                  <label for="apellidos_detenido_0">Apellidos</label>
                </div>
                `)
    : $('#personas_raiz').html('');


}


function agregarFormDetenido(){

  $('#personas_raiz').append(`
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="cui_detenido_0" name="cui_detenido_0" type="number">
                  <label for="cui_detenido_0">DPI</label>
                </div>
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="nombres_detenido_0" name="nombres_detenido_0" type="text">
                  <label for="nombres_detenido_0">Nombres</label>
                </div>
                <div class="input-field col s12 m6 l4">
                  <i class="material-icons prefix">chevron_right</i>
                  <input class="" id="apellidos_detenido_0" name="apellidos_detenido_0" type="text">
                  <label for="apellidos_detenido_0">Apellidos</label>
                </div>
                `);

}
