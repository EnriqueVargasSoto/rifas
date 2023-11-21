@extends('layouts.public-layout.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            </div>

        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 mb-4">
                <form action="{{ route('client-update') }}" method="post" id="updateClientInfoForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" name="name" value="{{ $client->name }}">
                    </div>
                    <div class="form-group">
                        <label for="">Apellidos</label>
                        <input type="text" class="form-control" name="last_name" value="{{ $client->last_name }}">
                    </div>
                    <div class="form-group">
                        <label for="">Telefono</label>
                        <input type="text" class="form-control" name="phone" placeholder="Teléfono"
                            value="{{ $client->phone }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="">Contraseña </label>
                        <input type="text" class="form-control" value="{{$client->clave}}"" name="password" placeholder="Contraseña"
                            autocomplete="current-password">
                    </div>

                    <div class="form-group">
                        <label for="">Direccion</label>
                        <input type="text" class="form-control" name="address" value="{{ $client->address }}">
                    </div>

                    <div class="row mt-3">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" >Actualizar datos</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>

        </div>
        <br>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 ">
                <div class="w-100 text-center">
                    <img src="{{ asset('yape.jpeg') }}" style="width:200px" alt="">
                </div>
                <div class="text-center w-100">
                    <p>Responsable: {{ $userInformation ? $userInformation->name : 'Eber Regalado' }}</p>
                    <p>Yape: <span id="numeroTelefono">{{ $userInformation ? $userInformation->phone : '924 061 643' }}
                        </span>
                        <span style="cursor: pointer" onclick="copiarNumero()"> <small> <i class="fa fa-copy"></i>
                                Copiar</small></span>
                    </p>


                </div>
            </div>
        </div>
        <section class="container mb-4" id="compras">
            <div class="row">
                <div class="col-md-2">

                </div>
                <div class="col-md-8">
                    <h4> Mis compras</h4>
                </div>
            </div>
            @foreach ($orderItemsGroupByStatus as $key => $value)
                <div class="row">
                
                    <div class="col-md-2"></div>
                    <div class="col-md-8  mb-4">
                        <h5 class="d-flex justify-content-between align-items-center mb-3">

                            @if ($key == 'reservado')
                                <span class="text-warning">
                                    Procesando
                                </span>
                            @elseif($key == 'aprobado')
                                <span class="text-success">
                                    Aprobadas
                                </span>
                            @elseif($key == 'cancelado')
                                <span class="text-danger">
                                    Canceladas
                                </span>
                            @endif
                            <span
                                class="badge badge-secondary badge-pill">{{ count($orderItemsGroupByStatus[$key]) }}</span>
                        </h5>
                        <ul class="list-group mb-3">
                            @foreach ($value as $orderItem)
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <h6 class="my-0">Rifa #{{ $orderItem->raffle->code }}</h6>
                                    </div>
                                    <span class="text-muted">{{ $orderItem->raffle->price }}</span>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total</span>
                                <strong>{{ number_format(count($orderItemsGroupByStatus[$key]) * 20, 2) }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </section>
        <section class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 mb-4">
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
                        <span
                            class="badge badge-secondary badge-pill">{{ session('cart') ? count(session('cart')) : 0 }}</span>
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

                    <form action="{{ route('cart.checkout') }}" method="POST" id="formCheckout"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 d-none">
                                <div class="form-group">
                                    <label for="">
                                        Codigo de transacción
                                    </label>
                                    <input type="text" name="transaction_code" class="form-control ">
                                </div>
                            </div>

                            <div class="col-md-12 d-none">
                                <div class="form-group">
                                    <label for="">
                                        Imagen de pago
                                    </label>
                                    <input type="file" name="image" class="form-control " accept="image/*"
                                        onchange="onSelectImage(this)">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block" onclick="openWhatsAppWindow()">
                            Comprar rifas
                        </button>

                        <p class="my-2">
                            Enviar por botón WhatsApp foto de pago y datos si desea colocar otros nombres en rifas
                        </p>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <img src="" alt="" id="previewImage" class="w-100">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 mb-1">
                    <div class="">
                        <button  class="btn btn-primary btn-block" data-toggle="modal"
                        data-target="#imagesRaffles">
                            Ver imagenes de rifas
                        </button>
                        <a href="{{ route('welcome') }}" class="btn btn-primary btn-block">
                            Seguir comprando
                        </a>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="imagesRaffles">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Imagenes de rifas </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row my-2">
                                <div class="col-md-12">
                                    <small>
                                        Click sobre la imagen para ver en tamaño completo
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($orderImages as $image)
                                    @if ($image["type"] == 'raffle')
                                        <div class="col-md-4 text-center">
                                            <div class="container-image">
                                                <div class="image" onclick="showImage(this)">
                                                    <img src="{{ asset('storage/' . $image['image_url']) }}" alt=""
                                                        class="img-fluid" style="cursor: pointer; height:250px;">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                        </div>

                    </div>
                </div>
            </div>

        </section>

    

        <hr>
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

            function showImage(image) {
                var viewer = new Viewer(image, {
                    inline: false,
                    viewed: function() {
                        viewer.zoomTo(0.6);
                    }
                });
                viewer.show();
            }

            function openWhatsAppWindow(){
                const user= @json($userInformation);
                const userPhone = user? user.phone :  '924061643' 
                var url = 'https://api.whatsapp.com/send?phone='+userPhone +'&text=Hola, realice la compra de las rifas via web...';
                window.open(url, '_blank');
            }

        </script>
        <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
        <script>
            $(function() {
                $.validator.setDefaults({
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
                $('#updateClientInfoForm').validate({
                    rules: {
                        phone: {
                            required: true,
                        }
                    },
                    messages: {
                        phone: {
                            required: "Por favor ingrese su celular",
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
