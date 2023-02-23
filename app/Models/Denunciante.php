<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denunciante extends Model
{
    use HasFactory;
    protected $table = 'sae.denunciante';
    protected $primaryKey = 'id_denunciante';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;

    public $guarded = [];

    public function denuncias(){
        return $this->hasMany('App\Models\Denuncia','id_denunciante'); 
    }

}
