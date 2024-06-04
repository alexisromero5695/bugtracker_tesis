@extends('layouts.app')
@section('title')
<title>Reportes</title>
@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="{{asset('libs/virtual-select/virtual-select.min.css')}}">
<script src="{{asset('libs/virtual-select/virtual-select.js')}}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/iconos/material-design-icon/css/materialdesignicons.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/iconos/material-icon/material-icons.css')}}">
<?php

use App\Helpers\Helper;
?>
@section('content')
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


                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="incidencias-reportadas-tab" data-toggle="tab" href="#incidencias-reportadas" role="tab" aria-controls="incidencias-reportadas" aria-selected="true">Incidencias reportadas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="incidencias-atendidas-tab" data-toggle="tab" href="#incidencias-atendidas" role="tab" aria-controls="incidencias-atendidas" aria-selected="true">Incidencias atendidas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="incidencias-no-atendidas-tab" data-toggle="tab" href="#incidencias-no-atendidas" role="tab" aria-controls="incidencias-no-atendidas" aria-selected="true">Incidencias no atendidas</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="incidencias-reportadas" role="tabpanel" aria-labelledby="incidencias-reportadas-tab">

                                        <div class="tab-pane active" id="actividades">

                                            <div class="mb-2">
                                                <fieldset class="border-main rounded-3 px-3 pb-3">
                                                    <legend class="float-none w-auto px-3 text-dark fw-bolder" style="font-size: 1rem;">Filtros de búsqueda</legend>

                                                    <div class="row px-3 align-items-end">

                                                        <div class="from-group">
                                                            <label for="" class="mb-0">Tipo </label>
                                                            <select class="w-100" multiple id="filtro_tipo" name="native-select" placeholder="Tipo" data-search="false" data-silent-initial-value-set="true">
                                                            </select>
                                                        </div>

                                                        <div class="form-group mb-0 ml-2 col-md-2">
                                                            <label for="" class="mb-0">Estado </label>
                                                            <select class="w-100" multiple id="filtro_estado" name="native-select" placeholder="Estado" data-search="false" data-silent-initial-value-set="true">
                                                            </select>
                                                        </div>

                                                        <div class="form-group mb-0 ml-2 col-md-2">
                                                            <label for="" class="d-block mb-0">Fecha desde </label>
                                                            <input type="date" name="" class="form-control" id="">
                                                        </div>

                                                        <div class="form-group mb-0 ml-2 col-md-2">
                                                            <label for="" class="d-block mb-0">Fecha hasta </label>
                                                            <input type="date" name="" class="form-control" id="">
                                                        </div>


                                                        <div class="form-group mb-0 col-md-2" id="dropdownParentPropietarioNegocio">
                                                            <label for="" class="d-block mb-0">Persona asignada </label>
                                                            <select class="w-100" multiple id="filtro_persona_asignada" name="native-select" placeholder="Persona asignada" data-search="false" data-silent-initial-value-set="true">
                                                            </select>
                                                        </div>

                                                        <button class="btn btn-primary"><em class="icon ni ni-search"></em><span class="m-0">Buscar</span></button>
                                                    </div>
                                                </fieldset>




                                                <div class="row mt-4">

                                                    <div class="col-md-6">
                                                        <figure class="highcharts-figure">
                                                            <div id="gb_incidencias_reportadas"></div>
                                                        </figure>


                                                    </div>

                                                    <div class="col-md-3">
                                                        <figure class="highcharts-figure">
                                                            <div id="gt_estado_incidencias_reportadas"></div>
                                                        </figure>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <figure class="highcharts-figure">
                                                            <div id="gt_prioridad_incidencias_reportadas"></div>
                                                        </figure>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 d-flex align-items-center justify-content-center" style="gap: 1rem;">
                                                        <button class="btn btn-green">
                                                            <span style="font-size: 1.5rem;" class="mdi mdi-file-excel-outline"> </span> <span style="top: 1;position: relative;">DESCARGAR</span>
                                                        </button>

                                                        <button class="btn btn-danger">
                                                            <span style="font-size: 1.5rem;" class="mdi mdi-file-pdf-box"></span><span style="top: 1;position: relative;">DESCARGAR</span>
                                                        </button>

                                                        <button class="btn btn-primary">
                                                            <span style="font-size: 1.5rem;" class="mdi mdi-code-json"></span><span style="top: 1;position: relative;">&nbspDESCARGAR</span>
                                                        </button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div style="border: 3px solid #000 !important; border-radius: 10px;" class="w-100 p-1">
                                                            <table class="w-100 text-dark">
                                                                <tbody>
                                                                    <tr style="border: 0px;">
                                                                        <td style="" width="70%"><em class="icon ni ni-clock"></em> Tiempo promedio de resolución</td>
                                                                        <td style="" width="30%" class="text-right"><span id="tbl_total_pagos_nota_credito_venta">1 día</span></td>
                                                                    </tr>
                                                                    <tr style="border: 0px;">
                                                                        <td style="" width="70%"><em class="icon ni ni-clock"></em> Tiempo promedio de clasificación</td>
                                                                        <td style="" width="30%" class="text-right"><span id="total_general_ventas">30 minutos</span></td>
                                                                    </tr>
                                                                    <tr style="border: 0px;">
                                                                        <td style="" width="70%"><em class="icon ni ni-percent"></em> Porcentaje de incidencias resueltas a tiempo</td>
                                                                        <td style="" width="30%" class="text-right"><span id="total_general_ventas">95%</span></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- <div class="text-right mt-2">
                                                    <button class="btn btn-primary"><em class="icon ni ni-search"></em><span class="m-0">Buscar</span></button>
                                                </div> -->

                                            </div>
                                            <div id="div_gestion_actividad" class="d-flex flex-wrap">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="tab-pane fade show" id="incidencias-atendidas" role="tabpanel" aria-labelledby="incidencias-atendidas-tab">
                                    </div>

                                    <div class="tab-pane fade show" id="incidencias-no-atendidas" role="tabpanel" aria-labelledby="incidencias-no-atendidas-tab">
                                    </div>
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
    var data_chart_estado = <?php echo json_encode($data_chart_estado) ?>;
    var data_chart_prioridad = <?php echo json_encode($data_chart_prioridad) ?>;
    $(document).ready(function() {
        $("#filtro_busqueda_incidencias_reportadas").removeClass("d-none");

        VirtualSelect.init({
            ele: '#filtro_tipo',
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
            ele: '#filtro_estado',
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
            ele: '#filtro_persona_asignada',
            selectAllText: 'Seleccionar todo',
            noOptionsText: 'No se encontraron resultados',
            noSearchResultsTex: 'No se encontraron resultados',
            searchPlaceholderText: 'Buscar...',
            optionsSelectedText: 'Opciones seleccionadas',
            optionSelectedText: 'Opción seleccionada',
            allOptionsSelectedText: 'Proyectos',
            dropboxWidth: "500px",
        });



        // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar

        // Create the chart
        // Highcharts.chart('gb_incidencias_reportadas', {
        //     chart: {
        //         type: 'column'
        //     },
        //     title: {
        //         align: 'left',
        //         text: 'Incidencias reportadas desde 01-02-2023 a 05-06-2023'
        //     },
        //     subtitle: {
        //         align: 'left',
        //     },
        //     accessibility: {
        //         announceNewData: {
        //             enabled: true
        //         }
        //     },
        //     xAxis: {
        //         type: 'category'
        //     },
        //     yAxis: {
        //         title: {
        //             text: 'Total percent market share'
        //         }

        //     },
        //     legend: {
        //         enabled: false
        //     },
        //     plotOptions: {
        //         series: {
        //             borderWidth: 0,
        //             dataLabels: {
        //                 enabled: true,
        //                 format: '{point.y:.1f}%'
        //             }
        //         }
        //     },

        //     tooltip: {
        //         headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        //         pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
        //     },

        //     series: [{
        //         name: 'Mes',
        //         colorByPoint: true,
        //         data: [{
        //                 name: 'Enero',
        //                 y: 63.06,
        //                 drilldown: 'Chrome'
        //             },
        //             {
        //                 name: 'Febrero',
        //                 y: 19.84,
        //                 drilldown: 'Safari'
        //             },
        //             {
        //                 name: 'Firefox',
        //                 y: 4.18,
        //                 drilldown: 'Firefox'
        //             },
        //             {
        //                 name: 'Edge',
        //                 y: 4.12,
        //                 drilldown: 'Edge'
        //             },
        //             {
        //                 name: 'Opera',
        //                 y: 2.33,
        //                 drilldown: 'Opera'
        //             },
        //             {
        //                 name: 'Internet Explorer',
        //                 y: 0.45,
        //                 drilldown: 'Internet Explorer'
        //             },
        //             {
        //                 name: 'Other',
        //                 y: 1.582,
        //                 drilldown: null
        //             }
        //         ]
        //     }],
        //     drilldown: {
        //         breadcrumbs: {
        //             position: {
        //                 align: 'right'
        //             }
        //         },
        //         series: [{
        //                 name: 'Chrome',
        //                 id: 'Chrome',
        //                 data: [
        //                     [
        //                         'v65.0',
        //                         0.1
        //                     ],
        //                     [
        //                         'v64.0',
        //                         1.3
        //                     ],
        //                     [
        //                         'v63.0',
        //                         53.02
        //                     ],
        //                     [
        //                         'v62.0',
        //                         1.4
        //                     ],
        //                     [
        //                         'v61.0',
        //                         0.88
        //                     ],
        //                     [
        //                         'v60.0',
        //                         0.56
        //                     ],
        //                     [
        //                         'v59.0',
        //                         0.45
        //                     ],
        //                     [
        //                         'v58.0',
        //                         0.49
        //                     ],
        //                     [
        //                         'v57.0',
        //                         0.32
        //                     ],
        //                     [
        //                         'v56.0',
        //                         0.29
        //                     ],
        //                     [
        //                         'v55.0',
        //                         0.79
        //                     ],
        //                     [
        //                         'v54.0',
        //                         0.18
        //                     ],
        //                     [
        //                         'v51.0',
        //                         0.13
        //                     ],
        //                     [
        //                         'v49.0',
        //                         2.16
        //                     ],
        //                     [
        //                         'v48.0',
        //                         0.13
        //                     ],
        //                     [
        //                         'v47.0',
        //                         0.11
        //                     ],
        //                     [
        //                         'v43.0',
        //                         0.17
        //                     ],
        //                     [
        //                         'v29.0',
        //                         0.26
        //                     ]
        //                 ]
        //             },
        //             {
        //                 name: 'Firefox',
        //                 id: 'Firefox',
        //                 data: [
        //                     [
        //                         'v58.0',
        //                         1.02
        //                     ],
        //                     [
        //                         'v57.0',
        //                         7.36
        //                     ],
        //                     [
        //                         'v56.0',
        //                         0.35
        //                     ],
        //                     [
        //                         'v55.0',
        //                         0.11
        //                     ],
        //                     [
        //                         'v54.0',
        //                         0.1
        //                     ],
        //                     [
        //                         'v52.0',
        //                         0.95
        //                     ],
        //                     [
        //                         'v51.0',
        //                         0.15
        //                     ],
        //                     [
        //                         'v50.0',
        //                         0.1
        //                     ],
        //                     [
        //                         'v48.0',
        //                         0.31
        //                     ],
        //                     [
        //                         'v47.0',
        //                         0.12
        //                     ]
        //                 ]
        //             },
        //             {
        //                 name: 'Internet Explorer',
        //                 id: 'Internet Explorer',
        //                 data: [
        //                     [
        //                         'v11.0',
        //                         6.2
        //                     ],
        //                     [
        //                         'v10.0',
        //                         0.29
        //                     ],
        //                     [
        //                         'v9.0',
        //                         0.27
        //                     ],
        //                     [
        //                         'v8.0',
        //                         0.47
        //                     ]
        //                 ]
        //             },
        //             {
        //                 name: 'Safari',
        //                 id: 'Safari',
        //                 data: [
        //                     [
        //                         'v11.0',
        //                         3.39
        //                     ],
        //                     [
        //                         'v10.1',
        //                         0.96
        //                     ],
        //                     [
        //                         'v10.0',
        //                         0.36
        //                     ],
        //                     [
        //                         'v9.1',
        //                         0.54
        //                     ],
        //                     [
        //                         'v9.0',
        //                         0.13
        //                     ],
        //                     [
        //                         'v5.1',
        //                         0.2
        //                     ]
        //                 ]
        //             },
        //             {
        //                 name: 'Edge',
        //                 id: 'Edge',
        //                 data: [
        //                     [
        //                         'v16',
        //                         2.6
        //                     ],
        //                     [
        //                         'v15',
        //                         0.92
        //                     ],
        //                     [
        //                         'v14',
        //                         0.4
        //                     ],
        //                     [
        //                         'v13',
        //                         0.1
        //                     ]
        //                 ]
        //             },
        //             {
        //                 name: 'Opera',
        //                 id: 'Opera',
        //                 data: [
        //                     [
        //                         'v50.0',
        //                         0.96
        //                     ],
        //                     [
        //                         'v49.0',
        //                         0.82
        //                     ],
        //                     [
        //                         'v12.1',
        //                         0.14
        //                     ]
        //                 ]
        //             }
        //         ]
        //     }
        // });

        // Datos de incidencias por mes desde enero de 2023 a diciembre de 2023
        const data = {
              "Febrero 2022": 520,
            "Marzo 2022": 480,
            "Abril 2022": 510,
            "Mayo 2022": 530,
            "Junio 2022": 540,
            "Julio 2022": 550,
            "Agosto 2022": 560,
            "Setiembre 2022": 570,
            "Octubre 2022": 580,
            "Noviembre 2022": 590,
            "Diciembre 2022": 600,
            "Enero 2023": 600
        };

        // Convertir los datos en el formato requerido por Highcharts para un gráfico de columnas
        const chartData = Object.keys(data).map(month => ({
            name: month,
            y: data[month]
        }));

        // Crear el gráfico de columnas
        // Crear el gráfico de columnas
        Highcharts.chart('gb_incidencias_reportadas', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Incidencias desde 01/02/2022 a 10/01/2023'
            },
            xAxis: {
                categories: Object.keys(data)
            },
            yAxis: {
                title: {
                    text: 'Número de Incidencias'
                }
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true,
                        // Personaliza el formato de las etiquetas de datos como desees
                        formatter: function() {
                            return this.y;
                        }
                    }
                }
            },
            series: [{
                name: 'Incidencias',
                data: chartData.map((point, index) => ({
                    ...point,
                    color: index % 2 === 0 ? '#ccc' : '#0077c8' // Color alternativo para cada barra
                }))
            }]


        });



        Highcharts.setOptions({
            colors: ['#FF5733', '#0077C8', '#FFD700 ', '#A0E22B', '#00c014', '#EAEAEA'] // Colores personalizados
        });

        // Configurar el gráfico
        Highcharts.chart('gt_estado_incidencias_reportadas', {
            chart: {
                type: 'pie',
            },
            title: {
                text: 'Incidencias por estado'
            },
            tooltip: {
                valueSuffix: '%'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        format: '{point.percentage:.1f}%',
                        style: {
                            fontSize: '1.2em',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '>',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },
            series: [{
                name: 'Porcentaje',
                colorByPoint: true,
                data: [{
                        name: 'Nuevo',
                        y: 55.02
                    },
                    {
                        name: 'En desarrollo',
                        sliced: true,
                        selected: true,
                        y: 26.71
                    },
                    {
                        name: 'En consulta',
                        y: 1.09
                    },
                    {
                        name: 'QA',
                        y: 15.5
                    },
                    {
                        name: 'Cerrado',
                        y: 1.68
                    },
                    {
                        name: 'Suspendido',
                        y: 1.68
                    },
                ]
            }]
        });


        Highcharts.setOptions({
            colors: ['#FF5733', '#FFD700', '#A0E22B ', '#0077C8', '#EAEAEA'] // Colores personalizados
        });

        // Configurar el gráfico
        Highcharts.chart('gt_prioridad_incidencias_reportadas', {
            chart: {
                type: 'pie',
            },
            title: {
                text: 'Incidencias por prioridad'
            },
            tooltip: {
                valueSuffix: '%'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        format: '{point.percentage:.1f}%',
                        style: {
                            fontSize: '1.2em',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '>',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },





            series: [{
                name: 'Prioridad',
                colorByPoint: true,
                data: [{
                        name: 'Inmediata',
                        y:  8.5
                    },
                    {
                        name: 'Alta',
                        sliced: true,
                        selected: true,
                        y: 10.71
                    },
                    {
                        name: 'Media',
                        y: 55.02
                    },
                    {
                        name: 'Baja',
                        y:  16.09
                    },
                    {
                        name: 'Ninguna',
                        y: 1.68
                    }
                ]
            }]
        });

    });
</script>
@endsection



@section('scripts')
<script src="{{asset('js/libs/datatable-btns.js?ver=2.9.0')}}"></script>
<link rel="stylesheet" href="{{asset('css/editors/summernote.css?ver=2.9.0')}}">
<script src="{{asset('js/libs/editors/summernote.js?ver=2.9.0')}}"></script>

@endsection