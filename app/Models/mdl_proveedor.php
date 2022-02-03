<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mdl_proveedor extends Model{

    protected $table = 'proveedor';
    protected $fillable = ['nombre', 'precio'];
  	protected $guarded = ['id'];

  	public function precio(){
    	return $this->hasMany(mdl_precio::class);
  	}
}
