<?php

namespace App\Http\Controllers;
// use App\Http\Controllers\SoapClient;
use SoapClient;
use Illuminate\Http\Request;

class WS_RenapController extends Controller
{

    public static function renap(Request $request,$renap=false){

        $cui = $request->cui;
    	$url = 'http://172.21.68.211/optimus2_rest/WS_OptimusPrime.php';
    	$cliente= "RAUL";
    	// $user= \Auth::user()->usuario;
    	$user= 'consulta_prueba';
        $ws = new SoapClient(null,array('location'=>$url,'uri'=>$url));
    	
        
        return $ws->DatosCiudadanoDPI_Renap($cui,$cliente,$renap,$user,false);


        // Codigo de errores identificados.

        // error 1: El DPI debe contener 13 digitos.

        // error 15: "No hay datos para la persona que busca en RENAP por favor verifique el número de DPI o sede_indice (1111111111111,)"

    }
}




