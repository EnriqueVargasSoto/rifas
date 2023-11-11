@extends('intranet.layouts.layout')

@section('content')
    <!-- Column starts -->
    <div class="col-xl-12">
        <div class="card dz-card" id="accordion-four">

            <div class="card-header">
                <div class="w-100 d-flex justify-content-between">
                    <h3 class="card-title">Lista de Rifas</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#basicModal"><i
                                class="fa-solid fa fa-plus mx-2"></i>Nueva rifa</button>
                    </div>
                </div>

                <div class="w-100 mt-2">
                    <form action="{{ route('rifas.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Buscar por código" value="{{ $search }}">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- /tab-content -->
            <div class="tab-content" id="myTabContent-3">
                <div class="tab-pane fade show active" id="withoutBorder" role="tabpanel" aria-labelledby="home-tab-3">
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table id="example4" class="display table" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th style="width: 15px">#</th>
                                        <td>Codigo</td>
                                        <th>Estado</th>
                                        <th>Price</th>
                                        <th>Usuario 1</th>
                                        <th>Usuario 2</th>
                                        <th>Usuario 3</th>
                                        <th>Fecha creación</th>
                                        <th style="width:25px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($raffles as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->firstUser?->short_name }}</td>
                                            <td>{{ $item->secondUser?->short_name }}</td>
                                            <td>{{ $item->thirdUser?->short_name }}</td>
                                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                            <td style="width:25px">
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#basicModalEdit{{ $item->id }}"><i
                                                        class="fa-solid fa fa-pen"></i></button>
                                                {{-- <a href="{{route('serials.destroy', $item->id)}}" class="btn btn-danger"><i class="fa-solid fa-trash me-2"></i>Eliminar</a> --}}
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                            {{ $raffles->appends(['search' => $search])->links() }}
                        </div>
                    </div>
                </div>

            </div>
            <!-- /tab-content -->

        </div>
    </div>
    <!-- Column ends -->

    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Nuevo Responsable</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('rifas.store') }}" method="post" id="formCreateRaffle">
                    @csrf
                    <div class="modal-body">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Codigo
                                    </label>
                                    <input type="text" name="name" class="form-control input-default ">
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        DNI
                                    </label>
                                    <input type="text" name="dni" class="form-control input-default ">
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @foreach ($raffles as $item)
        <!-- Modal -->
        <div class="modal fade" id="basicModalEdit{{ $item->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Responsable</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('rifas.update', $item->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="">Nombres completos</label>
                                        <input type="text" name="name" class="form-control input-default"
                                            value="{{ $item->code }}" placeholder="Ingrese Nombres Completos">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Crear</button>
                            </div>
                    </form>

                </div>
            </div>
        </div>
    @endforeach
@endsection
