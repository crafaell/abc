@extends('base')

@section('titulo') Productos @endsection

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

@section('titulo_seccion') Listado de productos <button class="btn btn-primary mb-1" onclick="ProductoAgregar();">Nuevo</button>@endsection

@section('contenido')
	<div class="col-xl-12 col-lg-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <table class="table table-striped table-hover table-responsive table-condensed" id="tbl_productos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>SKU</th>
                            <th>Presentacion</th>
                            <th>Volumen</th>
                            <th>Unidad</th>
                            <th>Foto</th>
                            <th>Fecha creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($productos) > 0)
	                    @foreach($productos as $indice => $producto)
							<tr>
                                <td>{{ ($indice+1) }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->sku }}</td>
                                <td>{{ $producto->presentacion->nombre }}</td>
                                <td>{{ $producto->volumen }}</td>
                                <td>{{ $producto->unidad }}</td>
                                <td>
                                    @if($producto->foto)
                                        <img width="130" src="img/productos/{{ $producto->foto }}" alt="Sin Foto">
                                    @else 
                                        Sin foto
                                    @endif
                                </td>
                                <td>{{ $producto->created_at }}</td>
	                            <td>
                                    <div class="row" style="margin-left:0px !important; width: 100%;">
                                        <a class="mb-1" href="#" onclick="ProductoEditar({{ $producto->id }});"><span class="foto simple-icon-pencil" data-toggle="tooltip" data-placement="bottom" title="Editar"></span></a>
    	                                <a class="mb-1" href="#" onclick="ProductoEliminar({{ $producto->id }}, '{{ $producto->nombre }}');"><span class="foto simple-icon-close" data-toggle="tooltip" data-placement="bottom" title="Eliminar"></span></a>
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
            $('#li_productos').addClass('active');
            $('#tbl_productos').dataTable({
                "pageLength": 50,
                "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
            });
        });

        function ProductoAgregar(){
            let formulario =`<div class="card mr-5 ml-5">
                                <div id="div_errores"></div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Nombre:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="txt_nombre">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>SKU:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="txt_sku">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Presentacion:</strong></label>
                                    <div class="col-sm-8">
                                        <select id="slc_presentacion_id" class="form-control">
                                            @foreach($presentaciones as $presentacion)
                                                <option value="{{ $presentacion->id }}">{{ $presentacion->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Volumen:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="txt_volumen">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Unidades por caja:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="txt_unidad">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Foto:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control" id="fil_foto">
                                    </div>
                                </div>
                            </div>`;
            $('.modal-titulo').html('Nuevo producto');
            $('.modal-body').html(formulario);
            $('.modal-footer').html(`<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                    <button id="btn_confirmar" class="btn btn-primary" onclick="ProductoAgregarConfirmar();">Aceptar</button>`);
            $('#btn_modal_mensaje').click();
        }

        function ProductoAgregarConfirmar(){
            var mensaje_error = '';
            var nombre = $('#txt_nombre').val();
            if(nombre == ''){
                mensaje_error += '<li>Ingrese el nombre del producto.</li>';
            }
            var sku = $('#txt_sku').val();
            if(sku == ''){
                mensaje_error += '<li>Ingrese el SKU del producto.</li>';
            }
            var volumen = $('#txt_volumen').val();
            if(volumen == ''){
                mensaje_error += '<li>Ingrese el Volumen del producto.</li>';
            }
            var unidad = $('#txt_unidad').val();
            if(unidad == ''){
                mensaje_error += '<li>Ingrese las unidades por caja del producto.</li>';
            }
            if(mensaje_error != ''){
                $('#div_errores').html('<ul>'+mensaje_error+'</ul>');
            }
            else{
                $('.loading-container').show();
                $('#btn_confirmar').prop('disabled', true);
                var token = jQuery("[name=_token]").val();
                var presentacion_id = jQuery('#slc_presentacion_id').val();
                var formData = new FormData();
                var foto = ($('#fil_foto')[0].files[0])?$('#fil_foto')[0].files[0]:'';
                formData.append('nombre', Codificar(nombre));
                formData.append('sku', Codificar(sku));
                formData.append('presentacion_id', Codificar(presentacion_id));
                formData.append('volumen', Codificar(volumen));
                formData.append('unidad', Codificar(unidad));
                formData.append('foto', foto);
                formData.append('_token', token);
                $.ajax({
                    url:'{{url("producto_nuevo")}}',
                    type:'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
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
                            $('#div_errores').html('<ul><li>Ya existe un registro con ese nombre, ingrese uno diferente.</li></ul>');
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

        function ProductoEditar(_producto_id){
            $('.loading-container').show();
            var token = jQuery("[name=_token]").val();
            $.ajax({
                url:'{{url("producto")}}',
                type:'POST',
                data:{
                    producto_id:Codificar(_producto_id),
                    _token:token
                },
                dataType: 'json',
                success: function (respuesta) {
                    $('.loading-container').hide();
                    let foto = (!respuesta.foto)?'<input type="file" class="form-control" id="fil_foto">':'<img width="200" src="img/productos/'+respuesta.foto+'"><br/><label><b>Cambiar:</b></label><input type="file" class="form-control" id="fil_foto">';
                    let sku = (respuesta.sku)?respuesta.sku:'';
                    let volumen = (respuesta.volumen)?respuesta.volumen:'';
                    let unidad = (respuesta.unidad)?respuesta.unidad:'';
                    let formulario =`<div class="card mr-5 ml-5">
                                        <div id="div_errores"></div>
                                        <div class="form-group row">
		                                    <label class="col-sm-4 col-form-label"><strong>Nombre:</strong></label>
		                                    <div class="col-sm-8">
		                                        <input type="text" class="form-control" id="txt_nombre" value="${respuesta.nombre}">
		                                    </div>
		                                </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><strong>SKU:</strong></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="txt_sku" value="${sku}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><strong>Presentacion:</strong></label>
                                            <div class="col-sm-8">
                                                <select id="slc_presentacion_id" class="form-control">
                                                    @foreach($presentaciones as $presentacion)
                                                        <option value="{{ $presentacion->id }}">{{ $presentacion->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><strong>Volumen:</strong></label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="txt_volumen" value="${volumen}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><strong>Unidad:</strong></label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="txt_unidad" value="${unidad}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><strong>foto:</strong></label>
                                            <div class="col-sm-8">
                                                ${foto}
                                            </div>
                                        </div>
                                    </div>`;
                    $('.modal-titulo').html('Editar Producto');
                    $('.modal-body').html(formulario);
                    $('.modal-footer').html(`<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                            <button id="btn_confirmar" class="btn btn-primary" onclick="ProductoEditarConfirmar('${_producto_id}');">Aceptar</button>`);
                    $('#btn_modal_mensaje').click();
                    $('#slc_presentacion_id option[value='+respuesta.presentacion_id+']').attr('selected','selected');
                },
                error: function(){
                    $('.modal-titulo').html('<label class="texto-rojo">Error de conexión. Intente nuevamente.</label>');
                    $('#div_errores').html('<ul><li>Error al editar la información. Revise su conexión a internet e intente nuevamente.</li></ul>');
                    $('.loading-container').hide();
                }
            });
        }

        function ProductoEditarConfirmar(_producto_id){
            var mensaje_error = '';
            var nombre = $('#txt_nombre').val();
            if(nombre == ''){
                mensaje_error += '<li>Ingrese el nombre del producto.</li>';
            }
            var sku = $('#txt_sku').val();
            if(sku == ''){
                mensaje_error += '<li>Ingrese el SKU del producto.</li>';
            }
            var volumen = $('#txt_volumen').val();
            if(volumen == ''){
                mensaje_error += '<li>Ingrese el Volumen del producto.</li>';
            }
            var unidad = $('#txt_unidad').val();
            if(unidad == ''){
                mensaje_error += '<li>Ingrese las unidades por caja del producto.</li>';
            }
            if(mensaje_error != ''){
                $('#div_errores').html('<ul>'+mensaje_error+'</ul>');
            }
            else{
                $('.loading-container').show();
                var token = jQuery("[name=_token]").val();
                $('#btn_confirmar').prop('disabled', true);
                var formData = new FormData();
                var presentacion_id = jQuery('#slc_presentacion_id').val();
                var foto = ($('#fil_foto')[0].files[0])?$('#fil_foto')[0].files[0]:'';
                formData.append('producto_id', Codificar(_producto_id));
                formData.append('nombre', Codificar(nombre));
                formData.append('sku', Codificar(sku));
                formData.append('presentacion_id', Codificar(presentacion_id));
                formData.append('volumen', Codificar(volumen));
                formData.append('unidad', Codificar(unidad));
                formData.append('foto', foto);
                formData.append('_token', token);
                $.ajax({
                    url:'{{url("producto_editar")}}',
                    type:'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (respuesta) {
                        if(parseInt(respuesta.res) == 1){
                            $('.modal-titulo').html('<label class="texto-verde">Exito.</label>');
                            $('.modal-body').html('Información editada exitosamente.');
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
                        $('#div_errores').html('<ul><li>Error al editar la información. Revise su conexión a internet e intente nuevamente.</li></ul>');
                        $('.loading-container').hide();
                        $('#btn_confirmar').prop('disabled', false);
                    }
                });
            }
        }

        function ProductoEliminar(_producto_id, _producto){
            let formulario = `<div class="card mr-5 ml-5">
                                <label>Está seguro de que quiere eliminar el Producto <b>${_producto}</b>?</label>  
                               </div>`;
            $('.modal-titulo').html('Eliminar producto');
            $('.modal-body').html(formulario);
            $('.modal-footer').html(`<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                    <button id="btn_confirmar" class="btn btn-danger" onclick="ProductoEliminarConfirmar(${_producto_id});">Eliminar</button>`);
            $('#btn_modal_mensaje').click();
        }

        function ProductoEliminarConfirmar(_producto_id){
            $('.loading-container').show();
            var token = jQuery("[name=_token]").val();
            $('#btn_confirmar').prop('disabled', true);
            $.ajax({
                url:'{{url("producto_eliminar")}}',
                type:'POST',
                data:{
                    producto_id:Codificar(_producto_id),
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
    </script>
@endsection