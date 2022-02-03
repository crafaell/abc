<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mdl_precio extends Model{

    protected $table = 'precio';
    protected $fillable = ['producto', 'proveedor'];
  	protected $guarded = ['id'];

  	public function producto(){
    	return $this->belongsTo(mdl_producto::class);
  	}

  	public function proveedor(){
    	return $this->belongsTo(mdl_proveedor::class);
  	}
}
