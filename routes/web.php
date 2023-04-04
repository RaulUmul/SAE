<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\DenunciaControllerVJsonB;
use App\Http\Controllers\ProcesosController;
use App\Http\Controllers\WS_RenapController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Login
Route::view('','login.login');
Route::post('',[AuthController::class,'login'])->name('login');

// Inicio
Route::view('/sae','index')->name('sae.inicio');

// Modulo Denuncia
Route::resource('/sae/denuncia', DenunciaControllerVJsonB::class)->parameters(['denuncia'=>'item']);
// Hay que individualizar las rutas.
// Route::get('denuncia_form_sindicado',[DenunciaController::class, 'form_sindicado'])->name('form_sindicado');
Route::get('denuncia_form_arma', [DenunciaControllerVJsonB::class, 'form_arma'])->name('form_arma');
Route::get('denuncia_form_sindicado',[DenunciaControllerVJsonB::class, 'form_sindicado'])->name('form_sindicado');

// Modulo Consulta
// Route::resource('/sae/consulta',ConsultaController::class)->parameters(['consulta'=>'item']);
Route::get('/sae/consulta',[ConsultaController::class,'index'])->name('consulta.index');
Route::get('/sae/consulta/create',[ConsultaController::class,'create'])->name('consulta.create');
Route::post('/sae/consulta/show',[ConsultaController::class,'show'])->name('consulta.show');


// Procesos
Route::controller(ProcesosController::class)->group(function(){
  // Verifica si existe ya en la DB un arma con el respectivo registro.
  Route::get('/sae/proceso/agregar_arma','agregarArma')->name('agregarArma');
  Route::get('/sae/proceso/agregar_marca','agregarMarca')->name('agregarMarca');
  Route::get('/sae/proceso/agregar_calibre','agregarCalibre')->name('agregarCalibre');
});
// Consulta de CUI a WSRenap.
Route::controller(WS_RenapController::class)->group(function(){
  Route::get('/sae/consulta_renap','renap')->name('consulta_renap');
});

