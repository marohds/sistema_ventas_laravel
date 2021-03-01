{{--

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
--}}
@extends("maestra")
@section("titulo", "Realizar venta")
@section("contenido")
@include("notificacion")
<div class="row">
    <div class="col-3">
        <h1>Nueva venta <i class="fa fa-cart-plus"></i></h1>
    </div>
    <div class="col-6">
        <div class="row">
            <div class="col-6 m-auto">
            <b>Bultos:</b><br />
            <div style="font-size: 48px; text-align: center;"><b>{{number_format($bultos, 0)}}</b></div>
        </div>
        <div class="col-6 m-auto" style="background-color: gold">
            <b>Total Compra:</b><br />
            <div style="font-size: 48px; text-align: center;"><b>$ {{number_format($total, 2)}}</b></div>
        </div>
        </div>
    </div>
    <div class="col-3">
        <form action="{{route("terminarOCancelarVenta")}}" method="post">
            @csrf
            <label for="id_cliente"><b>Cliente</b></label>
            <div class="input-group">
                <select required class="form-control" name="id_cliente" id="id_cliente">
                    @foreach($clientes as $cliente)
                    <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                    @endforeach
                </select>
                
            </div>
            @if(session("productos") !== null)
            <div class="float-right mt-1">
                <button name="accion" value="terminar" type="submit" class="btn btn-success mr-5">Terminar Venta</button>
                <button name="accion" value="cancelar" type="submit" class="btn btn-danger">Cancelar Venta</button>
            </div>
            @endif
            {{--@if(session("productos") !== null)
                <div class="col-6">
                    <div class="input-group">
                        <button name="accion" value="terminar" type="submit" class="btn btn-success mr-5">Terminar
                            venta
                        </button>
                        <button name="accion" value="cancelar" type="submit" class="btn btn-danger">Cancelar
                            venta
                        </button>
                    </div>
                </div>
                @endif--}}
        </form>
    </div>
</div>
<div class="row">
    <div class="col-3">
        <form action="{{route("agregarProductoVenta")}}" method="post">
                    @csrf
                    <label for="codigo"><b>Código de barras [Tecla B]</b></label>
                    <div class="input-group">
                        <input id="codigo" autocomplete="off" required autofocus name="codigo" type="text"
                               class="form-control"
                               placeholder="Código de barras">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit">Agregar</button>
                        </div>
                    </div>
                </form>
        <form action="{{route("agregarVarios")}}" method="post">
                    @csrf
                    <label for="varios">Importe <b>Varios [Tecla X]</b></label>
                    <div class="input-group">
                        <input type="decimal(9,2)" id="varios" class="form-control" required name="varios" min="0" value="0" step=".01" placeholder="Ingrese un importe">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit">Agregar</button>
                        </div>
                    </div>
                </form>
        <form action="{{route("agregarCarniceria")}}" method="post">
                    @csrf
                    <label for="varios">Importe <b>Carnicería [Tecla C]</b></label>
                    <div class="input-group">
                        <input type="decimal(9,2)" id="carniceria" class="form-control" required name="carniceria" min="0" value="0" step=".01" placeholder="Ingrese un importe">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit">Agregar</button>
                        </div>
                    </div>
                </form>
        <form action="{{route("agregarFiambre")}}" method="post">
                    @csrf
                    <label for="varios">Importe <b>Fiambres [Tecla F]</b></label>
                    <div class="input-group">
                        <input type="decimal(9,2)" id="fiambre" class="form-control" required name="fiambre" min="0" value="0" step=".01" placeholder="Ingrese un importe">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit">Agregar</button>
                        </div>
                    </div>
                </form>
    </div>
    <div class="col-9">
        <div class="col-12 mt-3">
        @if(session("productos") !== null)
        <div class="table-responsive">
            <table class="table table-bordered table-vender">
                <thead>
                    <tr>
                        <th style="padding: 0.3rem !important; vertical-align: initial !important;">Código de barras</th>
                        <th style="padding: 0.3rem !important; vertical-align: initial !important;">Descripción</th>
                        <th style="padding: 0.3rem !important; vertical-align: initial !important;">Precio</th>
                        <th style="padding: 0.3rem !important; vertical-align: initial !important;">Cantidad</th>
                        <th style="padding: 0.3rem !important; vertical-align: initial !important;">Quitar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(array_reverse(session("productos")) as $producto)
                    <tr>
                        <td style="padding: 0.3rem !important; vertical-align: initial !important;">{{$producto->codigo_barras}}</td>
                        <td style="padding: 0.3rem !important; vertical-align: initial !important;">{{$producto->descripcion}}</td>
                        <td style="padding: 0.3rem !important; vertical-align: initial !important;">${{number_format($producto->precio_venta, 2)}}</td>
                        <td style="padding: 0.3rem !important; vertical-align: initial !important;">{{$producto->cantidad}}</td>
                        <td style="padding: 0.3rem !important; vertical-align: initial !important;">
                            <form action="{{route("quitarProductoDeVenta")}}" method="post">
                                @method("delete")
                                @csrf
                                <input type="hidden" name="indice" value="{{$producto->indice}}">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <h2>Aquí aparecerán los productos de la venta
            <br>
            Escanea el código de barras o escribe y presiona Enter</h2>
        @endif
    </div>
    </div>
</div>
<script>  
    focusConTecla = function(cid) {
        $("#codigo").val('');
        $("#carniceria").val('');
        $("#fiambre").val('');
        $("#varios").val('');
        $("#" + cid).focus();
    }
 
    $(document).on('keydown', function (e) {
       var keycode = (event.keyCode ? event.keyCode : event.which);
        //B - Codigo de Barras
        if (keycode == '66') {
            focusConTecla("codigo");
            event.preventDefault();
            event.stopPropagation();
        }
        //C - Carnicería
        if (keycode == '67') {
            focusConTecla("carniceria");
            event.preventDefault();
            event.stopPropagation();
        }
        //F - Fiambres
        if (keycode == '70') {
            focusConTecla("fiambre");
            event.preventDefault();
            event.stopPropagation();
        }
        //X - Varios
        if (keycode == '88') {
            focusConTecla("varios");
            event.preventDefault();
            event.stopPropagation();
        }
   });
</script>
@endsection
