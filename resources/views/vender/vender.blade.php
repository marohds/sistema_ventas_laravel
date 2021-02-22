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


<div class="row">
    <div class="col-6">
        <h1>Nueva venta <i class="fa fa-cart-plus"></i></h1>
    </div>
    <div class="col-6">
        <form action="{{route("terminarOCancelarVenta")}}" method="post">
            @csrf
            <label for="id_cliente"><b>Cliente</b></label>
            <div class="input-group">
                <select required class="form-control mr-5" name="id_cliente" id="id_cliente">
                    @foreach($clientes as $cliente)
                    <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                    @endforeach
                </select>
                @if(session("productos") !== null)
                <div class="input-group-append mr-5">
                    <button name="accion" value="terminar" type="submit" class="btn btn-success mr-5">Terminar Venta</button>
                </div>
                <div class="input-group-append mr-5">
                    <button name="accion" value="cancelar" type="submit" class="btn btn-danger">Cancelar Venta</button>
                </div>
                @endif
            </div>
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
@include("notificacion")
<div class="row mt-3">
    <div class="col-6 align-items-center">
        <div class="row">
            <div class="col-12">
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
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-4">
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
            </div>
            <div class="col-4">
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
            </div>
            <div class="col-4">
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
        </div>
    </div>
    <div class="col-6 align-items-center">
        <div class="row">
            <div class="col-6 m-auto">
                <b>Bultos:</b><br />
                <div style="font-size: 72px; text-align: center;"><b>{{number_format($bultos, 0)}}</b></div>
            </div>
            <div class="col-6 m-auto" style="background-color: gold">
                <b>Total Compra:</b><br />
                <div style="font-size: 72px; text-align: center;"><b>$ {{number_format($total, 2)}}</b></div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        @if(session("productos") !== null)
        <div class="table-responsive" style="font-size: large;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Código de barras</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Quitar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(array_reverse(session("productos")) as $producto)
                    <tr>
                        <td>{{$producto->codigo_barras}}</td>
                        <td>{{$producto->descripcion}}</td>
                        <td>${{number_format($producto->precio_venta, 2)}}</td>
                        <td>{{$producto->cantidad}}</td>
                        <td>
                            <form action="{{route("quitarProductoDeVenta")}}" method="post">
                                @method("delete")
                                @csrf
                                <input type="hidden" name="indice" value="{{$loop->index}}">
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
