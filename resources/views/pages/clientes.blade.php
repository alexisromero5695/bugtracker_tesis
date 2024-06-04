@extends('layouts.app')
@section('title')
<title>Clientes</title>
@endsection

@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/cropperjs"></script>
<link rel="stylesheet" type="text/css" href="{{asset('libs/treeview/hummingbird-treeview.css')}}">
<link rel="stylesheet" href="{{asset('libs/virtual-select/virtual-select.min.css')}}">
<script src="{{asset('libs/virtual-select/virtual-select.js')}}"></script>
<style>
    .modal-lg {
        max-width: 1000px !important;
    }

    .overlay {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        background-color: rgba(255, 255, 255, 0.5);
        overflow: hidden;
        height: 0;
        transition: .5s ease;
        width: 100%;
    }

    .treeview_container {
        border: 1px solid #dbdfea;
        width: 100%;
        border-radius: 8px;
        padding-top: 29px;
    }

    .d-none-2 {
        pointer-events: none;
        color: rgb(255, 255, 255);
    }
</style>

<!-- 
    --------------------------------------------------------------------------------
                                            MODALES
    --------------------------------------------------------------------------------    
-->
<div class="modal fade" data-backdrop="static" id="md-crear-cliente">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-crear-actualizar-cliente"></h5>
                <a href="#" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross "></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="form-crear-cliente" class="form-validate is-alter">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label" for="full-name">Número de documento <strong class="text-danger">*</strong> </label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="numero_documento" name="numero_documento" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="form-label" for="full-name">Nombre / Razón Social <strong class="text-danger">*</strong> </label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Giro <strong class="text-danger">*</strong> </label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="giro" name="giro" required>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="row  mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Correo <strong class="text-danger">*</strong> </label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="correo" name="correo" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Teléfono <strong class="text-danger">*</strong> </label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row  mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Dirección </label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="direccion" name="direccion">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Sitio Web </label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="sitio_web" name="sitio_web">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-md btn-outline-light mr-1" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn-crear-cliente" class="btn btn-md btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">

            </div>
        </div>
    </div>
</div>

<!-- 
    --------------------------------------------------------------------------------
                                            CUERPO
    --------------------------------------------------------------------------------    
-->
<div class="nk-content pt-0">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview  mx-auto">


                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">

                            </div>
                        </div>

                        <div class="card card-preview">
                            <div class="card-inner">
                                <div class="w-100">
                                    <nav aria-label="breadcrumb">
                                        <ol class="default-breadcrumb">
                                            <li class="crumb">
                                                <div class="link"><em class="icon ni ni-users <?php echo $breadcrumb[count($breadcrumb) - 1]['icono_modulo'] ?>"></em></div>
                                            </li>
                                            @foreach($breadcrumb as $key => $item)
                                            <li class="crumb <?php echo ($key == count($breadcrumb) - 1) ? "active" : "" ?>">
                                                <div class="link text-uppercase"><a href="javascript:void(0)">{{$item['nombre_modulo']}}</a></div>
                                            </li>
                                            @endforeach
                                        </ol>
                                    </nav>
                                </div>

                                <h5 for="">Filtro de búsqueda</h5>
                                <div style="background-color: #f5f6fa;padding: 0.5rem;" id="filtro_busqueda" class="px-1 d-none mb-4">
                                    <div class="input-group ">
                                        <input type="text" class="form-control" placeholder="Buscar clientes" aria-label="Buscar clientes" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button"><em class="icon ni ni-search"></em><span class="m-0">Buscar</span></button>
                                        </div>
                                    </div>
                                </div>


                                <table id="tbl-cliente" class="table table-striped table-bordered w-100">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col tb-col-lg font-weight-normal"><span class="sub-text"></span></th>
                                            <th class="nk-tb-col font-weight-normal"><span class="sub-text">NRO. DOCUMENTO</span></th>
                                            <th class="nk-tb-col tb-col-mb font-weight-normal"><span class="sub-text">NOMBRE</span></th>
                                            <th class="nk-tb-col tb-col-mb font-weight-normal"><span class="sub-text">TELÉFONO</span></th>
                                            <th class="nk-tb-col tb-col-mb font-weight-normal"><span class="sub-text">EMAIL</span></th>
                                            <th class="nk-tb-col tb-col-lg font-weight-normal"><span class="sub-text"></span></th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    /* ------------------------------------------------------------------
                 FUNCIONES CREACION cliente    
    ------------------------------------------------------------------ */

    var id_cliente = 0;
    $(document).on('click', '#btn-md-crear-cliente', function() {
        id_cliente = 0;
        ResetForm('form-crear-cliente');
        $("#titulo-crear-actualizar-cliente").html('Nuevo Cliente');
        $("#md-crear-cliente").modal('show');
    })

    $(document).on('click', '.btn-md-editar-cliente', function() {
        ResetForm('form-crear-cliente');
        id_cliente = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: "{{url('traer-cliente')}}",
            async: false,
            data: {
                id_cliente
            },
            success: function(data) {
                $("#nombre").val(data.nombre_cliente);
                $("#numero_documento").val(data.documento_cliente);
                $("#telefono").val(data.telefono_cliente);
                $("#giro").val(data.giro_cliente);
                $("#correo").val(data.correo_cliente);
                $("#direccion").val(data.direccion_cliente);
                $("#sitio_web").val(data.sitio_web_cliente);
            }
        })
        $("#titulo-crear-actualizar-cliente").html('Editar Cliente');
        $("#md-crear-cliente").modal('show');
    })


    $(document).on('click', '#btn-crear-cliente', function() {
        if (!$('#form-crear-cliente').valid()) {
            DevExpress.ui.notify({
                position: 'top',
                message: "Complete todos los campos obligatorios",
                width: 200,
                shading: false,
            }, "error", 800);
            return false;
        };
        $(".invalid-feedback").remove();
        $(".form-control").removeClass("is-invalid");
        let btn = $(this);
        $(btn).prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: "{{url('crear-cliente')}}",
            data: $('#form-crear-cliente').serialize() + '&id_cliente=' + encodeURIComponent(id_cliente),
            async: false,
            success: function(data) {
                DevExpress.ui.notify({
                    position: 'top',
                    message: (id_cliente == 0) ? "Cliente creado exitosamente" : "Cliente actualizado exitosamente",
                    width: 200,
                    shading: false,
                }, "success", 800);
                $('#tbl-cliente').DataTable().ajax.reload();
                $("#md-crear-cliente").modal('hide');
            },
            error: function(xhr, status, error) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(field, messages) {
                    var $input = $('[name="' + field + '"]');
                    $input.addClass('is-invalid');
                    var parentElement = $input.parent();
                    if (parentElement.hasClass('input-group')) {
                        parentElement = parentElement.parent();
                    }
                    parentElement.append($('<div>').addClass('invalid-feedback').html(messages));
                });

                DevExpress.ui.notify({
                    position: 'top',
                    message: "Ocurrio un error",
                    width: 200,
                    shading: false,
                }, "error", 800);
                console.error('Error: ' + error);
            }
        })

        $(btn).prop('disabled', false);
    });


    $(document).on('click', '.btn-md-eliminar-cliente', function() {
        id_cliente = $(this).data("id");

        var customDialog = DevExpress.ui.dialog.custom({
            title: "Confirmación de eliminación",
            message: "¿Está seguro de que desea eliminar este cliente?",
            toolbarItems: [{
                    text: "NO",
                    onClick: function() {
                        return false
                    },
                    focusStateEnabled: false
                },
                {
                    text: "SI",
                    onClick: function() {
                        return true
                    }
                }
            ],
        });

        setTimeout(function() {
            $(".dx-dialog-button:last").addClass("dx-state-focused");
        }, 100);

        customDialog.show().done(function(dialogResult) {
            if (dialogResult) {
                $.ajax({
                    type: 'POST',
                    url: "{{url('eliminar-cliente')}}",
                    async: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id_cliente,
                    },
                    success: function(data) {
                        $('#tbl-cliente').DataTable().ajax.reload();
                        DevExpress.ui.notify({
                            position: 'top',
                            message: "Cliente eliminado exitosamente",
                            width: 300,
                            shading: false,
                        }, "success", 800);
                    }
                })
            }
        });

    })

    var cropper;
    var image = document.getElementById('sample_image');
    $(document).ready(function() {
        $("#filtro_busqueda").removeClass("d-none");
        $.validator.setDefaults({
            ignore: []
        });
        /* ------------------------------------------------------------------
             INICIALIZACION LIBRERIAS VALIDACION, DATATABLE, SUMMERNOTE
        ------------------------------------------------------------------ */

        $("#form-crear-cliente").validate({
            ignore: ':hidden:not(:disabled),[readonly]', // No ignorar campos readonly
            rules: {
                numero_documento: "required",
                nombre: "required",
                giro: "required",
                telefono: {
                    required: true,
                    number: true // Validar que el campo sea numérico
                },
                correo: {
                    required: true,
                    email: true,
                }
            },
            messages: {
                numero_documento: 'Este campo es requerido.',
                nombre: 'Este campo es requerido.',
                giro: 'Este campo es requerido.',
                telefono: {
                    required: 'Este campo es requerido.',
                    number: 'Ingrese solo números.'
                },
                correo: {
                    required: 'Ingrese un correo electrónico.',
                    email: 'Ingrese un correo electrónico válido.',
                }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.parent("label"));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("border border-danger");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass("border border-danger");
            }
        });

        $('#tbl-cliente').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay datos",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(Filtro de _MAX_ total registros)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ registros",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "cliente no encontrado",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": Activar orden de columna ascendente",
                    "sortDescending": ": Activar orden de columna desendente"
                }

            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('tabla-clientes')}}",
                "type": 'GET',
            },
            "order": [
                [0, 'asc']
            ],        
            "searching": false, // Aquí se oculta la barra de búsqueda
            dom: "<'row'<'col-sm-6'l><'col-sm-6 text-right'<'custom-button'>>>" + // Aquí defines tu propia estructura con el botón
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>", // Estructura predeterminada para la paginación e información
            initComplete: function () { // Aquí puedes añadir tu botón personalizado
                $('.custom-button').html('<button type="button" class="btn btn-primary" id="btn-md-crear-cliente" data-toggle="modal">Nuevo Cliente&nbsp<em class="icon ni ni-plus-c"></em></button>');
            },
            "pageLength": 10,
            "columns": [{
                    "data": "orden",
                    'visible': false,

                },
                {
                    "data": "documento",
                    'className': 'align-middle',
                    "orderable": false,
                },
                {
                    "data": 'nombre',
                    'className': 'align-middle',
                    "orderable": false,
                },
                {
                    "data": "telefono",
                    'className': 'align-middle',
                    "orderable": false,
                },
                {
                    "data": "correo",
                    'className': 'align-middle',
                    "orderable": false,
                },
                {
                    "data": "accion",
                    'className': 'align-middle',
                    "orderable": false,
                },
            ],

        });

    });
</script>
@endsection

@section('scripts')
<script src="{{asset('js/libs/datatable-btns.js?ver=2.9.0')}}"></script>
<link rel="stylesheet" href="{{asset('css/editors/summernote.css?ver=2.9.0')}}">
<script src="{{asset('js/libs/editors/summernote.js?ver=2.9.0')}}"></script>
<script src="{{asset('libs/treeview/hummingbird-treeview.js')}}"></script>

@endsection