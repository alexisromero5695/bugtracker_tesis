@extends('layouts.app')
@section('title')
<title>Inicio</title>
@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php

use App\Helpers\Helper;
?>
@section('content')
<!-- 
    --------------------------------------------------------------------------------
                                            CUERPO
    --------------------------------------------------------------------------------    
-->

<div class="nk-content pt-0 ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview  mx-auto">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-2">
                                <div class="card-body py-2">
                                    <h5><em class="icon ni ni-growth-fill"></em> Panel global de seguimiento</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9">

                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>150</h3>
                                            <p class="mb-1">Proyectos</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-checkmark-circled"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3 class="text-white">53</h3>
                                            <p class="mb-1">Incidencias abiertas</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bug"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3 class="text-white">150</h3>
                                            <p class="mb-1 text-white">Clientes</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-flag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3 class="text-white">90%</h3>
                                            <p class="mb-1 text-dark">Tasa de resolución</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-stats-bars"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>


                            <div class="card mb-2">
                                <div class="card-body py-2">
                                    <h5><em class="icon ni ni-list-index"></em> Ultimas incidencias</h5>
                                </div>
                            </div>


                            <div class="card border-top-card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="mis-incidencias-tab" data-toggle="tab" href="#mis-incidencias" role="tab" aria-controls="mis-incidencias" aria-selected="true">Asignadas a mi</a>
                                        </li>
                                        @foreach($estados as $item)
                                        <li class="nav-item">
                                            <a class="nav-link" id="estado-{{$item->id_estado}}-tab" data-toggle="tab" href="#estado-{{$item->id_estado}}" role="tab" aria-controls="estado-{{$item->id_estado}}" aria-selected="false">{{$item->nombre_estado}}</a>
                                        </li>
                                        @endforeach

                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        
                                        <div class="tab-pane fade show active" id="mis-incidencias" role="tabpanel" aria-labelledby="mis-incidencias-tab">
                                            <div class="table-responsive">

                                            

                                                <div class="nk-tb-list nk-tb-orders ">
                                                    <div class="nk-tb-item nk-tb-head">
                                                        <div class="nk-tb-col"><span>Clave.</span></div>
                                                        <div class="nk-tb-col tb-col-md"><span>Resumen</span></div>
                                                        <div class="nk-tb-col tb-col-sm"><span>Estado</span></div>
                                                        <div class="nk-tb-col tb-col-lg"><span>Prioridad</span></div>
                                                        <div class="nk-tb-col"><span>Tipo</span></div>
                                                        <div class="nk-tb-col"><span>Persona asignada</span></div>
                                                        <div class="nk-tb-col"><span>Ultima modificación</span></div>
                                                    </div>

                                                    @foreach($incidencias as $item)

                                                    <?php
                                                    if ($item->id_responsable) {
                                                        $handlerAbrev = strtoupper(substr($item->nombre_responsable, 0, 1) . '' . substr($item->apellido_paterno_responsable, 0, 1));
                                                        $responsable = "<div class='user-card text-nowrap'>
                                                            <div class='user-avatar xs bg-$item->color_responsable'>
                                                                <span>$handlerAbrev</span>
                                                            </div>
                                                            <div class=''>
                                                                <span class='tb-lead ml-2'>$item->nombre_responsable $item->apellido_paterno_responsable</span>
                                                            </div>
                                                        </div>";
                                                    } else {
                                                        $responsable = "<div class='user-card text-nowrap'>
                                                            <img style='width:26px' src='/images/default/sin-asignar.svg'>
                                                            <div class=''>
                                                                <span class='tb-lead ml-2'>Sin asignar</span>
                                                            </div>
                                                        </div>";
                                                    }
                                                    ?>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col"><span class="tb-lead"><a href="/incidencia/{{$item->codigo_proyecto}}-{{$item->numero_incidencia}}">{{$item->codigo_proyecto}}-{{$item->numero_incidencia}}</a></span></div>
                                                        <div class="nk-tb-col"><span class="tb-lead"><a href="/incidencia/{{$item->codigo_proyecto}}-{{$item->numero_incidencia}}">{{$item->nombre_incidencia}}</a></span></div>
                                                        <div class="nk-tb-col text-center"><span class="tb-lead">
                                                                <span style="border-radius: 14px; background: {{$item->color_estado}}; color: {{$item->color_texto_estado}};padding: 3px 8px;" class="text-nowrap">{{$item->estado}}</span>
                                                        </div>
                                                        <div class="nk-tb-col text-center"><span class="tb-lead">
                                                                <span style="border-radius: 14px; background: {{$item->color_prioridad}}; color: {{$item->color_texto_prioridad}};padding: 3px 8px;" class="text-nowrap">{{$item->prioridad}}</span>
                                                        </div>
                                                        <div class="nk-tb-col"><span class="tb-lead">{{$item->tipo}}</span></div>
                                                        <div class="nk-tb-col">{!! $responsable !!}</div>
                                                        <div class="nk-tb-col">
                                                            <em class="icon ni ni-clock"></em> <?php echo Helper::tiempoTranscurrido($item->fecha_actualizacion_incidencia); ?>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @foreach($estados as $item)
                                        <div class="tab-pane fade" id="estado-{{$item->id_estado}}" role="tabpanel" aria-labelledby="estado-{{$item->id_estado}}-tab">...</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">

                            <div class="card border-top-card">
                                <div class="card-body">
                                    <h5 class="card-title">Grafico de incidencias por estado</h5>                                   
                                    <canvas id="grafico_estado"></canvas>
                                    <ul class="list-unstyled mt-1">
                                        <li class="d-flex justify-content-between">
                                            <span>Activo</span>
                                            <span style="color:green">65%</span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <span>Cerrado</span>
                                            <span style="color:red">35%</span>
                                        </li>
                                    </ul>
                                    
                                </div>
                            </div>

                            <div class="card border-top-card">
                                <div class="card-body">
                                    <h5 class="card-title">Grafico de incidencias por prioridad</h5>                                   
                                    <canvas id="grafico_prioridad"></canvas>                                 
                                    
                                </div>
                            </div>

                        </div>                        
                    </div>



                    <!-- <div class="nk-block nk-block-lg ">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title mb-0">Bienvenido {{Session::get('nombre_staff')}} {{Session::get('apellido_paterno_staff')}} {{Session::get('apellido_materno_staff')}}</h4>
                                <div class="nk-block-des">
                                    <p>Empresa: <b>Empresa Prueba</b> </p>
                                </div>

                            </div>
                        </div>
                        <section id="recent_projects">




                            <h6>Proyectos recientes</h6>
                            <div class="card-columns">
                                <div class="card card-bordered m-0 p-0">
                                    <img src="https://www.baxterip.com.au/wp-content/uploads/2021/02/Software-patents-hero-image.svg" class="card-img-top" alt="">
                                    <div class="card-inner text-center">
                                        <h5 class="card-title">Card with stretched link</h5>
                                        <a href="#" class="btn btn-primary">Ver proyecto</a>
                                    </div>
                                </div>
                                <div class="card card-bordered m-0 p-0">
                                    <img src="https://www.baxterip.com.au/wp-content/uploads/2021/02/Software-patents-hero-image.svg" class="card-img-top" alt="">
                                    <div class="card-inner text-center">
                                        <h5 class="card-title">Card with stretched link</h5>
                                        <a href="#" class="btn btn-primary">Ver proyecto</a>
                                    </div>
                                </div>
                                <div class="card card-bordered m-0 p-0">
                                    <img src="https://www.baxterip.com.au/wp-content/uploads/2021/02/Software-patents-hero-image.svg" class="card-img-top" alt="">
                                    <div class="card-inner text-center">
                                        <h5 class="card-title">Card with stretched link</h5>
                                        <a href="#" class="btn btn-primary">Ver proyecto</a>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div> -->
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>
</div>

<script>
    var data_chart_estado = <?php echo json_encode($data_chart_estado) ?>;
    var data_chart_prioridad = <?php echo json_encode($data_chart_prioridad) ?>;
   
//  var data = {
    //   labels: ['Nuevo', 'En desarrollo', 'Cerrado', 'Purple','Red', ],
    //   datasets: [{
    //     label: 'My Dataset',
    //     data: [12, 19, 3, 5, 2],
    //     backgroundColor: [
     
    //       '#0098DA',
    //       '#f4bd0e',
    //       '#00875a',
    //       'rgba(153, 102, 255, 0.5)',
    //       'rgba(255, 99, 132, 0.5)',
    //     ],
    //     borderColor: [      
    //       '#0098DA',
    //       '#f4bd0e',
    //       '#00875a',
    //       'rgba(153, 102, 255, 1)',
    //       'rgba(255, 99, 132, 1)',
    //     ],
    //     borderWidth: 1
    //   }]
    //    }
    // };

    // Configuración del gráfico
    var options = {
      responsive: true,
      cutoutPercentage: 50,
      animation: {
        animateScale: true,
        animateRotate: true
      }
    };

    // Crear el gráfico de tipo doughnut
    var ctx = document.getElementById('grafico_estado').getContext('2d');
    var grafico_estado = new Chart(ctx, {
      type: 'doughnut',
      data: data_chart_estado,
      options: options
    });


    var ctx = document.getElementById('grafico_prioridad').getContext('2d');
    var grafico_prioridad = new Chart(ctx, {
      type: 'doughnut',
      data: data_chart_prioridad,
      options: options
    });
</script>
@endsection

@section('scripts')
<script src="{{asset('js/libs/datatable-btns.js?ver=2.9.0')}}"></script>
<link rel="stylesheet" href="{{asset('css/editors/summernote.css?ver=2.9.0')}}">
<script src="{{asset('js/libs/editors/summernote.js?ver=2.9.0')}}"></script>

@endsection