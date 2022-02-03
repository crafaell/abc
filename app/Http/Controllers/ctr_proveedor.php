<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mdl_proveedor;
use Illuminate\Support\Facades\App;

class ctr_proveedor extends Controller{

    public function proveedores(Request $request){
        $proveedores = mdl_proveedor::all();
        return view('proveedores', ['proveedores'=>$proveedores]);
    }

    public function nuevo(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $nombre = $funciones->callAction('Sanitizar', [base64_decode($datos['nombre'])]);
        $existe = mdl_proveedor::where('nombre', $nombre)->first();
        if($existe == NULL){
            $proveedor_nuevo = new mdl_proveedor();
            $proveedor_nuevo->nombre = $nombre;
            $proveedor_nuevo->save();
            if($proveedor_nuevo->wasRecentlyCreated == true){
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

    public function proveedor(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $proveedor_id = $funciones->callAction('Sanitizar', [base64_decode($datos['proveedor_id'])]);
        $proveedor = mdl_proveedor::find($proveedor_id);
        return response()->json($proveedor);
    }
}
