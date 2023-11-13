@extends('layouts.public-layout.layout')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-4 order-md-1">
                <div class="w-100 text-center">
                    <img src="{{ asset('yape.jpg') }}" style="width:200px" alt="">
                </div>
                <div class="text-center w-100">
                    <p>Responsable: {{ $userInformation ? $userInformation->name : 'Eber Regalado' }}</p>
                    <p>Yape: <span id="numeroTelefono">{{ $userInformation ? $userInformation->phone : '924 061 643' }}
                        </span>
                        <i class="fa fa-copy" onclick="copiarNumero()"></i>
                    </p>
                </div>
            </div>
            <div class="col-md-8 order-md-2 mb-4">
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
                    @if (!count($raffles))
                        <div class="alert alert-info">
                            No hay rifas en el carrito
                        </div>
                    @endif

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong>{{ $total }}</strong>
                    </li>
                </ul>

                <form action="{{ route('cart.checkout') }}" method="POST" id="formCheckout" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">
                                    Codigo de transacción
                                </label>
                                <input type="text" name="transaction_code" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">
                                    Imagen de pago
                                </label>
                                <input type="file" name="image" class="form-control" required accept="image/*"
                                    onchange="onSelectImage(this)">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Comprar rifas
                    </button>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <img src="" alt="" id="previewImage" class="w-100">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    @endsection

    @section('scripts')
        <script>
            function copiarNumero() {
                /* Obtener el elemento de texto con el número de teléfono */
                var numeroTelefono = document.getElementById("numeroTelefono");

                /* Crear un área de texto temporal */
                var textarea = document.createElement("textarea");
                textarea.value = numeroTelefono.textContent;

                /* Añadir el área de texto al cuerpo del documento */
                document.body.appendChild(textarea);

                /* Seleccionar el contenido del área de texto */
                textarea.select();
                textarea.setSelectionRange(0, 99999); /* Para dispositivos móviles */

                /* Copiar el contenido al portapapeles */
                document.execCommand("copy");

                /* Eliminar el área de texto temporal */
                document.body.removeChild(textarea);

                alert("Número copiado: " + numeroTelefono.textContent);
            }


            // mostrar imagen seleccionada

            function onSelectImage(e) {
                if (e.files && e.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('previewImage').src = e.target.result;
                    }
                    reader.readAsDataURL(e.files[0]);
                }
            }
        </script>

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
                transaction_code: {
                    required: true,
                },
                image: {
                    required: true
                }
            },
            messages: {
                transaction_code: {
                    required: "Por favor ingrese el codigo de transacción",
                },
                image: {
                    required: "Por favor seleccione una imagen de pago",
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
