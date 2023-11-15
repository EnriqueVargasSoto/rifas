@extends('intranet.layouts.layout')
@section('content')
    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}

            </div>
        @endif


        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}

            </div>
        @endif
            <div class="row">
                <div class="col-12">

                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <b>Compra #{{ str_pad($order->id, 8, STR_PAD_LEFT, '0') }}</b><br>
                                
                                <address>
                                    <strong>Cliente: {{ $order->client->name }} {{ $order->client->last_name }}</strong><br>
                                    Telefono : {{ $order->client->phone }}<br>
                                    Direccion: {{ $order->client->address }}<br>
                                </address>
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Cant.</th>
                                            <th class="text-center">Rifa</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->order_items as $key => $orderItem)
                                        @endforeach
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">1</td>
                                            <td class="text-center">{{ $orderItem->raffle->code }}</td>
                                            <td class="text-right">{{ $orderItem->raffle->price }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                <p class="lead">Imagenes de pago:</p>
                                <div class="row">
                                        <div class="col-md-3 text-center">
                                            <img src="{{ asset('storage/' . $order->image_payment_url) }}"
                                                class="img-fluid mb-2" alt="white sample" style="height: 100px"
                                                onclick="showImage(this)" />
                                        </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                <p class="lead">Fecha {{ $order->created_at->format('d/m/Y') }}</p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Total:</th>
                                            <td class="text-right">{{ $order->total }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row my-3">
                            
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#modalImagesRaffles"  >
                                    Subir imagenes de rifas
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#modalImagesPayment">
                                    Subir imagenes de comprobantes de pago
                                </button>
                            </div>
                        </div>

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="{{ route('orders.index') }}" role="button" class="btn btn-danger"><i
                                        class="fas fa-backward"></i> Volver</a>

                            </div>
                        </div>


                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    <div class="modal fade" id="modalImagesRaffles">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rifas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('orders.storeFiles') }}" method="POST" enctype="multipart/form-data"
                    id="storeRaffleFile">
                    @method('POST')
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <div class="form-group">
                                    <label for="">
                                        Seleccione la imagen de la rifa
                                    </label>
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                                    <input type="hidden" name="type"  value="raffle">
                                    <input type="file" name="image" class="form-control-input" accept="image/*"><br>
                                    <button class="btn btn-primary">
                                        <i class="fa-solid fa fa-upload"></i>
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <div class="row">
                    @foreach ($order->order_images as $image)
                        @if($image->type == 'raffle')
                        <div class="col-md-4 text-center" >
                            <div class="container-image">
                                <div class="image" onclick="showImage(this)">
                                    <img src="{{ asset('storage/' . $image->image_url) }}" alt="" class="img-fluid" style="cursor: pointer; height:250px;" >
                                </div>
                            </div>
                            <form action="{{ route('orders.deleteFile', $image->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="raffle_id" value="{{ $order->id }}">
                                <input type="hidden" name="image_id" value="{{ $image->id }}">
                                <input type="submit" value="Eliminar" class="btn btn-danger btn-block mt-2">
                            </form>
                        </div>
                        @endif
                    @endforeach
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalImagesPayment">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Comprobantes de pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('orders.storeFiles') }}" method="POST" enctype="multipart/form-data"
                    id="storeRaffleFile">
                    @method('POST')
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <div class="form-group">
                                    <label for="">
                                        Seleccione la imagen
                                    </label>
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                                    <input type="hidden" name="type"  value="payment">
                                    <input type="file" name="image" class="form-control-input" accept="image/*"><br>
                                    <button class="btn btn-primary">
                                        <i class="fa-solid fa fa-upload"></i>
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <div class="row">
                    @foreach ($order->order_images as $image)
                        @if($image->type == 'payment')
                        <div class="col-md-4 text-center" >
                            <div class="container-image">
                                <div class="image" onclick="showImage(this)">
                                    <img src="{{ asset('storage/' . $image->image_url) }}" alt="" class="img-fluid" style="cursor: pointer; height:250px;" >
                                </div>
                            </div>
                            <form action="{{ route('orders.deleteFile', $image->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="raffle_id" value="{{ $order->id }}">
                                <input type="hidden" name="image_id" value="{{ $image->id }}">
                                <input type="submit" value="Eliminar" class="btn btn-danger btn-block mt-2">
                            </form>
                        </div>
                        @endif
                    @endforeach
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function showImage(image) {
            var viewer = new Viewer(image, {
                inline: false,
                viewed: function() {
                    viewer.zoomTo(0.6);
                }
            });
            viewer.show();
        }
    </script>
       <script>
        $(function() {
            $.validator.setDefaults({
                submitHandler: function(form) {
                    // submit form
                    form.submit();
                }
            });
            $('#storeRaffleFile').validate({
                rules: {
                    image: {
                        required: true,
                    }
                },
                messages: {
                    image: {
                        required: "Por favor seleccione una imagen"
                    },
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
