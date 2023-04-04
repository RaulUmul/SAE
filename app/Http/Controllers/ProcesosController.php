<?php

namespace App\Http\Controllers;

use App\Models\Arma;
use App\Models\Categoria;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $item_estado_arma = Item::where('id_categoria',9)->get();
        foreach($item_estado_arma as $value){
          switch($value->descripcion){
            case('Robada'):
              $item_robada = $value->id_item;
            break;
            case('Extraviada'):
              $item_extraviada = $value->id_item;
            break;
            case('Hurtada'):
              $item_hurtada = $value->id_item;
            break;
          }
        };

        $registro_arma = Arma::select('registro')->where('registro',$request->registroArma)
                                                ->where('estado_arma',$item_robada)
                                                ->where('estado_arma',$item_hurtada)
                                                ->where('estado_arma',$item_extraviada)
                                                ->get();


        $data = [
            'statusReload' => $request->statusReload,
            'registro_arma'=>$registro_arma
        ];
        
        return  response()->json($data);
    }

    public function agregarMarca(Request $request){

        //1. Tenemos que traernos los items.]
        $idcategoria_marca_arma = (Categoria::select('id_categoria')->where('descripcion','Marca arma')->first())->id_categoria;

        $marca_toUpper = strtoupper($request->marcaArma);
        $lastId = DB::table('sae.item')->max('id_item');
        $newId = $lastId + 1;

        $item_marca_arma_update = new Item();
         $item_marca_arma_update->id_item = $newId;
         $item_marca_arma_update->descripcion = $marca_toUpper;
         $item_marca_arma_update->id_categoria = $idcategoria_marca_arma;
        $item_marca_arma_update->save();

        $marca_arma = $item_marca_arma_update;
        
        return response()->json($marca_arma);


    }

    public function agregarCalibre(Request $request){

        //1. Tenemos que traernos los items.]
        $idcategoria_calibre = (Categoria::select('id_categoria')->where('descripcion','Calibre')->first())->id_categoria;

        $calibre_toUpper = strtoupper($request->calibreArma);
        $lastId = DB::table('sae.item')->max('id_item');
        $newId = $lastId + 1;

        $item_calibre_update = new Item();
         $item_calibre_update->id_item = $newId;
         $item_calibre_update->descripcion = $calibre_toUpper;
         $item_calibre_update->id_categoria = $idcategoria_calibre;
        $item_calibre_update->save();

        $calibre_arma = $item_calibre_update;
        
        return response()->json($calibre_arma);


    }

}
