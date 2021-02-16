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
@section("titulo", "Productos")
@section("contenido")
    <div class="row">
        <div class="col-12">
            <h1>Productos <i class="fa fa-box"></i><a href="{{route("productos.create")}}" class="btn btn-success mb-2 ml-5">Agregar</a></h1>
            <div class="row align-items-center">
                <div class="col-4">
                    <form action="{{route("buscarProducto")}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="codigo">Buscar por Código de barras</label>
                            <input id="codigo" autocomplete="off" required autofocus name="codigo" type="text"
                                   class="form-control"
                                   placeholder="Código de barras">
                            <button type="submit" class="btn btn-success">Enviar</button>
                        </div>
                    </form>
                </div>
                <div class="col-4">
                    <form action="{{route("buscarPorNombre")}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="codigo">Buscar por Nombre</label>
                            <input id="nomprod" required autofocus name="nomprod" type="text"
                                   class="form-control"
                                   placeholder="Ingrese un nombre de producto o parte de él"
                                   value="{{ isset($nomprod) ? $nomprod : '' }}"
                                   >
                            <button type="submit" class="btn btn-success">Enviar</button>
                            <a href="{{route("productos.index")}}" class="btn btn-warning">Limpiar</a>
                        </div>
                    </form>
                </div>
            </div>
            @include("notificacion")
            {{ $productos->links() }}
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Código de barras</th>
                        <th>Descripción</th>
                        <th>Precio de compra</th>
                        <th>Precio de venta</th>
                        <th>Utilidad</th>
                        <th>Existencia</th>

                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productos as $producto)
                        <tr>
                            <td>{{$producto->codigo_barras}}</td>
                            <td>{{$producto->descripcion}}</td>
                            <td>{{$producto->precio_compra}}</td>
                            <td>{{$producto->precio_venta}}</td>
                            <td>{{$producto->precio_venta - $producto->precio_compra}}</td>
                            <td>{{$producto->existencia}}</td>
                            <td>
                                <a class="btn btn-warning" href="{{route("productos.edit",[$producto])}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{route("productos.destroy", [$producto])}}" method="post">
                                    @method("delete")
                                    @csrf
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
        </div>
    </div>
@endsection
