@extends('layouts.app')
@section('title')
<title>Incidencias</title>
@endsection

@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/cropperjs"></script>
<link rel="stylesheet" href="{{asset('libs/virtual-select/virtual-select.min.css')}}">
<script src="{{asset('libs/virtual-select/virtual-select.js')}}"></script>

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
                                        <select class="form-control form-select" id="tipo" name="tipo">
                                         
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            {{--
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Sistema</label>
                                    <div class="form-control-wrap">
                                        <select class="form-control form-select" data-search="on" id="sistema" name="sistema"></select>
                                    </div>
                                </div>
                            </div>
                            --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Cliente</label>
                                    <div class="form-control-wrap">
                                        <select class="form-control form-select" data-search="on" id="cliente" name="cliente"></select>
                                    </div>
                                </div>
                            </div>
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
                        <!-- <div class="row mt-2">
                      
                        </div> -->
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
                                        <input id="fecha_vencimiento" name="fecha_vencimiento" type="date" class="form-control">
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
                                <div class="w-100 d-flex justify-content-between align-items-center">
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
                                    @endif      
                                </div>

                                <h5 for="">Filtros de búsqueda</h5>
                                <div style="background-color: #f5f6fa;padding: 0.5rem;" id="filtro_busqueda" class="mb-3 d-none">
                                    <div style="padding: 0.5rem 0rem;" class="card-inner position-relative card-tools-toggle" data-select2-id="49">
                                        <div class="card-title-group" data-select2-id="39">
                                            <div class="card-tools" data-select2-id="38">
                                                <div class="form-inline flex-nowrap gx-3 align-items-end" data-select2-id="37">
                                                    <div class="form-wrap d-flex" style="gap: 1rem;" >                                                               
                                                        <select class="w-100" multiple id="filtro_proyecto" name="native-select" placeholder="Proyecto" data-search="false" data-silent-initial-value-set="true">                  
                                                            @foreach($proyectos as $item)
                                                                <option value="{{$item->id_proyecto}}">{{$item->nombre_proyecto}}</option>
                                                            @endforeach
                                                        </select>                                                       

                                                        <select multiple id="filtro_tipo" name="native-select" placeholder="Tipo" data-search="false" data-silent-initial-value-set="true">                                               
                                                            @foreach($tipos_incidencia as $item)
                                                                    <option value="{{$item->id_nombre_tipo}}">{{$item->nombre_tipo}}</option>
                                                            @endforeach
                                                        </select>

                                                        <select multiple id="filtro_estado" name="native-select" placeholder="Estado" data-search="false" data-silent-initial-value-set="true">                                                            
                                                                @foreach($estados as $item)
                                                                    <option value="{{$item->id_estado}}">{{$item->nombre_estado}}</option>
                                                                @endforeach
                                                        </select>

                                                        <select multiple id="filtro_persona_asignada" name="native-select" placeholder="Persona Asignada" data-search="false" data-silent-initial-value-set="true">                                                            
                                                                @foreach($usuarios as $item)
                                                                    <option value="{{$item->id_staff}}">{{$item->apellido_paterno_staff}} {{$item->apellido_materno_staff}} {{$item->nombre_staff}}</option>
                                                                @endforeach
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
                                                    <input type="text" class="form-control border-transparent form-focus-none" placeholder="Buscar incidencias">
                                                    <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
                                                    <th hidden></th>
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
    function formatoSelectorCirculo(proyecto) {
        if (!proyecto.id) {
            return proyecto.text;
        }
        var $proyecto = $(           
            '<span> <span style="font-size:1.2rem; color:'+proyecto.color+'">●</span> ' + proyecto.text + "</span>"
        );
        return $proyecto;
    };

    function formatoSelector(proyecto) {
        if (!proyecto.id) {
            return proyecto.text;
        }
        var $proyecto = $(
            '<img  style="width:1em;" class="mr-1" src="files/' + proyecto.image + '">' +
            '<span></span>' + proyecto.text + "</span>"
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
            item['color'] = item.color_prioridad;   
            item['image'] = `prioridad/${item.imagen_prioridad}`;
            return item;
        });
        $("#prioridad").select2({
            placeholder: "Seleccione",
            templateResult: formatoSelectorCirculo,
            templateSelection: formatoSelectorCirculo,
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
                    item['id'] = item.id_tipo;
                    item['text'] = item.nombre_tipo;
                    item['image'] = `tipo_incidencia/${item.imagen_tipo}`;
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


        $("#cliente").select2({
            width: "100%",
            ajax: {
                url: "{{url('listar-cliente-autocomplete')}}", //URL for searching companies
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
                                text: item.nombre_cliente,
                                id: item.id_cliente,                
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
                noResults: function() {
                    return "No se encontraron resultados";
                },
            },
            placeholder: "Busque un cliente",
            escapeMarkup: function(m) {
                return m;
            },
            minimumInputLength: 0
        });



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
        $("#filtro_busqueda").removeClass("d-none");
   
        VirtualSelect.init({ 
            ele: '#filtro_proyecto' ,          
            selectAllText: 'Seleccionar todo',
            noOptionsText: 'No se encontraron resultados',
            noSearchResultsTex: 'No se encontraron resultados',
            searchPlaceholderText: 'Buscar...',
            optionsSelectedText: 'Opciones seleccionadas',
            optionSelectedText: 'Opción seleccionada',
            allOptionsSelectedText: 'Proyectos',            
            dropboxWidth: "500px",
        });

        VirtualSelect.init({ 
            ele: '#filtro_tipo' ,
            selectAllText: 'Seleccionar todo',
            noOptionsText: 'No se encontraron resultados',
            noSearchResultsTex: 'No se encontraron resultados',
            searchPlaceholderText: 'Buscar...',
            optionsSelectedText: 'Opciones seleccionadas',
            optionSelectedText: 'Opción seleccionada',
            allOptionsSelectedText: 'Tipos',            
            dropboxWidth: "500px",
        });
        VirtualSelect.init({ 
            ele: '#filtro_estado' ,
            selectAllText: 'Seleccionar todo',
            noOptionsText: 'No se encontraron resultados',
            noSearchResultsTex: 'No se encontraron resultados',
            searchPlaceholderText: 'Buscar...',
            optionsSelectedText: 'Opciones seleccionadas',
            optionSelectedText: 'Opción seleccionada',
            allOptionsSelectedText: 'Estados',            
            dropboxWidth: "500px",
        });
        VirtualSelect.init({ 
            ele: '#filtro_persona_asignada' ,
            selectAllText: 'Seleccionar todo',
            noOptionsText: 'No se encontraron resultados',
            noSearchResultsTex: 'No se encontraron resultados',
            searchPlaceholderText: 'Buscar...',
            optionsSelectedText: 'Opciones seleccionadas',
            optionSelectedText: 'Opción seleccionada',
            allOptionsSelectedText: 'Personas asignadas',            
            dropboxWidth: "500px",
        });

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
                // $('.dataTables_length').appendTo('#div_dataTables_length');
                // $("#tbl-incidencia_length").find('label').addClass('d-flex');

                // $('.dataTables_filter').appendTo('#div_dataTables_filter');
                // $("#tbl-incidencia_filter").find('label').addClass('d-flex');


                $('.dataTables_paginate').appendTo('#div_dataTables_paginate');
                $('.custom-button').html('<button type="button" class="btn btn-primary" id="btn-md-crear-incidencia" data-toggle="modal"><span>Nueva Incidencia</span> <em class="icon ni ni-plus-c"></em></button>');

            },

            "searching": false, // Aquí se oculta la barra de búsqueda
            dom: "<'row'<'col-sm-6'l><'col-sm-6 text-right'<'custom-button'>>>" + // Aquí defines tu propia estructura con el botón
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>", // Estructura predeterminada para la paginación e información
       

            "columns": [
                {
                    "data": "orden",
                    'className': 'align-middle',
                    'visible': false
                },
                {
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