<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mdl_usuario extends Model{

    protected $table = 'usuario';
    protected $fillable = ['nombres', 'apellidos'];
  	protected $guarded = ['id'];
}
