@extends('layouts.public-layout.layout')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">

                @if (session('success-delete-cart'))
                    <div class="alert alert-success">
                        {{ session('success-delete-cart') }}
                    </div>
                @endif

                @if (session('error-delete-cart'))
                    <div class="alert alert-danger">
                        {{ session('error-delete-cart') }}
                    </div>
                @endif
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Tu carrito</span>
                    <span class="badge badge-secondary badge-pill">{{ session('cart') ? count(session('cart')) : 0 }}</span>
                </h4>
                <ul class="list-group mb-3">
                    @foreach ($raffles as $rifa)
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Rifa #{{ $rifa->code }}</h6>
                                <form action="{{ route('cart.remove', $rifa->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" value="{{ $rifa->id }}" name="id">
                                    <button type="submit" class="btn p-0 m-0 btn-link text-danger">Quitar del
                                        carrito</button>
                                </form>
                            </div>
                            <span class="text-muted">{{ $rifa->price }}</span>
                        </li>
                    @endforeach

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong>{{ $total }}</strong>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-1">
                @if (session('success-checkout'))
                    <div class="alert alert-success">
                        {{ session('success-checkout') }}
                    </div>
                @endif

                @if (session('error-checkout'))
                    <div class="alert alert-danger">
                        {{ session('error-checkout') }}
                    </div>
                @endif

                <h4 class="mb-3">Datos del comprador</h4>
                <form class="needs-validation" action="{{route('cart.checkout')}}" id="formCheckout" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="">
                                    Nombre
                                </label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                            </div>

                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="">
                                    Apellidos
                                </label>
                                <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="">
                                    Documento de identidad
                                </label>
                                <input type="text" name="identity_number" class="form-control" value="{{old('identity_number')}}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="">
                                    Correo electronico <small class="text-muted">(Opcional)</small>
                                </label>
                                <input type="email" name="email" class="form-control" placeholder="email@gmail.com" value="{{old('email')}}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="">
                                    Celular
                                </label>
                                <input type="text" name="phone" class="form-control" value="{{old('phone')}}">
                            </div>
                        </div>


                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="">
                                    Direccion <small class="text-muted">(Opcional)</small>
                                </label>
                                <input type="text" name="address" class="form-control" value="{{old('address')}}">
                            </div>
                        </div>

                    </div>

                    <hr class="mb-4">
                    <h4 class="mb-3">Pago</h4>
                    <div class="d-block my-3">
                        <div class="form-group">
                            <label for="">Adjuntar imagen</label>
                            <input type="file" name="image" class="form-control" id="imageInput">
                        </div>
                    </div>
                    <div class="d-block my-3">
                        <img src="" alt="" id="imagePreview" style="max-width: 100%; max-height: 200px;">
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Comprar</button>
                </form>
            </div>
        </div>
    @endsection


    @section('scripts')
        <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
        <script>
            $(function() {
                $.validator.setDefaults({
                    submitHandler: function() {
                        $('#formCheckout').submit();
                    }
                });
                $('#formCheckout').validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        last_name: {
                            required: true,
                        },
                        identity_number: {
                            required: true,
                        },
                        phone: {
                            required: true,
                        },
                        image:{
                            required: true,
                            extension: "jpg|jpeg|png"
                        }
                    },
                    messages: {
                        name: {
                            required: "Por favor ingrese su nombre",
                        },
                        last_name: {
                            required: "Por favor ingrese su apellido",
                        },
                        identity_number: {
                            required: "Por favor ingrese su documento de identidad",
                        },
                        phone: {
                            required: "Por favor ingrese su celular",
                        },
                        image:{
                            required: "Por favor adjunte una imagen",
                            extension: "Solo se permiten imagenes"
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

        <script>
            document.getElementById('imageInput').addEventListener('change', function() {
                var preview = document.getElementById('imagePreview');
                var file = this.files[0];
                var reader = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "";
                }
            });
        </script>
    @endsection
