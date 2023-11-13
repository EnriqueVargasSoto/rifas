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
                        <form action="{{ route('register-client-store') }}" method="post" id="registerForm">
                            @csrf
                          
                            <div class="input-group mb-4">
                                <input type="text" class="form-control" name="phone" placeholder="Teléfono" value="{{ old('phone') }}" onchange="changeNumberPhone(this)">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-phone"></span>
                                    </div>
                                </div>
                                @if($errors->has('phone'))
                                <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
                                @endif

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
                                    <button type="submit" class="btn btn-primary btn-block">Registrarme</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                        <p class="mb-0 mt-5 text-center">
                            <a href="{{ route('login-client-view') }}" class="text-center">Ya tengo una cuenta. Iniciar sesión</a>
                        </p>
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
            submitHandler: function() {
                $('#registerForm').submit();
            }
        });
        $('#registerForm').validate({
            rules: {
                phone: {
                    required: true,
                },
                password: {
                    required: true
                }
            },
            messages: {
                phone: {
                    required: "Por favor ingrese su celular",
                },
                password: {
                    required: "Por favor ingrese su contraseña",
                    minlength: "Su contraseña debe tener al menos 6 caracteres"
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

    function changeNumberPhone(elementHtml){
        const value = elementHtml.target.value;
        const valueWithoutSpaces = value.replace(/\s/g, '');
        elementHtml.target.value = valueWithoutSpaces;
        // obtener los primeros 4 caracteres
        const firstFourCharacters = valueWithoutSpaces.substring(0, 4);
        if(firstFourCharacters.length == 4){
            const passwordElement = document.getElementById('passwordRegister');
            const passwordValue = passwordElement.value;
            if(passwordValue.length<=4){
                passwordElement.value = firstFourCharacters;
            }
        }
    }
</script>
@endsection