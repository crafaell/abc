<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mdl_usuario;

class ctr_autenticacion extends Controller{

    public function ingreso(Request $request){
        $usuario = mdl_usuario::where('usuario', $request->txt_usuario)->
                                where('clave', md5($request->txt_clave))->first();
        if(!$usuario){
            return back()->with('existe','0');
        }
        else{
            $request->session()->put('usuario_id', $usuario->id);
            $request->session()->put('usuario_usuario', $usuario->usuario);
            $request->session()->put('usuario_nombre', $usuario->nombres.' '.$usuario->apellidos);
            $request->session()->save();
            return redirect('productos');
        }
    }

    public function salir(Request $request){
        $request->session()->forget('usuario_id');
        $request->session()->forget('usuario_nombre');
        return redirect('/');
    }
}
