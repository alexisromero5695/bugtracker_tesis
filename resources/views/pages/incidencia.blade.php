@extends('layouts.app')
@section('title')
<title>Incidencias</title>
@endsection

@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/cropperjs"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<style>
    .dropzone {
        width: 98%;
        margin: 1%;
        border: 2px dashed #3498db !important;
        border-radius: 5px;
        transition: .2s;
    }

    .dropzone.dz-drag-hover {
        border: 2px solid #3498db !important;
    }

    .dz-message.needsclick img {
        width: 50px;
        display: block;
        margin: auto;
        opacity: .6;
        margin-bottom: 15px;
    }

    span.plus {
        display: none;
    }

    .dropzone.dz-started .dz-message {
        display: inline-block !important;
        width: 120px;
        /* float: ; */
        border: 1px solid rgba(238, 238, 238, 0.36);
        border-radius: 30px;
        height: 120px;
        margin: 16px;
        transition: .2s;
    }

    .dropzone.dz-started .dz-message span.text {
        display: none;
    }

    .dropzone.dz-started .dz-message span.plus {
        display: block;
        font-size: 70px;
        color: #AAA;
        line-height: 110px;
    }
</style>


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


                                <div class="project-head"><a href="#" class="project-title">
                                        <div class="user-avatar sq bg-light">
                                            <img src="/files/avatar/{{$incidencia['imagen_avatar']}}" alt="">
                                        </div>
                                        <div class="project-info">
                                            <h6 class="title">{{$incidencia['nombre_proyecto']}} | {{$incidencia['codigo_proyecto']}} - {{$incidencia['numero_incidencia']}}</h6>
                                            <h4 class="font-weight-bolder text-primary">{{$incidencia['nombre_incidencia']}}</h4>
                                        </div>
                                    </a>
                                </div>

                                <section id="cuerpo" class="mt-2">
                                    <div class="row">
                                        <div class="col-md-9 border-right">
                                            <section id="detalles">
                                              


                                                <!--Descripcion -->
                                                <h6 class="mb-2"> <i class="mdi mdi-arrow-down-bold-box"></i> Descripción</h6>
                                                <div class="container mb-5">
                                                    <div name="descripcion" id="descripcion" class="summernote-minimal"></div>
                                                </div>

                                                <!--Adjuntos -->
                                                <!-- <h6 class="mb-2"> <i class="mdi mdi-arrow-down-bold-box"></i> Documentos adjuntos</h6>
                                                <div class="container">
                                                    <div id="dropzone">
                                                        <form action="/upload" class="dropzone needsclick" id="demo-upload">
                                                            <div class="dz-message needsclick">
                                                                <span class="text">
                                                                    <img src="http://www.freeiconspng.com/uploads/------------------------------iconpngm--22.png" alt="Camera" />
                                                                    Drop files here or click to upload.
                                                                </span>
                                                                <span class="plus">+</span>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div> -->

                                            </section>
                                        </div>
                                        <div class="col-md-3">
                                            <section id="detalles">
                                                <h6> <i class="mdi mdi-arrow-down-bold-box"></i> Detalle</h6>
                                                <label class="m-0 p-0 text-muted font-weight-bolder">Tipo</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control form-select" id="tipo_incidencia" name="tipo_incidencia"></select>
                                                </div>   

                                                <label class="mt-2 m-0 p-0 text-muted font-weight-bolder">Estado</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control form-select" id="estado" name="estado"></select>
                                                </div>
                                                
                                                
                                                <label class="mt-2 m-0 p-0 text-muted font-weight-bolder">Prioridad</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control form-select" id="prioridad" name="prioridad">
                                                    </select>
                                                </div>

                                                <label class="mt-2 m-0 p-0 text-muted font-weight-bolder">Resolución</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control form-select" id="resolucion" name="resolucion"></select>
                                                </div>   
                                                <!-- PERSONAS -->
                                                <h6 class="mt-2"> <i class="mdi mdi-arrow-down-bold-box"></i> Personas</h6>                                              
                                                    <label class="m-0 p-0 text-muted font-weight-bolder">Responsable</label>                                                   
                                                    <select class="form-control form-select" id="responsable" name="responsable">
                                                    </select>
                                                  
                                                    <label class="mt-2 m-0 p-0 text-muted font-weight-bolder">Informante</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-control form-select" id="informante" name="informante">
                                                        </select>
                                                    </div>

                                                <!-- PERSONAS -->
                                                <h6 class="mt-4"> <i class="mdi mdi-arrow-down-bold-box"></i> Fechas</h6>
                                                                                                  
                                                <label class=" m-0 p-0 text-muted font-weight-bolder">Fecha de creación</label>
                                                <div class="form-control-wrap">
                                                    <input type="date" class="form-control"  id="fecha_creacion" name="fecha_creacion" >
                                                </div>
                                            
                                                <label class="mt-2 m-0 p-0 text-muted font-weight-bolder">Fecha de actualización</label>
                                                <div class="form-control-wrap">
                                                    <input type="date" class="form-control"  id="fecha_actualizacion" name="fecha_actualizacion" >
                                                </div>
                                               
                                        </div>
                                </section>
                            </div>
                        </div>
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
                    item['image'] = `avatar/${item.tipo_incidencia}`;
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

    function formatoSelector(item) {
        if (!item.id) {
            return item.text;
        }
        var $item =
            `<img  style="width:1em;" class="mr-1" src="files/${item.image}">
            <span>${item.text}</span>`;
        
        return $item;
    };

    function formatoSelectorColorSelection(item) {
        if (!item.id) {
            return item.text;
        }
        var $item = `<div  style='text-align:center;color: #fff;border: 1px solid  ${item.color} ; background-color: ${item.color}; padding: 0.1rem 1rem;position: absolute;transform: translate(-50%, -50%);top: 50%;left: 50%;width: 100%; color: ${item.color_texto}'>${item.text}</div>`;        
        return $item;
    };

    function formatoSelectorColorResult(item) {
        if (!item.id) {
            return item.text;
        }
        var $item = `<div  style='text-align:center;color: #fff;border: 1px solid  ${item.color} ; background-color: ${item.color}; padding: 0.1rem 1rem;width: 100%; color: ${item.color_texto}'>${item.text}</div>`;        
        return $item;
    };

    function formatoSelectorStaffSelection(item){
        if (!item.id) {
            return item.text;
        }
        var $item = ` <div class="nk-tb-col p-0 m-0" style='position: absolute;transform: translate(10%, -50%);top: 50%;left: 0'>
                            <div class="user-card">
                                <div class="user-avatar xs bg-primary"><span>${item.nombre_staff[0].toUpperCase()}${item.apellido_paterno_staff[0].toUpperCase()}</span></div>
                                <div class="user-name">
                                    <span class="tb-lead font-weight-bolder">${item.text}</span>
                                </div>
                            </div>
                        </div> `;        
        return $item;
    }

    function formatoSelectorStaffResult(item){
        if (!item.id) {
            return item.text;
        }
        var $item = ` <div class="nk-tb-col p-0 m-0">
                            <div class="user-card">
                                <div class="user-avatar xs bg-primary"><span>${item.nombre_staff[0].toUpperCase()}${item.apellido_paterno_staff[0].toUpperCase()}</span></div>
                                <div class="user-name">
                                    <span class="tb-lead font-weight-bolder">${item.text}</span>
                                </div>
                            </div>
                        </div> `;        
        return $item;
    }

    var data_tipo_incidencia =  @json($tipos_incidencia);
    var data_prioridad = @json($prioridades);
    var data_estados = @json($estados);
    var data_resoluciones = @json($resoluciones);
    $(document).ready(function() {
        data_tipo_incidencia = data_tipo_incidencia.map(function(item) {
            item['id'] = item.id_tipo_incidencia;
            item['text'] = item.nombre_tipo_incidencia;
            item['image'] = `tipo_incidencia/${item.imagen_tipo_incidencia}`;
            return item;
        });

        data_prioridad = data_prioridad.map(function(item) {
            item['id'] = item.id_prioridad;
            item['text'] = item.nombre_prioridad;
            item['image'] = `prioridad/${item.imagen_prioridad}`;
            return item;
        });

        data_estados = data_estados.map(function(item) {
            item['id'] = item.id_estado;
            item['text'] = item.nombre_estado;
            item['color'] = item.color_estado;
            item['color_texto'] = item.color_texto_estado;            
            return item;
        });

        data_resoluciones = data_resoluciones.map(function(item) {
            item['id'] = item.id_resolucion;
            item['text'] = item.nombre_resolucion;   
            return item;
        });
       
        setTimeout(() => {
            // alert('1');
            $("#tipo_incidencia").select2({
                placeholder: "Seleccione",
                templateResult: formatoSelector,
                templateSelection: formatoSelector,
                data: data_tipo_incidencia,
                width: '100%',
                escapeMarkup: function(m) {
                    return m;
                }
            });

            $("#prioridad").select2({
                placeholder: "Seleccione",
                templateResult: formatoSelector,
                templateSelection: formatoSelector,
                data: data_prioridad,
                width: '100%',
                escapeMarkup: function(m) {
                    return m;
                }
            });

            $("#estado").select2({
                placeholder: "Seleccione",
                templateResult: formatoSelectorColorResult,
                templateSelection: formatoSelectorColorSelection,
                data: data_estados,
                width: '100%',
                escapeMarkup: function(m) {
                    return m;
                }
            });

            $("#resolucion").select2({
                placeholder: "Seleccione",        
                data: data_resoluciones,
                width: '100%',
                escapeMarkup: function(m) {
                    return m;
                }
            });

            $("#responsable").select2({
                width: "100%",            
                
                ajax: {
                    url: "{{url('listar-staff-autocomplete')}}", //URL for searching companies
                    dataType: "json",
                    delay: 200,
                    data: function(params) {
                        return {
                            search: params.term, //params send to companies controller                     
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nombre_staff + ' ' + item.apellido_paterno_staff + ' ' + item.apellido_materno_staff,
                                    id: item.id_staff,
                                    nombre_staff: item.nombre_staff, 
                                    apellido_paterno_staff: item.apellido_paterno_staff,                                                 
                                }
                            })
                        };
                    },
                    cache: true
                },
                language: {
                    searching: function() {
                        return "Buscando...";
                    },
                    inputTooShort: function(args) {
                        return "Por favor ingrese 3 o más caracteres";
                    },
                    noResults: function(){
                        return "No se encontraron resultados";
                    },
                },
                placeholder: "Busque un responsable",
                templateResult: formatoSelectorStaffResult,
                templateSelection: formatoSelectorStaffSelection,
                escapeMarkup: function(m) {
                    return m;
                },
                minimumInputLength: 3
            });
            

            $("#informante").select2({
                width: "100%",            
                ajax: {
                    url: "{{url('listar-staff-autocomplete')}}", //URL for searching companies
                    dataType: "json",
                    delay: 200,
                    data: function(params) {
                        return {
                            search: params.term, //params send to companies controller                     
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nombre_staff + ' ' + item.apellido_paterno_staff + ' ' + item.apellido_materno_staff,
                                    id: item.id_staff,           
                                    nombre_staff: item.nombre_staff, 
                                    apellido_paterno_staff: item.apellido_paterno_staff,                                                  
                                }
                            })
                        };
                    },
                    cache: true
                },
                language: {
                    searching: function() {
                        return "Buscando...";
                    },
                    inputTooShort: function(args) {
                        return "Por favor ingrese 3 o más caracteres";
                    },
                    noResults: function(){
                        return "No se encontraron resultados";
                    },
                },
                placeholder: "Busque un informante",
                templateResult: formatoSelectorStaffResult,
                templateSelection: formatoSelectorStaffSelection,
                escapeMarkup: function(m) {
                    return m;
                },
                minimumInputLength: 3
            });

        }, 1);
        
        



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
        
        $('#descripcion').summernote({
            placeholder: 'Descripción',
            tabsize: 2,
            height: 300,
            lang: 'es-ES',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['view', ['fullscreen']]
            ]
        });       
       
    });

  

</script>
@endsection

@section('scripts')
<script src="{{asset('js/libs/datatable-btns.js?ver=2.9.0')}}"></script>
<link rel="stylesheet" href="{{asset('css/editors/summernote.css?ver=2.9.0')}}">
<script src="{{asset('js/libs/editors/summernote.js?ver=2.9.0')}}"></script>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-es-ES.js"></script>
@endsection