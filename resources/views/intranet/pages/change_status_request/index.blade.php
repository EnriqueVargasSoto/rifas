@extends('intranet.layouts.layout')

@section('content')
    <!-- Column starts -->
    <div class="col-xl-12">
        <div class="card dz-card" id="accordion-four">

            <div class="card-header">
                <div class="w-100 d-flex justify-content-between">
                    <h3 class="card-title">Lista solicitudes de cambio de estado de rifas </h3>
                    <div class="card-tools">
                    </div>
                </div>
                <form action="" method="GET">
                    <div class="row mt-3">
                        <div class="col-md-3 mb-3">
                            <label for="search">Buscar </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="">
                            </div>
                        </div>

                        <div class="col-md-2 mt-4">

                            <button type="submit" class="btn btn-primary btn-block">Buscar</button>

                        </div>
                        <div class="col-md-2 mt-4">
                            <a href="" class="btn btn-danger"><i class="fa fa-undo"></i>
                                Restabler filtros</a>
                        </div>
                    </div>
                </form>


            </div>

            <!-- /tab-content -->
            <div class="tab-content" id="myTabContent-3">

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
                <div class="tab-pane fade show active" id="withoutBorder" role="tabpanel" aria-labelledby="home-tab-3">
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table id="example4" class="display table" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th style="width: 15px">#</th>
                                        <th>Fecha</th>
                                        <th class="text-center">Estado</th>
                                        <th>Solicitante</th>
                                        <th>Cambiar rifas a </th>
                                        <th style="width:25px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($changeStatusRequests as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center">
                                                <div class="badge badge-{{ $item->status == 'Pendiente' ? 'warning' : '' }}{{ $item->status == 'Aprobado' ? 'success' : '' }}{{ $item->status == 'Rechazado' ? 'danger' : '' }}"
                                                    data-toggle="modal"
                                                    data-target="#basicModalStatusOrder{{ $item->id }}">
                                                    {{ $item->status }}
                                                </div>
                                            </td>
                                            <td>{{ $item->user?->name }} {{ $item->user?->last_name }}</td>
                                            <td>
                                                @if ($item->status_request == 'Liquidada')
                                                    <span class="badge badge-success">{{ $item->status_request }}</span>
                                                @elseif ($item->status_request == 'Stock')
                                                    <span class="badge badge-primary">{{ $item->status_request }}</span>
                                                @elseif ($item->status_request == 'Fiada')
                                                    <span class="badge badge-warning">{{ $item->status_request }}</span>
                                                @elseif ($item->status_request == 'Pagada')
                                                    <span class="badge badge-info">{{ $item->status_request }}</span>
                                                @elseif ($item->status_request == 'Reservada')
                                                    <span class="badge badge-secondary">{{ $item->status_request }}</span>
                                                @else
                                                    {{ $item->status_request }} 
                                                @endif
                                            </td>
                                            <td style="width:30px" class="d-flex">
                                                {{-- <a class="fa fa-eye text-primary mx-2" role="button"
                                                    href="{{ route('orders.show', $item->id) }}"></a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between">
                                <div class="mt-2">
                                    <p>Mostrando {{ $changeStatusRequests->firstItem() }} a
                                        {{ $changeStatusRequests->lastItem() }} de
                                        {{ $changeStatusRequests->total() }} registros</p>
                                </div>
                                {{ $changeStatusRequests->appends(['search' => ''])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @foreach ($changeStatusRequests as $item)
        <div class="modal fade" id="basicModalStatusOrder{{ $item->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Estado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('orders.changeStatus') }}" method="POST" enctype="multipart/form-data"
                            id="changeOrderStatus{{ $item->id }}">
                            @method('POST')
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $item->id }}">
                            <div class="form-group">
                                <label for="status">Estado</label>
                                <select name="status" class="form-control" onchange="selectStatus(this,{{ $item->id }})"
                                    value="{{ $item->status }}">
                                    <option value="">-- Seleccione -- </option>
                                    <option value="aprobado" {{ $item->status == 'aprobado' ? 'selected' : '' }}>Aprobar
                                    </option>
                                    <option value="cancelado" {{ $item->status == 'cancelado' ? 'selected' : '' }}>
                                        Cancelar
                                    </option>
                                </select>
                            </div>

                            <div class="w-100 d-none" id="containerAprovedOrder{{$item->id}}">
                                <div class="form-group">
                                    <label for="">
                                        Codigo de transacción
                                    </label>
                                    <input type="text" name="transaction_id" class="form-control"
                                        value="{{ $item->transaction_id }}">
                                </div>
                                <div class="form-group d-none">
                                    <label for="">
                                        Fecha de pago
                                    </label>
                                    <input type="date" name="payment_at" id="payment_at" class="form-control"
                                        value="{{ now()->format('Y-m-d') }}">
                                </div>

                                <div class="form-group d-none">
                                    <label for="">
                                        Monto de pago
                                    </label>
                                    <input type="number" name="amount_paid" id="amount_paid" class="form-control"
                                        value="{{ $item->total }}">
                                </div>
                            </div>

                            <div class="w-100 d-none" id="containerCancelOrder{{$item->id}}">
                                <div class="form-group">
                                    <label for="">
                                        Motivo de cancelación
                                    </label>
                                    <textarea name="rejection_reason" id="reason" cols="30" rows="5" class="form-control"
                                        id="rejection_reason{{ $item->id }}"></textarea>
                                </div>
                            </div>

                            <div class="w-100 d-flex justify-content-end my-3">
                                <button type="button" class="btn btn-danger light mx-2"
                                    data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach --}}
@endsection
@section('scripts')
    <script>
        // function selectStatus(e,id) {

        //     const status = e.value;
        //     if (status == 'aprobado') {
        //         document.getElementById('containerAprovedOrder'+id).classList.remove('d-none');
        //         document.getElementById('containerCancelOrder'+id).classList.add('d-none');
        //     } else if (status == 'cancelado') {
        //         document.getElementById('containerAprovedOrder'+id).classList.add('d-none');
        //         document.getElementById('containerCancelOrder'+id).classList.remove('d-none');
        //     } else {
        //         document.getElementById('containerAprovedOrder'+id).classList.add('d-none');
        //         document.getElementById('containerCancelOrder'+id).classList.add('d-none');
        //     }

        // }
        // $(function() {
        //     $.validator.setDefaults({
        //         submitHandler: function(form) {
        //             // submit form
        //             form.submit();
        //         }
        //     });
        // });
    </script>

    {{-- @foreach ($orders as $order)
        <script>
            $(function() {

                $('#changeOrderStatus' + {{ $order->id }}).validate({
                    rules: {
                        status: {
                            required: true,
                        }
                    },
                    messages: {
                        status: {
                            required: "Por favor seleccione un estado",
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
    @endforeach --}}
@endsection
