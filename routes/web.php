<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\DenunciaControllerVJsonB;
use App\Http\Controllers\ProcesosController;
use App\Http\Controllers\WS_RenapController;
use Illuminate\Support\Facades\Route;


// Login
Route::view('/','login.login')->name('login')->middleware('guest');
Route::view('/registro','login.registro')->middleware('guest');
Route::post('/login',[AuthController::class,'acceso'])->name('acceso')->middleware('guest');
Route::post('/registro',[AuthController::class,'registro'])->name('registro');
Route::get('logout',[AuthController::class,'logout'])->name('logout');


// Inicio
Route::view('/sae','index')->name('sae.inicio')->middleware('auth');

// Modulo Denuncia
Route::resource('/sae/denuncia', DenunciaControllerVJsonB::class)->parameters(['denuncia'=>'item'])->middleware('auth');
// Hay que individualizar las rutas.
// Route::get('denuncia_form_sindicado',[DenunciaController::class, 'form_sindicado'])->name('form_sindicado');
Route::get('denuncia_form_arma', [DenunciaControllerVJsonB::class, 'form_arma'])->name('form_arma');
Route::get('denuncia_form_sindicado',[DenunciaControllerVJsonB::class, 'form_sindicado'])->name('form_sindicado');

// Modulo Consulta
// Route::resource('/sae/consulta',ConsultaController::class)->parameters(['consulta'=>'item']);
Route::get('/sae/consulta',[ConsultaController::class,'index'])->name('consulta.index')->middleware('auth');
Route::get('/sae/consulta/create',[ConsultaController::class,'create'])->name('consulta.create')->middleware('auth');
Route::post('/sae/consulta/show',[ConsultaController::class,'show'])->name('consulta.show');


// Procesos
Route::controller(ProcesosController::class)->group(function(){
  // Verifica si existe ya en la DB un arma con el respectivo registro.
  Route::get('/sae/proceso/agregar_arma','agregarArma')->name('agregarArma');
  Route::get('/sae/proceso/mostrar_todas_armas','showArmas')->name('showArmas');
  Route::get('/sae/proceso/agregar_marca','agregarMarca')->name('agregarMarca');
  Route::get('/sae/proceso/agregar_calibre','agregarCalibre')->name('agregarCalibre');
  Route::get('/sae/proceso/show_status_arma','showStatusArma')->name('showStatusArma');
  Route::get('/sae/proceso/edit_status_arma','editStatusArma')->name('editStatusArma'); //->Eliminar, sin uso.
  Route::get('/sae/proceso/edit_arma','editArma')->name('editArma');
  Route::post('/sae/proceso/update_arma','updateArma')->name('updateArma');
  Route::post('/sae/proceso/registro_recuperacion','registroRecuperacion')->name('registroRecuperacion');
  Route::post('/sae/proceso/historial_arma','showHistorial')->name('showHistorial');
});
// Consulta de CUI a WSRenap.
Route::controller(WS_RenapController::class)->group(function(){
  Route::get('/sae/consulta_renap','renap')->name('consulta_renap');
});

