<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ctr_autenticacion;
use App\Http\Controllers\ctr_producto;
use App\Http\Controllers\ctr_proveedor;
use App\Http\Controllers\ctr_envio;
use App\Http\Controllers\ctr_usuario;
use App\Http\Controllers\ctr_precio;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('ingreso');
});

//AUTENTICACION Y SALIR
Route::post('ingresar', [ctr_autenticacion::class, 'ingreso']);
Route::get('salir', [ctr_autenticacion::class, 'salir']);

//PRODUCTOS
Route::get('productos', [ctr_producto::class, 'productos']);
Route::post('producto_nuevo', [ctr_producto::class, 'nuevo']);
Route::post('producto', [ctr_producto::class, 'producto']);
Route::post('producto_editar', [ctr_producto::class, 'editar']);
Route::post('producto_eliminar', [ctr_producto::class, 'eliminar']);

//USUARIOS
Route::get('usuarios', [ctr_usuario::class, 'usuarios']);
Route::post('usuario_nuevo', [ctr_usuario::class, 'nuevo']);
Route::post('usuario', [ctr_usuario::class, 'usuario']);

//ENVIOS
Route::get('envios', [ctr_envio::class, 'envios']);
Route::post('envio_nuevo', [ctr_envio::class, 'nuevo']);
Route::post('envio', [ctr_envio::class, 'envio']);
Route::post('envio_eliminar', [ctr_envio::class, 'eliminar']);

//PROVEEDORES
Route::get('proveedores', [ctr_proveedor::class, 'proveedores']);
Route::post('proveedor_nuevo', [ctr_proveedor::class, 'nuevo']);
Route::post('proveedor', [ctr_proveedor::class, 'proveedor']);

//PRECIOS
Route::get('precios', [ctr_precio::class, 'precios']);
Route::post('precio_nuevo', [ctr_precio::class, 'nuevo']);
Route::post('precio', [ctr_precio::class, 'precio']);






