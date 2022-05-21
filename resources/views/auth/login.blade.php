@extends('layouts.app')
@section('content')

<div class="nk-block nk-block-middle nk-auth-body  wide-xs">
    <div class="brand-logo pb-4 text-center">
        <a href="html/index.html" class="logo-link">
            <img class="logo-light logo-img logo-img-lg" src="{{asset('images/logo.png')}}" srcset="./images/logo2x.png 2x" alt="logo">
            <img class="logo-dark logo-img logo-img-lg" src="{{asset('images/logo-dark.png')}}" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
        </a>
    </div>

    <div class="card card-bordered">
        <div class="card-inner card-inner-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Iniciar Sesión</h4>
                </div>
            </div>
            <form method="POST" id="form-iniciar-sesion">
                @csrf
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="default-01">Correo electrónico</label>
                    </div>
                    <div class="form-control-wrap">
                        <input id="email" type="email" class="form-control form-control-lg " name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>

                </div>

                <div class="form-group">
                    <div class="form-label-group">
                        <label for="contrasenia" class="form-label">Contraseña</label>
                    </div>
                    <div class="form-control-wrap">
                        <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                        </a>
                        <input id="password" type="password" name="contrasenia" class="form-control form-control-lg"  required autocomplete="current-password">

                    </div>
                </div>
                <div class="form-group">
                    <button type="button" id="btn-iniciar-sesion" class="btn btn-lg btn-primary btn-block">
                        Iniciar Sesion
                    </button>

                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-link link link-primary link-sm" href="{{ route('password.request') }}">
                            ¿Has olvidado tu contraseña?
                        </a>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Recordar contraseña</label>
                        </div>
                    </div>

                    <hr>
                    <a href="{{ route('register') }}" type="button" class="btn btn-lg btn-success btn-block">
                        Crear cuenta nueva
                    </a>
                </div>




            </form>

        </div>
    </div>
</div>


<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000
    });
    $(document).ready(function() {
        localStorage.setItem("inicio_sesion", 0);
        $(".autocomplete-off").prop('readonly', true);
        var validarInicioSesion = $('#form-iniciar-sesion').validate({
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            focusInvalid: false,
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                contrasenia: {
                    required: true,
                },
            },
            messages: {
                email: {
                    required: 'Ingrese correo electronico.',
                    email: 'Ingrese un correo válido.',
                },
                contrasenia: {
                    required: "Ingrese contraseña",
                },
            },
            ignore: "",
            errorElement: "span",
            errorClass: 'is-invalid',
            highlight: function(element, errorClass) {
                $(element).addClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            success: function(label) {
                label.closest('.form-group').removeClass('is-invalid').find(".text-danger").show();
                label.remove();
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

    $(document).on('click', '#btn-iniciar-sesion', function() {
        if (!$('#form-iniciar-sesion').valid()) {
            return false
        };

        $.ajax({
            type: 'POST',
            url: "{{url('autenticar')}}",
            data: $("#form-iniciar-sesion").serialize(),
            async: false,
            success: function(data) {
                if (data == 'ok') {
                    window.location.href = "/inicio";
                    localStorage.setItem("inicio_sesion", 1);

                }
            },
            error: function(error) {
                let errores = error.responseJSON.errors;
                Toast.fire({
                    icon: 'error',
                    title: errores
                })
                $(button).prop('disabled', false);
            }
        })
    })
</script>

@include('pages.footer-full')
@endsection
@section('scripts')
@endsection