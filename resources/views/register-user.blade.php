@extends('layouts.public-layout.layout')

@section('content')
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">

            <div class="login-box">
                <!-- /.login-logo -->
                <div class="card card-outline card-primary">

                    <div class="card-body">
                        <p class="login-box-msg">Complete sus datos</p>
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('user.register-store') }}" method="post" id="registerForm">
                            @csrf
                            <div class="input-group mb-4">
                                <input type="text" class="form-control" name="name" placeholder="Nombre" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-4">
                                <input type="text" class="form-control" name="dni" placeholder="Dni" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-4">
                                <input type="text" class="form-control" name="short_name" placeholder="Nombre corto" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-4">
                                <input type="text" class="form-control" name="phone" placeholder="Teléfono" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-phone"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-4">
                                <input type="text" class="form-control" name="unit" placeholder="Institución" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-4">
                                <input type="text" class="form-control" name="area" placeholder="Area" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-4">
                                <input type="text" class="form-control" name="position" placeholder="Cargo" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-4">
                                <input type="text" class="form-control" name="address" placeholder="Direccion" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-4">
                                <input type="text" class="form-control" name="email" placeholder="Correo" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>

                            

                            <div class="input-group mb-4">
                                <input type="text" class="form-control" name="password" id="passwordRegister" placeholder="Contraseña" autocomplete="current-password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <!-- /.col -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block"> <i id="sendingForm" class="fa fa-spinner fa fa-spin d-none"></i> Ingresar</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script>
    $(function() {
        $.validator.setDefaults({
            submitHandler: function(form) {
                const sendingForm = document.getElementById('sendingForm');
                sendingForm.classList.remove('d-none');
                form.submit();
            }
        });
        $('#registerForm').validate({
            rules: {
                name: {
                    required: true
                },
                dni: {
                    required: true,
                    minlength: 8
                },
                short_name: {
                    required: true,
                    minlength: 3
                },
                phone: {
                    required: true,
                },
                unit: {
                    required: true
                },
                area: {
                    required: true
                },
                position: {
                    required: true
                },
                address: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Por favor ingrese su nombre"
                },
                dni: {
                    required: "Por favor ingrese su dni",
                    minlength: "El dni debe tener 8 caracteres"
                },
                short_name: {
                    required: "Por favor ingrese su nombre corto",
                    minlength: "El nombre corto debe tener 3 caracteres"
                },
                phone: {
                    required: "Por favor ingrese su teléfono",
                },
                unit: {
                    required: "Por favor ingrese su unidad"
                },
                area: {
                    required: "Por favor ingrese su area"
                },
                position: {
                    required: "Por favor ingrese su posición"
                },
                address: {
                    required: "Por favor ingrese su dirección"
                },
                email: {
                    required: "Por favor ingrese su correo",
                    email: "Por favor ingrese un correo válido"
                },
                password: {
                    required: "Por favor ingrese su contraseña"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
    
</script>
@endsection