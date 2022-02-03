<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mdl_puerto_tipo extends Model{

    protected $table = 'puerto_tipo';
    protected $fillable = ['nombre'];
  	protected $guarded = ['id'];
}
