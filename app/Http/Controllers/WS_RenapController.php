<?php

namespace App\Http\Controllers;
// use App\Http\Controllers\SoapClient;
use SoapClient;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use SimpleXMLElement;

class WS_RenapController extends Controller
{

    public static function renap(Request $request,$renap=false){

        $cui = $request->cui;   
    	$url = 'http://172.21.68.211/optimus2_rest/WS_OptimusPrime.php';
    	$cliente= "RAUL";
    	// $user= \Auth::user()->usuario;
    	$user= 'consulta_prueba';
        $ws = new SoapClient(null,array('location'=>$url,'uri'=>$url));


        $consulta = $ws->DatosCiudadanoDPI_Renap($cui,$cliente,$renap,$user,false);


        $modal = self::modal_renap($consulta);
        return  response()->json(['content'=>$modal->render(),'consulta'=>$consulta], 200);

        // Codigo de errores identificados.
        // error 1: El DPI debe contener 13 digitos.
        // error 15: "No hay datos para la persona que busca en RENAP por favor verifique el número de DPI o sede_indice (1111111111111,)"

    }

    public static function modal_renap($consulta){

        // Aqui hay que verificar si la consulta trae la data o si trae errores.\

        $xml = new \SimpleXMLElement($consulta['foto']);
        $newdataset = $xml->children();
        $dataset = get_object_vars($newdataset);
        $foto=$dataset['PortraitImage'];
        $img = base64_decode($foto);

        $imgSrc = 'data: '. $xml . ';base64,' . $foto;


        if($consulta['error']){
            return view("denuncia\_modal_wsrenap",[
                'error'=>$consulta['error'],
                'descripcion'=>$consulta['descripcion'],
            ]);
        }else{
            return view("denuncia\_modal_wsrenap",[
                'dpi'=>$consulta['dpi'],
                'primer_nombre'=>$consulta['primer_nombre'],
                'segundo_nombre'=>$consulta['segundo_nombre'],
                'tercer_nombre'=>$consulta['tercer_nombre'],
                'primer_apellido'=>$consulta['primer_apellido'],
                'segundo_apellido'=>$consulta['segundo_apellido'],
                'apellido_casada'=>$consulta['apellido_casada'],
                'genero'=>$consulta['genero'],
                'fecha_nacimiento'=>$consulta['fecha_nacimiento'],
                'foto'=>$imgSrc,
            ]);
        }


    }
}




