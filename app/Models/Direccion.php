<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    protected $table =  'sae.direccion';
    protected $primaryKey = 'id_direccion';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;

    public $guarded = [];
  
    public function denunciantes(){
        return $this->hasMany('App\Models\denunciante','','id_denunciante');
    }


}
