@extends('layouts.app')
@section('title')
<title>Incidencia</title>
@endsection

@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/cropperjs"></script>
<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.2/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@5.9.2/dist/min/dropzone.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" />

<style>
    .tag_principal_absolute{
        font-size: 10px !important;
        position: absolute;
        top: 0;
        background: #007cb2;
        right: 0;
        color: #fff;
        padding: 0px 4px;
        cursor: pointer;
    }   
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

    .dropdown:hover>.dropdown-menu {
        display: block;
    }


</style>
<div class="">
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
                                                <div class="container">
                                                    <div name="descripcion" id="descripcion" class="summernote-minimal"></div>
                                                </div>
                                                <div class="mt-2 mx-2">
                                                    <button class="btn btn-primary btn-editar-descripcion d-none">Guardar</button>
                                                    <button class="btn btn-outline-dark btn-cancelar-editar-descripcion d-none">Cancelar</button>
                                                </div>

                                                <!-- archivos adjuntos -->
                                               
                                                <div class="form-group mt-3">
                                                    <h6 class="mb-1"><label class="mb-0" for="file-upload">Archivos adjuntos({{count(json_decode($archivos))}})</label></h6>
                                                    <div class="dropzone" id="file-upload"> </div>
                                                </div>
                                             
                                              

                                                <h6><label class="mb-1" id="ver-comentarios" data-cantidad="{{count($comentarios)}}" onclick="VerComentarios(this);" for="asignado_tarea">
                                                        <em class="icon ni ni-chat-fill"></em><?php echo (count($comentarios) == 0) ?  " Agregar comentario" :  " Comentarios (" . count($comentarios) . ")"  ?>

                                                    </label>
                                                </h6>
                                                <div id="div-comentarios">
                                                </div>     
                                            </section>
                                        </div>
                                        <div class="col-md-3">
                                            <section id="detalles">
                                                <h6> <i class="mdi mdi-arrow-down-bold-box"></i> Detalle</h6>
                                                <label class="m-0 p-0 text-muted font-weight-bolder">Tipo</label>
                                                <div class="form-control-wrap">
                                                    <select onchange="EditarIncidencia('tipo')" class="form-control form-select" id="tipo" name="tipo"></select>
                                                </div>

                                                <label class="mt-2 m-0 p-0 text-muted font-weight-bolder">Estado</label>
                                                <div class="form-control-wrap">
                                                    <select  onchange="EditarIncidencia('estado')" class="form-control form-select" id="estado" name="estado"></select>
                                                </div>


                                                <label class="mt-2 m-0 p-0 text-muted font-weight-bolder">Prioridad</label>
                                                <div class="form-control-wrap">
                                                    <select onchange="EditarIncidencia('prioridad')" class="form-control form-select" id="prioridad" name="prioridad">
                                                    </select>
                                                </div>

                                                <label class="mt-2 m-0 p-0 text-muted font-weight-bolder">Resolución</label>
                                                <div class="form-control-wrap">
                                                    <select onchange="EditarIncidencia('resolucion')" class="form-control form-select" id="resolucion" name="resolucion"></select>
                                                </div>
                                                <!-- PERSONAS -->
                                                <h6 class="mt-2"> <i class="mdi mdi-arrow-down-bold-box"></i> Personas</h6>
                                                <label class="m-0 p-0 text-muted font-weight-bolder">Responsable</label>
                                                <select onchange="EditarIncidencia('responsable')"  class="form-control form-select" id="responsable" name="responsable">
                                                </select>

                                                <label class="mt-2 m-0 p-0 text-muted font-weight-bolder">Informante</label>
                                                <div class="form-control-wrap">
                                                    <select onchange="EditarIncidencia('informante')" class="form-control form-select" id="informante" name="informante">
                                                    </select>
                                                </div>

                                                <!-- PERSONAS -->
                                                <h6 class="mt-4"> <i class="mdi mdi-arrow-down-bold-box"></i> Fechas</h6>

                                                <label class=" m-0 p-0 text-muted font-weight-bolder">Fecha de vencimiento</label>
                                                <div class="form-control-wrap">
                                                    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento">
                                                </div>

                                                <label class=" m-0 p-0 text-muted font-weight-bolder">Fecha de creación</label>
                                                <div class="form-control-wrap">
                                                    <!-- <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion"> -->
                                                    <div class="form-control">
                                                        <span id="fecha_creacion"></span>
                                                    </div>
                                                </div>

                                                <label class="mt-2 m-0 p-0 text-muted font-weight-bolder">Fecha de actualización</label>
                                                <div class="form-control-wrap">
                                                    <!-- <input type="date" class="form-control" id="fecha_actualizacion" name="fecha_actualizacion"> -->
                                                    <div class="form-control">
                                                        <span id="fecha_actualizacion"></span>
                                                    </div>
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
    var archivos = {!!$archivos!!};

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
                    item['id'] = item.id_tipo;
                    item['text'] = item.nombre_tipo;
                    item['image'] = `avatar/${item.tipo}`;
                    return item;
                });
                $("#tipo").select2({
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
                width: 300,
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
                    width: 300,
                    shading: false,
                }, "success", 800);
                $('#tbl-incidencia').DataTable().ajax.reload();
            },
            error: function(error) {
                DevExpress.ui.notify({
                    position: 'top',
                    message: "Ocurrio un error",
                    width: 300,
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

    function formatoSelectorStaffSelection(item) {
        if (!item.id) {
            return item.text;
        }

        var nombre_staff = item.nombre_staff || item.element.dataset.nombre_staff;
        var apellido_paterno_staff =  item.apellido_paterno_staff || item.element.dataset.apellido_paterno_staff;

        var $item = ` <div class="nk-tb-col p-0 m-0" style='position: absolute;transform: translate(10%, -50%);top: 50%;left: 0'>
                            <div class="user-card">
                                <div class="user-avatar xs bg-primary"><span>${nombre_staff[0].toUpperCase()}${apellido_paterno_staff[0].toUpperCase()}</span></div>
                                <div class="user-name">
                                    <span class="tb-lead font-weight-bolder">${item.text}</span>
                                </div>
                            </div>
                        </div> `;
        return $item;
    }

    function formatoSelectorStaffResult(item) {
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

    function formatoSelectorCirculo(proyecto) {
        if (!proyecto.id) {
            return proyecto.text;
        }
        var $proyecto = $(
            '<span> <span style="font-size:1.2rem; color:' + proyecto.color + '">●</span> ' + proyecto.text + "</span>"
        );
        return $proyecto;
    };
    var incidencia = @json($incidencia);
    var data_tipo = @json($tipos_incidencia);
    var data_prioridad = @json($prioridades);
    var data_estados = @json($estados);
    var data_resoluciones = @json($resoluciones);
    Dropzone.autoDiscover = false;
    var visualizar_alerta_cambio = 0;
    $(document).ready(function() {

        var $btnSave = $('.btn-editar-descripcion');
        var $btnCancel = $('.btn-cancelar-editar-descripcion');
        var $summernote = $('#descripcion');


        var dropzoneTarea = new Dropzone("#file-upload", {
            dictDefaultMessage: "Arrastra tus archivos aquí o haz clic para subirlos",
            dictFallbackMessage: "Su navegador no admite arrastrar y soltar archivos para cargar.",
            dictFallbackText: "Utilice el formulario de respaldo a continuación para cargar sus archivos como en los viejos tiempos.",            
            dictFileTooBig: function(file, maxFilesize) {
                var message = `El archivo es demasiado grande (${Dropzone.filesize(file.size)}). Tamaño máximo de archivo: ${Dropzone.filesize(maxFilesize)}.`;
                return message;
            },
            dictInvalidFileType: "No se puede cargar este tipo de archivo.",
            dictResponseError:  function(file, maxFilesize) {
                var message =`El servidor respondió con el código ${Dropzone.filesize(file.size)}.`
                return message;
            },                      
            dictCancelUpload: "Cancelar carga",
            dictCancelUploadConfirmation: "¿Estás seguro de que quieres cancelar esta carga?",
            dictRemoveFile: "Eliminar archivo",
            dictMaxFilesExceeded: "No puedes cargar más archivos.",
            dictDefaultMessageMultiple: `Arrastra tus archivos aquí o haz clic para subirlos. Se permiten cargar 2000 archivos.`,
            dictFallbackMessageMultiple: `Su navegador no admite arrastrar y soltar archivos para cargar. Se permiten cargar 2000 archivos.`,
            dictFallbackTextMultiple: `Utilice el formulario de respaldo a continuación para cargar sus archivos como en los viejos tiempos. Se permiten cargar 2000 archivos.`,
            dictFileTooBigMultiple:  function(file, maxFilesize) {
                var message = `Algunos archivos son demasiado grandes (${Dropzone.filesize(file.size)} MB). Tamaño máximo de archivo: ${Dropzone.filesize(maxFilesize)} MB.`
                return message;
            },                      
            dictInvalidFileTypeMultiple: "No se pueden cargar algunos archivos de este tipo.",
            dictResponseErrorMultiple:  function(file, maxFilesize) {
                var message =  `El servidor respondió con el código ${Dropzone.filesize(file.size)} para algunos archivos.`
                return message;
            },                      
            dictCancelUploadMultiple: "Cancelar cargas",
            dictCancelUploadConfirmationMultiple: "¿Estás seguro de que quieres cancelar estas cargas?",
            dictRemoveFileMultiple: "Eliminar archivos",
            dictMaxFilesExceededMultiple: "No puedes cargar más archivos.",
            thumbnailWidth: 120,
            thumbnailHeight: 120,
            addRemoveLinks: true,
            addDownloadLinks: true,
            dictRemoveFile: "Eliminar archivo",
            dictDownloadFile: "Descargar archivo",
            dictCancelUpload: "Cancelar",
            dictDefaultMessage: "Arrastra los archivos aquí o haz clic para seleccionar",
            url: "{{url('crear-actualizar-archivos')}}",
            paramName: "file",
            uploadMultiple: true,
            maxFilesize: 209715200,
            timeout: 1000000,
            parallelUploads: 100,
            acceptedFiles: "image/png,image/jpeg,image/jpg,application/pdf,.doc,.docx,text/plain,.xls,.xlsx,.ppt,.pptx,video/mp4,video/avi,video/quicktime,video/x-ms-wmv,application/x-rar-compressed,.rar,application/zip,audio/mpeg",
            maxFiles: 2000,
            autoProcessQueue: true,
            params: {
                'id_incidencia': "{{$incidencia['id_incidencia']}}"
            },
            init: function() {                      
                this.on("sending", function(file, xhr, formData) {                 
                    // formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                    var csrfToken = "{{ csrf_token() }}";
                    formData.append("_token", csrfToken);
               
                });              
                this.on("addedfile", function(file) {
                    var ext = file.name.split('.').pop().toLowerCase();                       
                        let cambia_imagen = 0;
                        let src;
                        switch (ext) {

                            case "mp3":
                            case "wav":
                            case "ogg":
                                cambia_imagen = 1;
                                src = "{{asset('/images/files/AUDIO.png')}}";
                                break;                                
                            case "png":       
                            case "jpeg":       
                            case "jpg":       

                                break;
                            case "xls":                         
                            case "xlsx":
                                cambia_imagen = 1;
                                src = "{{asset('/images/files/CALCULO.png')}}";
                                break;
                            case "pdf":
                                cambia_imagen = 1;
                                src = "{{asset('/images/files/PDF.png')}}";
                                break;
                            case "doc":
                            case "txt":
                            case "docx":
                                cambia_imagen = 1;
                                src = "{{asset('/images/files/DOC.png')}}";
                                break;
                            case "ppt":
                            case "pptx":
                                cambia_imagen = 1;
                                src = "{{asset('/images/files/DIAPOSITIVA.png')}}";
                                break;                     
                            case "mp4":                              
                            case "avi":
                            case "mov":
                            case "wmv":
                                cambia_imagen = 1;
                                src = "{{asset('/images/files/VIDEO.png')}}";
                                break;
                            case "rar":
                            case "zip":
                                cambia_imagen = 1;
                                src = "{{asset('/images/files/COMPRIMIDO.png')}}";
                                break;
                            default:                         
                                cambia_imagen = 1;
                                src = "{{asset('/images/files/DEFECTO.png')}}";
                                break;
                        }
                        let elemento =    file.previewElement.querySelector(".dz-image");
                        if(cambia_imagen == 1){       
                            $(elemento).html("<img src='" + src + "' width='" + this.options.thumbnailWidth + "' height='" + this.options.thumbnailHeight + "' />");
                        }else{                            
                            $(elemento).find('img').css('height','100%');
                            $(elemento).find('img').css('width','100%');
                        }
                 
                    let previewUrl;
                    if (!file.url) { // Si el archivo no tiene una URL, generamos una URL temporal para el archivo
                        file.previewUrl = URL.createObjectURL(file);
                        previewUrl = file.previewUrl;
                    } else {
                        previewUrl = file.url;
                    }
                    var downloadLink = document.createElement('a');
                    downloadLink.href = previewUrl;
                    downloadLink.innerHTML = 'Descargar';
                    downloadLink.classList.add('dz-download');
                    downloadLink.download = file.name;

                    var div = document.createElement('div');
                    div.classList.add('text-center');
                    div.appendChild(downloadLink);
                    file.previewElement.appendChild(div);
                });

                this.on("removedfile", function(file) {
                    var files = dropzoneTarea.getAcceptedFiles();
                    if (dropzoneTarea.getAcceptedFiles().length === 0) {                  
                    }
                    $.ajax({
                        type: "POST",
                        url: "{{url('eliminar-archivo-incidencia')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id_incidencia': "{{$incidencia['id_incidencia']}}",
                            'path_archivo': file.name
                        },
                        async: false,
                        success: function(response) {                         
                            DevExpress.ui.notify({
                                position: 'top',
                                message: 'Archivo eliminado con éxito.',
                                width: 300,
                                shading: false,
                            }, "success", 800);
                        },
                        error: function(xhr, status, error) {

                            DevExpress.ui.notify({
                                position: 'top',
                                message: 'Ocurrió un error al eliminar el archivo.',
                                width: 300,
                                shading: false,
                            }, "error", 800);
                         
                        }
                    });                
                });
                this.on("queuecomplete", function() {
                });
                this.on("success", function(file, response) {
                    if (response) {
                        // Verificamos si la respuesta es satisfactoria
                        if (response == "ok") {
                            // Mostramos una alerta de éxito      
                            DevExpress.ui.notify({
                                position: 'top',
                                message: 'Archivo agregado con éxito.',
                                width: 300,
                                shading: false,
                            }, "success", 800);
                        } else {
                            // Mostramos una alerta de fracaso                            
                            DevExpress.ui.notify({
                                position: 'top',
                                message:'Ocurrión un error al agregar el archivo.',
                                width: 300,
                                shading: false,
                            }, "error", 800);
                        }
                    }

                });
            }
        });

        data_tipo = data_tipo.map(function(item) {
            item['id'] = item.id_tipo;
            item['text'] = item.nombre_tipo;
            item['image'] = `tipo_incidencia/${item.imagen_tipo}`;
            return item;
        });

        data_prioridad = data_prioridad.map(function(item) {
            item['id'] = item.id_prioridad;
            item['text'] = item.nombre_prioridad;
            // item['image'] = `prioridad/${item.imagen_prioridad}`;
            item['color'] = item.color_prioridad;
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
            $("#tipo").select2({
                placeholder: "Seleccione",
                templateResult: formatoSelector,
                templateSelection: formatoSelector,
                data: data_tipo,
                width: '100%',
                escapeMarkup: function(m) {
                    return m;
                }
            });

            $("#prioridad").select2({
                placeholder: "Seleccione",
                templateResult: formatoSelectorCirculo,
                templateSelection: formatoSelectorCirculo,
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
                    cache: true,
                    pagination: false // Desactivar la paginación
                },
                language: {
                    searching: function() {
                        return "Buscando...";
                    },
                    // inputTooShort: function(args) {
                    //     return "Por favor ingrese 3 o más caracteres";
                    // },
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                },
                placeholder: "Busque un responsable",
                templateResult: formatoSelectorStaffResult,
                templateSelection: formatoSelectorStaffSelection,
                escapeMarkup: function(m) {
                    return m;
                },
                minimumInputLength: 0
            });
   
            $("#informante").select2({
                width: "100%",
                'ajax':{
                    url: "{{url('listar-staff-autocomplete')}}", //URL for searching companies
                    dataType: "json",
                    // delay: 200,
                    async: false,
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
                    cache: true,
                    pagination: false // Desactivar la paginación
                },
                language: {
                    searching: function() {
                        return "Buscando...";
                    },
                    // inputTooShort: function(args) {
                    //     return "Por favor ingrese 3 o más caracteres";
                    // },
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                },
                placeholder: "Busque un informante",
                templateResult: formatoSelectorStaffResult,
                templateSelection: formatoSelectorStaffSelection,
                escapeMarkup: function(m) {
                    return m;
                },
                minimumInputLength: 0
            });

            if(incidencia.id_tipo){      
                $("#tipo").val(incidencia.id_tipo).change();
            }            

            if(incidencia.id_estado){      
                $("#estado").val(incidencia.id_estado).change();
            }

            if(incidencia.id_prioridad){            
                $("#prioridad").val(incidencia.id_prioridad).change();
            }

            if(incidencia.id_resolucion){            
                $("#resolucion").val(incidencia.id_resolucion).change();
            }

            if(incidencia.id_responsable){
                var select_responsable = $('#responsable');
                var option_responsable = new Option(`${incidencia.nombre_responsable} ${incidencia.apellido_paterno_responsable} ${incidencia.apellido_materno_responsable}`, incidencia.id_responsable, true, true);
                option_responsable.dataset.nombre_staff = incidencia.nombre_responsable;
                option_responsable.dataset.apellido_paterno_staff = incidencia.apellido_paterno_responsable;      
                select_responsable.append(option_responsable);   
            }

            if(incidencia.id_informante){
                var select_informante = $('#informante');
                var option_informante = new Option(`${incidencia.nombre_informante} ${incidencia.apellido_paterno_informante} ${incidencia.apellido_materno_informante}`, incidencia.id_informante, true, true);
                option_informante.dataset.nombre_staff = incidencia.nombre_informante;
                option_informante.dataset.apellido_paterno_staff = incidencia.apellido_paterno_informante;      
                select_informante.append(option_informante);   
            }

            if(incidencia.descripcion_incidencia){
                $('#descripcion').summernote('code', incidencia.descripcion_incidencia);
            }
         
            if(incidencia.fecha_vencimiento_incidencia){
                $("#fecha_vencimiento").val(incidencia.fecha_vencimiento_incidencia);
            }

            $("#fecha_creacion").text(incidencia.fecha_creacion_incidencia);
            $("#fecha_actualizacion").text(incidencia.fecha_actualizacion_incidencia);
            
            visualizar_alerta_cambio = 1;
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
                tipo: {
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
                tipo: {
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
                ['style', ['style', 'bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['font', ['fontsize', 'color', 'fontname']],
                ['para', ['paragraph', 'height', 'ul', 'ol', 'style']],
                ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                ['misc', ['fullscreen', 'codeview', 'undo', 'redo', 'help']]
            ],
            callbacks: {
                onFocus: function() {
                    currentContent = $('#descripcion').summernote('code');
                    $btnSave.removeClass('d-none');
                    $btnCancel.removeClass('d-none');
                },
            }
        });

        
        $btnSave.on('click', function() {          
            $.ajax({
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id_incidencia': "{{$incidencia['id_incidencia']}}",
                    'descripcion': $summernote.summernote('code'),
                },
                url: "{{url('crear-incidencia')}}",
                type: 'post',
                async: false,
                success: function(data) {             
                    DevExpress.ui.notify({
                        position: 'top',
                        message: 'Descripción actualizada con éxito.',
                        width: 300,
                        shading: false,
                    }, "success", 800);
                },
                error: function(data) {
                    DevExpress.ui.notify({
                        position: 'top',
                        message: 'Ocurrio un error al guardar los datos.',
                        width: 300,
                        shading: false,
                    }, "error", 800);
                }
            });

                $btnSave.addClass('d-none');
                $btnCancel.addClass('d-none');
        });

        $btnCancel.on('click', function() {
            $('#descripcion').summernote('code', currentContent);
            $btnSave.addClass('d-none');
            $btnCancel.addClass('d-none');
        }); 

        archivos.forEach(function(file) {
            var mockFile = {
                name: file.name,
                size: file.size,
                type: file.type,
                url: file.url
            };
            dropzoneTarea.emit("addedfile", mockFile);
            dropzoneTarea.emit("thumbnail", mockFile, file.url);
            dropzoneTarea.emit("success", mockFile);
            dropzoneTarea.emit("complete", mockFile);
            dropzoneTarea.files.push(mockFile);
        });
    });


    /*----------------------------------------------------------------------------------------------------
    COMENTARIOS
    ----------------------------------------------------------------------------------------------------*/
    function VerComentarios(element) {
        let id_tarea = "{{$incidencia['id_incidencia']}}";
        if ($(element).hasClass('active')) {
            $(`#div-comentarios`).html("");
            $(element).removeClass('active')
            let cantidad = $(element).data('cantidad');
            if (cantidad == 0) {
                $(element).html(`<em class="icon ni ni-chat-fill"></em> Agregar comentario`);
            } else {
                $(element).html(`<em class="icon ni ni-chat-fill"></em> Comentarios (${cantidad})`);
            }
        } else { //muestra            
            $(element).addClass('active');
            ListarComentariosTarea(id_tarea);
            $(element).html(`<em class="icon ni ni-chat-fill"></em> Ocultar comentarios`);
        }
    }

    function ListarComentariosTarea(id_incidencia) {
        let html_comentarios = '';
        $(`#div-comentarios`).html(html_comentarios);
        $.ajax({
            type: 'GET',
            url: "{{url('listar-comentarios-incidencia')}}",
            async: false,
            data: {
                'id_incidencia': id_incidencia,
            },
            success: function(data) {
                $(`#ver-comentarios`).data('cantidad', data.length);
                $.each(data, function(i, item) {
                    var comentario_nodos = $.parseHTML(item.detalle_comentario);
                    var div_temporal = document.createElement("div");
                    for (var i = 0; i < comentario_nodos.length; i++) {
                        div_temporal.appendChild(comentario_nodos[i].cloneNode(true));
                    }                

                    var comentario_html_convertido = div_temporal.innerHTML;
                    let html_comentarios = `<div class="mb-4 div-contenedor-comentario-tarea" >         
                                                <span class="d-flex align-items-center justify-content-between mb-2">
                                                    <div style="gap:6px"  class="d-flex align-items-center">
                                                        <div class="user-avatar  bg-primary d-none d-sm-flex xs mr-1"><span>${ item.nombre_usuario.charAt(0)}</span></div>
                                                        <span class="text-nowrap fw-bold">${item.nombre_usuario} ${item.apellidopaterno_usuario} ${item.apellidomaterno_usuario}</span>
                                                    </div>       
                                                    <span>
                                                        ${item.fecha_creacion}
                                                    </span>
                                                </span>
                                              
                                                <div  id="div-comentario-${item.id_comentario}" style="position:relative; background:#e5e9f278" class='d-block p-2'>
                                                    <div  style="background: #f000;" id="previsualizador-comentario-${item.id_comentario}"> ${comentario_html_convertido} </div>

                                                    <div class="dropdown tag_principal_absolute">
                                                    
                                                        
                                                        <label for="" class="font-weight-bold dropdown-toggle tag_principal_absolute" id="dropdownMenuComentarioTarea${item.id_comentario}" data-toggle="dropdown" aria-expanded="false"> Ver más                                                 
                                                        </label>

                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a data-id_comentario="${item.id_comentario}" data-id_tarea="${id_incidencia}" class="text-muted d-block px-3 py-1 eliminar_comentario_tarea" ><em class="icon ni ni-trash"></em> Eliminar</a>                                                      
                                                            <a data-id_comentario="${item.id_comentario}" class="text-muted d-block px-3 py-1 editar_comentario_tarea" ><em class="icon ni ni-pen"></em> Editar</a>
                                                        </div>
                                                    </div>
                                                


                                                                                                        
                                                </div>                       
                                            </div>`;

                    $(`#div-comentarios`).append(html_comentarios);
                })

                let usuario_sesion = "{{Session::get('staff')->nombre_staff}}" + ' ' + "{{Session::get('staff')->apellido_paterno_staff}}" + ' ' + "{{Session::get('staff')->apellido_materno_staff}}";

                $(`#div-comentarios`).append(`
                                            <span style="gap:6px" class="d-flex align-items-center mb-2">
                                                <div class="user-avatar  bg-primary d-none d-sm-flex xs mr-1"><span>${usuario_sesion.charAt(0)}</span></div>
                                                <span class="text-nowrap fw-bold">${usuario_sesion}</span>
                                            </span>

                                            <div class="row mt-1 div-summernote-crear" id="div-summernote-crear-comentarios">
                                                <div class="col-sm-12 ">
                                                    <textarea rows="4" class="summernote" name="comentario_tarea" id="summernote-crear-comentarios"></textarea>
                                                </div>
                                                <div class="col-sm-12  mt-1">
                                                    <button data-id="${id_incidencia}" class="btn btn-sm btn-primary btn_crear_comentario_tarea">Guardar</button>                                                                      
                                                </div>
                                            </div>`);

                $(`#summernote-crear-comentarios`).summernote({
                    tabsize: 2,
                    height: 120,
                    lang: 'es-ES',
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['view', ['codeview']]
                        ['insert', ['link']],
                    ]
                });

            }
        })
    }

    $(document).on('click', '.editar_comentario_tarea', function() {
        let id_comentario = $(this).data('id_comentario');
        let id_div = "";
        if ($("#nav-link-actividad").hasClass('active')) {
            id_div = "comentarios-tarea-actividad";
        } else if ($("#nav-link-tarea").hasClass('active')) {
            id_div = "comentarios-tarea-tarea";
        }

        $(`#div-comentario-${id_comentario}`).removeClass('d-block').addClass("d-none");

        $(this).closest('.div-contenedor-comentario-tarea').append(`<div class="row mt-1 div-summernote-editar" id="div-summernote-editar-comentario">
                                                                        <div class="col-sm-12 ">
                                                                            <textarea rows="4" class="summernote" name="comentario_tarea" id="summernote-comentario-${id_comentario}"></textarea>
                                                                        </div>
                                                                        <div class="col-sm-12  mt-1">
                                                                            <button data-id="${id_comentario}" data-id_html="summernote-comentario-${id_comentario}" class="btn btn-sm btn-primary btn_editar_comentario_tarea">Guardar</button>
                                                                            <button data-id="${id_comentario}" data-id_html="div-summernote-editar-comentario" class="btn btn-sm btn-danger btn_cancelar_comentario_tarea">Cancelar</button>
                                                                        </div>
                                                                    </div>`);

        $(`#summernote-comentario-${id_comentario}`).summernote({
            tabsize: 2,
            height: 120,
            lang: 'es-ES',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['codeview']]
                ['insert', ['link']],
            ]
        });

        $.ajax({
            type: 'GET',
            url: "{{url('traer-comentario-incidencia')}}",
            async: false,
            data: {
                'id_comentario': id_comentario,
            },
            success: function(data) {
                $(`#summernote-comentario-${id_comentario}`).summernote('code', data.detalle_comentario);
            }
        });
    })

    $(document).on('click', '.btn_editar_comentario_tarea', function() {
        let id_comentario = $(this).data('id');
        let html_comentario_tarea = $(`#${$(this).data('id_html')}`).summernote('code');

        var formData = new FormData();
        formData.append("cuerpo", html_comentario_tarea);
        formData.append("id_comentario", id_comentario);
        var csrfToken = "{{ csrf_token() }}";
        formData.append("_token", csrfToken);
        $.ajax({
            url: "{{url('crear-actualizar-comentario-incidencia')}}",           
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            async: false,
            success: function(data) {      
                DevExpress.ui.notify({
                    position: 'top',
                    message: 'Comentario actualizado con éxito.',
                    width: 300,
                    shading: false,
                }, "success", 800);
            },
            error: function() {}
        })

        $(`#previsualizador-comentario-${id_comentario}`).html(html_comentario_tarea);
        $(`#div-comentario-${id_comentario}`).removeClass("d-none").addClass('d-block');
        $(this).closest('.div-summernote-editar').remove();

    });

    $(document).on('click', '.eliminar_comentario_tarea', function() {
        let id_comentario = $(this).data('id_comentario');
        let id_incidencia = $(this).data('id_tarea');

        var customDialog = DevExpress.ui.dialog.custom({
            title: "Confirmación de eliminación",
            message: "¿Está seguro de eliminar este comentario?",
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
                    url: "{{url('eliminar-comentario-incidencia')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id_comentario': id_comentario,
                    },
                    type: 'post',
                    async: false,
                    success: function(data) {
                  
                        DevExpress.ui.notify({
                            position: 'top',
                            message: 'Comentario eliminado con éxito.',
                            width: 300,
                            shading: false,
                        }, "success", 800);
                        
                        ListarComentariosTarea(id_incidencia);
                    },
                    error: function(data) {                     
                        DevExpress.ui.notify({
                            position: 'top',
                            message:  'Ocurrio un error.',
                            width: 300,
                            shading: false,
                        }, "error", 800);
                    }
                });
            }
        });

    });


    $(document).on('click', '.btn_cancelar_comentario_tarea', function() {
        let id_comentario = $(this).data('id');
        $(`#div-comentario-${id_comentario}`).removeClass("d-none").addClass('d-block');
        $(`#${$(this).data('id_html')}`).remove();
    });

    $(document).on('click', '.btn_crear_comentario_tarea', function() {
        let id_incidencia = $(this).data('id');
        let html_comentario_tarea = $(`#summernote-crear-comentarios`).summernote('code');

        var formData = new FormData();
        formData.append("cuerpo", html_comentario_tarea);
        formData.append("id_incidencia", id_incidencia);
        var csrfToken = "{{ csrf_token() }}";
        formData.append("_token", csrfToken);
        $.ajax({
            url: "{{url('crear-actualizar-comentario-incidencia')}}",           
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            async: false,
            success: function(data) {             
                DevExpress.ui.notify({
                    position: 'top',
                    message: 'Comentario creado con éxito.',
                    width: 300,
                    shading: false,
                }, "success", 800);
                ListarComentariosTarea(id_incidencia);
            },
            error: function() {
                DevExpress.ui.notify({
                    position: 'top',
                    message: 'Ocurrió un error al guardar el comentario.',
                    width: 300,
                    shading: false,
                }, "error", 800);               
            }
        })
    });


    function EditarIncidencia(parametro){   

        var data = {
            "_token": "{{ csrf_token() }}",
            'id_incidencia': "{{$incidencia['id_incidencia']}}",
        };
        
        // Agrega la variable parametro como propiedad al objeto de datos
        data[parametro] = $(`#${parametro}`).val();

        $.ajax({
            type: 'POST',
            url: "{{url('crear-incidencia')}}",
            data: data,
            async: false,
            success: function(data) {
                if(visualizar_alerta_cambio == 1){
                    DevExpress.ui.notify({
                        position: 'top',
                        message: "Incidencia actualizada exitosamente",
                        width: 300,
                        shading: false,
                    }, "success", 800);
                }
              
            },
            error: function(error) {
                if(visualizar_alerta_cambio == 1){
                    DevExpress.ui.notify({
                        position: 'top',
                        message: "Ocurrio un error",
                        width: 300,
                        shading: false,
                    }, "error", 800);               
                }

            }
        })


    }
</script>
@endsection

@section('scripts')
<script src="{{asset('js/libs/datatable-btns.js?ver=2.9.0')}}"></script>
<link rel="stylesheet" href="{{asset('css/editors/summernote.css?ver=2.9.0')}}">
<script src="{{asset('js/libs/editors/summernote.js?ver=2.9.0')}}"></script>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-es-ES.js"></script>
@endsection