<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table =  'sae.item';
    protected $primaryKey = 'id_item';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;


    public function categoria(){
        return $this->belongsTo('App\Models\Categoria','id_categoria');
    }
}
