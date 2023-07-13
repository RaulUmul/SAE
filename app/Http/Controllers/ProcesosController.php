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
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Estatus_Arma_Denuncia;
use App\Models\Propietario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Arr;



class ProcesosController extends Controller
{
  //Procesos relacionados a la interaccion de los datos de armas en Denuncia, Consulta.
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
                                               $q->orwhere('id_estatus_arma',$item_robada)
                                                 ->orWhere('id_estatus_arma',$item_hurtada)
                                                 ->orWhere('id_estatus_arma',$item_extraviada);
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
    //1. Tenemos que traernos los items.
    $idcategoria_marca_arma = (Categoria::select('id_categoria')->where('descripcion','Marca arma')->first())->id_categoria;
    if ($item->doesntExist() ){
      //dd($idcategoria_marca_arma);
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
  //    PENDIENTE -> No esta en uso
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
      $arma_update->id_estatus_arma = $item_estado->id_item;
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
    $tipo_propietario = Item::where('id_categoria',11)->get();
    //Recibimos todos los datos del arma, para devolver una vista Form. Con los datos del arma.
    //Vista del modal con los datos a editar del arma
    $arma = $request->arma;
    $nombre_completo_denunciante = implode(" ",array_filter([
      $request->denunciante['persona']['primer_nombre'],
      $request->denunciante['persona']['segundo_nombre'],
      $request->denunciante['persona']['tercer_nombre'],
      $request->denunciante['persona']['primer_apellido'],
      $request->denunciante['persona']['segundo_apellido'],
      $request->denunciante['persona']['apellido_casada']
    ]));

    if(!empty($request->arma['propietario']['id_propietario'])){
      $id_propietario = $request->arma['propietario']['id_propietario'];
      $propietario = Propietario::where('id_propietario',$id_propietario)->first();
    }else{ 
      $propietario = NULL;
    }
    return view('consulta._form_edit_arma',compact(
      'arma',
      'calibre_arma',
      'marca_arma',
      'tipo_arma',
      'tipo_propietario',
      'propietario',
      'nombre_completo_denunciante'
    ));
  }

  //  Actualiza la informacioni del arma solicitada.
  public  function  updateArma(Request $request){
    $queryString = $request['data'];
    parse_str($queryString,$data);
    // return $data;

    //Generamos las reglas necesarias.

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

      // Cuando volvemos a guardar/actualizar la informacion del arma, tenemos 3 casos.
      // 1. El arma viene con propietario = Denunciante
      // 2. El arma viene con propietario = Otro
      // 3. No viene el propietario
      
      if(isset($data['propietario']) && $data['propietario'] != ""){
          if($data['propietario']=='Denunciante'){
            $propietario_db = Propietario::where('nombre_propietario',$data['nombre_completo_denunciante']);
          }else{
            $propietario_db = Propietario::where('nombre_propietario',$data['propietario']);
          }

        if($propietario_db->doesntExist()){
				  if($data['propietario'] == 'Denunciante'){
				  	$propietario = new Propietario();
						$propietario->nombre_propietario = $data['nombre_completo_denunciante'];
				  	$propietario->id_tipo_propietario = 369; //Automatizar
				  	$propietario->save();
				  	$id_propietario = $propietario->latest('id_propietario')->first('id_propietario')->id_propietario;
				  }else if($data['propietario'] != 'Denunciante' ){
				  	$propietario = new Propietario();
				  	$propietario->nombre_propietario = $data['propietario'];
				  	$propietario->id_tipo_propietario = $data['tipo_propietario'];
				  	$propietario->save();
				  	$id_propietario = $propietario->latest('id_propietario')->first('id_propietario')->id_propietario;
				  }
        }else if($propietario_db->exists()){
          $id_propietario = $propietario_db->first()->id_propietario; //Verificar comportamiento
          $propietario = Propietario::find($id_propietario);
          $propietario->id_tipo_propietario = $data['tipo_propietario'];
          $propietario->save();
        }
			}else{
        // Si no tenia propietario, lo quitara por venir vacio.
        if(!isset($data['propietario'])){
          $id_propietario = NULL;
        }else if($data['propietario'] == ""){
          $id_propietario = NULL;
        }
      }
      $arma_actualizada->id_propietario = $id_propietario;
      $arma_actualizada->save();
      // Registro de la ampliacion, en efecto.
      $registro_historial = new Registro_Procedimiento_Arma();
      $registro_historial->id_tipo_procedimiento = 418; // Automatizar.
      $registro_historial->id_autor = auth()->user()->id_user; // Automatizar.
      $registro_historial->id_arma = $data['id_arma'];
      $registro_historial->descripcion = $data['descripcion_ampliacion'];
      $registro_historial->save();
      return response()->json(['success'=>'Recuperada correctamente']);
    //  Fin :)
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
    // return $data;

    $rules = [
      '$data["tipo_documento"]' => 'required',
      '$data["numero_documento"]' => 'required',
      '$data["fecha_hecho"]' => 'required',
      '$data["descripcion_hecho"]' => 'required',
      '$data["departamento_hecho_recuperacion"]' => 'required',
      '$data["direccion_hecho"]' => 'required',
    ];

    $mensajes = [
      '$data["tipo_documento"].required' => 'Ingrese tipo de documento',
      '$data["numero_documento"].required' => 'Ingrese No. Documento',
      '$data["fecha_hecho"].required' => 'Ingrese Fecha',
      '$data["descripcion_hecho"].required' => 'Ingrese descripcion',
      '$data["departamento_hecho_recuperacion"].required' => 'Ingrese departamento del hecho',
      '$data["direccion_hecho"].required' => 'Agrege direccion o referencia del hecho',
    ];

    $validator = Validator::make([
      '$data["tipo_documento"]'=>$data['tipo_documento'],
      '$data["numero_documento"]'=>$data['numero_documento'],
      '$data["fecha_hecho"]'=>$data['fecha_hecho'],
      '$data["descripcion_hecho"]'=>$data['descripcion_hecho'],
      '$data["departamento_hecho_recuperacion"]'=>$data['departamento_hecho_recuperacion'],
      '$data["direccion_hecho"]'=>$data['direccion_hecho'],
    ],$rules,$mensajes);

    $item_recuperada = Item::select('id_item')->where('descripcion','Recuperada')->where('id_categoria',9)->first();
    $item_solvente = Item::select('id_item')->where('descripcion','Solvente')->where('id_categoria',9)->first();

    $estados_denuncia = Item::where('id_categoria',16)->get();
    foreach($estados_denuncia as $value){
      switch ($value->descripcion) {
        case 'En cola':
          $item_en_cola = $value->id_item;
          break;
        case 'En proceso':
          $item_en_proceso = $value->id_item;
          break;
        case 'Procesada':
          $item_procesada = $value->id_item;
          break;
      }
    }

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
    // Ahora se encuentra en $detenidos el arreglo de detenidos.xd
      foreach ($detenidos as $detenido) {
        //        Preguntamos si ya existe segun dpi.
        if(empty($detenido['cui_detenido']) && empty($detenido['nombres_detenido'])){
          break;
        }
        if(!empty($detenido['cui_detenido'] )){
          $detenido_db = Persona::where('cui',$detenido['cui_detenido']);

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
    }
    //      return $id_detenidos;

    try {
      DB::beginTransaction();
      // Direccion
      $direccion_hecho = new Direccion();
      $direccion_hecho->id_departamento = $data['departamento_hecho_recuperacion'];
      isset($data['municipio_hecho_recuperacion']) && $direccion_hecho->id_municipio = $data['municipio_hecho_recuperacion'];
      $direccion_hecho->direccion_exacta = $data['direccion_hecho'];
      $direccion_hecho->save();
      // Hecho
      $hecho = new Hecho();
      // $hecho->numero_diligencia = $data['numero_documento']; //Se movio para arma_recuperada
      $hecho->id_tipo_hecho = '412'; //Automatizar.
      $hecho->fecha_hecho = $data['fecha_hecho'];
      isset($data['hora_hecho']) && $hecho->hora_hecho = $data['hora_hecho'];
      $hecho->narracion = $data['descripcion_hecho'];
      isset($data['demarcacion_hecho']) && $hecho->id_demarcacion = $data['demarcacion_hecho'];
      $hecho->id_direccion = $direccion_hecho->latest('id_direccion')->first('id_direccion')->id_direccion;
      $hecho->save();
      // Arma recuperada
      $arma_recuperada = new Arma_Recuperada();
      $arma_recuperada->id_arma = $data['id_arma'];
      $arma_recuperada->id_tipo_documento = $data['tipo_documento'];
      $arma_recuperada->numero_documento = $data['numero_documento'];
      $arma_recuperada->id_hecho = $hecho->latest('id_hecho')->first('id_hecho')->id_hecho;
      $arma_recuperada->id_personas = json_encode($id_detenidos);
      $arma_recuperada->id_tipo_persona = 405;
      isset($data['dependencia_policial']) && $arma_recuperada->dependencia_policial = $data['dependencia_policial'];
      $arma_recuperada->save();
      $actualizacion = self::editStatusArma($data['id_arma'],'Recuperada');

      //Cambio de estado en Estatus_Denuncia_Arma.
      $id_estatus_denuncia = Estatus_Arma_Denuncia::select('id_registro')->where('id_denuncia',$data['id_denuncia'])->first()->id_registro;
      $estatus_denuncia = Estatus_Arma_Denuncia::find($id_estatus_denuncia);
      
        // Se verifica el estado de la denuncia por cada estado de las armas.
      $armas_solventes_recuperadas = 0;
      foreach (json_decode($estatus_denuncia->id_armas) as $arma) {
        $total_armas = count(json_decode($estatus_denuncia->id_armas));
        $estado_arma_fe = Arma::find($arma->id_arma);
        if($estado_arma_fe->id_estatus_arma == $item_recuperada->id_item || $estado_arma_fe->id_estatus_arma == $item_solvente->id_item){
          $armas_solventes_recuperadas+=1;
        }
      }
        // Realizamos la resta de $armas solventes - $total de armas.
      $total_armas_activas = $total_armas - $armas_solventes_recuperadas;
      
      switch ($total_armas_activas) {
        case 0:
          $estatus_denuncia->id_estatus_denuncia = $item_procesada;
          $estatus_denuncia->save();
          break;

        default:
          // Por defecto se asigna el estado como "En proceso".
          $estatus_denuncia->id_estatus_denuncia = $item_en_proceso;
          $estatus_denuncia->save();
          break;
      }

      if($actualizacion){
        $registro_historial = new Registro_Procedimiento_Arma();
        $registro_historial->id_tipo_procedimiento = 417; // Automatizar
        $registro_historial->id_autor = auth()->user()->id_user;
        $registro_historial->id_arma = $data['id_arma'];
        $registro_historial->id_tipo_documento = $data['tipo_documento'];
        $registro_historial->numero_documento = $data['numero_documento'];
        $registro_historial->descripcion = $data['descripcion_hecho']; //Automatizar -> Cual de los dos va, este o el de la sig. Linea.
        // $registro_historial->descripcion = 'Registro de recuperacion'; //Automatizar
        $registro_historial->id_estatus_arma_registrado = $item_recuperada->id_item;
        $registro_historial->save();
      }
      DB::commit();
      return response()->json(['success'=>'Recuperada correctamente']);

      }catch (\Throwable $th){

        throw $th;
        DB::rollBack();

      }
  }

  //Devuelve el historial del arma.
   public function showHistorial(Request $request){
    $tipo_procedimiento = Item::where('id_categoria', 14)->get(); //Automatizar
    $tipo_recuperacion = Item::select('id_item')->where('descripcion','Registro de recuperacion')->first()->id_item;
    $tipo_documento = Item::where('id_categoria',17)->get();
    $usuarios = User::all();
    $arma = $request['arma'];
    $id_arma = $arma['id_arma'];
    $registro = $arma['registro'];
    //Vamos a traernos lo de la tabla registro procedimiento.
    $historial = Registro_Procedimiento_Arma::where('id_arma',$id_arma)->get();
    $arma_recuperada = null;
    foreach ($historial as $value){
      if($value->id_tipo_procedimiento == $tipo_recuperacion ){
        $arma_recuperada = Arma_Recuperada::where('id_arma',$id_arma)->get();
      }
    }
    return view('consulta._historialArma',compact('historial','registro','tipo_procedimiento','arma_recuperada','usuarios','arma','tipo_documento'));
  }

  // Imprime el viewport de Historial
  public function impresionHistorial(Request $request){
    $pdf =  Pdf::loadView('consulta.pdfs.historialArma',['data'=>$request])->stream('historial_serie_.pdf');
    return $pdf;
  }

  public function impresionDenuncia(Request $request){

    $denuncia = json_decode($request->denuncia);
    $departamento = json_decode($request->departamento);
    $municipio = json_decode($request->municipio);
    $genero = $request->genero;
    $tipo_arma = $request->tipo_arma;
    $marca_arma = json_decode($request->marca_arma);
    $calibre_arma = json_decode($request->calibre_arma);
    $estado_arma = $request->estado_arma;
    $tipo_denuncia = $request->tipo_denuncia;
    // $vista = view('consulta.pdfs.denunciaArma')->render();
    $pdf =  Pdf::loadView('consulta.pdfs.denunciaArma',compact('denuncia','departamento','municipio','genero','tipo_arma','marca_arma','calibre_arma','estado_arma','tipo_denuncia'))->stream('denuncia_.pdf');
    return $pdf;
  }

  public function detalleRecuperacion(Request $request){
    $detenidos = [];
    $departamento = Departamento::all();
    $municipio = Municipio::all();
    $demarcacion = Item::where('id_categoria',12)->get();
    $tipo_documento = Item::where('id_categoria',17)->get();


    // Consulta para traer la informacion de la recuperacion.

    // return $request->recuperacion['id_hecho'];
    // return response()->json($request);
    $hecho = Hecho::where('id_hecho',$request->recuperacion['id_hecho'])
    ->with('direccion')
    ->first();
    foreach (json_decode($request->recuperacion['id_personas']) as $persona){
      $detenidos = Arr::prepend($detenidos,Persona::where('id_persona',$persona)->first());
    }
    $detalle = $request->all();
    return view('consulta.detalleRecuperacion',compact(
      'hecho',
      'detalle',
      'detenidos',
      'departamento',
      'municipio',
      'demarcacion',
      'tipo_documento'
    ));
  }

}

