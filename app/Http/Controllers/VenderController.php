<?php
/*

  ____          _____               _ _           _
 |  _ \        |  __ \             (_) |         | |
 | |_) |_   _  | |__) |_ _ _ __ _____| |__  _   _| |_ ___
 |  _ <| | | | |  ___/ _` | '__|_  / | '_ \| | | | __/ _ \
 | |_) | |_| | | |  | (_| | |   / /| | |_) | |_| | ||  __/
 |____/ \__, | |_|   \__,_|_|  /___|_|_.__/ \__, |\__\___|
         __/ |                               __/ |
        |___/                               |___/

    Blog:       https://parzibyte.me/blog
    Ayuda:      https://parzibyte.me/blog/contrataciones-ayuda/
    Contacto:   https://parzibyte.me/blog/contacto/

    Copyright (c) 2020 Luis Cabrera Benito
    Licenciado bajo la licencia MIT

    El texto de arriba debe ser incluido en cualquier redistribucion
*/ ?>
<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Producto;
use App\ProductoVendido;
use App\Venta;
use Illuminate\Http\Request;
use App\Providers\VentasServiceProvider;

class VenderController extends Controller
{

    public function terminarOCancelarVenta(Request $request)
    {
        if ($request->input("accion") == "terminar") {
            return $this->terminarVenta($request);
        } else {
            return $this->cancelarVenta();
        }
    }

    public function terminarVenta(Request $request)
    {
        // Crear una venta
        $venta = new Venta();
        $venta->id_cliente = $request->input("id_cliente");
        $venta->saveOrFail();
        $idVenta = $venta->id;
        $productos = $this->obtenerProductos();
        // Recorrer carrito de compras
        foreach ($productos as $producto) {
            // El producto que se vende...
            $productoVendido = new ProductoVendido();
            $productoVendido->fill([
                "id_venta" => $idVenta,
                "descripcion" => $producto->descripcion,
                "codigo_barras" => $producto->codigo_barras,
                "precio" => $producto->precio_venta,
                "cantidad" => $producto->cantidad,
            ]);
            // Lo guardamos
            $productoVendido->saveOrFail();
            // Y restamos la existencia del original
            $productoActualizado = Producto::find($producto->id);
            $productoActualizado->existencia -= $productoVendido->cantidad;
            $productoActualizado->saveOrFail();
        }
        VentasServiceProvider::vaciarProductos();
        return redirect()
            ->route("ventas.show", $venta)
            ->with("mensaje", "Venta terminada");
    }

    private function obtenerProductos()
    {
        $productos = session("productos");
        if (!$productos) {
            $productos = [];
        }
        return $productos;
    }    

    public function cancelarVenta()
    {
        VentasServiceProvider::vaciarProductos();
        return redirect()
            ->route("vender.index")
            ->with("mensaje", "Venta cancelada");
    }

    public function quitarProductoDeVenta(Request $request)
    {
        $indice = $request->post("indice");
        $productos = $this->obtenerProductos();
        array_splice($productos, $indice, 1);
        VentasServiceProvider::guardarProductos($productos);
        return redirect()
            ->route("vender.index");
    }
    
    public function agregarVarios(Request $request)
    {
        $importe = $request->post("varios");
        $producto = Producto::where("codigo_barras", "=", 1)->first();
        if (!$producto) {
            $producto = new Producto();
            $producto->codigo_barras = 1;
            $producto->descripcion = "Varios";
            $producto->precio_compra = 0;
            $producto->precio_venta = 0;
            $producto->existencia = 9999999;
            $producto->saveOrFail();
        }
        $producto->precio_venta = (float)$importe;
        $this->agregarProductoACarrito($producto);
        return redirect()
            ->route("vender.index");
    }

    public function agregarProductoVenta(Request $request)
    {
        $codigo = $request->post("codigo");
        $producto = Producto::where("codigo_barras", "=", $codigo)->first();
        if (!$producto) {
            return redirect()
                ->route("vender.index")
                ->with("mensaje", "Producto no encontrado");
        }
        $this->agregarProductoACarrito($producto);
        return redirect()
            ->route("vender.index");
    }

    private function agregarProductoACarrito($producto)
    {
//        if ($producto->existencia <= 0) {
//            return redirect()->route("vender.index")
//                ->with([
//                    "mensaje" => "No hay existencias del producto",
//                    "tipo" => "danger"
//                ]);
//        }
        $productos = $this->obtenerProductos();
        $posibleIndice = -1;
        if ($producto->codigo_barras != "1") {
            $posibleIndice = $this->buscarIndiceDeProducto($producto->codigo_barras, $productos);
        }
        // Es decir, producto no fue encontrado
        if ($posibleIndice === -1) {
            $producto->cantidad = 1;
            array_push($productos, $producto);
        } else {
//            if ($productos[$posibleIndice]->cantidad + 1 > $producto->existencia) {
//                return redirect()->route("vender.index")
//                    ->with([
//                        "mensaje" => "No se pueden agregar más productos de este tipo, se quedarían sin existencia",
//                        "tipo" => "danger"
//                    ]);
//            }
            $productos[$posibleIndice]->cantidad++;
        }
        VentasServiceProvider::guardarProductos($productos);
    }

    private function buscarIndiceDeProducto(string $codigo, array &$productos)
    {
        foreach ($productos as $indice => $producto) {
            if ($producto->codigo_barras === $codigo) {
                return $indice;
            }
        }
        return -1;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = 0;
        foreach ($this->obtenerProductos() as $producto) {
            $total += $producto->cantidad * $producto->precio_venta;
        }
        return view("vender.vender",
            [
                "total" => $total,
                "clientes" => Cliente::all(),
            ]);
    }
}
