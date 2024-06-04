@extends('layouts.app')
@section('title')
<title>Proyectos</title>
@endsection

@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/cropperjs"></script>
<link rel="stylesheet" href="{{asset('libs/virtual-select/virtual-select.min.css')}}">
<script src="{{asset('libs/virtual-select/virtual-select.js')}}"></script>
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
                <h5 class="modal-title" id="titulo-crear-actualizar-proyecto"></h5>
                <a href="#" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross "></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="form-crear-proyecto" class="form-validate is-alter">
                    @csrf
                    <input type="text" hidden id="id_proyecto" name="id_proyecto">
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
                            <input id="fecha_inicio" name="fecha_inicio" type="date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pay-amount">Fecha de Fin</label>
                        <div class="form-control-wrap">
                            <div class="form-icon form-icon-left">
                                <em class="icon ni ni-calendar-alt"></em>
                            </div>
                            <input id="fecha_fin" name="fecha_fin" type="date" class="form-control">
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

                                <div class="w-100">
                                    <nav aria-label="breadcrumb">
                                        <ol class="default-breadcrumb">
                                            <li class="crumb">
                                                <div class="link"><em class="icon ni ni-users <?php echo $breadcrumb[count($breadcrumb)-1]['icono_modulo'] ?>"></em></div>
                                            </li>
                                                @foreach($breadcrumb as $key => $item)
                                                <li class="crumb <?php echo ($key == count($breadcrumb)-1) ? "active":"" ?>">
                                                <div class="link text-uppercase"><a href="javascript:void(0)">{{$item['nombre_modulo']}}</a></div>
                                            </li>
                                                @endforeach                                              
                                        </ol>
                                    </nav>                                    
                                </div>


                                <h5 for="">Filtros de búsqueda</h5>
                                <div style="background-color: #f5f6fa;padding: 0.5rem;" id="filtro_busqueda" class="mb-4 d-none">
                                    <div style="padding: 0.5rem 0rem;" class="card-inner position-relative card-tools-toggle" data-select2-id="49">
                                        <div class="card-title-group" data-select2-id="39">
                                            <div class="card-tools" data-select2-id="38">
                                                <div class="form-inline flex-nowrap gx-3 align-items-end" data-select2-id="37">
                                                    <div class="form-wrap d-flex" style="gap: 1rem;" >         
                                                       
                                                        <label class="text-nowrap fw-bolder" for="">Fecha inicio</label>
                                                        <input type="date" name="" class="form-control" id="">
                                                        <select multiple id="filtro_responsable" name="native-select" placeholder="Persona Asignada" data-search="false" data-silent-initial-value-set="true">                                                                                                                        
                                                        </select>
                                                    </div>

                                                    <div class="btn-wrap">
                                                            <span class="d-none d-md-block">
                                                                <button class="btn btn-primary"><em class="icon ni ni-search"></em><span class="m-0">Buscar</span></button>
                                                            </span>
                                                            <span class="d-md-none">
                                                                <button class="btn btn-dim btn-outline-light btn-icon disabled">
                                                                    <em class="icon ni ni-arrow-right"></em>
                                                                </button>
                                                            </span>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="card-tools me-n1">
                                                <ul class="btn-toolbar gx-1">
                                                    <li><a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a></li>
                                                    <li class="btn-toolbar-sep"></li>
                                                    <li>
                                                        <div class="toggle-wrap"><a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                            <div class="toggle-content" data-content="cardTools">
                                                                <ul class="btn-toolbar gx-1">
                                                                    <li class="toggle-close"><a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a></li>                                                      
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-search search-wrap" data-search="search">
                                            <div class="card-body">
                                                <div class="search-content"><a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                                    <input type="text" class="form-control border-transparent form-focus-none" placeholder="Buscar proyectos">
                                                    <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
        $("#titulo-crear-actualizar-proyecto").html('Nuevo Proyecto');
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


    $(document).on('click', '.btn-md-editar-proyecto', function() {

        ResetForm('form-crear-proyecto');
        id_proyecto = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: "{{url('listar-staff')}}",
            async: false,
            success: function(data_staff) {
                var html = `<option selected disabled>Seleccionar</option>`;
                $.each(data_staff, function(i, item) {
                    html += `<option value="${item.id_staff}">${item.nombre_staff} ${item.apellido_paterno_staff} ${item.apellido_materno_staff}</option>`;
                })
                $("#staff").html(html);
            },
            error: function(error) {
                console.error('Error: ' + error);
            }
        })


        $.ajax({
            type: 'GET',
            url: "{{url('traer-proyecto')}}",
            async: false,
            data: {
                id_proyecto
            },
            success: function(data) {
                $("#id_proyecto").val(data.id_proyecto);
                $("#nombre").val(data.nombre_proyecto);
                $("#codigo").val(data.codigo_proyecto);              
                $("#fecha_inicio").val(data.fecha_inicio_proyecto);            
                $("#fecha_fin").val(data.fecha_fin_proyecto);               
                $("#descripcion").summernote('code', data.descripcion_proyecto);
                if(data.id_responsable){
                    $("#staff").val(data.id_responsable).change();    
                    var select_responsable = $('#informante');
                    var option_responsable = new Option(`${data.nombre_responsable} ${data.apellido_paterno_responsable} ${data.apellido_materno_responsable}`, data.id_responsable, true, true);             
                        select_responsable.append(option_responsable);  
                }

                imagen_avatar = "/images/default/default-600.png";
                if (data.imagen_avatar) {
                    imagen_avatar ="/files/avatar/"+data.imagen_avatar;
                }

                $('#avatar_image').attr('src', imagen_avatar);
                $('#avatar').val(data.id_avatar);
            }
        })       

        $("#titulo-crear-actualizar-proyecto").html('Editar Usuario');
        $("#md-crear-proyecto").modal('show');
    })


    var cropper;
    var image = document.getElementById('sample_image');
    $(document).ready(function() {
        $("#filtro_busqueda").removeClass("d-none");

       
        VirtualSelect.init({ 
            ele: '#filtro_responsable' ,
            selectAllText: 'Seleccionar todo',
            noOptionsText: 'No se encontraron resultados',
            noSearchResultsTex: 'No se encontraron resultados',
            searchPlaceholderText: 'Buscar...',
            optionsSelectedText: 'Opciones seleccionadas',
            optionSelectedText: 'Opción seleccionada',
            allOptionsSelectedText: 'Responsable',            
            dropboxWidth: "500px",
        });

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
            "searching": false, // Aquí se oculta la barra de búsqueda
            dom: "<'row'<'col-sm-6'l><'col-sm-6 text-right'<'custom-button'>>>" + // Aquí defines tu propia estructura con el botón
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>", // Estructura predeterminada para la paginación e información
            initComplete: function () { // Aquí puedes añadir tu botón personalizado
                $('.custom-button').html('<button type="button" class="btn btn-primary" id="btn-md-crear-proyecto" data-toggle="modal"><span>Nuevo Proyecto</span> <em class="icon ni ni-plus-c"></em></button>');
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