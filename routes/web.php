<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/',[LoginController::class,'usuarioLogin'])->name('login');

Route::get('/usuario/registrase',[LoginController::class,'usuarioRegistro'])->name('usuario.registrarse');

Route::get('/usuario/home',[ProductController::class,'verTodo'])
->middleware('auth')
->name('home');

Route::get('/usuario/editar/{id}
',[ProductController::class,'editarProducto'])->name('usuario.editarProducto')->middleware('auth');

Route::get('/usuario/agregarProducto',[ProductController::class,'verAgregarProducto'])->name('usuario.agregar');


Route::get('/usuario/login',[LoginController::class,'iniciarSesion'])->name('usuario.login');

Route::get('/usuario/registro',[LoginController::class,'registrarUsuario'])->name('usuario.registro');

Route::get('/usuario/logout',[LoginController::class,'cerrarSesion'])->name('usuario.logout');
Route::post('/usuario/producto/editar',[ProductController::class,'modificarProducto'])->name('usuario.productoEditado');
Route::get('/usuario/producto/eliminar/{id}',[ProductController::class,'eliminarProducto'])->name('usuario.eliminarProducto');

Route::post('/usuario/agregar',[ProductController::class,'agregarProducto'])->name('usuario.agregarProducto');

Route::get('/usuario/buscar/producto/{clave?}',[ProductController::class,'buscarProducto'])->name('usuario.buscarProducto');