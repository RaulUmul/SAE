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
    if (request('numero_cui')) {
      $persona = Persona::where('cui', request()->only('numero_cui'));

      if ($persona->exists()) {
        // Obtenemos el id de cada denuncia.
        $persona_denuncia = Persona_Denuncia::where('id_persona', $persona->first()->id_persona);
        // $persona_denuncia->get();

        $id_denuncias = [];

        foreach ($persona_denuncia->get() as $key => $value) {
          $id_denuncias = Arr::add($id_denuncias, $key, $value->id_denuncia);
        }

        // Recorremos el arreglo
        $i_denuncia = [];
        $count = 0;
        foreach ($id_denuncias as $key => $value) {
          $persona_denuncia = Persona_Denuncia::with('persona')
            ->whereRelation('denuncia', 'id_denuncia', $value)
            ->get();
          foreach($persona_denuncia as $persona){
            $direccion=[];
            if(isset($persona['persona']['id_direccion'])){
              if(is_array(json_decode($persona['persona']['id_direccion'], true))){
                foreach (json_decode($persona['persona']['id_direccion']) as $direc){
                  $direccion[]=self::direccion($direc->id_direccion);
                }
              }
            }
            $persona['persona']['direccion']=$direccion;

          }

          $denuncia = Denuncia::where('id_denuncia', $value)->first();
          $armas = [];
          foreach( (json_decode($denuncia->id_armas)) as $arma){
            $armas[] = Arma::where('id_arma',$arma->id_arma)->first();
          }

          $hecho_direccion = Hecho::where('id_hecho', $denuncia->id_hecho)
            ->with('direccion')
            ->first();
//          $denuncia = Denuncia::whereJsonContains('id_armas', [['id_arma' => $arma->first('id_arma')->id_arma]])->get();
//          $arma = Arma::where('id_arma',


          $denunciante = $persona_denuncia->where('id_tipo_persona', 403)->first();
          $sindicados = $persona_denuncia->where('id_tipo_persona', 404);

          $i_denuncia = Arr::add($i_denuncia, 'denuncia_' . $key, ['denunciante' => $denunciante, 'sindicados' => $sindicados, 'hecho' => $hecho_direccion,'armas'=>$armas]);

        }
//           return $i_denuncia;

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

      } else if ($persona->doesntExist()) {
        return redirect(route('consulta.create'))
          ->with('error', 'No se ha encontrado el registro.');
      }


    } else if (request('numero_registro') || request('numero_licencia') || request('numero_tenencia')) {

      if (request('numero_registro')) {
        $arma = Arma::orWhere('registro', strtoupper(request()->only('numero_registro')['numero_registro']));
      }
      if (request('numero_licencia')) {
        $arma = Arma::orWhere('licencia', request()->only('numero_licencia'));
      }
      if (request('numero_tenencia')) {
        $arma = Arma::orWhere('tenencia', request()->only('numero_tenencia'));
      }


      if ($arma->exists()) {
        // Si arma existe ejecuta lo sig.

        $denuncia = Denuncia::whereJsonContains('id_armas', [['id_arma' => $arma->first('id_arma')->id_arma]])->get();

        // Denuncia y Persona;
        $persona_denuncia = Persona_Denuncia::with('persona')
          ->whereRelation('denuncia', 'id_denuncia', $denuncia->first()->id_denuncia)
          ->get();
          foreach($persona_denuncia as $persona){
            $direccion=[];
             if(isset($persona['persona']['id_direccion'])){
              if(is_array(json_decode($persona['persona']['id_direccion'], true))){
                    foreach (json_decode($persona['persona']['id_direccion']) as $direc){
                      $direccion[]=self::direccion($direc->id_direccion);
                }
               }
             }
            $persona['persona']['direccion']=$direccion;

          }


        // Hecho y Direccion
        $hecho_direccion = Hecho::where('id_hecho', $denuncia->first()->id_hecho)
          ->with('direccion')
          ->first();

        $denunciante = $persona_denuncia->where('id_tipo_persona', 403)->first();
        $sindicados = $persona_denuncia->where('id_tipo_persona', 404);

        $i_denuncia = [];
        $count = 0;
        $i_denuncia = Arr::add($i_denuncia, 'denuncia_' . (string)$count + 1, ['denunciante' => $denunciante, 'sindicados' => $sindicados, 'hecho' => $hecho_direccion, 'armas' => $arma->get()]);

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
