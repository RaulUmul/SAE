<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arma extends Model
{
    use HasFactory;
    protected $table =  'sae.arma';
    protected $primaryKey = 'id_arma';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;

    public $guarded = [];

    public function denuncias(){
        return $this->hasMany('App\Models\Denuncia','id_arma');
    }

    public function propietario(){
      return $this->belongsTo('App\Models\Propietario','id_propietario','id_propietario');
    }
}
