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
    
    private $total = 0;
    private $bultos = 0;

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
        $productos = $this->obtenerProductosCarrito();
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
                "iva"=>$producto->iva,
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

    private function obtenerProductosCarrito()
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
        $productos = $this->obtenerProductosCarrito();
        //array_splice($productos, $indice, 1);
        $this->quitarProductoDelCarrito($indice, $productos);
        return redirect()->action([VenderController::class, 'index']);
    }
    
    public function agregarVarios(Request $request)
    {
        $request->validate([
            'varios' => 'required|numeric|min:0|max:9999999.99|not_in:0',
        ]);
        $importe = $request->post("varios");
        $producto = Producto::where("codigo_barras", "=", 1)->first();
        if (!$producto) {
            $producto = new Producto();
            $producto->codigo_barras = 1;
            $producto->descripcion = "Varios";
            $producto->precio_compra = 0;
            $producto->precio_venta = 0;
            $producto->existencia = 9999999;
            $producto->iva = 21.00;
            $producto->saveOrFail();
        }
        $producto->precio_venta = (float)$importe;
        $this->agregarProductoACarrito($producto);
        return redirect()->action([VenderController::class, 'index']);
    }
    
    public function agregarCarniceria(Request $request)
    {
        $request->validate([
            'carniceria' => 'required|numeric|min:0|max:9999999.99|not_in:0',
        ]);
        $importe = $request->post("carniceria");
        $producto = Producto::where("codigo_barras", "=", 2)->first();
        if (!$producto) {
            $producto = new Producto();
            $producto->codigo_barras = 2;
            $producto->descripcion = "Carniceria";
            $producto->precio_compra = 0;
            $producto->precio_venta = 0;
            $producto->existencia = 9999999;
            $producto->iva = 21.00;
            $producto->saveOrFail();
        }
        $producto->precio_venta = (float)$importe;
        $this->agregarProductoACarrito($producto);
        return redirect()->action([VenderController::class, 'index']);
    }
    
    public function agregarFiambre(Request $request)
    {
        $request->validate([
            'fiambre' => 'required|numeric|min:0|max:9999999.99|not_in:0',
        ]);
        $importe = $request->post("fiambre");
        $producto = Producto::where("codigo_barras", "=", 3)->first();
        if (!$producto) {
            $producto = new Producto();
            $producto->codigo_barras = 3;
            $producto->descripcion = "Fiambre";
            $producto->precio_compra = 0;
            $producto->precio_venta = 0;
            $producto->existencia = 9999999;
            $producto->iva = 21.00;
            $producto->saveOrFail();
        }
        $producto->precio_venta = (float)$importe;
        $this->agregarProductoACarrito($producto);
        return redirect()->action([VenderController::class, 'index']);
    }

    public function agregarProductoVenta(Request $request)
    {
        $request->validate([
            'codigo' => 'required|numeric|not_in:0',
        ]);
        $codigo = $request->post("codigo");
        $producto = Producto::where("codigo_barras", "=", $codigo)->first();
        if (!$producto) {
            return redirect()
                ->route("vender.index")
                ->with("mensaje", "Producto no encontrado en el catálogo.");
        }
        $this->agregarProductoACarrito($producto);
        return redirect()->action([VenderController::class, 'index']);
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
        $productos = $this->obtenerProductosCarrito();
        $posibleIndice = -1;
        //Varios / Carniceria /Fiambre
        if ($producto->codigo_barras != "1" && $producto->codigo_barras != "2" && $producto->codigo_barras != "3") {
            $posibleIndice = $this->buscarIndiceDeProducto($producto->codigo_barras, $productos);   
        }
        // Es decir, producto no fue encontrado, pero es 1, 2 o 3
        if ($posibleIndice === -1) {
            $producto->cantidad = 1;
            $producto->indice = count($productos);
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
        foreach ($productos as $ix => $producto) {
            if ($producto->codigo_barras === $codigo) {
                return $ix;
            }
        }
        return -1;
    }
    
    private function quitarProductoDelCarrito(string $indice, array &$productos)
    {
        foreach ($productos as $ix => $producto) {
            if ($producto->indice === (int)$indice) {
                array_splice($productos, $ix, 1);
                VentasServiceProvider::guardarProductos($productos);
                return true;
            }
        }
        return false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->calcularTotales();
        return view("vender.vender",
            [
                "total" => $this->total,
                "bultos" => $this->bultos,
                "clientes" => Cliente::all(),
            ]);
    }
    
    private function calcularTotales() {
        $this->total = 0;
        $this->bultos = 0;
        foreach ($this->obtenerProductosCarrito() as $producto) {
            $this->total += $producto->cantidad * $producto->precio_venta;
            $this->bultos += $producto->cantidad;
        }
    }
}
