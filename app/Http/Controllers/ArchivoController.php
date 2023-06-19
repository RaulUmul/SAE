<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archivo;

class ArchivoController extends Controller
{
    //
    public function index(Request $request){
        $id_denuncia = $request->id_denuncia;
        $archivo = Archivo::where('id_denuncia',$id_denuncia)->first();
        return view('archivo.index',compact('archivo'));
    }

    public function store(Request $request){

        // return $request;
        if ($request->hasFile('file')) {
            if($request->file('file')->isValid()){
                
                if($request->file('file')->getClientOriginalExtension() != 'pdf'){
                  return 'Solo es admitido formato PDF';
                }

                $nombre_hash = $request->file('file')->store('denuncias');

                $archivo = new Archivo();
                $archivo->id_denuncia = 1;
                $archivo->nombre = $request->file('file')->getClientOriginalName();
                $archivo->nombre_hash = $nombre_hash;
                $archivo->mime = $request->file('file')->getClientMimeType();
                $archivo->save();

                return 'Archivo cargado y guardado correctamente';
            }
        }else{
            return 'No hay archivo o no se cargo correctamente';
        }
    }

    public function download(){

    }

    public function update(){
        
    }

    public function delete(){

    }
    
    
}


