@extends('layouts.app')
@section('title')
<title>Inicio</title>
@endsection

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


                    <div class="nk-block nk-block-lg ">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title mb-0">Bienvenido {{Session::get('nombre_staff')}} {{Session::get('apellido_paterno_staff')}} {{Session::get('apellido_materno_staff')}}</h4>
                                <div class="nk-block-des">
                                    <p>Empresa: <b>Empresa Prueba</b> </p>
                                </div>

                            </div>
                        </div>
                        <section id="recent_projects">

                            <div class="row">
                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3>150</h3>
                                            <p class="mb-1">Errores Abiertos</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bug"></i>
                                        </div>
                                        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3 class="text-white">53</h3>
                                            <p class="mb-1">Errores Cerrados</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bug"></i>
                                        </div>
                                        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3 class="text-white">53</h3>
                                            <p class="mb-1 text-white">Hitos Abiertos</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-flag"></i>
                                        </div>
                                        <!-- <a href="#" class="small-box-footer">More primary <i class="fas fa-arrow-circle-right"></i></a> -->
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3 class="text-white">53</h3>
                                            <p class="mb-1 text-white">Hitos Cerrados</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-flag"></i>
                                        </div>
                                        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                                    </div>
                                </div>

                            </div>




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

                    </div> <!-- nk-block -->
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>
</div>

<script>

</script>
@endsection

@section('scripts')
<script src="{{asset('js/libs/datatable-btns.js?ver=2.9.0')}}"></script>
<link rel="stylesheet" href="{{asset('css/editors/summernote.css?ver=2.9.0')}}">
<script src="{{asset('js/libs/editors/summernote.js?ver=2.9.0')}}"></script>

@endsection