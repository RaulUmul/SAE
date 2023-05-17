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
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use PDO;

class ConsultaController extends Controller
{
  public function index()
  {
    return view('consulta._index');
  }


  public function create()
  {
    return view('consulta._create');
  }

  public function show(Request $request)
  {

    $departamento = Departamento::all();
    $municipio = Municipio::all();
    $genero = Item::where('id_categoria', 2)->get();
    $tipo_arma = Item::where('id_categoria', 3)->get();
    $marca_arma = Item::where('id_categoria', 4)->get();
    $calibre_arma = Item::where('id_categoria', 7)->get();
    $estado_arma = Item::where('id_categoria', 9)->get();
    $tipo_denuncia = Item::where('id_categoria',5)->get();

    // 1. Preguntar de que viene la consulta. Persona o Arma.
    // Request CUI
    if (request('numero_cui')) {
      $personas = Persona::where('cui', request()->only('numero_cui'));

      if ($personas->exists()) {
        // Obtenemos el id de cada denuncia.
        $personas_denuncia = Persona_Denuncia::where('id_persona', $personas->first()->id_persona);
        // $personas_denuncia->get();

        $id_denuncias = [];

        foreach ($personas_denuncia->get() as $key => $value) {
          $id_denuncias = Arr::add($id_denuncias, $key, $value->id_denuncia);
        }

        // Recorremos el arreglo
        $i_denuncia = [];
        $count = 0;
        foreach ($id_denuncias as $key => $value) {
          $personas_denuncia = Persona_Denuncia::with('persona')
            ->whereRelation('denuncia', 'id_denuncia', $value)
            ->get();
          foreach($personas_denuncia as $personas){
            $direccion=[];
            if(isset($personas['persona']['id_direccion'])){
              if(is_array(json_decode($personas['persona']['id_direccion'], true))){
                foreach (json_decode($personas['persona']['id_direccion']) as $direc){
                  $direccion[]=self::direccion($direc->id_direccion);
                }
              }
            }
            $personas['persona']['direccion']=$direccion;

          }

          $denuncia = Denuncia::where('id_denuncia', $value)->first();
          $armas = [];
          foreach( (json_decode($denuncia->id_armas)) as $arma){
            $armas[] = Arma::where('id_arma',$arma->id_arma)->first();
          }

          $hecho_direccion = Hecho::where('id_hecho', $denuncia->id_hecho)
            ->with('direccion')
            ->first();

          $denunciante = $personas_denuncia->where('id_tipo_persona', 403)->first();
          $sindicados = $personas_denuncia->where('id_tipo_persona', 404);

          $i_denuncia = Arr::add($i_denuncia, 'denuncia_' . $key, ['denunciante' => $denunciante, 'sindicados' => $sindicados, 'hecho' => $hecho_direccion,'armas'=>$armas]);

        }

        return view('consulta._show',
          compact('i_denuncia',
            'departamento',
            'municipio',
            'genero',
            'tipo_arma',
            'marca_arma',
            'calibre_arma',
            'estado_arma',
            'tipo_denuncia')

        );
      } else if ($personas->doesntExist()) {
        return redirect(route('consulta.create'))
          ->with('error', 'No se ha encontrado el registro.');
      }
    // Request Nombre
    }else if(request('nombre_completo')){
        // Solo encuentra busquedas exactas, la tilde por ejemplo.
        $nombre_completo = ucwords(request('nombre_completo'));
        $personas = Persona::whereRaw("REPLACE(TRIM(CONCAT(
                                        COALESCE(primer_nombre,''),' ',
                                        COALESCE(segundo_nombre,''),' ',
                                        COALESCE(tercer_nombre,''),' ',
                                        COALESCE(primer_apellido,''),' ',
                                        COALESCE(segundo_apellido,''),' ',
                                        COALESCE(apellido_casada,''))),'  ',' ')
                                        LIKE '%$nombre_completo%'");


        if($personas->exists()){

          // return $personas->get();
          // Pos como seria la pinchi logica?
          $datos=[];
          foreach($personas->get() as $persona){
            $datos[] = ['nombre_completo' => $persona->primer_nombre.' '.$persona->segundo_nombre.' '.$persona->tercer_nombre.' '.$persona->primer_apellido.' '.$persona->segundo_apellido.' '.$persona->apeliido_casada,
                        'id'=>$persona->id_persona];
          }
          return view('consulta.consulta_persona_eleccion',compact('datos'));


//          return  'avwsiexite';
        }else if($personas->doesntExist()){
          return redirect(route('consulta.create'))
          ->with('error', 'No se ha encontrado el registro.');

        }
    // Request Numero Registro, Licencia , Tenencia
    } else if (request('numero_registro') || request('numero_licencia') || request('numero_tenencia')) {

      if (request('numero_registro')) {
        $arma = Arma::where('registro', strtoupper(request()->only('numero_registro')['numero_registro']));
      }
      if (request('numero_licencia')) {
        $arma = Arma::where('licencia', request()->only('numero_licencia'));
      }
      if (request('numero_tenencia')) {
        $arma = Arma::where('tenencia', request()->only('numero_tenencia'));
      }


      if ($arma->exists()) {
        // Si arma existe ejecuta lo sig.
        $denuncias = Denuncia::whereJsonContains('id_armas', [['id_arma' => $arma->first('id_arma')->id_arma]])->get();
        $i_denuncia = [];

        foreach ($denuncias as $key => $denuncia) {

          // Denuncia y Persona;
          $personas_denuncia = Persona_Denuncia::with('persona')
            ->whereRelation('denuncia', 'id_denuncia', $denuncia->id_denuncia)
            ->get();
            foreach($personas_denuncia as $personas){
              $direccion=[];
               if(isset($personas['persona']['id_direccion'])){
                if(is_array(json_decode($personas['persona']['id_direccion'], true))){
                      foreach (json_decode($personas['persona']['id_direccion']) as $direc){
                        $direccion[]=self::direccion($direc->id_direccion);
                  }
                 }
               }
              $personas['persona']['direccion']=$direccion;

            }


          // Hecho y Direccion
          $hecho_direccion = Hecho::where('id_hecho', $denuncia->id_hecho)
            ->with('direccion')
            ->first();

          $denunciante = $personas_denuncia->where('id_tipo_persona', 403)->first();
          $sindicados = $personas_denuncia->where('id_tipo_persona', 404);

          $count = 0;
          $i_denuncia = Arr::add($i_denuncia, 'denuncia_'.$key, ['denunciante' => $denunciante, 'sindicados' => $sindicados, 'hecho' => $hecho_direccion, 'armas' => $arma->get()]);

        }

//                  return $i_denuncia;
          // Agregarle sus compact y el resto de weas xdxd


          // return $genero;
        return view('consulta._show',
          // (['denunciante'=>$denunciante,'sindicados'=>$sindicados,'hecho'=>$hecho_direccion,'arma'=>$arma->get()])
          compact(
            'i_denuncia',
            'departamento',
            'municipio',
            'genero',
            'tipo_arma',
            'marca_arma',
            'calibre_arma',
            'estado_arma',
            'tipo_denuncia',
          )
        );
      } else if ($arma->doesntExist()) {
        return redirect(route('consulta.create'))
          ->with('error', 'No se ha encontrado el registro.');
      }
    // Request ID Persona resultado de Busqueda por nombre;
    } else if(request('id_persona')){


        // Obtenemos el id de cada denuncia.
        $personas_denuncia = Persona_Denuncia::where('id_persona', request('id_persona'));
        // $personas_denuncia->get();

        $id_denuncias = [];

        foreach ($personas_denuncia->get() as $key => $value) {
          $id_denuncias = Arr::add($id_denuncias, $key, $value->id_denuncia);
        }

        // Recorremos el arreglo
        $i_denuncia = [];
        $count = 0;
        foreach ($id_denuncias as $key => $value) {
          $personas_denuncia = Persona_Denuncia::with('persona')
            ->whereRelation('denuncia', 'id_denuncia', $value)
            ->get();
          foreach ($personas_denuncia as $personas) {
            $direccion = [];
            if (isset($personas['persona']['id_direccion'])) {
              if (is_array(json_decode($personas['persona']['id_direccion'], true))) {
                foreach (json_decode($personas['persona']['id_direccion']) as $direc) {
                  $direccion[] = self::direccion($direc->id_direccion);
                }
              }
            }
            $personas['persona']['direccion'] = $direccion;

          }

          $denuncia = Denuncia::where('id_denuncia', $value)->first();
          $armas = [];
          foreach ((json_decode($denuncia->id_armas)) as $arma) {
            $armas[] = Arma::where('id_arma', $arma->id_arma)->first();
          }

          $hecho_direccion = Hecho::where('id_hecho', $denuncia->id_hecho)
            ->with('direccion')
            ->first();

          $denunciante = $personas_denuncia->where('id_tipo_persona', 403)->first();
          $sindicados = $personas_denuncia->where('id_tipo_persona', 404);

          $i_denuncia = Arr::add($i_denuncia, 'denuncia_' . $key, ['denunciante' => $denunciante, 'sindicados' => $sindicados, 'hecho' => $hecho_direccion, 'armas' => $armas]);
        }


        return view('consulta._show',
          compact('i_denuncia',
            'departamento',
            'municipio',
            'genero',
            'tipo_arma',
            'marca_arma',
            'calibre_arma',
            'estado_arma',
            'tipo_denuncia')

        );


    }else if(request('id_arma')){
        $arma = Arma::find(request('id_arma'));
      if ($arma->exists()) {
        // Si arma existe ejecuta lo sig.
        $denuncias = Denuncia::whereJsonContains('id_armas', [['id_arma' => $arma->id_arma]])->get();
        $i_denuncia = [];

        foreach ($denuncias as $key => $denuncia) {

          // Denuncia y Persona;
          $personas_denuncia = Persona_Denuncia::with('persona')
            ->whereRelation('denuncia', 'id_denuncia', $denuncia->id_denuncia)
            ->get();
          foreach($personas_denuncia as $personas){
            $direccion=[];
            if(isset($personas['persona']['id_direccion'])){
              if(is_array(json_decode($personas['persona']['id_direccion'], true))){
                foreach (json_decode($personas['persona']['id_direccion']) as $direc){
                  $direccion[]=self::direccion($direc->id_direccion);
                }
              }
            }
            $personas['persona']['direccion']=$direccion;

          }


          // Hecho y Direccion
          $hecho_direccion = Hecho::where('id_hecho', $denuncia->id_hecho)
            ->with('direccion')
            ->first();

          $denunciante = $personas_denuncia->where('id_tipo_persona', 403)->first();
          $sindicados = $personas_denuncia->where('id_tipo_persona', 404);

          $count = 0;
          $i_denuncia = Arr::add($i_denuncia, 'denuncia_'.$key, ['denunciante' => $denunciante, 'sindicados' => $sindicados, 'hecho' => $hecho_direccion, 'armas' => $arma->get()]);

        }

        //        return $i_denuncia;
        // Agregarle sus compact y el resto de weas xdxd


        // return $genero;
        return view('consulta._show',
          // (['denunciante'=>$denunciante,'sindicados'=>$sindicados,'hecho'=>$hecho_direccion,'arma'=>$arma->get()])
          compact(
            'i_denuncia',
            'departamento',
            'municipio',
            'genero',
            'tipo_arma',
            'marca_arma',
            'calibre_arma',
            'estado_arma',
            'tipo_denuncia',
          )
        );
      } else if ($arma->doesntExist()) {
        return redirect(route('consulta.create'))
          ->with('error', 'No se ha encontrado el registro.');
      }
    }
  }

    static  function direccion($id_direcccon = 0){
      $direccion = [];
        if ($id_direcccon!= 0) {
          $direccion = Direccion::find($id_direcccon);
        }
      return $direccion;
    }
}
