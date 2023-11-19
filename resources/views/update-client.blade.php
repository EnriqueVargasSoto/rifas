@extends('layouts.public-layout.layout')

@section('content')
    <div class="row">
        <div class="col-md-12 mb-1">
            <div class="">
                <a href="/cart#compras" class="btn btn-primary d-md-none btn-block">
                    Ver mis compras
                </a>
                <a href="{{ route('welcome') }}" class="btn btn-primary d-md-none btn-block">
                    Seguir comprando
                </a>
            </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">

            <div class="login-box">
                <!-- /.login-logo -->
                <div class="card card-outline card-primary">

                    <div class="card-body">
                        <p class="login-box-msg">Actualize sus datos</p>
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif


                        <form action="{{ route('client-update') }}" method="post" id="updateForm">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control" name="name" value="{{$client->name}}">

                            </div>

                            <div class="form-group">
                                <label for="">Apellidos</label>
                                <input type="text" class="form-control" name="last_name" value="{{$client->last_name}}">
                            </div>
                            <div class="form-group">
                                <label for="">Telefono</label>
                                <input type="text" class="form-control" name="phone" placeholder="Teléfono"
                                    value="{{ $client->phone }}" readonly>

                            </div>


                            <div class="form-group">
                                <label for="">Contraseña <small>(Complete si va modificar su
                                        contraseña)</small></label>
                                <input type="text" class="form-control" name="password" placeholder="Contraseña"
                                    autocomplete="current-password">

                            </div>

                            <div class="form-group">
                                <label for="">Direccion</label>
                                <input type="text" class="form-control" name="address" value="{{$client->address}}">
                            </div>

                            <div class="row mt-3">
                                <!-- /.col -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Actualizar datos</button>
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
                    form.submit();
                }
            });
            $('#updateForm').validate({
                rules: {
                    phone: {
                        required: true,
                    },
                    name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                },
                messages: {
                    phone: {
                        required: "Por favor ingrese su celular",
                    },
                    name: {
                        required: "Por favor ingrese su nombre",
                    },
                    last_name: {
                        required: "Por favor ingrese su apellido",
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
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
