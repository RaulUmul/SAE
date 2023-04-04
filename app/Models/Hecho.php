<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hecho extends Model
{
    use HasFactory;
    protected $table =  'sae.hecho';
    protected $primaryKey = 'id_hecho';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;

    public $guarded = [];

    public function denuncias(){
        return $this->hasMany('App\Models\Denuncia','id_hecho');
    }

    public function direccion(){
        return $this->belongsTo('App\Models\Direccion','id_direccion');
    }
}
