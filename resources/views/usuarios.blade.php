@extends('base')

@section('titulo') Usuarios @endsection

@section('extracss')
    <style type="text/css">
        #div_errores{
            color:red;
        }

        .form-group {
            margin-bottom: 5px !important;
        }

        .modal .modal-body, .modal .modal-footer, .modal .modal-header {
            padding: 1rem !important;
        }

        table.dataTable td {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }
    </style>
@endsection

@section('titulo_seccion') Listado de Usuarios <button class="btn btn-primary mb-1" onclick="UsuarioAgregar();">Nuevo</button>@endsection

@section('contenido')
	<div class="col-xl-12 col-lg-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <table class="table table-striped table-hover table-responsive table-condensed" id="tbl_usuarios">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                            <th>Fecha creación</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($usuarios) > 0)
	                    @foreach($usuarios as $indice => $usuario)
							<tr>
                                <td>{{ ($indice+1) }}</td>
                                <td>{{ $usuario->nombres }}</td>
                                <td>{{ $usuario->apellidos }}</td>
                                <td>{{ $usuario->usuario }}</td>
                                <td>{{ $usuario->clave }}</td>
                                <td>{{ $usuario->created_at }}</td>
	                        </tr>
	                    @endforeach
                    @else    
                        <tr>
                            <td colspan="7">No existe ningun registro.</td>
                        </tr>
					@endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! csrf_field() !!}
@endsection

@section('extrajs')
    <script src="{{ asset('js/funciones.js')}}"></script>
    <script>
        $( document ).ready(function() {
            $('.menu').removeClass('active');
            $('#li_usuarios').addClass('active');
            $('#tbl_usuarios').dataTable({
                "pageLength": 50,
                "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
            });
        });

        function UsuarioAgregar(){
            let formulario =`<div class="card mr-5 ml-5">
                                <div id="div_errores"></div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Nombres:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="txt_nombres">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Apellidos:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="txt_apellidos">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Usuario:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="txt_usuario">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Contraseña:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="txt_clave1">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Confirme la Contraseña:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="txt_clave2">
                                    </div>
                                </div>
                            </div>`;
            $('.modal-titulo').html('Nuevo usuario');
            $('.modal-body').html(formulario);
            $('.modal-footer').html(`<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                    <button id="btn_confirmar" class="btn btn-primary" onclick="usuarioAgregarConfirmar();">Aceptar</button>`);
            $('#btn_modal_mensaje').click();
        }

        function usuarioAgregarConfirmar(){
            var mensaje_error = '';
            var nombres = $('#txt_nombres').val();
            if(nombres == ''){
                mensaje_error += '<li>Ingrese los nombres del usuario.</li>';
            }
            var apellidos = $('#txt_apellidos').val();
            if(apellidos == ''){
                mensaje_error += '<li>Ingrese los apellidos del usuario.</li>';
            }
            var usuario = $('#txt_usuario').val();
            if(usuario == ''){
                mensaje_error += '<li>Ingrese el usuario.</li>';
            }
            var clave1 = $('#txt_clave1').val();
            if(clave1 == ''){
                mensaje_error += '<li>Ingrese la contraseña del usuario.</li>';
            }
            var clave2 = $('#txt_clave2').val();
            if(clave2 == ''){
                mensaje_error += '<li>Confirme la contraseña del usuario.</li>';
            }
            if(clave1 != clave2){
                mensaje_error += '<li>Las contraseñas no coinciden.</li>';
            }
            if(mensaje_error != ''){
                $('#div_errores').html('<ul>'+mensaje_error+'</ul>');
            }
            else{
                $('.loading-container').show();
                $('#btn_confirmar').prop('disabled', true);
                var token = jQuery("[name=_token]").val();
                $.ajax({
                    url:'{{url("usuario_nuevo")}}',
                    type:'POST',
                    data: {
                        _token:token,
                        nombres:Codificar(nombres),
                        apellidos:Codificar(apellidos),
                        usuario:Codificar(usuario),
                        clave:Codificar(clave1)
                    },
                    dataType: 'json',
                    success: function (respuesta) {
                        if(parseInt(respuesta.res) == 1){
                            $('.modal-titulo').html('<label class="texto-verde">Éxito.</label>');
                            $('.modal-body').html('Información guardada exitosamente.');
                            $('.modal-footer').html(`<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>`);
                            var intervalo = setInterval(function(){
                                document.location.reload();
                            },2000);
                        }
                        else if(parseInt(respuesta.res) == 2){
                            $('.modal-titulo').html('<label class="texto-rojo">El registro ya existe.</label>');
                            $('#div_errores').html('<ul><li>Ya existe un registro con ese usuario, ingrese uno diferente.</li></ul>');
                        }
                        else{
                            $('.modal-titulo').html('<label class="texto-rojo">Error de conexión. Intente nuevamente.</label>');
                        }
                        $('.loading-container').hide();
                        $('#btn_confirmar').prop('disabled', false);
                    },
                    error: function(){
                        $('.modal-titulo').html('<label class="texto-rojo">Error de conexión. Intente nuevamente.</label>');
                        $('#div_errores').html('<ul><li>Error al guardar la información. Revise su conexión a internet e intente nuevamente.</li></ul>');
                        $('.loading-container').hide();
                        $('#btn_confirmar').prop('disabled', false);
                    }
                });
            }
        }
    </script>
@endsection