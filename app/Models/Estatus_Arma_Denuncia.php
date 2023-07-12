<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estatus_Arma_Denuncia extends Model
{
    use HasFactory;
    protected $table =  'sae.estatus_arma_denuncia';
    protected $primaryKey = 'id_registro';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;

    public $guarded = [];

    public function estatus_denuncia(){
        return $this->belongsTo('App\Models\Denuncia','id_denuncia');
    }

}
