@extends('layouts.app')

@section('content')

<div class="nk-block nk-block-middle nk-auth-body  wide-xs">
    <div class="brand-logo pb-4 text-center">
        <a href="html/index.html" class="logo-link">
            <img class="logo-light logo-img logo-img-lg" src="{{asset('images/logo-bugtracker.svg')}}" srcset="./images/logo-bugtracker.svg 2x" alt="logo">
            <img class="logo-dark logo-img logo-img-lg" src="{{asset('images/logo-bugtracker.svg')}}" srcset="./images/logo-bugtracker.svg 2x" alt="logo-dark">
        </a>
    </div>

    <div class="card card-bordered">
        <div class="card-inner card-inner-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Registrarte</h4>
                </div>
            </div>

            <form method="POST" id="form-registro">
                @csrf           
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="nombres" class="col-form-label text-md-end">Nombres <span class="text-danger">*</span></label>
                        <div>
                            <input id="nombres" type="text" class="form-control" name="nombres" required autocomplete="nombres" autofocus>
                        </div>
                    </div>                   
                </div>

                <div class="row mb-3">
                <div class="col-md-6">
                        <label for="apellido_paterno" class="col-form-label text-md-end">Apellido Paterno <span class="text-danger">*</span></label>
                        <div class="">
                            <input id="apellido_paterno" type="text" class="form-control" name="apellido_paterno" required autocomplete="apellido_paterno" autofocus>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="apellido_materno" class="col-form-label text-md-end">Apellido Materno <span class="text-danger">*</span></label>
                        <div class="">
                            <input id="apellido_materno" type="text" class="form-control" name="apellido_materno" required autocomplete="apellido_materno" autofocus>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="correo" class="col-form-label text-md-end">Correo electrónico <span class="text-danger">*</span></label>
                    <div class="">
                        <input id="correo" type="correo" class="form-control" name="correo" required autocomplete="correo">
                    </div>
                </div>

                <div class=" mb-3">
                    <label for="contrasenia" class="col-form-label text-md-end">Contraseña <span class="text-danger">*</span></label>
                    <div class="">
                        <input id="contrasenia" type="password" class="form-control" name="contrasenia" required autocomplete="new-contrasenia">
                    </div>
                </div>

                <div class=" mb-3">
                    <label for="contrasenia-confirm" class="col-form-label text-md-end">Confirmar contraseña <span class="text-danger">*</span></label>
                    <div class="">
                        <input id="contrasenia-confirm" type="password" class="form-control" name="contrasenia_confirmation" required autocomplete="new-contrasenia">
                    </div>
                </div>

                <div class="text-center mb-0">
                    <button type="button" id="btn-registro" class="btn btn-primary">
                        Registrarte
                    </button><br>
                    ¿Tienes una cuenta?<a href="/login"> Iniciar Sesion</a>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#form-registro').validate({
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            focusInvalid: false,
            rules: {      
                nombres: {
                    required: true,
                },
                apellido_paterno: {
                    required: true,
                },
                apellido_materno: {
                    required: true,
                },
                correo: {
                    required: true,
                    email: true,
                },
                contrasenia: {
                    required: true,
                    minlength: 8,
                },
                contrasenia_confirmation: {
                    required: true,
                    equalTo: '#contrasenia',
                },
            },
            messages: {            
                nombres: {
                    required: 'Este campo es requerido.',
                },
                apellido_paterno: {
                    required: 'Este campo es requerido.',
                },
                apellido_materno: {
                    required: 'Este campo es requerido.',
                },
                correo: {
                    required: 'Ingrese un correo electrónico.',
                    email: 'Ingrese un correo electrónico válido.',
                },
                contrasenia: {
                    required: 'Ingrese una contraseña.',
                    minlength: 'La contraseña debe tener al menos {0} caracteres.',
                },
                contrasenia_confirmation: {
                    required: 'Confirme su contraseña.',
                    equalTo: 'Las contraseñas no coinciden.',
                },
            },
            ignore: "",
            highlight: function(element, errorClass) {
                // $(element).addClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                // $(element).removeClass(errorClass);
            },
            success: function(label) {
                // label.closest('.form-group').removeClass('is-invalid').find(".text-danger").show();
                // label.remove();
            },
            errorPlacement: function(error, element) {
                var elem;
                if (element.parent(".input-group").length > 0) {
                    elem = element.parent(".input-group").parent();
                } else {
                    elem = element.parent();
                }
                elem.append(error.addClass('text-danger'));
            }
        });

    });

    $(document).on('click', '#btn-registro', function() {
        if (!$('#form-registro').valid()) {
            return false
        };
        $.ajax({
            type: 'POST',
            url: "{{url('registrar')}}",
            data: $("#form-registro").serialize(),
            async: false,
            success: function(data) {              
                window.location.href = "/login";         
            },
            error: function(xhr, status, error) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(field, messages) {
                    console.log(field);
                    console.log(messages);
                    var $input = $('[name="' + field + '"]');
                    $input.addClass('is-invalid');
                    var parentElement = $input.parent();
                    if (parentElement.hasClass('input-group')) {
                        parentElement = parentElement.parent();
                    }
                    parentElement.append($('<div>').addClass('invalid-feedback').html(messages));
                });
            }
        })
    })
</script>

@include('pages.footer-full')
@endsection
@section('scripts')
@endsection