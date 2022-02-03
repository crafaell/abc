<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mdl_presentacion extends Model{

    protected $table = 'presentacion';
    protected $fillable = ['nombre'];
  	protected $guarded = ['id'];
}
