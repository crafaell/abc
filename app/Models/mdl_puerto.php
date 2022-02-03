<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mdl_puerto extends Model{

    protected $table = 'puerto';
    protected $fillable = ['puerto_tipo'];
  	protected $guarded = ['id'];

    public function puerto_tipo(){
        return $this->belongsTo(mdl_puerto_tipo::class);
    }


}
