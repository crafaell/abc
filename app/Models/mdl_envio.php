<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mdl_envio extends Model{

    protected $table = 'envio';
    protected $fillable = ['puerto', 'origen', 'usuario', 'productos_enviados'];
  	protected $guarded = ['id'];

  	public function puerto(){
    	return $this->belongsTo(mdl_puerto::class);
  	}

  	public function origen(){
    	return $this->belongsTo(mdl_pais::class);
  	}

  	public function usuario(){
    	return $this->belongsTo(mdl_usuario::class);
  	}

  	public function productos_enviados(){
    	return $this->hasMany(mdl_envio_producto::class, 'envio_id', 'id');
  	}

  	public function enviados(){
  		return $this->productos_enviados->sum('cantidad');
  	}
}
