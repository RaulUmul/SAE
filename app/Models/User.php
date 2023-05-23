<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
  use HasFactory, Notifiable;

    protected $table = 'public.users';
    protected $primaryKey = 'id_user';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;



//   public $guarded = [];
    protected $fillable = [
        'user',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

}
