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
                {{-- <form action="" method="GET">
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
                            <a href="{{route('change-status-requests.index')}}" class="btn btn-danger"><i class="fa fa-undo"></i>
                                Restabler filtros</a>
                        </div>
                    </div>
                </form> --}}


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
                                        <th>
                                            Aprobado por
                                        </th>
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
                                                    data-target="#basicModalStatusChange{{ $item->id }}">
                                                    {{ $item->status }}
                                                </div>
                                            </td>
                                            <td>{{ $item->user?->name }} {{ $item->user?->last_name }}</td>
                                            <td>{{ $item->userGestion?->name }} {{ $item->userGestion?->last_name }}</td>
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
                                                <i class="fa fa-image text-info" data-toggle="modal"
                                                    data-target="#basicModalGallery{{ $item->id }}" role="button"></i>

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

    @foreach ($changeStatusRequests as $item)
        <div class="modal fade" id="basicModalStatusChange{{ $item->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Estado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('changeStatusRequest.changeStatus') }}" method="POST"
                            id="changeStatusRequests{{ $item->id }}">
                            @method('POST')
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <div class="form-group">
                                <label for="status">Estado</label>
                                <select name="status" class="form-control" value="{{ $item->status }}" required>
                                    <option value="">-- Seleccione -- </option>
                                    <option value="Aprobado" {{ $item->status == 'Aprobado' ? 'selected' : '' }}>Aprobar
                                    </option>
                                    <option value="Rechazado" {{ $item->status == 'Rechazado' ? 'selected' : '' }}>
                                        Rechazar
                                    </option>
                                </select>
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

        <div class="modal fade" id="basicModalGallery{{ $item->id }}">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Imagen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="container-image">
                                    <div class="image" onclick="showImage(this)">
                                        <img src="{{ asset('storage/' . $item->image_url) }}" alt=""
                                            class="img-fluid" style="cursor: pointer; height:250px;">
                                    </div>
                                </div>
                            </div>
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
        $(function() {
            $.validator.setDefaults({
                submitHandler: function(form) {
                    // submit form
                    form.submit();
                }
            });
        });

        
    </script>
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

    @foreach ($changeStatusRequests as $item)
        <script>
            $(function() {

                $('#changeStatusRequests' + {{ $item->id }}).validate({
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
    @endforeach
@endsection
