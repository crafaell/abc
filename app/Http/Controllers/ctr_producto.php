<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mdl_producto;
use App\Models\mdl_presentacion;
use Illuminate\Support\Facades\App;

class ctr_producto extends Controller{

    public function productos(Request $request){
        $productos = mdl_producto::with('presentacion')->get();
        $presentaciones = mdl_presentacion::all();
        return view('productos', ['productos'=>$productos, 'presentaciones'=>$presentaciones]);
    }

    public function nuevo(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $nombre = $funciones->callAction('Sanitizar', [base64_decode($datos['nombre'])]);
        $existe = mdl_producto::where('nombre', $nombre)->first();
        if($existe == NULL){
            $sku = $funciones->callAction('Sanitizar', [base64_decode($datos['sku'])]);
            $presentacion_id = $funciones->callAction('Sanitizar', [base64_decode($datos['presentacion_id'])]);
            $volumen = $funciones->callAction('Sanitizar', [base64_decode($datos['volumen'])]);
            $unidad = $funciones->callAction('Sanitizar', [base64_decode($datos['unidad'])]);
            $producto_nuevo = new mdl_producto();
            $producto_nuevo->nombre = $nombre;
            $producto_nuevo->sku = $sku;
            $producto_nuevo->presentacion_id = $presentacion_id;
            $producto_nuevo->volumen = $volumen;
            $producto_nuevo->unidad = $unidad;
            if ($request->hasFile('foto')) {
                $imagen = $request->file('foto');
                $nombre_foto = time().'.'.$imagen->getClientOriginalExtension();
                $ruta = public_path('img/productos/');
                $imagen->move($ruta, $nombre_foto);
                $foto = $nombre_foto;
            }
            else{
                $foto = '';
            }
            $producto_nuevo->foto = $foto;
            $producto_nuevo->save();
            if($producto_nuevo->wasRecentlyCreated == true){
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

    public function producto(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $producto_id = $funciones->callAction('Sanitizar', [base64_decode($datos['producto_id'])]);
        $producto = mdl_producto::find($producto_id);
        return response()->json($producto);
    }

    public function editar(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $producto_id = $funciones->callAction('Sanitizar', [base64_decode($datos['producto_id'])]);
        $existe = mdl_producto::find($producto_id);
        if($existe != NULL){
            $nombre = $funciones->callAction('Sanitizar', [base64_decode($datos['nombre'])]);
            $sku = $funciones->callAction('Sanitizar', [base64_decode($datos['sku'])]);
            $presentacion_id = $funciones->callAction('Sanitizar', [base64_decode($datos['presentacion_id'])]);
            $volumen = $funciones->callAction('Sanitizar', [base64_decode($datos['volumen'])]);
            $unidad = $funciones->callAction('Sanitizar', [base64_decode($datos['unidad'])]);
            $existe->nombre = $nombre;
            $existe->sku = $sku;
            $existe->presentacion_id = $presentacion_id;
            $existe->volumen = $volumen;
            $existe->unidad = $unidad;
            if ($request->hasFile('foto')) {
                $imagen = $request->file('foto');
                $nombre_foto = time().'.'.$imagen->getClientOriginalExtension();
                $ruta = public_path('img/productos/');
                $imagen->move($ruta, $nombre_foto);
                $icono = $nombre_foto;
                $existe->foto = $icono;
            }
            $existe->save();
            $respuesta['res'] = 1;
        }
        else{
            $respuesta['res'] = 2;
        }
        return response()->json($respuesta);
    }

    public function eliminar(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $producto_id = $funciones->callAction('Sanitizar', [base64_decode($datos['producto_id'])]);
        $producto = mdl_producto::find($producto_id);
        if($producto != NULL){
            $producto->delete();
            $respuesta['res'] = 1;
        }
        else{
            $respuesta['res'] = 0;
        }
        return response()->json($respuesta);
    }
}
