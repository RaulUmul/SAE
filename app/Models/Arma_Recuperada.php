<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arma_Recuperada extends Model
{
  use HasFactory;
  protected $table =  'sae.arma_recuperada';
  protected $primaryKey = 'id_recuperacion';
  public $timestamps = false;
  public $autoincrement = false;
  public $incrementing = false;

  public $guarded = [];

}
