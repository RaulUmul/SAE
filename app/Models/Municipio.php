<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;
    protected $table =  'sae.municipio';
    protected $primaryKey = 'id_municipio';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;

    public $guarded = [];

    public function departamento(){
        return $this->belongsTo('App\Models\Departamento','id_departamento'); 
    }
}
