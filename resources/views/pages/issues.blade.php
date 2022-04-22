@extends('layouts.app')
@section('title')
<title>Incidencias</title>
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
<div class="modal fade" data-backdrop="static" id="modal_new_project">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Proyecto</h5>
                <a href="#" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross "></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="newProjectForm" class="form-validate is-alter">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nombre <strong class="text-danger">*</strong> </label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email-address">Clave <strong class="text-danger">*</strong></label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="code" name="code" required>
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
                            <input data-date-format="dd-mm-yyyy" id="start_date" name="start_date" type="text" class="form-control date-picker">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pay-amount">Fecha de Fin</label>
                        <div class="form-control-wrap">
                            <div class="form-icon form-icon-left">
                                <em class="icon ni ni-calendar-alt"></em>
                            </div>
                            <input data-date-format="dd-mm-yyyy" id="end_date" name="end_date" type="text" class="form-control date-picker">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Descripción</label>
                        <div name="description" id="description" class="summernote-minimal"></div>
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="button" class="btn btn-md btn-outline-light" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn_save_new_project" class="btn btn-md btn-primary">Agregar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" id="modal_list_avatar">
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

<div class="modal fade" data-backdrop="static" id="modal_upload_avatar">
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
                                    @if($project_id)
                                    <h4 class="nk-block-title mb-0">{{$project['title']}} - {{$project['code']}}</h4>
                                    @else
                                    <h4 class="nk-block-title mb-0">Todas las incidencias</h4>
                                    @endif
                                    <button type="button" class="btn btn-primary" id="btn_new_project" data-toggle="modal">Nueva Incidencia</button>
                                </div>

                                <div class="table-responsive">
                                    <table id="tabla_issues" style="font-size: 0.71rem!important;" class="table table-striped table-bordered w-100">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col font-weight-normal text-center"><span class="sub-text">Tipo</span></th>
                                                <th class="nk-tb-col font-weight-normal text-center"><span class="sub-text">Clave</span></th>
                                                <th class="nk-tb-col tb-col-mb font-weight-normal text-center"><span class="sub-text">Resumen</span></th>
                                                <th class="nk-tb-col tb-col-mb font-weight-normal text-center"><span class="sub-text">Persona Asignada</span></th>
                                                <th class="nk-tb-col tb-col-mb font-weight-normal text-center"><span class="sub-text">Informador</span></th>
                                                <th class="nk-tb-col tb-col-mb font-weight-normal text-center"><span class="sub-text">Pr</span></th>
                                                <th class="nk-tb-col tb-col-mb font-weight-normal text-center"><span class="sub-text">Estado</span></th>
                                                <th class="nk-tb-col tb-col-md font-weight-normal text-center"><span class="sub-text">Resolución</span></th>
                                                <th class="nk-tb-col tb-col-lg font-weight-normal text-center"><span class="sub-text">Creado</span></th>
                                                <th class="nk-tb-col tb-col-lg font-weight-normal text-center"><span class="sub-text">Actualización</span></th>
                                                <th class="nk-tb-col tb-col-lg font-weight-normal text-center"><span class="sub-text">Vencimiento</span></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

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

    $(document).on('click', '#btn_new_project', function() {
        upload_image = 0;
        show_modal_upload = 0;
        $("#avatar_image").attr('src', '/images/default/default-600.png');

        ResetForm('newProjectForm');
        $.ajax({
            type: 'GET',
            url: "{{url('get-staffs')}}",
            async: false,
            success: function(data) {
                var html = `<option selected disabled>Seleccionar</option>`;
                $.each(data, function(i, item) {
                    html += `<option value="${item.id}">${item.first_name} ${item.last_name}</option>`;
                })
                $("#staff").html(html);
            },
            error: function(error) {
                console.error('Error: ' + error);
            }
        })
        $("#modal_new_project").modal('show');
    })


    $(document).on('click', '#btn_save_new_project', function() {
        if (!$('#newProjectForm').valid()) {
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
            url: "{{url('create-project')}}",
            data: $('#newProjectForm').serialize() + '&description=' + encodeURIComponent($('#description').summernote('code')),
            async: false,
            success: function(data) {
                DevExpress.ui.notify({
                    position: 'top',
                    message: "Proyecto creado exitosamente",
                    width: 200,
                    shading: false,
                }, "success", 800);
                $('#tabla_issues').DataTable().ajax.reload();
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
        $("#modal_new_project").modal('hide');
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
            $("#modal_new_project").modal('hide');
            $.ajax({
                type: 'GET',
                url: "{{url('get-avatars')}}",
                async: false,
                success: function(data) {
                    var html = ``;
                    $.each(data, function(i, item) {
                        html += `<li class="preview-item">
                                <div class="user-avatar sq">
                                    <img data-id="${item.id}" role="button" class="option_avatar" src='/files/avatar/${item.path}' alt=''>
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
                $("#modal_list_avatar").modal('show');
            }, 200);
        })

        $('#upload_avatar').change(function(event) {
            var files = event.target.files;
            var done = function(url) {
                image.src = url;
                $("#modal_list_avatar").modal('hide');
                show_modal_upload = 1;
                setTimeout(() => {
                    $("#modal_upload_avatar").modal('show');
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

        $("#modal_upload_avatar").on('shown.bs.modal', function() {
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
                    $("#modal_list_avatar").modal('show');
                }

            }, 200);
        });

        $("#modal_list_avatar").on('hidden.bs.modal', function() {
            setTimeout(() => {
                if (show_modal_upload == 0) {
                    $("#modal_new_project").modal('show');
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
                        url: "{{url('upload-avatar')}}",
                        method: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            image: base64data
                        },
                        success: function(data) {
                            show_modal_upload = 0;
                            upload_image = 1;
                            $("#modal_upload_avatar").modal('hide');
                            $('#avatar_image').attr('src', data.path);
                            $('#avatar').val(data.id);
                            $('#newProjectForm').valid();
                            setTimeout(() => {
                                $("#modal_new_project").modal('show');
                            }, 200);
                        }
                    });
                };
            });
        })

        $(document).on('click', '.option_avatar', function() {
            $("#avatar_image").attr('src', $(this).attr('src'));
            $('#avatar').val($(this).data('id'));
            $("#modal_list_avatar").modal('hide');
            $('#newProjectForm').valid();
            setTimeout(() => {
                $("#modal_new_project").modal('show');
            }, 200);
        });

        /* ------------------------------------------------------------------
             INICIALIZACION LIBRERIAS VALIDACION, DATATABLE, SUMMERNOTE
        ------------------------------------------------------------------ */
        $("#newProjectForm").validate({
            rules: {
                title: "required",
                code: "required",
                avatar: "required",
            },
            messages: {
                title: "Este campo es requerido",
                code: "Este campo es requerido",
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

        $('#tabla_issues').DataTable({
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
                "zeroRecords": "Incidencia no encontrado",
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
                "url": "{{ url('table-issues')}}",
                "type": 'GET',
                'data': {
                    'project_id': "{{$project_id}}"
                },
            },

            "columns": [{
                    "data": "type",
                    'className': 'align-middle',
                },
                {
                    "data": 'code',
                    'className': 'align-middle',
                },
                {
                    "data": "title",
                    'className': 'align-middle',
                },
                {
                    "data": "handler",
                    'className': 'align-middle',
                },
                {
                    "data": "reporter",
                    'className': 'align-middle',
                },
                {
                    "data": "priority",
                    'className': 'align-middle',
                },
                {
                    "data": "state",
                    'className': 'align-middle text-center',
                },
                {
                    "data": "resolution",
                    'className': 'align-middle',
                },
                {
                    "data": "creation_date",
                    'className': 'align-middle',
                },
                {
                    "data": "last_update",
                    'className': 'align-middle',
                },
                {
                    "data": "expiration_date",
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