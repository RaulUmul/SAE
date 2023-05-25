<?php

namespace App\Http\Controllers;

use App\Models\Arma;
use App\Models\Arma_Recuperada;
use App\Models\Categoria;
use App\Models\Direccion;
use App\Models\Hecho;
use App\Models\Item;
use App\Models\Persona;
use App\Models\Registro_Procedimiento_Arma;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ProcesosController extends Controller
{
//  Procesos relacionados a la interaccion de los datos de armas en Denuncia, Consulta.
    public function agregarArma(Request $request){

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
//    PENDIENTE
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

    static function editStatusArma($id_arma,$estado){

      $item_estado = Item::select('id_item')->where('descripcion',$estado)->where('id_categoria',9)->first();


      try {
        $arma_update = Arma::find($id_arma);
        $arma_update->estado_arma = $item_estado->id_item;
        $arma_update->save();

        return true;

      }catch (\Throwable $th){
        throw $th;
        DB::rollBack();
        return false;
      }

    }
//  Muestra form para editar (ampliar) datos del arma.
    public  function editArma(Request $request){

      $marca_arma = Item::where('id_categoria',4)->get();
      $calibre_arma = Item::where('id_categoria',7)->get();
      $tipo_arma = Item::where('id_categoria',3)->get();

      //Recibimos todos los datos del arma, para devolver una vista Form. Con los datos del arma.
      //Vista del modal con los datos a editar del arma
      $arma = $request->arma;
      return view('consulta._form_edit_arma',compact('arma','calibre_arma','marca_arma','tipo_arma'));
    }
//  Actualiza la informacioni del arma solicitada.
    public  function  updateArma(Request $request){
      $queryString = $request['data'];
      parse_str($queryString,$data);
//      return $data;

//      Generamos las reglas necesarias.

      $rules = [
        '$data["registro_arma"]' => 'required',
        '$data["descripcion_ampliacion"]' => 'required',
      ];

      $mensajes = [
        '$data["registro_arma"].required' => 'Ingrese No. de registro',
        '$data["descripcion_ampliacion"].required' => 'Ingrese motivo de ampliacion',
      ];

      $validator = Validator::make([
        '$data["registro_arma"]'=>$data['registro_arma'],
        '$data["descripcion_ampliacion"]'=>$data['descripcion_ampliacion'],
      ],$rules,$mensajes);

      if($validator->fails()){
        $result = $validator->errors();
        return  response()->json($result,500);
      }

      // Actualizacion del arma, guardarla en un try catch;

      try {
        $arma_actualizada = Arma::find($data['id_arma']);
        $arma_actualizada->id_tipo_arma = $data['tipo_arma'];
        empty($data['marca_arma']) ? $arma_actualizada->id_marca_arma = null : $arma_actualizada->id_marca_arma = $data['marca_arma'] ;
        empty($data['modelo_arma']) ?  $arma_actualizada->modelo_arma = null : $arma_actualizada->modelo_arma = $data['modelo_arma'];
        $arma_actualizada->registro = $data['registro_arma'];
        empty($data['licencia_arma']) ? $arma_actualizada->licencia = null : $arma_actualizada->licencia = $data['licencia_arma'];
        empty($data['tenencia_arma']) ? $arma_actualizada->tenencia = null : $arma_actualizada->tenencia = $data['tenencia_arma'];
        empty($data['calibre_arma']) ? $arma_actualizada->id_calibre = null : $arma_actualizada->id_calibre = $data['calibre_arma'];
        empty($data['cantidad_tolvas']) ? $arma_actualizada->cantidad_tolvas = null : $arma_actualizada->cantidad_tolvas = $data['cantidad_tolvas'];
        empty($data['cantidad_municion']) ? $arma_actualizada->cantidad_municion = null : $arma_actualizada->cantidad_municion = $data['cantidad_municion'];
        $arma_actualizada->save();

        // Registro de la ampliacion, en efecto.
        $registro_historial = new Registro_Procedimiento_Arma();
        $registro_historial->id_tipo_procedimiento = 418; // Automatizar.
        $registro_historial->id_autor = auth()->user()->id_user; // Automatizar.
        $registro_historial->id_arma = $data['id_arma'];
        $registro_historial->descripcion = $data['descripcion_ampliacion'];
        $registro_historial->save();
        return response()->json(['success'=>'Recuperada correctamente']);
//      Fin :)
      }catch (\Throwable $th){
        throw $th;
        DB::rollBack();
        return response()->json($th,500);
      }

    }

    public function showArmas(){ //En table del Index - Denuncias
      $tipo_arma = Item::where('id_categoria',3)->get();
      $marca_arma = Item::where('id_categoria',4)->get();
      $estado_arma = Item::where('id_categoria',9)->get();
      $calibre_arma = Item::where('id_categoria',7)->get();
      $armas = Arma::all();
      return ['armas'=>$armas,'tipo_arma'=>$tipo_arma,'marca_arma'=>$marca_arma,'estado_arma'=>$estado_arma,'calibre_arma'=>$calibre_arma];
    }
    public function registroRecuperacion(Request $request){

      $queryString = $request['datos'];
      parse_str($queryString,$data);
      $detenidos = [];
      $id_detenidos=[];
//      return $data;



      $rules = [
        '$data["numero_prevencion"]' => 'required',
        '$data["fecha_hecho"]' => 'required',
        '$data["descripcion_hecho"]' => 'required',
        '$data["departamento_hecho_recuperacion"]' => 'required',
        '$data["direccion_hecho"]' => 'required',
      ];

      $mensajes = [
        '$data["numero_prevencion"].required' => 'Ingrese No. Prevencion',
        '$data["fecha_hecho"].required' => 'Ingrese Fecha',
        '$data["descripcion_hecho"].required' => 'Ingrese descripcion',
        '$data["departamento_hecho_recuperacion"].required' => 'Ingrese departamento del hecho',
        '$data["direccion_hecho"].required' => 'Agrege direccion o referencia del hecho',
      ];

      $validator = Validator::make([
        '$data["numero_prevencion"]'=>$data['numero_prevencion'],
        '$data["fecha_hecho"]'=>$data['fecha_hecho'],
        '$data["descripcion_hecho"]'=>$data['descripcion_hecho'],
        '$data["departamento_hecho_recuperacion"]'=>$data['departamento_hecho_recuperacion'],
        '$data["direccion_hecho"]'=>$data['direccion_hecho'],
      ],$rules,$mensajes);

      if($validator->fails()){
        $result = $validator->errors();
        return  response()->json($result,500);
      }

      if($data['existeDetenido'] == 1) {
        $patron = "/detenido_/";
        foreach ($data as $key => $value) {
          if (preg_match($patron, $key, $coincidencias))
            $detenidos[] = $value;
        }
      }
      if($data['existeDetenido'] == 1){
//      Ahora se encuentra en $detenidos el arreglo de detenidos.xd
        foreach ($detenidos as $detenido) {
          //        Preguntamos si ya existe segun dpi.

          if(empty($detenido['cui_detenido']) && empty($detenido['nombres_detenido'])){
            break;
          }

          if(!empty($detenido['cui_detenido'] )){
            $detenido_db = Persona::where('cui',$detenido['cui_detenido']);
          }

          if ($detenido_db->exists()){
            $id_detenidos[] = $detenido_db->first()->id_persona;
          }else{
            $newDetenido = new Persona();
            if(!empty($detenido['cui_detenido'])){$newDetenido->cui = $detenido['cui_detenido'];}
            if(!empty($detenido['nombres_detenido'])){
              $arrNombres = explode(" ",$detenido['nombres_detenido'],2);
              $newDetenido->primer_nombre = $arrNombres[0];
              isset($arrNombres[1]) ? $newDetenido->segundo_nombre = $arrNombres[1] : $newDetenido->segundo_nombre = null;
              isset($arrNombres[2]) ? $newDetenido->tercer_nombre = $arrNombres[2] : $newDetenido->tercer_nombre = null;
            }
            if(!empty($detenido['apellidos_detenido'])){
              $arrApellidos = explode(" ",$detenido['apellidos_detenido'],2);
              $newDetenido->primer_apellido = $arrApellidos[0];
              isset($arrApellidos[1]) ? $newDetenido->segundo_apellido = $arrApellidos[1] : $newDetenido->segundo_apellido = null;
            }
            $newDetenido->save();
            $id_detenidos[] = $newDetenido->latest('id_persona')->first('id_persona')->id_persona;
          }
        }
      }
//      return $id_detenidos;



      try {
        DB::beginTransaction();
        $direccion_hecho = new Direccion();
        $direccion_hecho->id_departamento = $data['departamento_hecho_recuperacion'];
        isset($data['municipio_hecho_direccion']) && $direccion_hecho->id_municipio = $data['municipio_hecho_direccion'];
        $direccion_hecho->direccion_exacta = $data['direccion_hecho'];
        $direccion_hecho->save();

        $hecho = new Hecho();
        $hecho->numero_diligencia = $data['numero_prevencion'];
        $hecho->id_tipo_hecho = '412'; //Automatizar.
        $hecho->fecha_hecho = $data['fecha_hecho'];
        isset($data['hora_hecho']) && $hecho->hora_hecho = $data['hora_hecho'];
        $hecho->narracion = $data['descripcion_hecho'];
        isset($data['demarcacion_hecho']) && $hecho->id_demarcacion = $data['demarcacion_hecho'];
        $hecho->id_direccion = $direccion_hecho->latest('id_direccion')->first('id_direccion')->id_direccion;
        $hecho->save();


        $arma_recuperada = new Arma_Recuperada();
        $arma_recuperada->id_arma = $data['id_arma'];
        $arma_recuperada->numero_prevencion = $data['numero_prevencion'];
        $arma_recuperada->id_hecho = $hecho->latest('id_hecho')->first('id_hecho')->id_hecho;
        $arma_recuperada->id_persona = json_encode($id_detenidos);
        $arma_recuperada->id_tipo_persona = 405;
        $arma_recuperada->descripcion = $data['descripcion_hecho'];
        $arma_recuperada->save();

        $actualizacion = self::editStatusArma($data['id_arma'],'Recuperada');


        DB::commit();
        if($actualizacion){
          $registro_historial = new Registro_Procedimiento_Arma();
          $registro_historial->id_tipo_procedimiento = 417; // Automatizar
          $registro_historial->id_autor = auth()->user()->id_user; // Automatizar
          $registro_historial->id_arma = $data['id_arma'];
          $registro_historial->numero_documento = $data['numero_prevencion'];
          $registro_historial->descripcion = $data['descripcion_hecho'];
          $registro_historial->save();
          return response()->json(['success'=>'Recuperada correctamente']);
        }

      }catch (\Throwable $th){

        throw $th;
        DB::rollBack();

      }



    }


//    Devuelve el historial del arma.

    public function showHistorial(Request $request){
      $tipo_procedimiento = Item::where('id_categoria', 14)->get(); //Automatizar
      $tipo_recuperacion = Item::select('id_item')->where('descripcion','Registro de recuperacion')->first()->id_item;
      $usuarios = User::all();
      $arma = $request['arma'];
      $id_arma = $arma['id_arma'];
      $registro = $arma['registro'];

//       Vamos a traernos lo de la tabla registro procedimiento.
      $historial = Registro_Procedimiento_Arma::where('id_arma',$id_arma)->get();
      $arma_recuperada = null;
      foreach ($historial as $value){
        if($value->id_tipo_procedimiento == $tipo_recuperacion ){
          $arma_recuperada = Arma_Recuperada::where('id_arma',$id_arma)->first();
        }
      }



      return view('consulta._historialArma',compact('historial','registro','tipo_procedimiento','arma_recuperada','usuarios'));
    }

}

