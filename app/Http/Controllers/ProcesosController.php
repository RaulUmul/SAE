<?php

namespace App\Http\Controllers;

use App\Models\Arma;
use Illuminate\Http\Request;

class ProcesosController extends Controller
{
    public function agregarArma(Request $request){

        // Verifica si se recargo la pagina.
        // if($request->statusReload == 'true'){
        //     Cache::flush();
        // }
        
        
        // Si no se recargo mantiene la cache.
        // Por lo que entiendo, dice que la funcion cache::get(par1: variablearecuperar, par2: variablepordefectosinoexiste);
        // Incluso podemos pasar un "closure", callback que retorne un valor por defecto en el par2.

        // $value = Cache::get('peticion',1);
        // El increment o decrement incrementara o disminuira el valor de un item de tipo int y el segundo parametro indicando en cuanto
        // Se incrementara o decrementara.
        // Cache::increment('peticion', 1);

        // $tipo_arma = TipoArma::where('id_tipo_arma',$request->tipo_arma)->get();
        // return response()->json($request->tipo_arma);

        $registro_arma = Arma::select('registro')->where('registro',$request->registroArma)->get();
                                                // ->where('estado_arma','$item_robada')
                                                // ->where('estado_arma',$item_hurtada)
                                                // ->where('estado_arma',$item_extraviada)
                                                // ->get();


        $data = [
            'statusReload' => $request->statusReload,
            'registro_arma'=>$registro_arma
        ];
        
        return  response()->json($data);
    }


}
