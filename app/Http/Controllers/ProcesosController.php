<?php

namespace App\Http\Controllers;

use App\Models\Arma;
use App\Models\Categoria;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcesosController extends Controller
{
//  Procesos relacionados a la interaccion de los datos de armas en Denuncia, Consulta.
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
                                                ->where(function($q) use ($item_robada,$item_hurtada,$item_extraviada) {
                                                  $q->orwhere('estado_arma',$item_robada)
                                                    ->orWhere('estado_arma',$item_hurtada)
                                                    ->orWhere('estado_arma',$item_extraviada);
                                                })
                                                ->get();


        $data = [
            'statusReload' => $request->statusReload,
            'registro_arma'=>$registro_arma
        ];

        return  response()->json($data);
    }

    public function agregarMarca(Request $request){

        $item =  Item::where('descripcion',strtoupper($request->marcaArma));
        //1. Tenemos que traernos los items.]

        $idcategoria_marca_arma = (Categoria::select('id_categoria')->where('descripcion','Marca arma')->first())->id_categoria;

        if ($item->doesntExist() ){
//      dd($idcategoria_marca_arma);

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
        }else{
          return  response()->json($item->first());
        }

    }

    public function agregarCalibre(Request $request){

        $item =  Item::where('descripcion',strtoupper($request->calibreArma));

        //1. Tenemos que traernos los items.]
        $idcategoria_calibre = (Categoria::select('id_categoria')->where('descripcion','Calibre')->first())->id_categoria;

      if ($item->doesntExist() ) {

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
      }else{
        return  response()->json($item->first());
      }

    }

    public function showStatusArma(Request $request){

      $request->estado_arma;
      $desc_estado = Item::where('id_item',$request->estado_arma)
                          ->where('id_categoria',9)->first();
      $solvente = false;
      $descripcion =$desc_estado->descripcion;
      $id_arma = $request->id_arma;

      if($desc_estado->descripcion != 'Solvente'){
          return view('consulta.showEstadoArma',compact('solvente','descripcion','id_arma'));
      }else{
        $solvente = true;
        return view('consulta.showEstadoArma',compact('solvente','descripcion'));
      }

    }

    public  function editStatusArma(Request $request){
//      return $request;

      $item_solvente = Item::select('id_item')->where('descripcion','Solvente')->where('id_categoria',9)->first();


      try {
        $arma_update = Arma::find($request->id_arma);
        $arma_update->estado_arma = $item_solvente->id_item;
        $arma_update->save();

        return response('success');

      }catch (\Throwable $th){
        throw $th;
        DB::rollBack();
      }

    }

    public  function editArma(Request $request){

      $marca_arma = Item::where('id_categoria',4)->get();
      $calibre_arma = Item::where('id_categoria',7)->get();
      $tipo_arma = Item::where('id_categoria',3)->get();

      //Recibimos todos los datos del arma, para devolver una vista Form. Con los datos del arma.
      //Vista del modal con los datos a editar del arma
      $arma = $request->arma;
      return view('consulta._form_edit_arma',compact('arma','calibre_arma','marca_arma','tipo_arma'));
    }

    public  function  updateArma(Request $request){
      return 'Todo bien prro :)';
    }

    public function showArmas(){
      $tipo_arma = Item::where('id_categoria',3)->get();
      $marca_arma = Item::where('id_categoria',4)->get();
      $estado_arma = Item::where('id_categoria',9)->get();
      $calibre_arma = Item::where('id_categoria',7)->get();
      $armas = Arma::all();
      return ['armas'=>$armas,'tipo_arma'=>$tipo_arma,'marca_arma'=>$marca_arma,'estado_arma'=>$estado_arma,'calibre_arma'=>$calibre_arma];
    }

    public function registroRecuperacion(){

    }

    public function recibirForm(Request $request){

      return $request;
      return response()->json(["Success"=>'Hola']);
    }
}
