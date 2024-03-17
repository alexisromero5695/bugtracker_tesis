@extends('layouts.app')
@section('title')
<title>Usuarios</title>
@endsection

@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/cropperjs"></script>
<link rel="stylesheet" type="text/css" href="{{asset('libs/treeview/hummingbird-treeview.css')}}">

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
<div class="modal fade" data-backdrop="static" id="md-crear-usuario">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-crear-actualizar-usuario"></h5>
                <a href="#" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross "></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="form-crear-usuario" class="form-validate is-alter">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label" for="full-name">Número de documento <strong class="text-danger">*</strong> </label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="numero_documento" name="numero_documento" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="full-name">Nombres <strong class="text-danger">*</strong> </label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                    </div>

                    <div class="row  mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Apellido Paterno <strong class="text-danger">*</strong> </label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Apellido Materno <strong class="text-danger">*</strong> </label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Perfil <strong class="text-danger">*</strong> </label>
                                <div class="form-control-wrap">
                                    <select class="form-control" id="perfil" name="perfil" data-search="on">
                                        <option value=""></option>
                                        @foreach($perfiles as $item)
                                            <option value="{{$item->id_perfil}}">{{$item->nombre_perfil}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    
                    </div>

                    <div class="row  mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Teléfono <strong class="text-danger">*</strong> </label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Correo <strong class="text-danger">*</strong> </label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="correo" name="correo" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row  mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Contraseña <strong class="text-danger">*</strong> </label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="contrasenia" name="contrasenia" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Confirmar contraseña <strong class="text-danger">*</strong> </label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="confirmar_contrasenia" name="confirmar_contrasenia" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-md btn-outline-light mr-1" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn-crear-usuario" class="btn btn-md btn-primary">Guardar</button>
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

                                <div class="w-100 d-flex justify-content-between align-items-center mb-5">
                                    <h4 class="nk-block-title mb-0">TODOS LOS USUARIOS</h4>
                                    <button type="button" class="btn btn-primary" id="btn-md-crear-usuario" data-toggle="modal">Nuevo Usuario</button>
                                </div>


                                <table id="tbl-usuario" class="table table-striped table-bordered w-100">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col tb-col-lg font-weight-normal"><span class="sub-text"></span></th>
                                            <th class="nk-tb-col font-weight-normal"><span class="sub-text">NRO. DOCUMENTO</span></th>
                                            <th class="nk-tb-col tb-col-mb font-weight-normal"><span class="sub-text">NOMBRE</span></th>
                                            <th class="nk-tb-col tb-col-mb font-weight-normal"><span class="sub-text">APELLIDOS</span></th>
                                            <th class="nk-tb-col tb-col-mb font-weight-normal"><span class="sub-text">TELÉFONO</span></th>
                                            <th class="nk-tb-col tb-col-mb font-weight-normal"><span class="sub-text">EMAIL</span></th>
                                            <th class="nk-tb-col tb-col-mb font-weight-normal"><span class="sub-text">PERFIL</span></th>
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
    var show_modal_upload = 0;
    var upload_image = 0;
    var perfiles = <?php echo json_encode($perfiles) ?>
   
    /* ------------------------------------------------------------------
                 FUNCIONES CREACION usuario
    ------------------------------------------------------------------ */


    var id_staff = 0;
    $(document).on('click', '#btn-md-crear-usuario', function() {
        id_staff = 0;
        $('#contrasenia').prop('readonly', false);
        $('#confirmar_contrasenia').prop('readonly', false); 
        ResetForm('form-crear-usuario');
        $("#titulo-crear-actualizar-usuario").html('Nuevo Usuario');
      
        $("#md-crear-usuario").modal('show');
    })

    $(document).on('click', '.btn-md-editar-usuario', function() {  
        ResetForm('form-crear-usuario');
        id_staff = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: "{{url('traer-usuario')}}",
            async: false,
            data: {
                id_staff
            },
            success: function(data) {
                $("#nombre").val(data.nombre_staff);
                $("#apellido_paterno").val(data.apellido_paterno_staff);
                $("#apellido_materno").val(data.apellido_materno_staff);
                $("#numero_documento").val(data.documento_staff);      
                // $("#nombre").val(data.direccion_staff);
                $("#telefono").val(data.telefono_staff);
                $("#perfil").val(data.id_perfil);
                $("#correo").val(data.correo_usuario);
            }
        })
        $("#titulo-crear-actualizar-usuario").html('Editar Usuario');
        $('#contrasenia').prop('readonly', true);
        $('#confirmar_contrasenia').prop('readonly', true); 
        $("#md-crear-usuario").modal('show');
    })


    $(document).on('click', '#btn-crear-usuario', function() {
        if (!$('#form-crear-usuario').valid()) {
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
            url: "{{url('crear-usuario')}}",
            data: $('#form-crear-usuario').serialize() + '&id_staff=' + encodeURIComponent(id_staff),
            async: false,
            success: function(data) {
                DevExpress.ui.notify({
                    position: 'top',
                    message: (id_staff == 0) ? "usuario creado exitosamente" : "usuario actualizado exitosamente",
                    width: 200,
                    shading: false,
                }, "success", 800);
                $('#tbl-usuario').DataTable().ajax.reload();
                $("#md-crear-usuario").modal('hide');
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



    var cropper;
    var image = document.getElementById('sample_image');
    $(document).ready(function() {        
        $.validator.setDefaults({
            ignore: []
        });

        /* ------------------------------------------------------------------
             INICIALIZACION LIBRERIAS VALIDACION, DATATABLE, SUMMERNOTE
        ------------------------------------------------------------------ */       

        $("#form-crear-usuario").validate({
            ignore: ':hidden:not(:disabled),[readonly]', // No ignorar campos readonly
            rules: {
                numero_documento: "required",
                nombre: "required",
                apellido_paterno: "required",
                apellido_materno: "required",
                perfil: "required",
                telefono: {
                    required: true,
                    number: true // Validar que el campo sea numérico
                },
                correo: {
                    required: true,
                    email: true,
                },
                contrasenia: {
                    required: true,
                    minlength: 8,
                },
                confirmar_contrasenia: {
                    required: true,
                    equalTo: '#contrasenia',
                }
            },
            messages: {
                numero_documento: 'Este campo es requerido.',
                nombre: 'Este campo es requerido.',
                apellido_paterno: 'Este campo es requerido.',
                apellido_materno: 'Este campo es requerido.',
                perfil: 'Este campo es requerido.',
                telefono: {
                    required: 'Este campo es requerido.',
                    number: 'Ingrese solo números.'
                },
                correo: {
                    required: 'Ingrese un correo electrónico.',
                    email: 'Ingrese un correo electrónico válido.',
                },
                contrasenia: {
                    required: 'Ingrese una contraseña.',
                    minlength: 'La contraseña debe tener al menos {0} caracteres.',
                },
                confirmar_contrasenia: {
                    required: 'Confirme su contraseña.',
                    equalTo: 'Las contraseñas no coinciden.',
                },
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

        $('#tbl-usuario').DataTable({
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
                "zeroRecords": "usuario no encontrado",
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
                "url": "{{ url('tabla-usuarios')}}",
                "type": 'GET',
            },
            "order": [
                [0, 'asc']
            ], // 0 es el índice de la columna "orden"
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
                    "data": 'apellidos',
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
                    "data": "perfil",
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