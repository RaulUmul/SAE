<?php

namespace App\Http\Controllers;

use App\Models\Arma;
use App\Models\Denuncia;
use App\Models\Departamento;
use App\Models\Direccion;
use App\Models\Hecho;
use App\Models\Item;
use App\Models\Municipio;
use App\Models\Persona;
use App\Models\Persona_Denuncia;
use App\Models\Registro_Procedimiento_Arma;
use App\Models\Archivo;
use App\Models\Propietario;
use App\Models\Estatus_Arma_Denuncia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class DenunciaControllerVJsonB extends Controller
{
	/**
	 * Esta funcion solo sirve para mostrar la vista de index
	 * y pasarle la informacion, esto es un summary.
	 *
	 * @access public
	 */
  public function index(){
    $tipo_arma = Item::where('id_categoria',3)->get();
    $estado_arma = Item::where('id_categoria',9)->get();
	  return view('denuncia.index',compact('tipo_arma','estado_arma'));
  }

  public function create(){
	$departamento = Departamento::all();
	$municipio = Municipio::all();
	$genero = Item::where('id_categoria',2)->get();
	$tipo_arma = Item::where('id_categoria',3)->get();
	$tipo_denuncia = Item::where('id_categoria',5)->get();
	$marca_arma = Item::where('id_categoria',4)->get();
	$calibre_arma = Item::where('id_categoria',7)->get();
	$pais_fabricacion = Item::where('id_categoria',8)->get();
	$tipo_propietario = Item::where('id_categoria',11)->get();
	$demarcacion = Item::where('id_categoria',12)->get();
	return view('denuncia.create',compact(
	  'departamento',
	  'municipio',
	  'tipo_denuncia',
	  'tipo_arma',
	  'marca_arma',
	  'calibre_arma',
	  'genero',
	  'pais_fabricacion',
		'demarcacion',
		'tipo_propietario'
	));
  }

  public function store(Request $request){

//		 return $request;
    $rules = [
      'poseeDocumento' => 'required',
      'cui_denunciante' => 'min:13|max:13',
      'numero_diligencia' => 'required',
      'tipo_hecho' => 'required'
    ];

    $mensajes = [
      'poseeDocumento.required' => 'Indique si posee documento o no.',
      'cui_denunciante.max' => 'DPI debe ser de 13 digitos',
      'cui_denunciante.min' => 'DPI debe ser de 13 digitos',
      'numero_diligencia.required' => 'El numero de diligencia es requerido ',
      'tipo_hecho.required' => 'El tipo del hecho es requerido '
    ];

    $validator = Validator::make($request->all(),$rules,$mensajes);
    if($validator->fails()){
      $result = $validator->errors();
      return  response()->json($result,500);
    }

		// return $request;
	  $data = $request->all();
	  $patron = "/arma_plus_/";
	  $patronSindicado = "/sindicado_plus/";
	  $datosArmas=NULL;
	  $datosSindicados = NULL;
	  $id_armas=[];
	  $id_denunciante = NULL;
	  $id_sindicados = [];
    $item_robada = '';
    $item_extraviada = '';
    $item_hurtada = '';
    $item_solvente = '';
    $item_recuperada = '';
    $tipo_procedimiento = Item::where('id_categoria', 14)->get();


	// Aislamos los registros de armas y transformamos en mayusculas los datos.
	foreach($data as $key => $value){
	  if(preg_match($patron, $key, $coincidencias)){
		$datosArmas = Arr::add($datosArmas,$key,array_map('strtoupper',$value));
	  };
	};

	// Aislamos los registros de sindicados asociados.
	foreach($data as $key => $value){
	  if(preg_match($patronSindicado,$key,$coincidencias)){
		$datosSindicados = Arr::add($datosSindicados,$key,$value);
	  }
	};


	//Consultamos si persona denunciante existe en la DB.
	switch($request->poseeDocumento){
	  case(0): //Si no posee documento identificacion.
		$denunciante_db = Persona::where('primer_nombre',request('primer_nombre'))
									->where('segundo_nombre',request('segundo_nombre'))
									->where('tercer_nombre',request('tercer_nombre'))
									->where('primer_apellido',request('primer_apellido'))
									->where('segundo_apellido',request('segundo_apellido'))
									->get();
	  break;

	  case(1): //Si posee documento identificacion.
		if(request('nacionalidad_persona')==1){ //Si es guatemalteco
		  $denunciante_db = Persona::where('cui',request('cui'))->get();
		}else if(request('nacionalidad_persona')==2){ //Si es extranjero
		  $denunciante_db = Persona::where('pasaporte',request('pasaporte'))->get();
		};
	  break;

	  default:
		return  'Algo salio mal';
	}



	//Recuperamos el id_tipo_direccion.
	$item_tipo_direccion = Item::where('id_categoria',10)->get();
	foreach($item_tipo_direccion as $value){
	  switch($value->descripcion){
		case('Residencia'):
		  $item_residencia = $value->id_item;
		break;
		case('Hecho'):
		  $item_hecho = $value->id_item;
		break;
		case('Incautacion'):
		  $item_incautacion = $value->id_item;
		break;
		case('Sindicado'):
		  $item_sindicado = $value->id_item;
		break;
	  }
	};

	//Recuperamos el id_estado_arma.
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
		case('Solvente'):
		  $item_solvente = $value->id_item;
		break;
    case('Recuperada'):
      $item_recuperada = $value->id_item;

	  }
	};

	// Recuperamos el id_tipo_denuncia.
	$item_tipo_denuncia = Item::where('id_categoria',5)->get();
	foreach($item_tipo_denuncia as $value){
	  switch($value->descripcion){
		case('Robo'):
		  $item_robo = $value->id_item;
		break;
		case('Hurto'):
		  $item_hurto = $value->id_item;
		break;
		case('Extravio'):
		  $item_extravio = $value->id_item;
		break;
	  }
	};

	// Recuperamos el id_tipo_persona;
	$item_tipo_persona = Item::where('id_categoria',13)->get();
	foreach($item_tipo_persona as $value){
	  switch($value->descripcion){
		case('Denunciante'):
		  $item_tipoPersonaDenunciante = $value->id_item;
		break;
		case('Sindicado'):
		  $item_tipoPersonaSindicado = $value->id_item;
		break;
	  }
	}

	// Recuperamos los estatus de la denuncia.
	$estados_denuncia = Item::where('id_categoria',16)->get();
	foreach($estados_denuncia as $value){
	  switch($value->descripcion){
			case('En cola'):
				$item_en_cola = $value->id_item;
			break;
			case('En proceso'):
				$item_en_proceso = $value->id_item;
			break;
			case('Procesada'):
				$item_procesada = $value->id_item;
			break;
		}
	}


	//Consultamos si existe direccion de algun tipo, comparando con datos del formulario.

	// Direccion de residencia del denunciante.
	$direccion_db_residencia = Direccion::select('id_direccion')
							  ->where('id_departamento',request('departamento_residencia'))
							  ->where('id_municipio',request('municipio_residencia'))
							  ->where('zona',request('zona_residencia'))
							  ->where('calle',request('calle_residencia'))
							  ->where('avenida',request('avenida_residencia'))
							  ->where('numero_casa',request('numero_casa'))
							  ->where('id_tipo_direccion',$item_residencia);

	$direccion_db_hecho = Direccion::select('id_direccion')
							  ->where('id_departamento',request('departamento_hecho'))
							  ->where('id_municipio',request('municipio_hecho'))
							  ->where('zona',request('zona_hecho'))
							  ->where('calle',request('calle_hecho'))
							  ->where('avenida',request('avenida_hecho'))
							  ->where('numero_casa',request('numero_casa_hecho'))
							  ->where('id_tipo_direccion',$item_hecho);


	try {
	  DB::beginTransaction();

	  // 1. Ingreso de direcciones.
	  if($direccion_db_residencia->doesntExist()){
		// Agregamos si no existe en la DB.
		$direccion_denunciante = new Direccion();
		  $direccion_denunciante->id_departamento = request('departamento_residencia');
		  $direccion_denunciante->id_municipio = request('municipio_residencia');
		  $direccion_denunciante->zona = request('zona_residencia');
		  $direccion_denunciante->calle = request('calle_residencia');
		  $direccion_denunciante->avenida = request('avenida_residencia');
		  $direccion_denunciante->numero_casa = request('numero_casa');
		  $direccion_denunciante->direccion_exacta = request('direccion_residencia');
		  $direccion_denunciante->referencia = request('referencia_residencia');
		  $direccion_denunciante->id_tipo_direccion = $item_residencia;
		// $direccion_denunciante->save();
	  }

	  if(!$direccion_db_hecho->count()){
		$direccion_hecho = new Direccion();
		  $direccion_hecho->id_departamento = request('departamento_hecho');
		  $direccion_hecho->id_municipio = request('municipio_hecho');
		  $direccion_hecho->zona = request('zona_hecho');
		  $direccion_hecho->calle = request('calle_hecho');
		  $direccion_hecho->avenida = request('avenida_hecho');
		  $direccion_hecho->numero_casa = request('numero_casa_hecho');
		  $direccion_hecho->direccion_exacta = request('direccion_hecho');
		  $direccion_hecho->referencia = request('referencia_hecho');
		  $direccion_hecho->id_tipo_direccion = $item_hecho;
		$direccion_hecho->save();
	  }

	  // 2. Ingreso de Personas
	  // 2.1 Tipo Denunciante.
	  if(!$denunciante_db->count()){
		// Agregamos si no existe la persona en la DB.
		  $denunciante = new Persona();
		    $denunciante->primer_nombre = request('primer_nombre');
		    $denunciante->segundo_nombre = request('segundo_nombre');
		    $denunciante->tercer_nombre = request('tercer_nombre');
		    $denunciante->primer_apellido = request('primer_apellido');
		    $denunciante->segundo_apellido = request('segundo_apellido');
		    $denunciante->apellido_casada = request('apellido_casada');
		    $denunciante->cui = request('cui');
		    $denunciante->pasaporte = request('pasaporte');
		    $denunciante->telefono_celular = request('telefono');
		    $denunciante->fecha_nacimiento = request('fecha_nacimiento');
		    $denunciante->id_genero = request('genero_persona');
		    $denunciante->id_nacionalidad = request('nacionalidad_persona');
		    if(!$direccion_db_residencia->count()){
		  	  // Si no existe la direccion en la db, se agrega.
		  	  $direccion_denunciante->save();
		  	  // return json_encode($direccion_denunciante->latest('id_direccion')->first('id_direccion'));
		  	  $denunciante->id_direccion = json_encode([$direccion_denunciante->latest('id_direccion')->first('id_direccion')]);
		    }else if($direccion_db_residencia->count()){
		  	  // Si ya existe la direccion, almacenamos el id existente en la DB.
		  	  $denunciante->id_direccion = json_encode([($direccion_db_residencia->first('id_direccion'))->id_direccion]);
		    }
		  $denunciante->save();
		  $id_denunciante = ($denunciante->latest('id_persona')->first('id_persona'))->id_persona;
		  // return $denunciante_db->count();
	  }else if($denunciante_db->count() && !$direccion_db_residencia->count()){

		  // return 'Sientraaca:/';
		  $direccion_denunciante->save();
		  // Si ya existia la persona y la direccion no existia, actualizamos la persona con
		  // la nueva direccion, pues si ya existia ya poseia direccion. / COMO?

		  // 1. Traemos lo que ya existia en el array.
      $direccion_actualizada = json_decode($denunciante_db->first()->id_direccion);
      // 2. Le pushamos el nuevo elemento.
       array_push($direccion_actualizada,json_decode($direccion_denunciante->latest('id_direccion')->first('id_direccion')));
		  // 3. Sobreescribimos el id_direccion que se encontro en la DB.
		   $denunciante_update = Persona::find(($denunciante_db->first())->id_persona);
		    $denunciante_update->id_direccion = json_encode($direccion_actualizada);
		   $denunciante_update->save();
		   $id_denunciante = ($denunciante_db->first())->id_persona;
	  }else if($denunciante_db->count() && $direccion_db_residencia->count()){
      $id_denunciante = $denunciante_db->first()->id_persona;
    }

	  // 2.2 Tipo Sindicado.
	  if($datosSindicados != NULL){
		foreach($datosSindicados as $key => $value){

		  $datosPersonalesForm = true;
		  $datosDireccionForm = true;
		  $otrosDatosForm = true;

		  if(isset($value['departamento_sindicado'])){
			$direccion_db_sindicado = Direccion::where('id_departamento',isset($value['departamento_sindicado']) ? $value['departamento_sindicado']  : null)
											  ->where('id_municipio',isset($value['municipio_sindicado']) ? $value['municipio_sindicado'] : null)
											  ->where('zona',isset($value['zona_sindicado']) ? $value['zona_sindicado'] : null)
											  ->where('calle',isset($value['calle_sindicado']) ? $value['calle_sindicado'] : null)
											  ->where('avenida',isset($value['avenida_sindicado']) ? $value['avenida_sindicado'] : null)
											  ->where('numero_casa',isset($value['numero_casa_sindicado']) ?  $value['numero_casa_sindicado'] : null)
											  ->where('id_tipo_direccion',$item_sindicado);
		  }else{
			$datosDireccionForm = false;
		  }


		  if(isset($value['cui_sindicado'])){
			// Consultamos si Persona sindicado existe en la DB.
			$sindicado_db = Persona::where('cui',isset($value['cui_sindicado'])?$value['cui_sindicado']:null);

		  }else if(isset($value['primer_nombre_sindicado']) || isset($value['segundo_nombre_sindicado'])){
			$sindicado_db = Persona::where('primer_nombre',isset($value['primer_nombre_sindicado']) ? $value['primer_nombre_sindicado'] : null)
									->where('segundo_nombre',isset($value['segundo_nombre_sindicado']) ? $value['segundo_nombre_sindicado'] : null)
									->where('tercer_nombre',isset($value['tercer_nombre_sindicado']) ? $value['tercer_nombre_sindicado'] : null)
									->where('primer_apellido',isset($value['primer_apellido_sindicado']) ? $value['primer_apellido_sindicado'] : null)
									->where('segundo_apellido',isset($value['segundo_apellido_sindicado']) ? $value['segundo_apellido_sindicado'] : null);

		  }else{
			$datosPersonalesForm = false;
		  }

		  if(isset($value['caracteristicas_fisicas']) || isset($value['vestimenta']) || isset($value['organizacion_criminal']) || isset($value['movilizacion'])){
			$otrosDatosForm = true;
		  }else{
			$otrosDatosForm = false;
		  }

		  // Desde aqui construiremos la persona_denuncia para asociar el id de cada persona tipo sindicado.

		  if($datosPersonalesForm){

			if($sindicado_db->doesntExist()){
			  // Si no existe en la DB, se ingresa.

			  $sindicado = new Persona();

			  isset($value['cui_sindicado']) && $sindicado->cui = $value['cui_sindicado'];
			  isset($value['pasaporte_sindicado']) && $sindicado->pasaporte = $value['pasaporte_sindicado'];
			  isset($value['primer_nombre_sindicado']) && $sindicado->primer_nombre = $value['primer_nombre_sindicado'];
			  isset($value['segundo_nombre_sindicado']) && $sindicado->segundo_nombre = $value['segundo_nombre_sindicado'];
			  isset($value['tercer_nombre_sindicado']) &&	$sindicado->tercer_nombre = $value['tercer_nombre_sindicado'];
			  isset($value['primer_apellido_sindicado']) && $sindicado->primer_apellido = $value['primer_apellido_sindicado'];
			  isset($value['segundo_apellido_sindicado']) && $sindicado->segundo_apellido = $value['segundo_apellido_sindicado'];
			  isset($value['apellido_casada_sindicado']) &&	$sindicado->apellido_casada = $value['apellido_casada_sindicado'];
			  isset($value['fecha_nacimiento_sindicado']) &&	$sindicado->fecha_nacimiento = $value['fecha_nacimiento_sindicado'];
			  isset($value['edad_sindicado']) &&	$sindicado->edad = $value['edad_sindicado'];
			  isset($value['genero_sindicado']) &&	$sindicado->id_genero = $value['genero_sindicado'];
			  isset($value['nacionalidad_sindicado']) &&	$sindicado->id_nacionalidad = $value['nacionalidad_sindicado'];
			  isset($value['caracteristicas_fisicas']) &&	$sindicado->caracteristicas_fisicas = $value['caracteristicas_fisicas'];
			  isset($value['vestimenta']) &&	$sindicado->vestimenta = $value['vestimenta'];
			  isset($value['organizacion_criminal']) &&	$sindicado->organizacion_criminal = $value['organizacion_criminal'];
			  // if(isset($value['id_nacionalidad_sindicado'])){
				// $sindicado->id_nacionalidad = $value['nacionalidad_sindicado'];
			  // }
			  isset($value['telefono_sindicado']) &&	$sindicado->telefono_celular = $value['telefono_sindicado']; //Pendiente en el form.

			  // Aqui hay que evaluar si ingresaron datos en direccion.
			  if($datosDireccionForm){
				  if($direccion_db_sindicado->doesntExist()){

				    $direccion_sindicado = new Direccion();

				    isset($value['municipio_sindicado']) && 	$direccion_sindicado->id_departamento = $value['departamento_sindicado'];
				    isset($value['municipio_sindicado']) && 	$direccion_sindicado->id_municipio = $value['municipio_sindicado'];
				    isset($value['zona_sindicado']) && 	$direccion_sindicado->zona = $value['zona_sindicado'];
				    isset($value['calle_sindicado']) && 	$direccion_sindicado->calle = $value['calle_sindicado'];
				    isset($value['avenida_sindicado']) && 	$direccion_sindicado->avenida = $value['avenida_sindicado'];
				    isset($value['numero_casa_sindicado']) && 	$direccion_sindicado->numero_casa = $value['numero_casa_sindicado'];
				    isset($value['referencia_residencia_sindicado']) && 	$direccion_sindicado->referencia = $value['referencia_residencia_sindicado'];
				    isset($value['direccion_residencia_sindicado']) && 	$direccion_sindicado->direccion_exacta = $value['direccion_residencia_sindicado'];
            $direccion_sindicado->id_tipo_direccion = $item_sindicado;
            $direccion_sindicado->save();
            $sindicado->id_direccion = json_encode([$direccion_sindicado->latest('id_direccion')->first('id_direccion')]);
            $sindicado->save();
            //  $id_sindicados = Arr::prepend($id_sindicados,$sindicado->latest('id_persona')->first('id_persona'));
            $id_sindicados = Arr::prepend($id_sindicados,($sindicado->latest('id_persona')->first('id_persona'))->id_persona);



          }else if($direccion_db_sindicado->exists()){
				      // se le asigna el existente.
				      $sindicado->id_direccion = json_encode([($direccion_db_sindicado->first('id_direccion'))->id_direccion]);
				      $sindicado->save();
				      // $id_sindicados = Arr::prepend($id_sindicados,$sindicado->latest('id_persona')->first('id_persona'));
				      $id_sindicados = Arr::prepend($id_sindicados,($sindicado->latest('id_persona')->first('id_persona'))->id_persona);

          }

			    }else{
				  // Solo se guarda al sindicado.
				  $sindicado->save();
				  $id_sindicados = Arr::prepend($id_sindicados,($sindicado->latest('id_persona')->first('id_persona'))->id_persona);
			  } //Si no hay datos de direccion, ahi termina.
			}else if($sindicado_db->count()){
			  // NOSQUEDAMOS HASTA ACA T.T
			  // Si existe en la db, traemos el ID del sindicado.
			  // Y lo almacenamos en la entidad persona_denuncia.

			  // $persona_denuncia->id_persona = $sindicado_db->first('id_persona'); ....
			  // if(($sindicado_db->first('id_direccion'))->id_direccion != $direccion_db_sindicado->first('id_direccion')){

			  // }

			  if($datosDireccionForm){
				  if($direccion_db_sindicado->doesntExist()){ //Aqui hay un error.
				    $direccion_sindicado = new Direccion();
				  	isset($value['municipio_sindicado']) &&  $direccion_sindicado->id_departamento = $value['departamento_sindicado'];
				  	isset($value['municipio_sindicado']) &&  $direccion_sindicado->id_municipio = $value['municipio_sindicado'];
				  	isset($value['zona_sindicado']) &&  $direccion_sindicado->zona = $value['zona_sindicado'];
				  	isset($value['calle_sindicado']) &&  $direccion_sindicado->calle = $value['calle_sindicado'];
				  	isset($value['avenida_sindicado']) &&  $direccion_sindicado->avenida = $value['avenida_sindicado'];
				  	isset($value['numero_casa_sindicado']) &&  $direccion_sindicado->numero_casa = $value['numero_casa_sindicado'];
				  	isset($value['referencia_residencia_sindicado']) &&  $direccion_sindicado->referencia = $value['referencia_residencia_sindicado'];
				  	isset($value['direccion_residencia_sindicado']) &&  $direccion_sindicado->direccion_exacta = $value['direccion_residencia_sindicado'];
				  	$direccion_sindicado->id_tipo_direccion = $item_sindicado;
				    $direccion_sindicado->save();
				    // Actualiza
            // 1. Traemos la direccion existente.
            $direccion_actualizada_sindicado = json_decode($sindicado_db->first()->id_direccion);
            // 2. Pusheamos el arreglo.
            array_push($direccion_actualizada_sindicado,json_decode($direccion_sindicado->latest('id_direccion')->first('id_direccion')));

				    $direccion_db_sindicado_update = Persona::find(($sindicado_db->first('id_persona'))->id_persona);
				    $direccion_db_sindicado_update->id_direccion = json_encode($direccion_actualizada_sindicado);
				    $direccion_db_sindicado_update->save();


				  }
// else if($direccion_db_sindicado->count()){
// 				    // Actualiza
// //				    $dirSindicadoDB = json_decode(($sindicado_db->first('id_direccion'))->id_direccion);
//             return 'sera que entra aqui?';
// //				    $direccion_db_sindicado_update = Persona::find(($sindicado_db->first('id_persona'))->id_persona);
// //				    $direccion_db_sindicado_update->id_direccion = json_encode(array_merge([$dirSindicadoDB]));
// //				    $direccion_db_sindicado_update->save();
// 				  }
			  }
			  $id_sindicados = Arr::prepend($id_sindicados,($sindicado_db->first('id_persona')->id_persona)); //Verificar que aca funciona.

			}

		  }else if($otrosDatosForm  && !$datosPersonalesForm){
			// Si existen otros datos. Se crea la persona unicamente con esos datos y se le asigna la direccion, si es que existe.

			$sindicado_ni = new Persona();
			  isset($value['caracteristicas_fisicas']) && $sindicado_ni->caracteristicas_fisicas = $value['caracteristicas_fisicas'];
			  isset($value['vestimenta']) && $sindicado_ni->vestimenta = $value['vestimenta'];
			  isset($value['organizacion_criminal']) && $sindicado_ni->organizacion_criminal = $value['organizacion_criminal'];
			  // if(isset($value['id_nacionalidad_sindicado'])){
				// $sindicado->id_nacionalidad = $value['nacionalidad_sindicado'];
			  // }
			  isset($value['telefono_sindicado']) && $sindicado_ni->telefono_celular = $value['telefono_sindicado']; //Pendiente en el form.
			  isset($value['movilizacion']) && $sindicado_ni->telefono_celular = $value['telefono_sindicado']; //Pendiente en el form.
			$sindicado_ni->save();

			$id_sindicados = Arr::prepend($id_sindicados,($sindicado_ni->latest('id_persona')->first('id_persona'))->id_persona);
		  }

		}; //FinForeachDatosSindicado

	  }


	  // 3. Ingreso de Armas
	  foreach($datosArmas as $value){
		// Evaluamos que el arma no se encuentre registrada, y si lo esta, que tenga un estado diferente de solvente.
		$registro_arma_db = Arma::where('registro',$value['registro_arma'])
							->where(function ($q) use ($item_robada,$item_hurtada,$item_extraviada){
                  $q->orwhere('id_estatus_arma',$item_robada)
                    ->orWhere('id_estatus_arma',$item_hurtada)
                    ->orWhere('id_estatus_arma',$item_extraviada);
              });
     $registro_arma_db_solvente = Arma::where('registro',$value['registro_arma'])
              ->where(function ($q) use ($item_solvente,$item_recuperada){
                $q->orWhere('id_estatus_arma', $item_solvente)
                  ->orWhere('id_estatus_arma',$item_recuperada);
              });

      $id_propietario = '';



// Aqui esta el problema --PROBLEMAAAA
//		$registro_arma_db_solvente = Arma::where('registro',$value['registro_arma'])
//    			                          ->orWhere('id_estatus_arma',$item_solvente);



//		 $registro_arma_db_solvente = Arma::where(function ($q) use ($value,$item_solvente){
//                  $q->where('registro',$value['registro_arma'])
//                    ->where('id_estatus_arma',$item_solvente);
//               });

//    dump($registro_arma_db_solvente->exists());
//    dump($registro_arma_db->doesntExist());
//    return $registro_arma_db->exists();

		if(isset($value['propietario'])){
			$propietario_db = Propietario::where('nombre_propietario',$value['propietario']);
		}

		if($registro_arma_db->doesntExist() && $registro_arma_db_solvente->doesntExist()){
		  // Si no existe el arma se agrega.

			// Verificamos si el propietario es el denunciante o una empresa de seguridad privada u otra entidad.
			if(isset($value['propietario'])){
        if($propietario_db->doesntExist()){
				  if($value['propietario'] == 'DENUNCIANTE'){
				  	$propietario = new Propietario();
				  	$propietario->nombre_propietario = request('primer_nombre')." ".request('segundo_nombre')." ".request('tercer_nombre')." ".request("primer_apellido")." ".request("segundo_apellido")." ".request("apellido_casada");//El nombre del denunciante recien guardado.
				  	$propietario->id_tipo_propietario = 369; //Automatizar
				  	$propietario->save();
				  	$id_propietario = $propietario->latest('id_propietario')->first('id_propietario')->id_propietario;
				  }else if($value['propietario'] != 'Denunciante' ){
				  	$propietario = new Propietario();
				  	$propietario->nombre_propietario = $value['propietario'];
				  	$propietario->id_tipo_propietario = $value['tipo_propietario'];
				  	$propietario->save();
				  	$id_propietario = $propietario->latest('id_propietario')->first('id_propietario')->id_propietario;
				  }
        }else if($propietario_db->exists()){
          $id_propietario = $propietario_db->first()->id_propietario; //Verificar comportamiento
        }
			}
			// isset($value['tipo_propietario'])
			// isset($value['propietario']) && $arma->propietario = $value['propietario'];


		  $arma = new Arma();

			if($value['tipo_arma'] == ""){
			  $arma->id_tipo_arma = NULL;
			}else{
			  $arma->id_tipo_arma = $value['tipo_arma'];
			}

			isset($value['marca_arma']) && $arma->id_marca_arma = $value['marca_arma'];
			isset($value['modelo_arma']) && $arma->modelo_arma = $value['modelo_arma'];
			isset($value['licencia_arma']) && $arma->licencia = $value['licencia_arma'];
			$arma->registro = $value['registro_arma'];
			isset($value['tenencia_arma']) && $arma->tenencia = $value['tenencia_arma'];
			isset($value['calibre_arma']) && $arma->id_calibre = $value['calibre_arma'];
			isset($value['pais_fabricacion']) && $arma->id_pais_fabricante = $value['pais_fabricacion'];
			isset($value['cantidad_tolvas']) && $arma->cantidad_tolvas = $value['cantidad_tolvas'];
			isset($value['cantidad_municion']) && $arma->cantidad_municion = $value['cantidad_municion'];
			isset($value['propietario']) && $arma->id_propietario = $id_propietario;
			// $arma->id_tipo_propietario = $value['']; //No he registrado esto aun
			// El estado se determina a un inicio por el tipo de hecho.
			switch((Item::select('descripcion')->where('id_item',$request->tipo_hecho)->where('id_categoria',5)->first())->descripcion){

			  case('Robo'):
				$arma->id_estatus_arma = $item_robada;
			  break;

			  case('Hurto'):
				$arma->id_estatus_arma = $item_hurtada;
			  break;

			  case('Extravio'):
				$arma->id_estatus_arma = $item_extraviada;
			  break;

			}
		  $arma->save();
		  // $id_armas = Arr::prepend($id_armas,Arma::latest('id_arma')->first('id_arma'));
		  //Almacenamos el id de armas.
		  $id_armas = Arr::prepend($id_armas,$arma->latest('id_arma')->first('id_arma'));
		}else if($registro_arma_db_solvente->exists()){
      //Si existe pero con estado de solvente, unicamente actualizamos.
//      return $registro_arma_db_solvente->first()->id_arma;
      $arma_update = Arma::find($registro_arma_db_solvente->first()->id_arma);

      switch((Item::select('descripcion')->where('id_item',$request->tipo_hecho)->where('id_categoria',5)->first())->descripcion){

        case('Robo'):
          $arma_update->id_estatus_arma = $item_robada;
          break;

        case('Hurto'):
          $arma_update->id_estatus_arma = $item_hurtada;
          break;

        case('Extravio'):
          $arma_update->id_estatus_arma = $item_extraviada;
          break;

      }

      $arma_update->save();
      //Esto funciona por el momento. //Ya vimos que no funciona.
//      $id_armas[] = Arr::prepend($id_armas,$arma_update->id_arma,'id_arma');
//      Probemos con este xd
      $id_armas = Arr::prepend($id_armas,['id_arma'=>$arma_update->id_arma]);
//      $id_armas = Arr::prepend($id_armas,($arma_update->latest('id_arma')->first('id_arma')));
    }


	  }

//    return $id_armas;


	  // 4. Ingreso de Hecho

	  $hecho = new Hecho();
		$hecho->id_tipo_hecho = request('tipo_hecho');
		// $hecho->numero_diligencia = request('numero_diligencia'); //Se movio para denuncia
		$hecho->fecha_hecho = request('fecha_hecho');
		$hecho->hora_hecho = request('hora_hecho');
		$hecho->narracion = request('narracion_hecho');
		$hecho->id_demarcacion = request('demarcacion_hecho'); //No esta registrado aun.
		if(!$direccion_db_hecho->count()){
		  $hecho->id_direccion = ($direccion_db_hecho->latest('id_direccion')->first())->id_direccion;
		}else{
		  $hecho->id_direccion = ($direccion_db_hecho->first())->id_direccion;
		}
	  $hecho->save();

	  // 5. Ingreso de Denuncia.
	  $denuncia = new Denuncia();

		$denuncia->numero_documento = request('numero_diligencia');
		$denuncia->id_tipo_documento = '419';  //Automatizar -> Diligencia dato quemado
		$denuncia->id_armas = json_encode($id_armas);
		// El tipo_denuncia se determina a un inicio por el tipo de hecho.
		switch((Item::select('descripcion')->where('id_item',$request->tipo_hecho)->where('id_categoria',5)->first())->descripcion){
		  case('Robo'):
			$denuncia->id_tipo_denuncia = $item_robo;
		  break;
		  case('Hurto'):
			$denuncia->id_tipo_denuncia = $item_hurto;
		  break;
		  case('Extravio'):
			$denuncia->id_tipo_denuncia = $item_extravio;
		  break;
		}

		// return $hecho->latest('id_hecho')->first('id_hecho');
		$denuncia->id_hecho = ($hecho->latest('id_hecho')->first('id_hecho'))->id_hecho;
	  $denuncia->save();
//    return $denuncia;

	  // 6. Ingreso de Persona_Denuncia.
	  // 6.1 Denunciante.
	  // El ingreso para el denunciante va a ser normal, no se preguntara si ya existe, porque se tomara la instancia creada.
	  $persona_denuncia = new Persona_Denuncia();
		$persona_denuncia->id_persona = $id_denunciante;
		$persona_denuncia->id_denuncia = ($denuncia->latest('id_denuncia')->first('id_denuncia'))->id_denuncia;
		$persona_denuncia->id_tipo_persona = $item_tipoPersonaDenunciante;
	  $persona_denuncia->save();
	  // 6.2 Sindicado
	  if($datosSindicados!=NULL){
			// 1. Empezaremos capturando todos los id de los sindicados, y guardarlo en un array.

			// 2. Cuando esten capturados id_sindicados:[{id:1}{id:2}] <- ejemplo.
			// 3. Lo recorremos y a cada uno le asignamos el id de la denuncia generada.

			// id: 1 ----- denuncias relacionas {1}
			// id: 2 ----- denuncias relacionas {1}


			// Ahora supongamos que para el sindicado 1 se le asigna en un distinto hecho una nueva denuncia.
			// id_sindicados:[{id:1}{id:3}]

			// id: 1 ----- denuncias relacionada {}


			foreach($id_sindicados as $value){
			  $persona_denuncia = new Persona_Denuncia();
				$persona_denuncia->id_persona = $value;
				$persona_denuncia->id_denuncia = ($denuncia->latest('id_denuncia')->first('id_denuncia'))->id_denuncia;
				$persona_denuncia->id_tipo_persona = $item_tipoPersonaSindicado;
			  // El asunto es recuperar aunquesea el mismo para asignarle la denuncia que acaba de ser creada.
				// $persona_denuncia->id_denuncias_relacionadas = json_encode(($denuncia->latest('id_denuncia')->first('id_denuncia'))->id_denuncia);
			  $persona_denuncia->save();
			}

			
	  }
		//7. Registro del archivo cargado.

		if ($request->hasFile('file')) {
			if($request->file('file')->isValid()){

				if($request->file('file')->getClientOriginalExtension() != 'pdf'){
					return 'Solo es admitido formato PDF'; //Hay que agregarlo al response de errores
				}
				$nombre_hash = $request->file('file')->store('denuncias');
				$archivo = new Archivo();
				$archivo->id_denuncia = ($denuncia->latest('id_denuncia')->first('id_denuncia'))->id_denuncia;
				$archivo->nombre = $request->file('file')->getClientOriginalName();
				$archivo->nombre_hash = $nombre_hash;
				$archivo->mime = $request->file('file')->getClientMimeType();
				$archivo->save();
			}

		}
		//8. Registro de la denuncia en historial.
    foreach ($id_armas as $id_arma) {
      $newID = json_encode($id_arma);
      $registro_historial = new Registro_Procedimiento_Arma();
      $registro_historial->id_tipo_procedimiento = 416; //Automatizar.
      $registro_historial->id_arma = json_decode($newID)->id_arma;
			$registro_historial->id_denuncia = ($denuncia->latest('id_denuncia')->first('id_denuncia'))->id_denuncia;
      $registro_historial->id_autor = auth()->user()->id_user;
      $registro_historial->numero_documento = request('numero_diligencia');
			$registro_historial->id_tipo_documento = '419'; //Automatizar Dato quemado
      $registro_historial->descripcion = 'Creacion de denuncia';
			switch((Item::select('descripcion')->where('id_item',$request->tipo_hecho)->where('id_categoria',5)->first())->descripcion){

			  case('Robo'):
				$registro_historial->id_estatus_arma_registrado = $item_robada;
			  break;

			  case('Hurto'):
				$registro_historial->id_estatus_arma_registrado = $item_hurtada;
			  break;

			  case('Extravio'):
				$registro_historial->id_estatus_arma_registrado = $item_extraviada;
			  break;

			}
      $registro_historial->save();
			//return $registro_historial;
    }

			// 9. Inicializacion del estado_denuncia_arma;
			$registro_estado_denuncia = new Estatus_Arma_Denuncia();
			$registro_estado_denuncia->id_estatus_denuncia = $item_en_cola;
			$registro_estado_denuncia->id_armas = json_encode($id_armas);
			$registro_estado_denuncia->id_denuncia = ($denuncia->latest('id_denuncia')->first('id_denuncia'))->id_denuncia;
			$registro_estado_denuncia->save();

	  DB::commit();

	  // return;

	  return redirect('/sae/denuncia')
	  ->with('success', 'Guardado exitosamente');
	} catch (\Throwable $th) {
	  DB::rollBack();
	  throw $th;
	}



  }

	public function ajustesDenuncia($id){
		$denuncia = Denuncia::find($id);
		return view('denuncia.ajuste_denuncia',compact('id','denuncia'));
	}

	public function delete(Request $request){
		$item_estado_arma = Item::where('id_categoria',9)->get();
		$tipo_procedimiento = Item::where('id_categoria',14)->get();
		$tipo_estado_denuncia = Item::where('id_categoria',16)->get();
		// return $tipo_procedimiento;
		$item_robada = '';
		$item_extraviada = '';
		$item_hurtada = '';
		$item_solvente = '';
		$item_recuperada = '';
		$item_creacion_denuncia = '';
		$item_recuperacion = '';

		foreach($tipo_procedimiento as $item ){
			switch ($item->descripcion) {
				case ('Registro de denuncia'):
					$item_creacion_denuncia = $item->id_item;
					break;

				case ('Registro de recuperacion'):
					$item_recuperacion = $item->id_item;
					break;
			}
		}

		foreach($tipo_estado_denuncia as $item ){
			switch ($item->descripcion) {
				case ('En cola'):
					$item_en_cola = $item->id_item;
					break;

				case ('En proceso'):
					$item_en_proceso = $item->id_item;
					break;

				case ('Procesada'):
					$item_procesada = $item->id_item;
					break;
			}
		}

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
			case('Solvente'):
				$item_solvente = $value->id_item;
			break;
			case('Recuperada'):
				$item_recuperada = $value->id_item;
	
			}
		};

		// if('noestaprocesada'){
			
			// }

			try {
				DB::beginTransaction();
				$denuncia = Denuncia::with('estatus_denuncia')->find($request->id_denuncia);
				// return $denuncia;
				if($denuncia->estatus_denuncia[0]->id_estatus_denuncia == $item_en_cola){
				
					// Al eliminar una denuncia tenemos varios casos.
					foreach(json_decode($denuncia->id_armas) as $arma){
						// return $arma;
						// Traemos todos los regist_procedimiento que coincidan con tipo de procedimiento = Creacion denuncia, y Registro recuperacion.
						$registro_procedimiento = Registro_Procedimiento_Arma::where('id_arma',$arma->id_arma)
																																	->where(function($q) use ($item_creacion_denuncia,$item_recuperacion){
																																		$q->orWhere('id_tipo_procedimiento',$item_creacion_denuncia)
																																		->orWhere('id_tipo_procedimiento',$item_recuperacion);
																																	});
																																	// ->get();
							
						// return $registro_procedimiento->latest('id_estatus_arma_registrado')->first()->id_estatus_arma_registrado;
						$arma_db = Arma::find($arma->id_arma);
						$estado_arma_db = $arma_db->id_estatus_arma;
						if(((count($registro_procedimiento->get()) - 1)==0) && ($estado_arma_db != $item_recuperada)){ //Agregar condicion && estado_arma != 'recuperada'<-codigo. 
							//1. CASO
							// Era la unica denuncia, entonces el arma se queda en la DB pero con estado de solvente (para que pueda ser agregada nuevamente). (Preguntar si se eliminar completamente de la DB);
							// El registro se elimina automaticamente con el CASCADE de id_denuncia;
							// Dejamos el estado de las armas en solvente
							// return count($registro_procedimiento->get());
							$arma_db->id_estatus_arma = $item_solvente; 
							$arma_db->save();
							// return $arma_db;
							// Dejamos constancia de la eliminacion?
						}elseif(($estado_arma_db != $item_recuperada)){
							//2. CASO
							// El arma vuelve al estado anterior de la denuncia mas reciente.
							// Restauramos el estado del arma segun el registro anterior al eliminado.
							// En este caso como no se puede crear otra arma hasta que este recuperada o solvente, solo podremos encontrar el arma en estado Recuperada.
							$arma_db->id_estatus_arma = $registro_procedimiento->latest('id_estatus_arma_registrado')->first('id_estatus_arma_registrado')->id_estatus_arma_registrado;
							$arma_db->save();
						}
						// EL hecho no se elimina, verificar.
						// return $registro_procedimiento;
					}
					// Antes de eliminar una denuncia debemos preguntar si esta se encuentra en proceso o procesada.
					// En caso de ya encontrarse procesada, ya no debera permitir la eliminacion de la denuncia.

						$denuncia->delete();
						DB::commit();
				}else{
					return redirect()->route('denuncia.index')->with('error','No se puede eliminar la denuncia ya que se encuentra procesada o en proceso');
				}
			} catch (\Throwable $th) {
				DB::rollBack();
				throw $th;
			}
		

		// return back()->with('success','Archivo cargado y guardado correctamente');
		return redirect()->route('denuncia.index')->with('success','Denuncia eliminada con exito');
	}


  public function form_arma(Request $request){
	$data = $request['datosLocalStorage'];
	$strings = [];

	foreach($data as $key => $value){
	  $vista = view("denuncia\_form_arma",[
		'index'=>$key,
		'tipo_arma'=>$value['tipo_arma'],
		'value_tipo_arma'=>$value['value_tipo_arma'],
		'registro_arma'=>$value['registro_arma'],
		'marca_arma'=>$value['marca_arma'],
		'value_marca_arma'=>$value['value_marca_arma'],
		'modelo_arma'=>$value['modelo_arma'],
		'calibre_arma'=>$value['calibre_arma'],
		'tenencia_arma'=>$value['tenencia_arma'],
		'licencia_arma'=>$value['licencia_arma'],
		'pais_fabricacion'=>$value['pais_fabricacion'],
		'value_pais_fabricacion'=>$value['value_pais_fabricacion'],
		'cantidad_tolvas'=>$value['cantidad_tolvas'],
		'cantidad_municion'=>$value['cantidad_municion'],
		'tipo_propietario'=>$value['tipo_propietario'],
		'value_tipo_propietario'=>$value['value_tipo_propietario'],
		'propietario'=>$value['propietario'],
		]
	  );
	  $strings[] = new HtmlString($vista);
	}
	return implode($strings);
  }

  public function form_sindicado(Request $request){

	// dd($request);
	// Verifica si se recargo la pagina.
	if($request['statusReload'] == 'true'){
		Cache::flush();
	}
	$index = Cache::get('peticion',0);
	Cache::increment('peticion', 1);
	$vista = view('denuncia\_form_sindicado',[
	  'index'=>$index,
	  'nacionalidad'=>$request['nacionalidad_sindicado'],
	  'cui_sindicado'=>$request['cui_sindicado'],
	  'pasaporte_sindicado'=>$request['pasaporte_sindicado'],
	  'primer_nombre_sindicado'=>$request['primer_nombre_sindicado'],
	  'segundo_nombre_sindicado'=>$request['segundo_nombre_sindicado'],
	  'tercer_nombre_sindicado'=>$request['tercer_nombre_sindicado'],
	  'primer_apellido_sindicado'=>$request['primer_apellido_sindicado'],
	  'segundo_apellido_sindicado'=>$request['segundo_apellido_sindicado'],
	  'apellido_casada_sindicado'=>$request['apellido_casada_sindicado'],
	  'genero_sindicado'=>$request['genero_sindicado'],
	  'fecha_nacimiento_sindicado'=>$request['fecha_nacimiento_sindicado'],
	  'edad_sindicado'=>$request['edad_sindicado'],
	  'departamento_sindicado' => $request['departamento_sindicado'],
	  'municipio_sindicado' => $request['municipio_sindicado'],
	  'zona_sindicado' => $request['zona_sindicado'],
	  'calle_sindicado' => $request['calle_sindicado'],
	  'avenida_sindicado' => $request['avenida_sindicado'],
	  'numero_casa_sindicado' => $request['numero_casa_sindicado'],
	  'direccion_residencia_sindicado' => $request['direccion_residencia_sindicado'],
	  'referencia_residencia_sindicado' => $request['referencia_residencia_sindicado'],
	  'caracteristicas_fisicas'=>$request['caracteristicas_fisicas'],
	  'vestimenta'=>$request['vestimenta'],
	  'organizacion_criminal'=>$request['organizacion_criminal'],
	  'telefono_sindicado'=>$request['telefono_sindicado']
	]);
	return $vista->render();
  }

}
