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

use App\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class VentasController extends Controller
{

    public function ticket(Request $request)
    {
        /*
         * {"printTicket":
         *  {"encabezado":{"tipo_cbte":"T"},
         *  "items":[
         *  {"alic_iva":21,"importe":0.01,"ds":"PEPSI","qty":1},
         *  {"alic_iva":21,"importe":0.12,"ds":"COCA","qty":2}
         * ]
         * }
         * }
         */
        $venta = Venta::findOrFail($request->get("id"));
        
        $obj = new \stdClass();
        $obj->printTicket = new \stdClass();
        $obj->printTicket->encabezado = new \stdClass();
        $obj->printTicket->items = array();
        
        $obj->printTicket->encabezado->{"tipo_cbte"} = "T";
        $obj->printerName = "IMPRESORA_FISCAL";
        
        foreach ($venta->productos as $producto) {
            $item = new \stdClass();
            $item->alic_iva = $producto->iva;
            $item->importe = (float) $producto->precio;
            $item->ds = $producto->descripcion;
            $item->qty = (float) $producto->cantidad;
            $obj->printTicket->items[] = $item;
        }
        
        return redirect()->back()->with("mensaje", json_encode($obj));
        
        //return redirect()->back()->with("mensaje", "Ticket impreso");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventasConTotales = Venta::join("productos_vendidos", "productos_vendidos.id_venta", "=", "ventas.id")
            ->select("ventas.*", DB::raw("sum(productos_vendidos.cantidad * productos_vendidos.precio) as total"))
            ->groupBy("ventas.id", "ventas.created_at", "ventas.updated_at", "ventas.id_cliente")
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view("ventas.ventas_index", [
            "ventas" => $ventasConTotales,
            "cierreZJson" => '{"dailyClose":"Z","printerName":"IMPRESORA_FISCAL"}',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Venta $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        $total = 0;
        foreach ($venta->productos as $producto) {
            $total += $producto->cantidad * $producto->precio;
        }
                
        return view("ventas.ventas_show", [
            "venta" => $venta,
            "total" => $total,
            "ticketJson" => $this->getTicketJson($venta),
        ]);
    }
    
    private function getTicketJson(Venta $venta)
    {
        $obj = new \stdClass();
        $obj->printTicket = new \stdClass();
        $obj->printTicket->encabezado = new \stdClass();
        $obj->printTicket->items = array();
        
        $obj->printTicket->encabezado->{"tipo_cbte"} = "T";
        $obj->printerName = "IMPRESORA_FISCAL";
        
        foreach ($venta->productos as $producto) {
            $item = new \stdClass();
            $item->alic_iva = $producto->iva;
            $item->importe = (float) $producto->precio;
            $item->ds = $producto->descripcion;
            $item->qty = (float) $producto->cantidad;
            $obj->printTicket->items[] = $item;
        }
        
        return json_encode($obj);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Venta $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Venta $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Venta $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        $venta->delete();
        return redirect()->route("ventas.index")
            ->with("mensaje", "Venta eliminada");
    }
}
