<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mdl_envio;
use App\Models\mdl_puerto;
use App\Models\mdl_pais;
use App\Models\mdl_precio;
use App\Models\mdl_envio_producto;
use Illuminate\Support\Facades\App;

class ctr_envio extends Controller{

    public function envios(Request $request){
        $envios = mdl_envio::all();
        $puertos = mdl_puerto::all();
        $pais = mdl_pais::all();
        $precios = mdl_precio::all();
        return view('envios', ['envios'=>$envios, 'puertos'=>$puertos, 'paises'=>$pais, 'precios'=>$precios]);
    }

    public function nuevo(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $contenedor = $funciones->callAction('Sanitizar', [base64_decode($datos['contenedor'])]);
        $existe = mdl_envio::where('contenedor', $contenedor)->first();
        if($existe == NULL){
            $puerto_id = $funciones->callAction('Sanitizar', [base64_decode($datos['puerto_id'])]);
            $origen_id = $funciones->callAction('Sanitizar', [base64_decode($datos['pais_id'])]);
            $fecha_envio = $funciones->callAction('Sanitizar', [base64_decode($datos['fecha_envio'])]);
            $fecha_llegada = $funciones->callAction('Sanitizar', [base64_decode($datos['fecha_llegada'])]);
            $lugar = $funciones->callAction('Sanitizar', [base64_decode($datos['lugar'])]);
            $envio_nuevo = new mdl_envio();
            $envio_nuevo->puerto_id = $puerto_id;
            $envio_nuevo->origen_id = $origen_id;
            $envio_nuevo->usuario_id = $request->session()->get('usuario_id');
            $envio_nuevo->contenedor = $contenedor;
            $envio_nuevo->fecha_envio = $fecha_envio;
            $envio_nuevo->fecha_llegada = $fecha_llegada;
            $envio_nuevo->lugar = $lugar;
            $envio_nuevo->save();
            if($envio_nuevo->wasRecentlyCreated == true){
                $respuesta['res'] = 1;
                foreach ($datos['precios'] as $key => $precio) {
                    $envio_producto = new mdl_envio_producto();
                    $envio_producto->envio_id = $envio_nuevo->id;
                    $envio_producto->precio_id = $precio[0];
                    $envio_producto->cantidad = $precio[1];
                    $envio_producto->save();
                }
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

    public function envio(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $envio_id = $funciones->callAction('Sanitizar', [base64_decode($datos['envio_id'])]);
        $envio = mdl_envio::with(['origen', 'puerto', 'usuario', 'productos_enviados.precio.proveedor', 'productos_enviados.precio.producto.presentacion'])->find($envio_id);
        return response()->json($envio);
    }

    public function eliminar(Request $request){
        $datos = $request->all();
        $funciones = App::make('\App\Http\Controllers\ctr_funciones');
        $envio_id = $funciones->callAction('Sanitizar', [base64_decode($datos['envio_id'])]);
        $envio = mdl_envio::find($envio_id);
        if($envio != NULL){
            $productos_enviados = mdl_envio_producto::where('envio_id', $envio_id)->delete();
            if($productos_enviados){
                $envio->delete();
            }
            $respuesta['res'] = 1;
        }
        else{
            $respuesta['res'] = 0;
        }
        return response()->json($respuesta);
    }
}
