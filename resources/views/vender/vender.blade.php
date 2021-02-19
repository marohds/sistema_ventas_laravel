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
    <div class="col-12">
        <h1>Nueva venta <i class="fa fa-cart-plus"></i></h1>
        @include("notificacion")
        <form action="{{route("terminarOCancelarVenta")}}" method="post">
            @csrf
            <div class="row align-items-end">
                <div class="col-6">
                    <label for="id_cliente">Cliente</label>
                    <div class="input-group">
                        <select required class="form-control" name="id_cliente" id="id_cliente">
                            @foreach($clientes as $cliente)
                            <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if(session("productos") !== null)
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
                @endif
            </div>
        </form>
        <div class="row align-items-center mt-3">
            <div class="col-4">
                <form action="{{route("agregarProductoVenta")}}" method="post">
                    @csrf
                    <label for="codigo"><b>Código de barras</b></label>
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
            <div class="col-2">
                <form action="{{route("agregarVarios")}}" method="post">
                    @csrf
                    <label for="varios">Importe <b>Varios</b></label>
                    <div class="input-group">
                        <input type="number" id="varios" class="form-control" required name="varios" min="0" value="0" step=".01" placeholder="Ingrese un importe">
                        <div class="input-group-append">
                          <button class="btn btn-outline-success" type="submit">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-2">
                <form action="{{route("agregarCarniceria")}}" method="post">
                    @csrf
                    <label for="varios">Importe <b>Carnicería</b></label>
                    <div class="input-group">
                        <input type="number" id="carniceria" class="form-control" required name="carniceria" min="0" value="0" step=".01" placeholder="Ingrese un importe">
                        <div class="input-group-append">
                          <button class="btn btn-outline-success" type="submit">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-2">
                <form action="{{route("agregarFiambre")}}" method="post">
                    @csrf
                    <label for="varios">Importe <b>Fiambres</b></label>
                    <div class="input-group">
                        <input type="number" id="fiambre" class="form-control" required name="fiambre" min="0" value="0" step=".01" placeholder="Ingrese un importe">
                        <div class="input-group-append">
                          <button class="btn btn-outline-success" type="submit">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if(session("productos") !== null)
        <h2 class="mt-3">Total: ${{number_format($total, 2)}}</h2>
        <div class="table-responsive">
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
                    @foreach(session("productos") as $producto)
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
                                <button type="submit" class="btn btn-danger">
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
@endsection
