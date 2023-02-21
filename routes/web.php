<?php

use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\FallbackController;
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


Route::view('/sae','index')->name('sae.inicio');
Route::get('denuncia_form_arma', [DenunciaController::class, 'form_arma'])->name('form_arma');
Route::get('denuncia_form_sindicado',[DenunciaController::class, 'form_sindicado'])->name('form_sindicado');

Route::resource('/sae/denuncia', DenunciaController::class)->parameters(['denuncia'=>'item']);

Route::controller(ProcesosController::class)->group(function(){
  // Verifica si existe ya en la DB un arma con el respectivo registro.
  Route::get('/sae/proceso/agregar_arma','agregarArma')->name('agregarArma');
});

Route::controller(WS_RenapController::class)->group(function(){
  Route::get('/sae/consulta_renap','renap')->name('consulta_renap');
});
