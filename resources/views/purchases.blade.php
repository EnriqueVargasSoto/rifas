@extends('layouts.public-layout.layout')
@section('content')
    <div class="container-fluid">
        <div class="alert alert-info">
            Actualizar información de usuario <a href="{{ route('client-update-view') }}">aquí</a>
        </div>
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
        @foreach ($orders as $order)
            <div class="row">

                <div class="col-md-8">
                    <h4>
                        Compra #{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}



                    </h4>
                    @if ($order->status == 'reservado')
                        <span class="badge badge-warning">Su compra se encuentra procesando</span>
                    @elseif($order->status == 'aprobado')
                        <span class="badge badge-success">Su compra a sido aprobada</span>
                    @elseif($order->status == 'cancelado')
                        <span class="badge badge-danger">Su compra a sido cancelada</span> : {{ $order->rejection_reason }}
                    @endif

                    <div class="d-flex flex-wrap mt-4">
                        @foreach ($order->order_items as $order_item)
                            <div class="mx-1" style="width: 100px!important">
                                <div class="card text-white bg-dark mb-2">
                                    <div class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                            viewBox="0 0 100 100">
                                            <!-- Círculo exterior -->
                                            <circle cx="50" cy="50" r="45" fill="white" stroke="black"
                                                stroke-width="2" />
                                            <!-- Número en el centro -->
                                            <text x="50" y="60" font-size="25" text-anchor="middle"
                                                fill="black">{{ $order_item->raffle->number }}</text>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-success btn-block" data-toggle="modal"
                        data-target="#imagesInvoicesPayment{{ $order->id }}">
                        <i class="fas fa-money-bill-wave"></i>
                        Comprobante de pago
                    </button>
                    {{-- <button class="btn btn-warning btn-block" data-toggle="modal" data-target="#imagesInvoicePurchase{{$order->id}}">
                        <i class="fas fa-money-bill-wave"></i>
                        Ver comprobante de compra
                    </button> --}}
                    <button class="btn btn-primary btn-block" data-toggle="modal"
                        data-target="#imagesRaffles{{ $order->id }}">
                        <i class="fas fa-image"></i>
                        Ver imagenes de rifas
                    </button>
                </div>
            </div>

            <hr>



            <div class="modal fade" id="imagesRaffles{{ $order->id }}">
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

                                @foreach ($order->order_images as $image)
                                    @if ($image->type == 'raffle')
                                        <div class="col-md-4 text-center">
                                            <div class="container-image">
                                                <div class="image" onclick="showImage(this)">
                                                    <img src="{{ asset('storage/' . $image->image_url) }}" alt=""
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

            <div class="modal fade" id="imagesInvoicePurchase{{ $order->id }}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Imagen de comprobante de compra </h5>
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
                                @foreach ($order->order_images as $image)
                                    @if ($image->type == 'invoice')
                                        <div class="col-md-4 text-center">
                                            <div class="container-image">
                                                <div class="image" onclick="showImage(this)">
                                                    <img src="{{ asset('storage/' . $image->image_url) }}" alt=""
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
            <div class="modal fade" id="imagesInvoicesPayment{{ $order->id }}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Comprobante de pago</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @if($order->image_payment_url)
                                <div class="col-md-4 text-center">
                                    <div class="container-image text-center">
                                        <div class="image text-center" onclick="showImage(this)">
                                            <img src="{{ asset('storage/' . $order->image_payment_url) }}" alt=""
                                                class="img-fluid" style="cursor: pointer; height:250px;">
                                        </div>
                                    </div>
                                    {{-- <form action="{{ route('purchases.deleteInvoicePaymentImage', $image->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <input type="submit" value="Eliminar" class="btn btn-danger btn-block mt-2">
                                    </form> --}}
                                </div>
                                @endif

                                @foreach ($order->order_images as $image)
                                    @if ($image->type == 'payment')
                                        <div class="col-md-4 text-center">
                                            <div class="container-image">
                                                <div class="image" onclick="showImage(this)">
                                                    <img src="{{ asset('storage/' . $image->image_url) }}" alt=""
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
        @endforeach
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
    @endsection
