@extends('layouts.app')
@section('title')
<title>Incidencias</title>
@endsection

@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/cropperjs"></script>

<section id="modales">
    <div class="modal fade" data-backdrop="static" id="md-crear-incidencia">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Incidencia</h5>
                    <a href="#" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross "></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="#" id="form-crear-incidencia" class="form-validate is-alter">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Proyecto <strong class="text-danger">*</strong> </label>
                                    <div class="form-control-wrap">
                                        <select class="form-control form-select" id="proyecto" name="proyecto" data-search="on"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Tipo de incidencia <strong class="text-danger">*</strong> </label>
                                    <div class="form-control-wrap">
                                        <select class="form-control form-select" id="tipo_incidencia" name="tipo_incidencia"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Sistema</label>
                                    <div class="form-control-wrap">
                                        <select class="form-control form-select" data-search="on" id="sistema" name="sistema"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Cliente</label>
                                    <div class="form-control-wrap">
                                        <select class="form-control form-select" data-search="on" id="cliente" name="cliente"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Prioridad</label>
                                    <div class="form-control-wrap">
                                        <select class="form-control form-select" id="prioridad" name="prioridad">

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="form-label" for="full-name">Titulo <strong class="text-danger">*</strong> </label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Descripción</label>
                            <div name="descripcion" id="descripcion" class="summernote-minimal"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Informante</label>
                                    <div class="form-control-wrap">
                                        <select id="informante" name="informante" data-search="on" class="form-select">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Responsable</label>
                                    <div class="form-control-wrap">
                                        <select id="responsable" name="responsable" data-search="on" class="form-select">
                                        </select>
                                    </div>
                                    <label id="asignarme" class="text-primary font-weight-bolder" for="">Asignarme a mi</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Fecha de vencimiento</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-calendar-alt"></em>
                                        </div>
                                        <input data-date-format="dd-mm-yyyy" id="fecha_vencimiento" name="fecha_vencimiento" type="text" class="form-control date-picker">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <button type="button" class="btn btn-md btn-outline-light" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="btn-crear-incidencia" class="btn btn-md btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                </div>
            </div>
        </div>
    </div>
</section>



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
                                    @if($codigo_proyecto)
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar sq mr-1">
                                            <img src="/files/avatar/{{$proyecto['imagen_avatar']}}">
                                        </div>
                                        <div>
                                            <h4 class="nk-block-title mb-0">{{$proyecto['nombre_proyecto']}} - {{$proyecto['codigo_proyecto']}}</h4>
                                            <span>Total incidencias:</span> <span id="contador_tabla">0</span>
                                        </div>                    
                                    </div>
                                  
                                    @else
                                    <div>
                                        <h4 class="nk-block-title mb-0">Todas las incidencias</h4>
                                        <span>Total incidencias:</span> <span id="contador_tabla">0</span>
                                    </div>
                                    
                                    @endif
                                    <button type="button" class="btn btn-primary" id="btn-md-crear-incidencia" data-toggle="modal">Nueva Incidencia</button>
                                </div>
                                <section>
                                    <div class="d-flex justify-content-sm-between flex-column flex-sm-row">
                                        <div id="div_dataTables_length"></div>
                                        <div id="div_dataTables_filter"></div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="tbl-incidencia" style="font-size: 0.71rem!important;" class="table table-striped table-bordered w-100">
                                            <thead>
                                                <tr class="nk-tb-item nk-tb-head">
                                                    <th class="nk-tb-col font-weight-normal text-center"><span class="sub-text">Tipo</span></th>
                                                    <th class="nk-tb-col font-weight-normal text-center"><span class="sub-text">Clave</span></th>
                                                    <th class="nk-tb-col tb-col-mb font-weight-normal text-center"><span class="sub-text">Resumen</span></th>
                                                    <th class="nk-tb-col tb-col-mb font-weight-normal text-center"><span class="sub-text">Persona Asignada</span></th>
                                                    <th class="nk-tb-col tb-col-mb font-weight-normal text-center"><span class="sub-text">Informante</span></th>
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
                                    <div id="div_dataTables_paginate" class="d-flex justify-content-end mt-2"></div>
                                </section>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    /* ====================================================================
                 FUNCIONES CREACION INCIDENCIA
    ==================================================================== */
    function formatoSelector(proyecto) {
        if (!proyecto.id) {
            return proyecto.text;
        }
        var $proyecto = $(
            '<img  style="width:1em;" class="mr-1" src="files/' + proyecto.image + '">' +
            '<span>' + proyecto.text + "</span>"
        );
        return $proyecto;
    };

    $(document).on('click', '#btn-md-crear-incidencia', function() {

        ResetForm('form-crear-incidencia');
        $("#descripcion").summernote("reset");

        var prioridades = @json($prioridades);
        var dataPrioridad = prioridades.map(function(item) {
            item['id'] = item.id_prioridad;
            item['text'] = item.nombre_prioridad;
            item['image'] = `prioridad/${item.imagen_prioridad}`;
            return item;
        });
        $("#prioridad").select2({
            placeholder: "Seleccione",
            templateResult: formatoSelector,
            templateSelection: formatoSelector,
            data: dataPrioridad,
            width: '100%',
            escapeMarkup: function(m) {
                return m;
            }
        });

        $.ajax({
            type: 'GET',
            url: "{{url('listar-staff')}}",
            async: false,
            success: function(data) {
                var html = ``;
                $.each(data, function(i, item) {
                    html += `<option value="${item.id_staff}">${item.nombre_staff} ${item.apellido_paterno_staff} ${item.apellido_materno_staff}</option>`;
                })
                $("#responsable").html(html);
                $("#informante").html(html);
            },
            error: function(error) {
                console.error('Error: ' + error);
            }
        })


        $.ajax({
            type: 'GET',
            url: "{{url('listar-proyectos')}}",
            async: false,

            success: function(data) {
                var data = data.map(function(item) {
                    item['id'] = item.id_proyecto;
                    item['text'] = item.nombre_proyecto;
                    item['image'] = `avatar/${item.imagen_avatar}`;
                    return item;
                });
                $("#proyecto").select2({
                    dropdownParent: $("#md-crear-incidencia"),
                    placeholder: "Seleccione",
                    templateResult: formatoSelector,
                    templateSelection: formatoSelector,
                    data: data,
                    width: '100%',
                    escapeMarkup: function(m) {
                        return m;
                    }
                });

            },
            error: function(error) {
                console.error('Error: ' + error);
            }
        })


        let id_proyecto = 0;
        $.ajax({
            type: 'GET',
            url: "{{url('listar-tipo-incidencia')}}",
            async: false,
            data: {
                'id_proyecto': id_proyecto,
            },
            success: function(data) {
                var data = data.map(function(item) {
                    item['id'] = item.id_tipo_incidencia;
                    item['text'] = item.nombre_tipo_incidencia;
                    item['image'] = `tipo_incidencia/${item.imagen_tipo_incidencia}`;
                    return item;
                });
                $("#tipo_incidencia").select2({
                    placeholder: "Seleccione",
                    templateResult: formatoSelector,
                    templateSelection: formatoSelector,
                    data: data,
                    width: '100%',
                    escapeMarkup: function(m) {
                        return m;
                    }
                });
            },
            error: function(error) {
                console.error('Error: ' + error);
            }
        })



        $("#md-crear-incidencia").modal('show');
    })


    $(document).on('click', '#btn-crear-incidencia', function() {

        if (!$('#form-crear-incidencia').valid()) {
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
            url: "{{url('crear-incidencia')}}",
            data: $('#form-crear-incidencia').serialize() + '&descripcion=' + encodeURIComponent($('#descripcion').summernote('code')),
            async: false,
            success: function(data) {
                DevExpress.ui.notify({
                    position: 'top',
                    message: "Incidencia creada exitosamente",
                    width: 200,
                    shading: false,
                }, "success", 800);
                $('#tbl-incidencia').DataTable().ajax.reload();
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
        $("#md-crear-incidencia").modal('hide');
        $(btn).prop('disabled', false);
    });



    /* FUNCIONES COMPLEMENTARIAS */
    $(document).on('click', "#asignarme", function() {
        $("#responsable").val("{{Session::get('id_staff')}}").change();
    })

    $(document).ready(function() {
        $.validator.setDefaults({
            ignore: []
        });

        /* ------------------------------------------------------------------
             INICIALIZACION LIBRERIAS VALIDACION, DATATABLE, SUMMERNOTE
        ------------------------------------------------------------------ */
        $("#form-crear-incidencia").validate({
            rules: {
                nombre: {
                    required: true,
                },
                proyecto: {
                    required: true,
                },
                tipo_incidencia: {
                    required: true,
                },
            },
            messages: {
                nombre: {
                    required: "Este campo es requerido",
                },
                proyecto: {
                    required: "Este campo es requerido",
                },
                tipo_incidencia: {
                    required: "Este campo es requerido",
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

        $('#tbl-incidencia').DataTable({
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
                "url": "{{ url('tabla-incidencias')}}",
                "type": 'GET',
                'data': {
                    'codigo_proyecto': "{{$codigo_proyecto}}"
                },
            },
            fnDrawCallback: function() {
                let cantidad = this.api().page.info().recordsTotal;
                $("#contador_tabla").text(`${cantidad}`);         
            },
            initComplete: (settings, json) => {
                $('.dataTables_length').appendTo('#div_dataTables_length');
                $("#tbl-incidencia_length").find('label').addClass('d-flex');

                $('.dataTables_filter').appendTo('#div_dataTables_filter');
                $("#tbl-incidencia_filter").find('label').addClass('d-flex');


                $('.dataTables_paginate').appendTo('#div_dataTables_paginate');
            },
            "columns": [{
                    "data": "tipo",
                    'className': 'align-middle',
                },
                {
                    "data": 'codigo',
                    'className': 'align-middle',
                },
                {
                    "data": "nombre",
                    'className': 'align-middle',
                },
                {
                    "data": "responsable",
                    'className': 'align-middle',
                },
                {
                    "data": "informante",
                    'className': 'align-middle',
                },
                {
                    "data": "prioridad",
                    'className': 'align-middle',
                },
                {
                    "data": "estado",
                    'className': 'align-middle text-center',
                },
                {
                    "data": "resolucion",
                    'className': 'align-middle',
                },
                {
                    "data": "fecha_creacion",
                    'className': 'align-middle',
                },
                {
                    "data": "fecha_actualizacion",
                    'className': 'align-middle',
                },
                {
                    "data": "fecha_vencimiento",
                    'className': 'align-middle',
                },
            ]
        });
        var _minimal = '.summernote-minimal';
        if ($(_minimal).exists()) {
            $(_minimal).each(function() {
                $(this).summernote({
                    placeholder: 'Descripción',
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