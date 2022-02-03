@extends('base')

@section('titulo') Envíos @endsection

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

@section('titulo_seccion') Listado de Envíos <button class="btn btn-primary mb-1" onclick="EnvioAgregar();">Nuevo</button>@endsection

@section('contenido')
	<div class="col-xl-12 col-lg-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <table class="table table-striped table-hover table-responsive table-condensed" id="tbl_envios">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha Envío</th>
                            <th>Fecha Llegada</th>
                            <th>Origen</th>
                            <th>Puerto</th>
                            <th>Lugar</th>
                            <th>Contenedor</th>
                            <th>Productos enviados</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($envios) > 0)
	                    @foreach($envios as $indice => $envio)
							<tr>
                                <td>{{ ($indice+1) }}</td>
                                <td>{{ date('Y-m-d', strtotime($envio->fecha_envio)) }}</td>
                                <td>{{ date('Y-m-d', strtotime($envio->fecha_llegada)) }}</td>
                                <td>{{ $envio->origen->nombre }}</td>
                                <td>{{ $envio->puerto->nombre }}</td>
                                <td>{{ $envio->lugar }}</td>
                                <td>{{ $envio->contenedor }}</td>
                                <td>{{ $envio->enviados() }}</td>
                                <td>{{ $envio->usuario->nombres }} {{ $envio->usuario->apellidos }}</td>
                                <td>
                                    <div class="row" style="margin-left:0px !important; width: 100%;">
                                        <a class="mb-1" href="#" onclick="EnvioVer({{ $envio->id }});"><span class="simple-icon-eye" data-toggle="tooltip" data-placement="bottom" title="Ver"></span></a>
    	                                <a class="mb-1" href="#" onclick="EnvioEliminar({{ $envio->id }}, '{{ $envio->contenedor }}');"><span class="foto simple-icon-close" data-toggle="tooltip" data-placement="bottom" title="Eliminar"></span></a>
                                    </div>
                                </td>
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
            $('#li_envios').addClass('active');
            $('#tbl_envios').dataTable({
                "pageLength": 50,
                "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
            });
        });

        function EnvioAgregar(){
            let formulario =`<div class="card mr-5 ml-5">
                                <div id="div_errores"></div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Origen:</strong></label>
                                    <div class="col-sm-8">
                                        <select id="slc_pais_id" class="form-control">
                                            @foreach($paises as $pais)
                                                <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Puerto Destino:</strong></label>
                                    <div class="col-sm-8">
                                        <select id="slc_puerto_id" class="form-control">
                                            @foreach($puertos as $puerto)
                                                <option value="{{ $puerto->id }}">{{ $puerto->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Contenedor:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="txt_contenedor">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Fecha Envío:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control datepicker" id="txt_fecha_envio">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Fecha Llegada:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control datepicker" id="txt_fecha_llegada">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Lugar:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="txt_lugar">
                                    </div>
                                </div>
                                <div class="separator mb-5"></div>
                                <label class="col-sm-2 col-form-label"><strong>PRODUCTOS:</strong></label>
                                <div class="form-group row">
                                    <table class="table table-striped table-hover table-responsive" id="tbl_productos">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Producto</th>
                                                <th>Proveedor</th>
                                                <th>Presentacion</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Enviar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($precios as $indice=>$precio)
                                                <tr>
                                                    <td>{{ $indice+1 }}</td>
                                                    <td>{{ $precio->producto->nombre }}</td>
                                                    <td>{{ $precio->proveedor->nombre }}</td>
                                                    <td>{{ $precio->producto->presentacion->nombre }}</td>
                                                    <td>Q {{ number_format((float)$precio->precio, 2, '.', '') }}</td>
                                                    <td><input type="number" class="form-control cantidad" placeholder="0" disabled></td>
                                                    <td>
                                                        <div class="custom-switch custom-switch-primary mb-1">
                                                            <input class="custom-switch-input switch" id="swt_{{$precio->id}}" type="checkbox" value="{{$precio->id}}" onclick="HabilitarCantidad(this);">
                                                            <label class="custom-switch-btn" for="swt_{{$precio->id}}"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>`;
            $('.modal-titulo').html('Nuevo envio');
            $('.modal-body').html(formulario);
            $('.modal-footer').html(`<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                    <button id="btn_confirmar" class="btn btn-primary" onclick="EnvioAgregarConfirmar();">Aceptar</button>`);
            $('#btn_modal_mensaje').click();
            $('.datepicker').datepicker({
                language: 'es',
                autoclose: true,
                clearBtn: true,
                daysOfWeekHighlighted:[0,6],
                todayBtn:true,
                todayHighlight:true,
                calendarWeeks:true,
            });
            $('#tbl_productos').dataTable();
        }

        function EnvioAgregarConfirmar(){
            $('#div_errores').html('');
            var mensaje_error = '';
            var contenedor = $('#txt_contenedor').val();
            if(contenedor == ''){
                mensaje_error += '<li>Ingrese los datos del Contenedor.</li>';
            }
            var fecha_envio = $('#txt_fecha_envio').val();
            if(fecha_envio == ''){
                mensaje_error += '<li>Seleccione la fecha de envío.</li>';
            }
            var fecha_llegada = $('#txt_fecha_llegada').val();
            if(fecha_llegada == ''){
                mensaje_error += '<li>Seleccione la fecha de llegada.</li>';
            }
            var lugar = $('#txt_lugar').val();
            if(lugar == ''){
                mensaje_error += '<li>Ingrse el lugar de llegada.</li>';
            }
            var seleccionados = 0;
            var precios = [];
            $('.switch').each(function( indice ) {
                if($(this).is(':checked')){
                    var cantidad = $(this).parent().parent().parent().find('.cantidad').val();
                    if(parseInt(cantidad) <= 0 || cantidad == ''){
                        mensaje_error += '<li>Ingrese una cantidad mayor a 0 en el producto '+(indice+1)+'</li>';
                    }
                    else{
                        precios.push([$(this).val(), cantidad]);
                        seleccionados++;
                    }
                }
            });
            if(seleccionados == 0){
                mensaje_error += '<li>Seleccione al menos un producto.</li>';
            }
            if(mensaje_error != ''){
                $('#div_errores').html('<ul>'+mensaje_error+'</ul>');
            }
            else{
                var pais_id = $('#slc_pais_id').val();
                var puerto_id = $('#slc_puerto_id').val();
                $('.loading-container').show();
                $('#btn_confirmar').prop('disabled', true);
                var token = jQuery("[name=_token]").val();
                $.ajax({
                    url:'{{url("envio_nuevo")}}',
                    type:'POST',
                    data: {
                        pais_id:Codificar(pais_id),
                        puerto_id:Codificar(puerto_id),
                        contenedor:Codificar(contenedor),
                        fecha_envio:Codificar(fecha_envio),
                        fecha_llegada:Codificar(fecha_llegada),
                        lugar:Codificar(lugar),
                        precios:precios,
                        _token:token
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
                            $('#div_errores').html('<ul><li>Ya existe un envío con ese contenedor, ingrese uno diferente.</li></ul>');
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

        function EnvioVer(_envio_id){
            $('.loading-container').show();
            var token = jQuery("[name=_token]").val();
            $.ajax({
                url:'{{url("envio")}}',
                type:'POST',
                data:{
                    envio_id:Codificar(_envio_id),
                    _token:token
                },
                dataType: 'json',
                success: function (respuesta) {
                    $('.loading-container').hide();
                    var productos = '';
                    $.each(respuesta.productos_enviados, function(indice, producto_enviado){
                        productos += `<tr>
                                        <td>${ indice+1 }</td>
                                        <td>${ producto_enviado.precio.producto.nombre }</td>
                                        <td>${ producto_enviado.precio.proveedor.nombre }</td>
                                        <td>${ producto_enviado.precio.producto.presentacion.nombre }</td>
                                        <td>Q ${ producto_enviado.precio.precio.toFixed(2) }</td>
                                        <td>${ producto_enviado.cantidad }</td>
                                    </tr>`;
                    });
                    let fecha_envio = (respuesta.fecha_envio)?respuesta.fecha_envio:'';
                    let fecha_llegada = (respuesta.fecha_llegada)?respuesta.fecha_llegada:'';
                    let contenedor = (respuesta.contenedor)?respuesta.contenedor:'';
                    let lugar = (respuesta.lugar)?respuesta.lugar:'';
                    let formulario = `<div class="card mr-5 ml-5">
                                        <div id="div_errores"></div>
                                        <div class="form-group row">
		                                    <label class="col-sm-4 col-form-label"><strong>Envío:</strong></label>
		                                    <div class="col-sm-8">
		                                        <ul>
                                                    <li><b>Origen</b>: ${respuesta.origen.nombre }</li>
                                                    <li><b>Puerto destino</b>: ${respuesta.puerto.nombre }</li>
                                                    <li><b>Contenedor</b>: ${contenedor}</li>
                                                    <li><b>Fecha Envío</b>: ${fecha_envio.substring(0, 10) }</li>
                                                    <li><b>Fecha Llegada</b>: ${fecha_llegada.substring(0, 10) }</li>
                                                    <li><b>Lugar</b>: ${lugar}</li>
                                                    <li><b>Usuario</b>: ${respuesta.usuario.nombres} ${respuesta.usuario.apellidos}</li>
                                                </ul>
		                                    </div>
		                                </div>
                                        <div class="separator mb-5"></div>
                                        <label class="col-sm-2 col-form-label"><strong>PRODUCTOS:</strong></label>
                                        <div class="form-group row">
                                            <table class="table table-striped table-hover table-responsive" id="tbl_productos">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Producto</th>
                                                        <th>Proveedor</th>
                                                        <th>Presentacion</th>
                                                        <th>Precio</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   ${productos}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>`;
                    $('.modal-titulo').html('Ver Envio');
                    $('.modal-body').html(formulario);
                    $('.modal-footer').html(`<button class="btn btn-primary" data-dismiss="modal">Aceptar</button>`);
                    $('#btn_modal_mensaje').click();
                    $('#tbl_productos').dataTable();
                },
                error: function(){
                    $('.modal-titulo').html('<label class="texto-rojo">Error de conexión. Intente nuevamente.</label>');
                    $('#div_errores').html('<ul><li>Error al visualizar la información. Revise su conexión a internet e intente nuevamente.</li></ul>');
                    $('.loading-container').hide();
                }
            });
        }

        function EnvioEliminar(_envio_id, _envio){
            let formulario = `<div class="card mr-5 ml-5">
                                <label>Está seguro de que quiere eliminar el envío del contenedor <b>${_envio}</b>?</label>
                               </div>`;
            $('.modal-titulo').html('Eliminar envio');
            $('.modal-body').html(formulario);
            $('.modal-footer').html(`<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                    <button id="btn_confirmar" class="btn btn-danger" onclick="EnvioEliminarConfirmar(${_envio_id});">Eliminar</button>`);
            $('#btn_modal_mensaje').click();
        }

        function EnvioEliminarConfirmar(_envio_id){
            $('.loading-container').show();
            var token = jQuery("[name=_token]").val();
            $('#btn_confirmar').prop('disabled', true);
            $.ajax({
                url:'{{url("envio_eliminar")}}',
                type:'POST',
                data:{
                    envio_id:Codificar(_envio_id),
                    _token:token
                },
                dataType: 'json',
                success: function (respuesta) {
                    if(parseInt(respuesta.res) == 1){
                        $('.modal-titulo').html('<label class="texto-verde">Exito.</label>');
                        $('.modal-body').html('Información eliminada exitosamente.');
                        $('.modal-footer').html(`<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>`);
                        var intervalo = setInterval(function(){
                            document.location.reload();
                        },2000);
                    }
                    else{
                        $('.modal-titulo').html('<label class="texto-rojo">Error de conexión. Intente nuevamente.</label>');
                    }
                    $('.loading-container').hide();
                    $('#btn_confirmar').prop('disabled', false);
                },
                error: function(){
                    $('.modal-titulo').html('<label class="texto-rojo">Error de conexión. Intente nuevamente.</label>');
                    $('#div_errores').html('<ul><li>Error al eliminar la información. Revise su conexión de internet e intente nuevamente.</li></ul>');
                    $('.loading-container').hide();
                    $('#btn_confirmar').prop('disabled', false);
                }
            });
        }

        function HabilitarCantidad(_elemento){
            var cantidad = $(_elemento).parent().parent().parent().find('.cantidad');
            if($(_elemento).is(':checked')){
                cantidad.prop('disabled', false);    
            }
            else{
                cantidad.prop('disabled', true);
                cantidad.val('');
            }
        }
    </script>
@endsection
