<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mdl_envio_producto extends Model{

    protected $table = 'envio_producto';
    protected $fillable = ['envio', 'precio'];
  	protected $guarded = ['id'];

  	public function envio(){
    	return $this->belongsTo(mdl_envio::class);
  	}

  	public function precio(){
    	return $this->belongsTo(mdl_precio::class);
  	}
}
