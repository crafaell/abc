<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mdl_producto extends Model{

    protected $table = 'producto';
    protected $fillable = ['nombre', 'sku', 'presentacion', 'precio'];
  	protected $guarded = ['id'];

  	public function presentacion(){
    	return $this->belongsTo(mdl_presentacion::class);
  	}

  	public function precio(){
    	return $this->hasMany(mdl_precio::class);
  	}
}
