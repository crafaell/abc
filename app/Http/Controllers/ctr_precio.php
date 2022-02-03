<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mdl_precio;
use App\Models\mdl_proveedor;
use App\Models\mdl_producto;
use Illuminate\Support\Facades\App;

class ctr_precio extends Controller{

    public function precios(Request $request){
        $precios = mdl_precio::all();
        $proveedores = mdl_proveedor::all();
        $productos = mdl_producto::all();
        return view('precios', ['precios'=>$precios, 'proveedores'=>$proveedores, 'productos'=>$productos]);
    }

    public function nuevo(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $proveedor_id = $funciones->callAction('Sanitizar', [base64_decode($datos['proveedor_id'])]);
        $producto_id = $funciones->callAction('Sanitizar', [base64_decode($datos['producto_id'])]);
        $existe = mdl_precio::where('proveedor_id', $proveedor_id)->
                                where('producto_id', $producto_id)->first();
        if($existe == NULL){
            $precio = $funciones->callAction('Sanitizar', [base64_decode($datos['precio'])]);
            $precio_nuevo = new mdl_precio();
            $precio_nuevo->proveedor_id = $proveedor_id;
            $precio_nuevo->producto_id = $producto_id;
            $precio_nuevo->precio = $precio;
            $precio_nuevo->save();
            if($precio_nuevo->wasRecentlyCreated == true){
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

    public function precio(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $precio_id = $funciones->callAction('Sanitizar', [base64_decode($datos['precio_id'])]);
        $precio = mdl_precio::find($precio_id);
        return response()->json($precio);
    }
}
