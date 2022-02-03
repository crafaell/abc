<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ABC: SISTEMA DE EXPORTACIONES</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('font/iconsmind/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('font/simple-line-icons/css/simple-line-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap-float-label.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <style>
        .frase{
            text-shadow: 3px 3px 4px black;
            margin-top: 390px;
            background-color: black;
            opacity: 0.7;
            border-radius: 10px;
            padding: 5px;
        }

        .logo-single2 {
            width: auto;
            height: 90px;
            background: url({{ asset('img/logo.png') }}) no-repeat 0 0 / 50% 100%;
            margin-top: -60px;
            margin-left: -18%;
            margin-right: -70px;
        }

        .image-side{
            width:80% !important;
        }
    </style>
</head>
<body class="background show-spinner">
    <div class="fixed-background" style="background: url({{ asset('img/fondo.jpg') }}) no-repeat 0 0 / 100% 100% fixed;"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-12 mx-auto my-auto">
                    <div class="card auth-card" style="margin-top: -30px;">
                        <div class="position-relative image-side " style="padding: 40px 100px 5px 40px; background: url({{ asset('img/exp.png') }}) no-repeat no-repeat 0 0 / 90% 100%;">
                            <p class="text-white h5 frase">El comercio une al mundo en una común hermandad.</p>
                            <p class="mb-0" style="font-style: italic;color:black;text-shadow: 2px 0 0 #fff, -2px 0 0 #fff, 0 2px 0 #fff, 0 -2px 0 #fff, 1px 1px #fff, -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff;">
                                James A. Garfield
                            </p>
                        </div>
                        <div class="form-side">
                            <a href="#">
                                <div class="logo-single2"></div>
                            </a>
                            <h6 class="mb-4 mt-4">Iniciar Sesión</h6>
                            <form action="{{ url('ingresar') }}" method="POST">
                                {{ csrf_field() }}
                                <label class="form-group has-float-label mb-4">
                                    <input type="text" class="form-control" name="txt_usuario">
                                    <span>Usuario</span>
                                </label>
                                <label class="form-group has-float-label mb-4">
                                    <input type="password" class="form-control" name="txt_clave">
                                    <span>Contraseña</span>
                                </label>
                                @if(session('existe') == '0')
                                    <hr>
                                    <p class="text-danger label label-danger">
                                      <b>El nombre de usuario o la contraseña son incorrectos</b>
                                      <b>Intente nuevamente</b>
                                    </p>
                                    <hr>
                                @endif
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#">Olvidó su contraseña?</a>
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">Iniciar Sesión</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/dore.script.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>