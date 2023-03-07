<?php

namespace App\Http\Controllers;

use App\Models\Arma;
use App\Models\Denunciante;
use App\Models\Departamento;
use App\Models\Direccion;
use App\Models\Item;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\DB;

class DenunciaController extends Controller
{

  public function index(){
    return view('denuncia.index');
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
    $patron = "/arma_plus_/";
    $datosArmas=NULL;
    $keys=NULL;
    // Aislamos los registros de armas y transformamos en mayusculas los datos.
    foreach($data as $key => $value){
      if(preg_match($patron, $key, $coincidencias)){
          $datosArmas = Arr::add($datosArmas,$key,array_map('strtoupper',$value));
          $keys = Arr::add($keys,$key,$key);
      };
      //La variable datosArmas Contiene los registros de cada Arma
    };

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
        return throw 'Algo salio mal';
    };

    
    $direccion_db_residencia = Direccion::select('id_direccion')->where('id_departamento',request('departamento_residencia'))
                                                  ->where('id_municipio',request('municipio_residencia'))
                                                  ->where('zona',request('zona_residencia'))
                                                  ->where('calle',request('calle_residencia'))
                                                  ->where('avenida',request('avenida_residencia'))
                                                  ->where('numero_casa',request('numero_casa'))
                                                  ->where('id_tipo_direccion',(Item::select('id_item')->where('descripcion','Residencia')->first())->id_item);
                                                  
                                                  
                                        
    $direccion_db_hecho = Direccion::select('id_direccion')->where('id_departamento',request('departamento_hecho'))
                                                  ->where('id_municipio',request('municipio_hecho'))
                                                  ->where('zona',request('zona_hecho'))
                                                  ->where('calle',request('calle_hecho'))
                                                  ->where('avenida',request('avenida_hecho'))
                                                  ->where('numero_casa',request('numero_casa_hecho'))
                                                  ->where('id_tipo_direccion',(Item::select('id_item')->where('descripcion','Hecho')->first())->id_item);

                                        
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
          $direccion_denunciante->id_tipo_direccion = (Item::select('id_item')->where('descripcion','Residencia')->first())->id_item;
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
          $direccion_hecho->id_tipo_direccion = (Item::select('id_item')->where('descripcion','Hecho')->first())->id_item;
        $direccion_hecho->save();
      }

      // Aun no se encuentra en el formulario.
      // $direccion_sindicado = new Direccion();
      //   $direccion_sindicado->id_departamento = request('departamento_sindicado');
      //   $direccion_sindicado->id_municipio = request('municipio_sindicado');
      //   $direccion_sindicado->zona = request('zona_sindicado');
      //   $direccion_sindicado->calle = request('calle_sindicado');
      //   $direccion_sindicado->avenida = request('avenida_sindicado');
      //   $direccion_sindicado->numero_casa = request('numero_casa_sindicado');
      //   $direccion_sindicado->direccion_exacta = request('direccion_sindicado');
      //   $direccion_sindicado->referencia = request('referencia_sindicado');
      //   $direccion_sindicado->id_tipo_direccion = (Item::select('id_item')->where('descripcion','Sindicado')->first())->id_item;
      // $direccion_sindicado->save();



      //2. Ingresamos a persona

      // Si ya existe la persona, ya no se agrega, de lo contrario se agrega.
      if(!$denunciante_db->count()){
        // Lo unico que deben de traer el request son los id no la descripcion de los items.? //R creo que si.
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
              $arma->id_marca_arma = $value['marca_arma'];
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
              $arma->calibre = $value['calibre_arma'];
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
            $arma->estado_arma = $request->tipo_hecho;
          $arma->save();
        }

      }
      

      //4. Ingresamos Hecho.
      


  
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
      'caracteristicas_fisicas'=>$request['caracteristicas_fisicas'],
      'vestimenta'=>$request['vestimenta'],
      'organizacion_criminal'=>$request['organizacion_criminal'],
      'telefono_sindicado'=>$request['telefono_sindicado']
    ]); 
    return $vista->render();
  }

}
