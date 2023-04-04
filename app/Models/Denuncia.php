<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    use HasFactory;
    protected $table =  'sae.denuncia';
    protected $primaryKey = 'id_denuncia';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;

    public $guarded = [];

    // public function denunciante(){
    //     return $this->belongsTo('App\Models\Denunciante','id_denunciante',);
    // }
    public function arma(){
        return $this->belongsTo('App\Models\Arma','id_arma');
    }
    public function hecho(){
        return $this->belongsTo('App\Models\Hecho','id_hecho');
    }
    // public function sindicado(){
    //     return $this->belongsTo('App\Models\Sindicado','id_sindicado',);
    // }

    public function personas_denuncias(){
        return $this->hasMany('App\Models\Persona_Denuncia','id_denuncia');
    }

}
