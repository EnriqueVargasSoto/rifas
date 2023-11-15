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
                                <input type="text" class="form-control" name="phone" placeholder="Teléfono" onchange="changeNumberPhone(this)">
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
                                    <button type="submit" class="btn btn-primary btn-block"> <i id="sendingForm" class="fa fa-spinner fa fa-spin d-none"></i> Ingresar</button>
                                </div>
                                <!-- /.col -->
                            </div>
                            <small class="text-center">Si olvidaste tu contraseña solicitalo al WhatsApp</small>
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
                         
    function changeNumberPhone(elementHtml) {
        const value = elementHtml.value;
        const valueWithoutSpaces = value.replace(/\s/g, '');
        elementHtml.value = valueWithoutSpaces;
        // obtener los primeros 4 caracteres
        const firstFourCharacters = valueWithoutSpaces.substring(0, 4);
        if (firstFourCharacters.length == 4) {
            const passwordElement = document.getElementById('passwordRegister');
            const passwordValue = passwordElement.value;
            if (passwordValue.length <= 4) {
                passwordElement.value = firstFourCharacters;
            }
        }
    }
</script>
@endsection