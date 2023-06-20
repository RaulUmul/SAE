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
        return view('archivo.index',compact('archivo','id_denuncia'));
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
                $archivo->id_denuncia = $request->id_denuncia;
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

    public function show(Request $request){
        // return $request;
        $archivo = \Storage::get($request->nombre_hash);
        return response($archivo,200)->header('Content-Type','application/pdf');
    }

    public function download(){

    }

    public function update(Request $request){

        if($request->hasFile('file')){
            if($request->file('file')->isValid()){

                $nombre_hash = $request->file('file')->store('denuncias');

                // Actualizamos
                $id_archivo = Archivo::select('id_archivo')->where('id_denuncia',$request->id_denuncia)->first();

                $archivo = Archivo::find($id_archivo->id_archivo);
                $archivo->nombre = $request->file('file')->getClientOriginalName();
                $archivo->nombre_hash = $nombre_hash;
                $archivo->mime = $request->file('file')->getClientMimeType();
                $archivo->save();

                return 'Se cambio exitosamente';
            }
        }else if(!$request->hasFile('file')){
            $id_archivo = Archivo::select('id_archivo')->where('id_denuncia',$request->id_denuncia)->first();
            $archivo = Archivo::find($id_archivo->id_archivo);
            $archivo->delete(); //Lo que deberiamos hacer es usar la funcion delete en lugar de esto, pero dejemolo por ahi.

            return 'Se elimino correctamente';
        }
        
    }

    public function delete(){

    }
    
    
}


