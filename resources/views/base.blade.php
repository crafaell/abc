<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ABC - @yield('titulo')</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('font/iconsmind/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('font/simple-line-icons/css/simple-line-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/datatables.responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/component-custom-switch.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap-datepicker3.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/spinkit.css') }}">
    <style>
        .logo-single2 {
            width: auto !important;
            height: 50px !important;
            margin-top: -8px !important;
        }

        .navbar {
            padding: 10px !important;
        }

        .errorlist li{
            color:red;
            text-transform: uppercase;
        }

        .icono{
            font-size:17px ;
        }

        .btn-icono{
            float: right;
            margin-left: 5px;
        }

        .texto-verde{
            color:green;
        }

        .texto-rojo{
            color:red;
        }

        .texto-anaranjado{
            color:orange;
        }

        .menu-texto{
            text-align: center;
        }

        .card{
            padding: 10px;
        }
    </style>
    @yield('extracss')
</head>
<body id="app-container" class="menu-default show-spinner">
    <nav class="navbar fixed-top">
        <div class="d-flex align-items-center navbar-left">
            <a href="#" class="menu-button d-none d-md-block">
                <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                    <rect x="0.48" y="0.5" width="7" height="1" />
                    <rect x="0.48" y="7.5" width="7" height="1" />
                    <rect x="0.48" y="15.5" width="7" height="1" />
                </svg>
                <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                    <rect x="1.56" y="0.5" width="16" height="1" />
                    <rect x="1.56" y="7.5" width="16" height="1" />
                    <rect x="1.56" y="15.5" width="16" height="1" />
                </svg>
            </a>
            <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                    <rect x="0.5" y="0.5" width="25" height="1" />
                    <rect x="0.5" y="7.5" width="25" height="1" />
                    <rect x="0.5" y="15.5" width="25" height="1" />
                </svg>
            </a>
            <!--div class="search" data-search-path="Layouts.Search.html?q=">
                <input placeholder="Search...">
                <span class="search-icon">
                    <i class="simple-icon-magnifier"></i>
                </span>
            </div-->
        </div>
        <a class="navbar-logo" href="#">
            <img class="d-none d-xs-block logo-single2" src="{{ asset('img/logo.png') }}">
            <span class="logo-mobile d-block d-xs-none"></span>
        </a>
        <div class="navbar-right">
            <div class="header-icons d-inline-block align-middle">
                <button class="header-icon btn btn-empty d-none d-sm-inline-block" type="button" id="fullScreenButton">
                    <i class="simple-icon-size-fullscreen"></i>
                    <i class="simple-icon-size-actual"></i>
                </button>
            </div>
            <div class="user d-inline-block">
                <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="name">
                        @if(empty(Session::get('error')))
                            {{ Session::get('usuario_usuario') }} 
                        @endif
                    </span>
                    <span>
                        <img alt="Menu" src="{{ asset('img/perfil.png') }}" />
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-right mt-3">
                    <a class="dropdown-item" href="{{ url('salir') }}">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="sidebar">
        <div class="main-menu">
            <div class="scroll">
                <ul class="list-unstyled">
                    @if(empty(Session::get('error'))) 
                        <li id="li_productos" class="menu">
                            <a href="{{ url('productos') }}">
                                <i class="simple-icon-bag"></i><label class="menu-texto">Productos</label>
                            </a>
                        </li>
                        <li id="li_proveedores" class="menu">
                            <a href="{{ url('proveedores') }}">
                                <i class="simple-icon-basket"></i><label class="menu-texto">Proveedores</label>
                            </a>
                        </li>
                        <li id="li_precios" class="menu">
                            <a href="{{ url('precios') }}">
                                <i class="simple-icon-credit-card"></i><label class="menu-texto">Precios</label>
                            </a>
                        </li>
                        <li id="li_envios" class="menu">
                            <a href="{{ url('envios') }}">
                                <i class="simple-icon-plane"></i><label class="menu-texto">Contenedores</label>
                            </a>
                        </li>
                        <li id="li_usuarios" class="menu">
                            <a href="{{ url('usuarios') }}">
                                <i class="simple-icon-people"></i><label class="menu-texto">Usuarios</label>
                            </a>
                        </li>
                    @else
                        <script type="text/javascript">
                            window.location.href = 'ingreso';
                        </script>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <main class="default-transition">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>@yield('titulo_seccion')</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        @yield('breadcums')
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            @yield('contenido')
        </div>
        <div class="loading-container" style="display: none;">
            <div class="sk-three-bounce">
                <div class="sk-child sk-bounce1"></div>
                <div class="sk-child sk-bounce2"></div>
                <div class="sk-child sk-bounce3"></div>
            </div>
            <p>Obteniendo información...</p>
        </div>
    </main>
    <!-- Button trigger modal -->
    <button type="button" id="btn_modal_mensaje" class="btn btn-outline-primary" data-toggle="modal" data-target="#mdl_mensaje" style="display:none;">
        Launch Demo Modal
    </button>
    <!-- Modal -->
    <div class="modal fade" id="mdl_mensaje" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 60%; min-width: 30%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal-titulo">Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <!--button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button-->
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/vendor/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('js/vendor/chartjs-plugin-datalabels.js') }}"></script>
    <script src="{{ asset('js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('js/vendor/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/vendor/mousetrap.min.js') }}"></script>
    <script src="{{ asset('js/vendor/progressbar.min.js') }}"></script>
    <script src="{{ asset('js/vendor/select2.full.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/vendor/Sortable.js') }}"></script>
    <script src="{{ asset('js/dore.script.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap-notify.min.js') }}"></script>
    <script>
        $( document ).ready(function() {
            $("body").fadeIn(2000);
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        });

        $.fn.datepicker.dates['es'] = {
            months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            monthsShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
            daysShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            daysMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            today: "Hoy",
            clear: "Limpiar",
            format: "yyyy-mm-dd",
            titleFormat: "MM yyyy",
            weekStart: '1'
        };
        
        let tipos = {
            primary:'iconsmind-Information',
            secundary:'simple-icon-star',
            info:'simple-icon-info',
            warning:'simple-icon-exclamation',
            success:'simple-icon-check',
            danger:'simple-icon-close'
        };

        function AlertaMostrar(_tipo, _mensaje){
            $.notify({
                icon:tipos[_tipo],
                message: _mensaje
            },{
                type: _tipo,
                placement: {
                    from: "top",
                    align: "center"
                },
                animate: {
                    enter: 'animated bounceInDown',
                    exit: 'animated bounceOutUp'
                },
                delay:5000,
                icon_type: 'class',
                template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                            '<span data-notify="icon" style="float:left;font-size:25px;margin-top:2%;"></span> ' +
                            '<span data-notify="message" style="float:left;margin-left:5px;width:84%;">{2}</span>' +
                        '</div>'
            });
        }
    </script>
    @yield('extrajs')
</body>

</html>