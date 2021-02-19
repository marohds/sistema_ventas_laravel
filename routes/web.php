<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Auth::routes([
//  'register' => false, // Register Routes...
//  'reset' => false, // Reset Password Routes...
//  'verify' => false, // Email Verification Routes...
//]);

Route::get('/', function () {
    return redirect()->route("home");
});
Route::get("/acerca-de", function () {
    return view("misc.acerca_de");
})->name("acerca_de.index");
Route::get("/soporte", function(){
    return redirect("https://parzibyte.me/blog/contrataciones-ayuda/");
})->name("soporte.index");

Auth::routes([
    "reset" => false,// no pueden olvidar contraseña
    'register' => false, // no permito registro
]);

Route::get('/home', 'HomeController@index')->name('home');
// Permitir logout con petición get
Route::get("/logout", function () {
    App\Providers\VentasServiceProvider::vaciarProductos();
    Auth::logout();
    return redirect()->route("home");
})->name("logout");


Route::middleware("auth")
    ->group(function () {
        Route::resource("clientes", "ClientesController");
        Route::resource("usuarios", "UserController")->parameters(["usuarios" => "user"]);
        Route::resource("productos", "ProductosController");
        Route::post("/buscarProducto", "ProductosController@buscarProducto")->name("buscarProducto");
        Route::post("/buscarPorNombre", "ProductosController@buscarPorNombre")->name("buscarPorNombre");
        Route::get("/ventas/ticket", "VentasController@ticket")->name("ventas.ticket");
        Route::resource("ventas", "VentasController");
        Route::get("/vender", "VenderController@index")->name("vender.index");
        Route::post("/agregarVarios", "VenderController@agregarVarios")->name("agregarVarios");
        Route::post("/agregarCarniceria", "VenderController@agregarCarniceria")->name("agregarCarniceria");
        Route::post("/agregarFiambre", "VenderController@agregarFiambre")->name("agregarFiambre");
        Route::post("/productoDeVenta", "VenderController@agregarProductoVenta")->name("agregarProductoVenta");
        Route::delete("/productoDeVenta", "VenderController@quitarProductoDeVenta")->name("quitarProductoDeVenta");
        Route::post("/terminarOCancelarVenta", "VenderController@terminarOCancelarVenta")->name("terminarOCancelarVenta");
    });
