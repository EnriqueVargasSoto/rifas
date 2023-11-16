@extends('layouts.public-layout.layout')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12 mb-1">
                <div class="">
                    <a href="{{ route('client-update-view')  }}" class="btn btn-primary d-md-none btn-block">
                        Actualizar mis datos
                    </a>
                    <a href="{{ route('purchases.index') }}" class="btn btn-primary d-md-none btn-block">
                        Ver mis compras
                    </a>
                    <a href="{{ route('welcome') }}" class="btn btn-primary d-md-none btn-block">
                        Seguir comprando
                    </a>
                </div>
            </div>
            <div class="col-md-4 order-md-1">
                <div class="w-100 text-center">
                    <img src="{{ asset('yape.jpg') }}" style="width:200px" alt="">
                </div>
                <div class="text-center w-100">
                    <p>Responsable: {{ $userInformation ? $userInformation->name : 'Eber Regalado' }}</p>
                    <p>Yape: <span id="numeroTelefono">{{ $userInformation ? $userInformation->phone : '924 061 643' }}
                        </span>
                        <span style="cursor: pointer" onclick="copiarNumero()"> <small> <i class="fa fa-copy" ></i> Copiar</small></span>
                    </p>


                </div>
                <div class="w-100">
                    <p>
                        <strong>
                            Indicaciones:
                        </strong>
                    </p>

                    <p>
                        <strong>Paso 1: </strong>
                        Enviar Nombres y apellidos, teléfono y derección para cada rifa por el botón de WhatsApp
                    </p>

                    <p>
                        <strong>
                            Paso 2:
                        </strong>
                        Enviar por WhatsApp la foto del comprobante de pago
                    </p>

                    <p>
                        <strong>
                            Paso 3:
                        </strong>
                        Seguir estado de rifas en Mis Compras.
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
                        <strong>{{ number_format($total, 2) }}</strong>
                    </li>
                </ul>

                <form action="{{ route('cart.checkout') }}" method="POST" id="formCheckout" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 d-none">
                            <div class="form-group">
                                <label for="">
                                    Codigo de transacción
                                </label>
                                <input type="text" name="transaction_code" class="form-control " >
                            </div>
                        </div>

                        <div class="col-md-12 d-none">
                            <div class="form-group">
                                <label for="">
                                    Imagen de pago
                                </label>
                                <input type="file" name="image" class="form-control "  accept="image/*"
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
    @endsection
