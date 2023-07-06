<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;



class PersonaController extends Controller
{
  public function show_persona(Request $request)
  {
    $persona = Persona::where('cui', $request->cui)->first();
    $id_direccion=null;
    foreach (json_decode($persona->id_direccion) as $direccion) {
      $id_direccion = $direccion->id_direccion;
      break;
    }
    $persona = Arr::add($persona,'direccion',self::direccion($id_direccion));
    return response()->json($persona);
  }

  static function direccion($id_direcccon = 0)
  {
    $direccion = [];
    if ($id_direcccon != 0) {
      $direccion = Direccion::find($id_direcccon);
    }
    return $direccion;
  }
}
