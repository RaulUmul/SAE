<?php

namespace App\Http\Controllers;

use App\Models\Arma;
use App\Models\Denuncia;
use App\Models\Denunciante;
use App\Models\Departamento;
use App\Models\Direccion;
use App\Models\Hecho;
use App\Models\Item;
use App\Models\Municipio;
use App\Models\Sindicado;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\DB;
use Throwable;

use function PHPSTORM_META\type;

class DenunciaController extends Controller
{

  public function index(){
    $tipo_arma = Item::where('id_categoria',3)->get();
    return view('denuncia.index',compact('tipo_arma'));
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
    return view('denuncia.create',compact(
      'departamento',
      'municipio',
      'tipo_denuncia',
      'tipo_arma',
      'marca_arma',
      'calibre_arma',
      'genero',
      'pais_fabricacion'
    ));
  }
  public function store(Request $request){
    // return $request;
    $data = $request->all();
    $patronArma = "/arma_plus_/";
    $datosArmas=NULL;
    $keys=NULL;
    $id_sindicados = [];
    $id_armas = [];
    // Aislamos los registros de armas y transformamos en mayusculas los datos.
    foreach($data as $key => $value){
      if(preg_match($patronArma, $key, $coincidencias)){
          $datosArmas = Arr::add($datosArmas,$key,array_map('strtoupper',$value));
          $keys = Arr::add($keys,$key,$key);
      };
      //La variable datosArmas Contiene los registros de cada Arma
    };

    $patronSindicado = "/sindicado_plus/";
    $datosSindicado = NULL;
    // Aislamos los registros de sindicados asociados.
    foreach($data as $key => $value){
      if(preg_match($patronSindicado,$key,$coincidencias)){
        $datosSindicado = Arr::add($datosSindicado,$key,$value);
      }
    };

    // return $datosSindicado;
    // return $datosArmas;




    switch($request->poseeDocumento){
      case(0): //Si no posee documento identificacion.
        $denunciante_db = Denunciante::where('primer_nombre',request('primer_nombre'))
                                    ->where('primer_nombre',request('primer_nombre'))
                                    ->where('segundo_nombre',request('segundo_nombre'))
                                    ->where('tercer_nombre',request('tercer_nombre'))
                                    ->where('primer_apellido',request('primer_apellido'))
                                    ->where('segundo_apellido',request('segundo_apellido'))
                                    ->get();
      break;

      case(1): //Si posee documento identificacion.
        if(request('nacionalidad_persona')==1){ //Si es guatemalteco
          $denunciante_db = Denunciante::where('cui',request('cui'))->get();
        }else if(request('nacionalidad_persona')==2){ //Si es extranjero
          $denunciante_db = Denunciante::where('pasaporte',request('pasaporte'))->get();
        };
      break;

      default:
        return  'Algo salio mal';
      break;
    };




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
    }


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
      }
    }

    $direccion_db_residencia = Direccion::select('id_direccion')->where('id_departamento',request('departamento_residencia'))
                                                  ->where('id_municipio',request('municipio_residencia'))
                                                  ->where('zona',request('zona_residencia'))
                                                  ->where('calle',request('calle_residencia'))
                                                  ->where('avenida',request('avenida_residencia'))
                                                  ->where('numero_casa',request('numero_casa'))
                                                  ->where('id_tipo_direccion',$item_residencia);



    $direccion_db_hecho = Direccion::select('id_direccion')->where('id_departamento',request('departamento_hecho'))
                                                  ->where('id_municipio',request('municipio_hecho'))
                                                  ->where('zona',request('zona_hecho'))
                                                  ->where('calle',request('calle_hecho'))
                                                  ->where('avenida',request('avenida_hecho'))
                                                  ->where('numero_casa',request('numero_casa_hecho'))
                                                  ->where('id_tipo_direccion',$item_hecho);



    try {
      DB::beginTransaction();

      //1. Ingresamos las direcciones.
      // Preguntamos si hay direcciones exactas que coincidan en la DB.
      if(!$direccion_db_residencia->count()){
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
        $direccion_denunciante->save();
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




      //2. Ingresamos a persona

      // Si ya existe la persona, ya no se agrega, de lo contrario se agrega.
      if(!$denunciante_db->count()){
        $denunciante = new Denunciante();
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
            $denunciante->id_direccion = ($direccion_denunciante->latest('id_direccion')->first())->id_direccion;
          }else{
            $denunciante->id_direccion = ($direccion_db_residencia->first())->id_direccion;
          }
        $denunciante->save();
        $id_denunciante = $denunciante->latest('id_denunciante')->first('id_denunciante');
      }else{
        // Solo guardamos el id_denunciante ya existente en la db.
        $id_denunciante = $denunciante_db;
      };

      //3. Ingresamos Armas
      foreach($datosArmas as $value){
        $registro_arma_db = Arma::where('registro',$value['registro_arma']);

        if(!$registro_arma_db->count()){
          // Si no existe el arma se agrega.
          $arma = new Arma();
            if($value['tipo_arma'] == ""){
              $arma->id_tipo_arma = NULL;
            }else{
              $arma->id_tipo_arma = $value['tipo_arma'];
            }



            if(isset($value['marca_arma'])){

                // if(isset($e) =='22P02'){
                //   $marca_arma_db_update = new Item();
                //    $marca_arma_db_update->descripcion = $value['marca_arma'];
                //    $marca_arma_db_update->id_categoria = 4;
                //   $marca_arma_db_update->save();
                // }

                  $arma->id_marca_arma = $value['marca_arma'];
                // return $arma->id_marca_arma = Item::select('id_item')->where('descripcion',$value['marca_arma']);
            }


            if(isset($value['modelo_arma'])){
              $arma->modelo_arma = $value['modelo_arma'];
            }

            if(isset($value['licencia_arma'])){
              $arma->licencia = $value['licencia_arma'];
            }

            $arma->registro = $value['registro_arma'];

            if(isset($value['tenencia_arma'])){
              $arma->tenencia = $value['tenencia_arma'];
            }

            if(isset($value['calibre_arma'])){
              $arma->id_calibre = $value['calibre_arma'];
            }

            if(isset($value['pais_fabricacion'])){
              $arma->id_pais_fabricante = $value['pais_fabricacion'];
            }
            if(isset($value['cantidad_tolvas'])){
              $arma->cantidad_tolvas = $value['cantidad_tolvas'];
            }
            if(isset($value['cantidad_municion'])){
              $arma->cantidad_municion = $value['cantidad_municion'];
            }
            if(isset($value['propietario'])){
              $arma->propietario = $value['propietario'];
            }
            // $arma->id_tipo_propietario = $value['']; //No he registrado esto aun

            // El estado se determina a un inicio por el tipo de denuncia.
            switch((Item::select('descripcion')->where('id_item',$request->tipo_hecho)->where('id_categoria',5)->first())->descripcion){

              case('Robo'):
                $arma->estado_arma = $item_robada;
              break;

              case('Hurto'):
                $arma->estado_arma = $item_hurtada;
              break;

              case('Extravio'):
                $arma->estado_arma = $item_extraviada;
              break;

            }
          $arma->save();
          // $id_armas = Arr::prepend($id_armas,Arma::latest('id_arma')->first('id_arma'));
          $id_armas = Arr::prepend($id_armas,$arma->latest('id_arma')->first('id_arma'));
        }else{
          // Esto nunca pasara....
          // Solo almacenamos los id del arma en la db.
          $id_armas = Arr::prepend($id_armas,($registro_arma_db->get('id_arma')->first()),'id');
        }

      }

      // return $id_armas;
      //4. Ingresamos Hecho.
      $hecho = new Hecho();
        $hecho->id_tipo_hecho = request('tipo_hecho');
        $hecho->fecha_hecho = request('fecha_hecho');
        $hecho->hora_hecho = request('hora_hecho');
        $hecho->narracion = request('narracion_hecho');
        // $hecho->id_demarcacion = request('demarcacion_hecho'); //No esta registrado aun.
        $hecho->id_direccion = request('narracion_hecho');
        if(!$direccion_db_hecho->count()){
          $hecho->id_direccion = ($direccion_db_hecho->latest('id_direccion')->first())->id_direccion;
        }else{
          $hecho->id_direccion = ($direccion_db_hecho->first())->id_direccion;
        }
      $hecho->save();
    //  return ($hecho->get('id_hecho')->first())->id_hecho;

      if($datosSindicado != NULL){
      //5. Ingresamos Sindicado
      foreach($datosSindicado as $key => $value){
        // dd($datosSindicado) ;
        $sindicado_db = Sindicado::where('cui',isset($value['cui_sindicado'])?$value['cui_sindicado']:null);
        // if(isset($value['cui_sindicado'])){
          // $sindicado_db = Sindicado::where('cui',$value['cui_sindicado']);
        // }else if(isset($value['nombres'])||isset($value['apellidos'])){
          // $sindicado_db = Sindicado::where('nombres',isset($value['nombres'])?isset($value['nombres']):null )
                                    // ->where('apellidos',isset($value['apellidos'])?isset($value['apellidos']):null );
        // }
        // $sindicado_db_get = Sindicado::where('cui',$value['cui_sindicado']);
        $direccion_db_sindicado = Direccion::where('id_departamento',isset($value['departamento_sindicado']) ? $value['departamento_sindicado']  : null)
                                          ->where('id_municipio',isset($value['municipio_sindicado']) ? $value['municipio_sindicado'] : null)
                                          ->where('zona',isset($value['zona_sindicado']) ? $value['zona_sindicado'] : null)
                                          ->where('calle',isset($value['calle_sindicado']) ? $value['calle_sindicado'] : null)
                                          ->where('avenida',isset($value['avenida_sindicado']) ? $value['avenida_sindicado'] : null)
                                          ->where('numero_casa',isset($value['numero_casa_sindicado']) ?  $value['numero_casa_sindicado'] : null)
                                          ->where('id_tipo_direccion',$item_sindicado);

        // Si al menos existe departamento, se ingresa la direccion.
        if(isset($value['departamento_sindicado'])){



          //  return isset($value['municipio_sindicado']) ? $value['municipio_sindicado']: null;




          if(!$direccion_db_sindicado->count()){
            // Si no existe se agrega
            $direccion_sindicado = new Direccion();

              $direccion_sindicado->id_departamento = $value['departamento_sindicado'];
              if(isset($value['municipio_sindicado'])){
                $direccion_sindicado->id_municipio = $value['municipio_sindicado'];
              }
              if(isset($value['zona_sindicado'])){
                $direccion_sindicado->zona = $value['zona_sindicado'];
              }
              if(isset($value['calle_sindicado'])){
                $direccion_sindicado->calle = $value['calle_sindicado'];
              }
              if(isset($value['avenida_sindicado'])){
                $direccion_sindicado->avenida = $value['avenida_sindicado'];
              }
              if(isset($value['numero_casa_sindicado'])){
                $direccion_sindicado->numero_casa = $value['numero_casa_sindicado'];
              }
              if(isset($value['referencia_residencia_sindicado'])){
                $direccion_sindicado->referencia = $value['referencia_residencia_sindicado'];
              }
              if(isset($value['direccion_residencia_sindicado'])){
                $direccion_sindicado->direccion_exacta = $value['direccion_residencia_sindicado'];
              }
              $direccion_sindicado->id_tipo_direccion = $item_sindicado;
            $direccion_sindicado->save();
          }
        }
        // si no, salta el ingreso de direccion y se agrega solo los datos del sindicado.

        // Si ya existe el sindicado no se agrega la informacion,
        if(!$sindicado_db->count()){
          // return $sindicado_db;
          $sindicado = new Sindicado();
          if(isset($value['cui_sindicado'])){
            $sindicado->cui = $value['cui_sindicado'];
          }
          if(isset($value['pasaporte_sindicado'])){
            $sindicado->nombres = $value['pasaporte_sindicado'];
          }
          if(isset($value['nombres_sindicado'])){
            $sindicado->nombres = $value['nombres_sindicado'];
          }
          if(isset($value['apellidos_sindicado'])){
            $sindicado->apellidos = $value['apellidos_sindicado'];
          }
          if(isset($value['edad_sindicado'])){
            $sindicado->edad = $value['edad_sindicado'];
          }
          if(isset($value['genero_sindicado'])){
            $sindicado->id_genero = $value['genero_sindicado'];
          }
          if(isset($value['caracteristicas_fisicas'])){
            $sindicado->caracteristicas_fisicas = $value['caracteristicas_fisicas'];
          }
          if(isset($value['vestimenta'])){
            $sindicado->vestimenta = $value['vestimenta'];

          }
          if(isset($value['organizacion_criminal'])){
            $sindicado->organizacion_criminal = $value['organizacion_criminal'];
          }
          // if(isset($value['id_nacionalidad_sindicado'])){
          //   $sindicado->id_nacionalidad = $value['nacionalidad_sindicado'];
          // }
          if(isset($value['telefono_sindicado'])){
            $sindicado->telefono = $value['telefono_sindicado']; //Pendiente en el form.
          }

            if(!$direccion_db_sindicado->count()){
              // Si no existe direccion, se agrega la que acabamos de guardar.
              // $sindicado->id_direccion = ($direccion_sindicado->latest('id_direccion')->first())->id_direccion;
              $sindicado->id_direccion = null;
            }else{
              // Si existe en la db
              $sindicado->id_direccion = ($direccion_db_sindicado->first())->id_direccion;
            }
          $sindicado->save();
          // Almacenamos el id de cada sindicado ingresado a la db.
          // $id_sindicados = Arr::add($id_sindicados,'id',($sindicado->get('id_sindicado')));

          $id_sindicados = Arr::prepend($id_sindicados,($sindicado->latest('id_sindicado')->first('id_sindicado')));

        }else if(isset($value['departamento_sindicado'])){
          // si no solo se actualiza el jsonb de id_direccion, pero se verifica que exista departamento al menos
          // return $sindicado_db->id_sindicado;

          // Si se agrego la direccion.
          if(!$direccion_db_sindicado->count()){
            $sindicadoDireccion_update = Sindicado::find(($sindicado_db->first())->id_sindicado);
              $sindicadoDireccion_update->id_direccion = ($direccion_sindicado->latest('id_direccion')->first())->id_direccion;
            $sindicadoDireccion_update->save();
          }else{
            // Si existe en la db
            $sindicadoDireccion_update = Sindicado::find(($sindicado_db->first())->id_sindicado);
              $sindicadoDireccion_update->id_direccion = ['id_direccion'=>[($direccion_db_sindicado->latest('id_direccion')->first())->id_direccion]];
            $sindicadoDireccion_update->save();
          }

          // Guardamos ids si ya existia en la db.
          if($sindicado_db->count()){
            // $id_sindicados = Arr::add($id_sindicados,'id',($sindicado_db->first())->id_sindicado);
            $id_sindicados = Arr::prepend($id_sindicados,($sindicado_db->first())->id_sindicado,'id');
          }

        }
      }
      }
      // dd($id_sindicados);
      // return $id_sindicados;

      // 6. Ingresamos registro de la Denuncia

      foreach($id_armas as $value){

          // return $value->id_arma;

          $denuncia = new Denuncia();
           $denuncia->id_denunciante = ($id_denunciante->first())->id_denunciante;
           $denuncia->id_arma = $value->id_arma;
           $denuncia->id_tipo_denuncia = request('tipo_hecho');
           $denuncia->id_hecho = ($hecho->latest('id_hecho')->first('id_hecho'))->id_hecho;
          //  $denuncia->id_sindicados = $id_sindicados;

          // echo implode($id_sindicados);
          foreach($id_sindicados as $value){
            // return $value;
            $denuncia->id_sindicados = $value;
            // foreach($value as $sindicado){
            // }
          }
          $denuncia->save();


      }

      // return;

      DB::commit();

      // Finalizado:
      return redirect('/sae/denuncia')
            ->with('success', 'Guardado exitosamente');

    } catch (\Throwable $th) {
      DB::rollBack();
      return throw $th;
    }


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
      // 'nacionalidad'=>$request['nacionalidad_sindicado'],
      'cui_sindicado'=>$request['cui_sindicado'],
      'pasaporte_sindicado'=>$request['pasaporte_sindicado'],
      'nombres_sindicado'=>$request['nombres_sindicado'],
      'apellidos_sindicado'=>$request['apellidos_sindicado'],
      'genero_sindicado'=>$request['genero_sindicado'],
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
