<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mdl_pais extends Model{

    protected $table = 'pais';
    protected $fillable = ['nombre'];
  	protected $guarded = ['id'];
}
