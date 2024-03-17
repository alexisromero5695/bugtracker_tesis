@extends('layouts.app')
@section('title')
<title>Proyectos</title>
@endsection

@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/cropperjs"></script>

<style>
    .image_area {
        position: relative;
    }

    img {
        display: block;
        max-width: 100%;
    }

    .preview {
        overflow: hidden;
        width: 10em;
        height: 10em;
        margin: 10px;
        border: 1px solid red;
    }

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

    .image_area:hover .overlay {
        height: 50%;
        cursor: pointer;
    }

    .text {
        color: #333;
        font-size: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        text-align: center;
    }
</style>

<!-- 
    --------------------------------------------------------------------------------
                                            MODALES
    --------------------------------------------------------------------------------    
-->
<div class="modal fade" data-backdrop="static" id="md-crear-proyecto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Proyecto</h5>
                <a href="#" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross "></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="form-crear-proyecto" class="form-validate is-alter">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nombre <strong class="text-danger">*</strong> </label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email-address">Clave <strong class="text-danger">*</strong></label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="codigo" name="codigo" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email-address">Avatar <strong class="text-danger">*</strong></label>
                        <div class="form-control-wrap d-flex align-items-center">
                            <div class="user-avatar sq">
                                <img style="image-rendering: -webkit-optimize-contrast;" id="avatar_image" src="" alt="">
                            </div>
                            <a type="button" id="btn_avatar" class="ml-2" href="javascript:void(0);">Seleccionar imagen</a>
                        </div>
                        <input type="text" class="form-control d-none" id="avatar" name="avatar">


                    </div>
                    <div class="form-group">
                        <label class="form-label" for="phone-no">Responsable</label>
                        <div class="form-control-wrap">
                            <select id="staff" name="staff" data-search="on" class="form-select">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fecha de Inicio</label>
                        <div class="form-control-wrap">
                            <div class="form-icon form-icon-left">
                                <em class="icon ni ni-calendar-alt"></em>
                            </div>
                            <input data-date-format="dd-mm-yyyy" id="fecha_inicio" name="fecha_inicio" type="text" class="form-control date-picker">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pay-amount">Fecha de Fin</label>
                        <div class="form-control-wrap">
                            <div class="form-icon form-icon-left">
                                <em class="icon ni ni-calendar-alt"></em>
                            </div>
                            <input data-date-format="dd-mm-yyyy" id="fecha_fin" name="fecha_fin" type="text" class="form-control date-picker">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Descripción</label>
                        <div name="descripcion" id="descripcion" class="summernote-minimal"></div>
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="button" class="btn btn-md btn-outline-light" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn-crear-proyecto" class="btn btn-md btn-primary">Agregar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" id="md-listar-avatar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Avatar</h5>
                <a href="#" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <label for="upload_avatar" class="btn btn-round  btn-success m-0">Subir un nuevo avatar</label>
                </div>

                <div class="custom-file d-none">
                    <input type="file" class="custom-file-input" id="upload_avatar">
                    <label class="custom-file-label" for="upload_avatar">Seleccionar imagen</label>
                </div>
                <hr>
                <div id="avatars">

                </div>
                <div class="form-group d-flex justify-content-end mt-2">
                    <button type="button" class="btn btn-sm btn-outline-light " data-dismiss="modal">Cancelar</button>
                </div>

            </div>


            <div class="modal-footer bg-light">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" id="md-subir-avatar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subir Avatar</h5>
                <a href="#" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="" id="sample_image" />
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
                <div class="div w-100 text-right mt-2">
                    <button type="button" class="btn btn-lg btn-outline-light" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-lg btn-primary" id="btn_upload_avatar">Agregar</button>
                </div>

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
                                    <h4 class="nk-block-title mb-0">TODOS LOS PROYECTOS</h4>
                                    <button type="button" class="btn btn-primary" id="btn-md-crear-proyecto" data-toggle="modal">Nuevo Proyecto</button>
                                </div>


                                <table id="tbl-proyecto" class="table table-striped table-bordered w-100">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col font-weight-normal"><span class="sub-text">Nombre</span></th>
                                            <th class="nk-tb-col tb-col-mb font-weight-normal"><span class="sub-text">Clave</span></th>
                                            <th class="nk-tb-col tb-col-md font-weight-normal"><span class="sub-text">Responsable</span></th>
                                            <th class="nk-tb-col tb-col-lg font-weight-normal"><span class="sub-text">Fecha Inicio</span></th>
                                            <th class="nk-tb-col tb-col-lg font-weight-normal"><span class="sub-text"></span></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div><!-- .card-preview -->
                    </div> <!-- nk-block -->
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>
</div>



<script>
    var show_modal_upload = 0;
    var upload_image = 0;
    /* ------------------------------------------------------------------
                 FUNCIONES CREACION PROYECTO
    ------------------------------------------------------------------ */

    $(document).on('click', '#btn-md-crear-proyecto', function() {
        upload_image = 0;
        show_modal_upload = 0;
        $("#avatar_image").attr('src', '/images/default/default-600.png');

        ResetForm('form-crear-proyecto');
        $.ajax({
            type: 'GET',
            url: "{{url('listar-staff')}}",
            async: false,
            success: function(data) {
                var html = `<option selected disabled>Seleccionar</option>`;
                $.each(data, function(i, item) {
                    html += `<option value="${item.id_staff}">${item.nombre_staff} ${item.apellido_paterno_staff} ${item.apellido_materno_staff}</option>`;
                })
                $("#staff").html(html);
            },
            error: function(error) {
                console.error('Error: ' + error);
            }
        })
        $("#md-crear-proyecto").modal('show');
    })


    $(document).on('click', '#btn-crear-proyecto', function() {
        if (!$('#form-crear-proyecto').valid()) {
            DevExpress.ui.notify({
                position: 'top',
                message: "Complete todos los campos obligatorios",
                width: 200,
                shading: false,
            }, "error", 800);
            return false;
        };

        let btn = $(this);
        $(btn).prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: "{{url('crear-proyecto')}}",
            data: $('#form-crear-proyecto').serialize() + '&descripcion=' + encodeURIComponent($('#description').summernote('code')),
            async: false,
            success: function(data) {
                DevExpress.ui.notify({
                    position: 'top',
                    message: "Proyecto creado exitosamente",
                    width: 200,
                    shading: false,
                }, "success", 800);
                $('#tbl-proyecto').DataTable().ajax.reload();
            },
            error: function(error) {
                DevExpress.ui.notify({
                    position: 'top',
                    message: "Ocurrio un error",
                    width: 200,
                    shading: false,
                }, "error", 800);
                console.error('Error: ' + error);
            }
        })
        $("#md-crear-proyecto").modal('hide');
        $(btn).prop('disabled', false);
    });



    var cropper;
    var image = document.getElementById('sample_image');
    $(document).ready(function() {
        $.validator.setDefaults({
            ignore: []
        });
        /* ------------------------------------------------------------------
                        FUNCIONES PARA SUBIR AVATAR
        ------------------------------------------------------------------ */
        $(document).on('click', '#btn_avatar', function() {
            $("#md-crear-proyecto").modal('hide');
            $.ajax({
                type: 'GET',
                url: "{{url('listar-avatar')}}",
                async: false,
                success: function(data) {
                    var html = ``;
                    $.each(data, function(i, item) {
                        html += `<li class="preview-item">
                                <div class="user-avatar sq">
                                    <img data-id="${item.id_avatar}" role="button" class="option_avatar" src='/files/avatar/${item.imagen_avatar}' alt=''>
                                </div>
                            </li>`;
                    })
                    html = `<ul class="preview-list g-2">${html}</ul>`
                    $("#avatars").html(html);
                },
                error: function(error) {
                    console.error('Error: ' + error);
                }
            })
            setTimeout(() => {
                $("#md-listar-avatar").modal('show');
            }, 200);
        })

        $('#upload_avatar').change(function(event) {
            var files = event.target.files;
            var done = function(url) {
                image.src = url;
                $("#md-listar-avatar").modal('hide');
                show_modal_upload = 1;
                setTimeout(() => {
                    $("#md-subir-avatar").modal('show');
                }, 200);
            };
            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function(event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $("#md-subir-avatar").on('shown.bs.modal', function() {
            if (cropper != null) {
                cropper.destroy();
            }
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });

        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
            setTimeout(() => {
                show_modal_upload = 0;
                if (upload_image == 0) {
                    $("#md-listar-avatar").modal('show');
                }

            }, 200);
        });

        $("#md-listar-avatar").on('hidden.bs.modal', function() {
            setTimeout(() => {
                if (show_modal_upload == 0) {
                    $("#md-crear-proyecto").modal('show');
                }
            }, 200);
        });

        $(document).on('click', '#btn_upload_avatar', function() {
            canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $.ajax({
                        url: "{{url('subir-avatar')}}",
                        method: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            image: base64data
                        },
                        success: function(data) {
                            show_modal_upload = 0;
                            upload_image = 1;
                            $("#md-subir-avatar").modal('hide');
                            $('#avatar_image').attr('src', data.imagen_avatar);
                            $('#avatar').val(data.id_avatar);
                            $('#form-crear-proyecto').valid();
                            setTimeout(() => {
                                $("#md-crear-proyecto").modal('show');
                            }, 200);
                        }
                    });
                };
            });
        })

        $(document).on('click', '.option_avatar', function() {
            $("#avatar_image").attr('src', $(this).attr('src'));
            $('#avatar').val($(this).data('id'));
            $("#md-listar-avatar").modal('hide');
            $('#form-crear-proyecto').valid();
            setTimeout(() => {
                $("#md-crear-proyecto").modal('show');
            }, 200);
        });

        /* ------------------------------------------------------------------
             INICIALIZACION LIBRERIAS VALIDACION, DATATABLE, SUMMERNOTE
        ------------------------------------------------------------------ */
        $("#form-crear-proyecto").validate({
            rules: {
                nombre: "required",
                codigo: "required",
                avatar: "required",
            },
            messages: {
                nombre: "Este campo es requerido",
                codigo: "Este campo es requerido",
                avatar: "Este campo es requerido",
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

        $('#tbl-proyecto').DataTable({
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
                "zeroRecords": "Proyecto no encontrado",
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
                "url": "{{ url('tabla-proyectos')}}",
                "type": 'GET',
            },

            "columns": [{
                    "data": "nombre",
                    'className':'align-middle',
                },
                {
                    "data": 'codigo',
                    'className': 'align-middle',
                },
                {
                    "data": "staff",
                    'className': 'align-middle',
                },
                {
                    "data": "fecha_inicio",
                    'className': 'align-middle',
                },
                {
                    "data": "accion",
                    'className': 'align-middle',
                },
            ]
        });
        var _minimal = '.summernote-minimal';
        if ($(_minimal).exists()) {
            $(_minimal).each(function() {
                $(this).summernote({
                    placeholder: 'Descripción del proyecto',
                    tabsize: 2,
                    height: 120,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['view', ['fullscreen']]
                    ]
                });
            });
        }
    });
</script>
@endsection

@section('scripts')
<script src="{{asset('js/libs/datatable-btns.js?ver=2.9.0')}}"></script>
<link rel="stylesheet" href="{{asset('css/editors/summernote.css?ver=2.9.0')}}">
<script src="{{asset('js/libs/editors/summernote.js?ver=2.9.0')}}"></script>

@endsection