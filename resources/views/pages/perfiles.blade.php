@extends('layouts.app')
@section('title')
<title>Perfiles</title>
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
<div class="modal fade" data-backdrop="static" id="md-crear-perfil">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-crear-actualizar-perfil"></h5>
                <a href="#" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross "></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="form-crear-perfil" class="form-validate is-alter">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nombre <strong class="text-danger">*</strong> </label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                    </div>
                    <div class="treeview_container p-1">
                        <div id="treeview"></div>
                    </div>


                    <div class="form-group d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-md btn-outline-light mr-1" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn-crear-perfil" class="btn btn-md btn-primary">Guardar</button>
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

                                
                                <h5 for="">Filtro de búsqueda</h5>
                                <div style="background-color: #f5f6fa;padding: 0.5rem;" id="filtro_busqueda" class="px-1 d-none mb-4">
                                    <div class="input-group ">
                                        <input type="text" class="form-control" placeholder="Buscar perfiles" aria-label="Buscar perfiles" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button"><em class="icon ni ni-search"></em><span class="m-0">Buscar</span></button>
                                        </div>
                                    </div>
                                </div>

                                <table id="tbl-perfil" class="table table-striped table-bordered w-100">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col font-weight-normal"><span class="sub-text">Perfil</span></th>
                                            <th class="nk-tb-col tb-col-mb font-weight-normal"><span class="sub-text">Modulos</span></th>
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
    var modulos = <?php echo json_encode($modulos) ?>
    /* ------------------------------------------------------------------
                 FUNCIONES CREACION perfil
    ------------------------------------------------------------------ */
    function pintarArbol(container, data) {
        const treeView = $(container);
        function construirArbol(parent, items) {
            for (const item of items) {
                let clase_li = "";
                if (!item.submenu) {
                    clase_li = "d-flex align-items-center";
                    if (item.cantidad_hijos > 0) { //si es un padre cuyo total de hijos estan asignados no aparece
                        clase_li = "d-none-2";
                    }
                }
                var node = $(`<li class="${clase_li}" data-id="${item.id_modulo}">
                        <i role="button" class="icon ni ni-minus ${(!item.submenu) ? "d-none-2" : ""}"></i>
                        <label class='bg-inherit mb-0'>
                            <input role="button" id="modulo_${item.id_modulo}" ${(item.submenu) ? 'data-check=0' : 'data-check=1'}" name='modulo[]' value="${item.id_modulo}" data-id="${item.id_modulo}" data-cantidad_hijos="${(!item.submenu) ? 0 : item.submenu.length}" type="checkbox" /> ${item.nombre}
                        </label>                 
                    </li>`);

                parent.append(node);
                if (item.submenu) {
                    const ul = $("<ul style='display:block!important' class='pl-4'></ul>");
                    node.append(ul);
                    construirArbol(ul, item.submenu);
                }
            }
        }
        construirArbol(treeView, data);
    }


    var id_perfil = 0;
    $(document).on('click', '#btn-md-crear-perfil', function() {
        id_perfil = 0;
        $("#treeview").html("");
        pintarArbol("#treeview", modulos);
        $("#treeview").hummingbird();
        ResetForm('form-crear-perfil');
        $("#titulo-crear-actualizar-perfil").html('Nuevo Perfil');
        $("#md-crear-perfil").modal('show');
    })

    $(document).on('click','.btn-md-editar-perfil',function(){
        $("#treeview").html("");
        pintarArbol("#treeview", modulos);
        $("#treeview").hummingbird();
        ResetForm('form-crear-perfil');
        id_perfil = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: "{{url('traer-perfil')}}",
            async: false,
            data:{
                id_perfil
            },
            success: function(data){
                $("#nombre").val(data.nombre);
                $.each(data.modulos,function(i,item){                   
                    $(`#modulo_${item}`).prop('checked',true);
                })
            }
        })
        $("#titulo-crear-actualizar-perfil").html('Editar Perfil');
        $("#md-crear-perfil").modal('show');
    })


    $(document).on('click', '#btn-crear-perfil', function() {
        if (!$('#form-crear-perfil').valid()) {
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
            url: "{{url('crear-perfil')}}",
            data: $('#form-crear-perfil').serialize() + '&id_perfil=' + encodeURIComponent(id_perfil),
            async: false,
            success: function(data) {
                DevExpress.ui.notify({
                    position: 'top',
                    message: (id_perfil == 0) ? "Perfil creado exitosamente" : "Perfil actualizado exitosamente",
                    width: 200,
                    shading: false,
                }, "success", 800);
                $('#tbl-perfil').DataTable().ajax.reload();
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
        $("#md-crear-perfil").modal('hide');
        $(btn).prop('disabled', false);
    });



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
        $("#form-crear-perfil").validate({
            rules: {
                nombre: "required",            
            },
            messages: {
                nombre: "Este campo es requerido",             
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

        $('#tbl-perfil').DataTable({
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
                "zeroRecords": "perfil no encontrado",
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
                "url": "{{ url('tabla-perfiles')}}",
                "type": 'GET',
            },
            "searching": false, // Aquí se oculta la barra de búsqueda
            dom: "<'row'<'col-sm-6'l><'col-sm-6 text-right'<'custom-button'>>>" + // Aquí defines tu propia estructura con el botón
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>", // Estructura predeterminada para la paginación e información
            initComplete: function () { // Aquí puedes añadir tu botón personalizado
                $('.custom-button').html('<button type="button" class="btn btn-primary" id="btn-md-crear-perfil" data-toggle="modal">Nuevo Perfil&nbsp<em class="icon ni ni-plus-c"></em></button></button>');
            },
            "pageLength": 10,
            "columns": [{
                    "data": "nombre",
                    'className': 'align-middle',
                },
                {
                    "data": 'modulos',
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
                    placeholder: 'Descripción del perfil',
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
<script src="{{asset('libs/treeview/hummingbird-treeview.js')}}"></script>

@endsection