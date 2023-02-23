<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Item;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

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
        return $request;
    }


    public function form_arma(Request $request){

        $data = $request['datosLocalStorage'];
        $strings = [];
        
        foreach($data as $key => $value){

            $vista = view("denuncia\_form_arma",[
                'index'=>$key,
                'tipo_arma'=>$value['tipo_arma'],
                'registro_arma'=>$value['registro_arma'],
                'marca_arma'=>$value['marca_arma'],
                'modelo_arma'=>$value['modelo_arma'],
                'tenencia_arma'=>$value['tenencia_arma'],
                'licencia_arma'=>$value['licencia_arma'],
                'pais_fabricacion'=>$value['pais_fabricacion'],
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
