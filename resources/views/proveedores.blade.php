@extends('base')

@section('titulo') Proveedores @endsection

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

@section('titulo_seccion') Listado de proveedores <button class="btn btn-primary mb-1" onclick="ProveedorAgregar();">Nuevo</button>@endsection

@section('contenido')
	<div class="col-xl-12 col-lg-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <table class="table table-striped table-hover table-responsive table-condensed" id="tbl_proveedores">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Fecha de creación</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($proveedores) > 0)
	                    @foreach($proveedores as $indice => $proveedor)
							<tr>
                                <td>{{ ($indice+1) }}</td>
                                <td>{{ $proveedor->nombre }}</td>
                                <td>{{ $proveedor->created_at }}</td>
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
            $('#li_proveedores').addClass('active');
            $('#tbl_proveedores').dataTable({
                "pageLength": 50,
                "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
            });
        });

        function ProveedorAgregar(){
            let formulario =`<div class="card mr-5 ml-5">
                                <div id="div_errores"></div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Nombre:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="txt_nombre">
                                    </div>
                                </div>
                            </div>`;
            $('.modal-titulo').html('Nuevo proveedor');
            $('.modal-body').html(formulario);
            $('.modal-footer').html(`<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                    <button id="btn_confirmar" class="btn btn-primary" onclick="proveedorAgregarConfirmar();">Aceptar</button>`);
            $('#btn_modal_mensaje').click();
        }

        function proveedorAgregarConfirmar(){
            var mensaje_error = '';
            var nombre = $('#txt_nombre').val();
            if(nombre == ''){
                mensaje_error += '<li>Ingrese el nombre del proveedor.</li>';
            }
            if(mensaje_error != ''){
                $('#div_errores').html('<ul>'+mensaje_error+'</ul>');
            }
            else{
                $('.loading-container').show();
                $('#btn_confirmar').prop('disabled', true);
                var token = jQuery("[name=_token]").val();
                $.ajax({
                    url:'{{url("proveedor_nuevo")}}',
                    type:'POST',
                    data: {
                        nombre:Codificar(nombre),
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
    </script>
@endsection