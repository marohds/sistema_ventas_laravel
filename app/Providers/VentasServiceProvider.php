<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VentasServiceProvider extends ServiceProvider
{
    public static function vaciarProductos()
    {
        self::guardarProductos(null);
    }

    public static function guardarProductos($productos)
    {
        session(["productos" => $productos]);
    }
}
