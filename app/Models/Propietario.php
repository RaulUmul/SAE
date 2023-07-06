<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    use HasFactory;

    protected $table =  'sae.propietario';
    protected $primaryKey = 'id_propietario';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;

    public $guarded = [];

     public function armas(){
         return $this->hasMany('App\Models\Arma','id_arma');
     }

    // public function personas_denuncias(){
        // return $this->hasMany('App\Models\Persona_Denuncia','id_persona');
    // }
}
