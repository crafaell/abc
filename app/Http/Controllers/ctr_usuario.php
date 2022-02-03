<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mdl_usuario;
use Illuminate\Support\Facades\App;

class ctr_usuario extends Controller{

    public function usuarios(Request $request){
        $usuarios = mdl_usuario::all();
        return view('usuarios', ['usuarios'=>$usuarios]);
    }

    public function nuevo(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $usuario = $funciones->callAction('Sanitizar', [base64_decode($datos['usuario'])]);
        $existe = mdl_usuario::where('usuario', $usuario)->first();
        if($existe == NULL){
            $nombres = $funciones->callAction('Sanitizar', [base64_decode($datos['nombres'])]);
            $apellidos = $funciones->callAction('Sanitizar', [base64_decode($datos['apellidos'])]);
            $clave = $funciones->callAction('Sanitizar', [base64_decode($datos['clave'])]);
            $usuario_nuevo = new mdl_usuario();
            $usuario_nuevo->nombres = $nombres;
            $usuario_nuevo->apellidos = $apellidos;
            $usuario_nuevo->usuario = $usuario;
            $usuario_nuevo->clave = md5($clave);
            $usuario_nuevo->save();
            if($usuario_nuevo->wasRecentlyCreated == true){
                $respuesta['res'] = 1;
            }
            else{
                $respuesta['res'] = 0;
            }
        }
        else{
            $respuesta['res'] = 2;
            $respuesta['existe'] = $existe;
        }
        return response()->json($respuesta);
    }

    public function usuario(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $usuario_id = $funciones->callAction('Sanitizar', [base64_decode($datos['usuario_id'])]);
        $usuario = mdl_usuario::find($usuario_id);
        return response()->json($usuario);
    }
}
