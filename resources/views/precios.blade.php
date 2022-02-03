@extends('base')

@section('titulo') Precios @endsection

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

@section('titulo_seccion') Listado de Precios <button class="btn btn-primary mb-1" onclick="PrecioAgregar();">Nuevo</button>@endsection

@section('contenido')
	<div class="col-xl-12 col-lg-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <table class="table table-striped table-hover table-responsive table-condensed" id="tbl_precios">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Proveedor</th>
                            <th>Producto</th>
                            <th>Presentación</th>
                            <th>Precio</th>
                            <th>Fecha de creación</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($precios) > 0)
	                    @foreach($precios as $indice => $precio)
							<tr>
                                <td>{{ ($indice+1) }}</td>
                                <td>{{ $precio->proveedor->nombre }}</td>
                                <td>{{ $precio->producto->nombre }}</td>
                                <td>{{ $precio->producto->presentacion->nombre }}</td>
                                <td>{{ $precio->precio }}</td>
                                <td>{{ $precio->created_at }}</td>
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
            $('#li_precios').addClass('active');
            $('#tbl_precios').dataTable({
                "pageLength": 50,
                "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
            });
        });

        function PrecioAgregar(){
            let formulario =`<div class="card mr-5 ml-5">
                                <div id="div_errores"></div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Proveedor:</strong></label>
                                    <div class="col-sm-8">
                                        <select id="slc_proveedor_id" class="form-control">
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Producto:</strong></label>
                                    <div class="col-sm-8">
                                        <select id="slc_producto_id" class="form-control">
                                            @foreach($productos as $producto)
                                                <option value="{{ $producto->id }}">{{ $producto->nombre }} - {{ $producto->presentacion->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Precio:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="txt_precio">
                                    </div>
                                </div>
                            </div>`;
            $('.modal-titulo').html('Nuevo precio');
            $('.modal-body').html(formulario);
            $('.modal-footer').html(`<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                    <button id="btn_confirmar" class="btn btn-primary" onclick="PrecioAgregarConfirmar();">Aceptar</button>`);
            $('#btn_modal_mensaje').click();
        }

        function PrecioAgregarConfirmar(){
            var mensaje_error = '';
            var precio = $('#txt_precio').val();
            if(precio == ''){
                mensaje_error += '<li>Ingrese el precio del producto.</li>';
            }
            if(mensaje_error != ''){
                $('#div_errores').html('<ul>'+mensaje_error+'</ul>');
            }
            else{
                var proveedor_id = $('#slc_proveedor_id').val();
                var producto_id = $('#slc_producto_id').val();
                $('.loading-container').show();
                $('#btn_confirmar').prop('disabled', true);
                var token = jQuery("[name=_token]").val();
                $.ajax({
                    url:'{{url("precio_nuevo")}}',
                    type:'POST',
                    data: {
                        proveedor_id:Codificar(proveedor_id),
                        producto_id:Codificar(producto_id),
                        precio:Codificar(precio),
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
                            $('#div_errores').html('<ul><li>Ya existe un precio para ese producto y ese proveedor, ingrese uno diferente.</li></ul>');
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