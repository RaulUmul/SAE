<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

class DenunciaController extends Controller
{

    public function index(){
        return view('denuncia.index');
    }

    public function create(){
        return view('denuncia.create');
    }

    public function store(){

    }


    public function form_arma(Request $request){

        $data = $request['datosLocalStorage'];
        $strings = [];
        
        foreach($data as $key => $value){

            $vista = view("denuncia\_form_arma",[
                'index'=>$key,
                'tipo_arma'=>$value['tipo_arma'],
                'registro_arma'=>$value['registro_arma']
                ]
            );

            $strings[] = new HtmlString($vista);
        }

        return implode($strings);
    }

}
