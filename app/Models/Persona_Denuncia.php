<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona_Denuncia extends Model
{
    use HasFactory;
    protected $table =  'sae.persona_denuncia';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;

    public $guarded = [];

    // public function denuncias(){
    //     return $this->hasMany('App\Models\Denuncia','id_sindicado');
    // }

}
