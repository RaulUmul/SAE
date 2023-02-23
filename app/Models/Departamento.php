<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;
    protected $table =  'sae.departamento';
    protected $primaryKey = 'id_departamento';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;

    public $guarded = [];

    public function municipios(){
        return $this->hasMany('App\Models\Municipio','id_departamento');
    }
}
