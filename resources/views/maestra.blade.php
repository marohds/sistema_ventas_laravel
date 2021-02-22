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
<!doctype html>
<html lang="es">
<!--

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
-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{env("APP_NAME")}}">
    <meta name="author" content="Parzibyte">
    <title>@yield("titulo") - {{env("APP_NAME")}}</title>
    <link href="{{url("/css/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{url("/css/all.min.css")}}" rel="stylesheet">
    <script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
    <script src="{{ asset('js/fiscalberry.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <style>
        body {
            padding-top: 70px;
            /*Para la barra inferior fija*/
            padding-bottom: 70px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    {{--<a class="navbar-brand" target="_blank" href="//parzibyte.me/blog">{{env("APP_NAME")}}</a>--}}
    <button class="navbar-toggler" type="button" data-toggle="collapse"
            id="botonMenu" aria-label="Mostrar u ocultar menú">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav mr-auto">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>

                {{--<li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        Registro
                    </a>--}}
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{route("home")}}">Inicio&nbsp;<i class="fa fa-home"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("productos.index")}}">Productos&nbsp;<i class="fa fa-box"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("vender.index")}}">Vender&nbsp;<i class="fa fa-cart-plus"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("ventas.index")}}">Ventas&nbsp;<i class="fa fa-list"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("usuarios.index")}}">Usuarios&nbsp;<i class="fa fa-users"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("clientes.index")}}">Clientes&nbsp;<i class="fa fa-users"></i></a>
                </li>
            @endguest
        </ul>
        <ul class="navbar-nav ml-auto">
            @auth
                <li class="nav-item">
                    <a id="ws-message" href="#" class="btn btn-danger" style="float:right;" data-toggle="modal" data-target="#showimp">Impresora Offline</a>
                </li>
                
                <li class="nav-item">
                    <a href="{{route("logout")}}" class="nav-link">
                        Salir ({{ Auth::user()->name }})
                    </a>
                </li>
            @endauth
            <li class="nav-item">
                <a class="nav-link" href="{{route("soporte.index")}}">Soporte&nbsp;<i
                        class="fa fa-hands-helping"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route("acerca_de.index")}}">Acerca de&nbsp;<i class="fa fa-info"></i></a>
            </li>
        </ul>
    </div>
</nav>
<script type="text/javascript">
    // Tomado de https://parzibyte.me/blog/2019/06/26/menu-responsivo-bootstrap-4-sin-dependencias/
    document.addEventListener("DOMContentLoaded", () => {
        const menu = document.querySelector("#menu"),
            botonMenu = document.querySelector("#botonMenu");
        if (menu) {
            botonMenu.addEventListener("click", () => menu.classList.toggle("show"));
        }
    });
</script>
<main class="container-fluid">
    
    <div id="connection_details" style="display:none;">
        <label for="host">host:</label>
        <input type="text" id="host" value="localhost" style="background:#ff0000;"/><br/>
        <label for="port">port:</label>
        <input type="text" id="port" value="12000" style="background:#ff0000;"/><br/>
        <label for="uri">uri:</label>
        <input type="text" id="uri" value="/ws" style="background:#ff0000;"/><br/>
        <input type="submit" id="open" value="open"/>
    </div>  
    
    <div class="modal fade" id="showimp">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Mensajes de la Impresora Fiscal</h4>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="terminal"></div>
                        </div>
                        <div class="modal-footer">
                            <!--<input type="button" class="btn btn-primary" value="Cerrar">-->
                        </div>
                    </div>
                </div>
            </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield("contenido")
</main>
{{--<footer class="px-2 py-2 fixed-bottom bg-dark">
    <span class="text-muted">Punto de venta en Laravel
        <i class="fa fa-code text-white"></i>
        con
        <i class="fa fa-heart" style="color: #ff2b56;"></i>
        por
        <a class="text-white" href="//parzibyte.me/blog">Parzibyte</a>
        &nbsp;|&nbsp;
        <a target="_blank" class="text-white" href="//github.com/parzibyte/sistema_ventas_laravel">
            <i class="fab fa-github"></i>
        </a>
    </span>
</footer>--}}
<script>
$( document ).ready(function() {
    
    // instancio la clase Fiscalberry del archivo fiscablerry.js
    var fbrry = new Fiscalberry();

    // log function
    log = function (txt) {
        var $span = $("<span class='msg'>").text("[MSG] " + txt);
        $("div#terminal").prepend("</br>").prepend($span);
        console.info(txt);
    };

    // log function
    logRta = function (txt) {
        var $span = $("<span class='rta'>").text("[RTA] " + txt);
        $("div#terminal").prepend("</br>").prepend($span);
        console.debug(txt);
    };

    // log function
    logErr = function (txt) {
        var $span = $("<span class='error'>").text("[ERR] " + txt);
        $("div#terminal").prepend("</br>").prepend($span);
        console.error(txt);
    };


    // como recibo un $.promise() puedo usar el done.
    // se ejecuta ni bien conecta con el host del WS
    fbrry.promise.done(function () {
        console.info("Iniciado el Web Socket promise DONE");
    });

    fbrry.promise.fail(function () {
        console.info("No hay conexion con el Web Socket promise ERROR");
    });


    // Handle incoming websocket message callback
    fbrry.on('message', function (ob, evt) {
        // recibe mensajes y respuestas. O sea todo lo que recibe el WS
        console.info("Vino algo del websocket %o", evt);
    });

    // Handle msg recibido del server.py
    fbrry.on("fb:msg", function (ob, evt) {
        if (typeof evt.data === 'string') {
            log(evt.data);
        }
        if (typeof evt.data === 'object') {
            for (key in evt.data) {
                log("Message Received: " + key);
                if (typeof evt.data[key] != "string" && Array.isArray(evt.data[key])) {
                    for (var i = evt.data[key].length - 1; i >= 0; i--) {
                        log("   " + key + ": " + evt.data[key][i]);
                    }
                }
            }
        }
    });


    // Handle msg recibido del server.py
    fbrry.on("fb:err", function (ob, evt) {
        if (typeof evt.data === 'string') {
            logErr(evt.data);
        }
        if (typeof evt.data === 'object') {
            for (key in evt.data) {
                logErr("Message Received: " + key);
                if (typeof evt.data[key] != "string" && Array.isArray(evt.data[key])) {
                    for (var i = evt.data[key].length - 1; i >= 0; i--) {
                        logErr("   " + key + ": " + evt.data[key][i]);
                    }
                }
            }
        }
    });


    // Handle rta recibido a un comando nviado previamente
    fbrry.on("fb:rta", function (ob, evt) {
        console.info("vino la respuesta %o", evt.data);

        if (evt.data.hasOwnProperty("action")) {
            logRta(evt.data["action"] + " : " + evt.data["rta"]);
        }


        if (Array.isArray(evt.data)) {
            for (var i = evt.data.length - 1; i >= 0; i--) {
                if (evt.data[i].hasOwnProperty("action")) {
                    logRta(evt.data[i]["action"] + " : " + evt.data[i]["rta"]);
                }

                if (typeof evt.data[i] === "string") {
                    logRta(evt.data[i]);
                }
            }

        }

    });


    // Handle msg recibido del server.py
    fbrry.on("fb:rta:getAvaliablePrinters", function (ob, evt) {
        console.info("Vino RTA DE  getAvaliablePrinters: %o", evt.data);

        var $select = $("<select>"),
                ops, val;
        for (var i = evt.data.length - 1; i >= 0; i--) {
            val = evt.data[i];
            ops = "<option value='" + val + "'>" + val + "</option>";
            $(ops).appendTo($select);
        }
        // borrar mensaje de que hay que apretar el boton para ver impresoras
        $(".content", "#select-printers").empty();

        // agregar el select con las impresoras configuradas
        $select.appendTo($(".content", "#select-printers"));
    });


    fbrry.on("fb:rta:printTicket", function (ob, evt) {
        console.info("Vino RTA DE printTicket: %o", evt.data);

    });


    // Close Websocket callback
    fbrry.on('close', function (evt) {
        log("***Connection Closed***");
        $("#host").css("background", "#ff0000");
        $("#port").css("background", "#ff0000");
        $("#uri").css("background", "#ff0000");
        $("div#message_details").hide();
    });


    // Open Websocket callback
    fbrry.on('open', function (evt) {
        $("#host").css("background", "#00ff00");
        $("#port").css("background", "#00ff00");
        $("#uri").css("background", "#00ff00");
        $("div#message_details").show();
        log("***Connection Opened***");
    });


    // Close Websocket callback
    fbrry.on('close', function (evt) {

        // reconnect
        log(" reconectando en 3 segundos ");
        setTimeout(function () {
            startWs();
        }, 3000);
    });


    // manejo el mensaje ONLINE/OFFLINE
    fbrry.on('close', function (evt) {
        console.info("CLOSE");
        $("#ws-message").html("Impresora Offline").addClass("ws-msg-offline btn-danger").removeClass("ws-msg-online btn-success");
        $("#configPanel").hide();
        $(".panel_configuracion").hide();
    });
    fbrry.on('open', function (evt) {
        console.info("OPEN CONECTADO");
        $("#ws-message").html("Impresora Online").removeClass("ws-msg-offline btn-danger").addClass("ws-msg-online btn-success");
        $(".panel_configuracion").show();
        $(".panel_configuracion").val("Abrir panel de configuración de Fiscalberry");
        $("#listadoImpresoras").children(".impresora").remove();
        $("#sectionServidor").children("label[name='port_label'], input[name='server_port']").remove();
        fbrry.send('{ "getActualConfig":"" }');
    });


    // funcion para conectar usando el FORM
    function startWs() {
        var host = $("#host").val();
        var port = $("#port").val();
        var uri = $("#uri").val();
        // create websocket instance
        fbrry.connect(host, port);

        console.info("START INICIANDO");

    }


    function ponerJSONenTextarea(jsontext) {

        jsontemp = JSON.parse(jsontext);
        var printerName = $("#select-printers select").val();
        if (printerName) {
            jsontemp['printerName'] = printerName;
        }
        $("#message").html(JSON.stringify(jsontemp));
    }

    $(document).on('click', "#msg-drawer", function () {
        ponerJSONenTextarea('{"openDrawer": true}');

    });

    $(document).on('click', "#msg-status", function () {
        ponerJSONenTextarea('{"getStatus": {}}');
    });

    $("#msg-lst-number").on('click', function () {
        ponerJSONenTextarea('{"getLastNumber": "T"}');
    });

    $("#msg-daily").on('click', function () {
        ponerJSONenTextarea('{"dailyClose": "X"}');
    });

    $("#msg-cancel").on('click', function () {
        ponerJSONenTextarea('{"cancelDocument": ""}');
    });

    $("#msg-get-printers").on('click', function () {
        ponerJSONenTextarea('{"getAvaliablePrinters": ""}');
    });


    var ticketString =
            '{"printTicket": {\
                "encabezado": {\
                    "tipo_cbte": "T"\
                },\
                "items": [{\
                  "alic_iva":21.0,\
                  "importe": 0.01,\
                  "ds": "PEPSI",\
                  "qty": 1.0\
                },\
                {\
                  "alic_iva": 21.0,\
                  "importe": 0.12,\
                  "ds": "COCA",\
                  "qty": 2.0\
                }]\
            }}';

    var NCString =
            '{"printTicket": {\
                "encabezado": {\
                    "tipo_cbte": "NCA",\
                    "referencia": "00066778",\
                    "nombre_cliente": "Carlos Tevez",\
                    "domicilio_cliente": "zaraza",\
                    "tipo_responsable": "RESPONSABLE_INSCRIPTO",\
                    "tipo_doc": "CUIT",\
                    "nro_doc": 22222222226\
                },\
                "items": [{\
                  "alic_iva":21.0,\
                  "importe": 1.00,\
                  "ds": "PEPSI",\
                  "qty": 1.0\
                }]\
            }}';

    var NCStringTest =
            '{"printTicket": {\
                "encabezado": {\
                    "tipo_cbte": "NCB",\
                    "referencia": "00066811"\
                },\
                "items": [{\
                  "alic_iva":21.0,\
                  "importe": 1.00,\
                  "ds": "PEPSI",\
                  "qty": 1.0\
                }]\
            }}';

    $("#msg-ticket").on('click', function () {
        ponerJSONenTextarea(ticketString);
    });


    // Cuando aprieto el SUBMIT OPEN para conectar desde el FORM
    $("#open").on("click", function (evt) {
        evt.preventDefault();
        startWs();

    });


    $("#msg-nc").on('click', function () {
        ponerJSONenTextarea(NCString);
    });

    $("#msg-nc-test").on('click', function () {
        ponerJSONenTextarea(NCStringTest);
    });


    $("div#message_details").hide();


    startWs();

    // Send websocket message function
    $("#btnSend").on("click", function (evt) {
        log("Sending Message: " + $("#message").val());
        fbrry.send($("#message").val());
    });
});
</script>
</body>
</html>
