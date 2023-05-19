<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro_Procedimiento_Arma extends Model
{
  use HasFactory;
  protected $table =  'sae.registro_procedimiento_arma';
  protected $primaryKey = 'id_procedimiento';
//  public $timestamps = false; --habilitado
const CREATED_AT = 'fecha_creacion';
const UPDATED_AT = 'fecha_actualizacion';

  public $autoincrement = false;
  public $incrementing = false;

  public $guarded = [];
}
