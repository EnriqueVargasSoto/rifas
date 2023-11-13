@extends('intranet.layouts.layout')

@section('content')
    <!-- Column starts -->
    <div class="col-xl-12">
        <div class="card dz-card" id="accordion-four">
            <div class="card-header">
                <h3 class="card-title">Asignaciones</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#basicModal"><i
                            class="fa-solid fa fa-plus mx-2"></i>Nuevo Asignacion</button>
                </div>
            </div>

            <!-- /tab-content -->
            <div class="tab-content" id="myTabContent-3">
                <div class="tab-pane fade show active" id="withoutBorder" role="tabpanel" aria-labelledby="home-tab-3">


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

                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table id="example4" class="display table" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th style="width: 15px">#</th>
                                        <th>Opción 1</th>
                                        <th>Opción 2</th>
                                        <th>Opción 3</th>
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                        <th>Numeros</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assignments as $key => $assignment)
                                        <tr>
                                            <td>{{ $assignment->id }}</td>
                                            <td>{{ $assignment->firstUser?->short_name }}</td>
                                            <td>{{ $assignment->secondUser?->short_name }}</td>
                                            <td>{{ $assignment->thirdUser?->short_name }}</td>
                                            <td>{{ $assignment->start }}</td>
                                            <td>{{ $assignment->end }}</td>
                                            <td>{{ $assignment->codes }}</td>
                                            <td>{{ $assignment->created_at->format('d/m/Y') }}</td>

                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="mt-2">
                                <p>Mostrando {{ $assignments->firstItem() }} a {{ $assignments->lastItem() }} de
                                    {{ $assignments->total() }} registros</p>
                            </div>

                            {{ $assignments->links() }}
                        </div>
                    </div>
                </div>

            </div>
            <!-- /tab-content -->

        </div>
    </div>
    <!-- Column ends -->

    <!-- Modal -->
    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Nueva Asignación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('assignaciones.store') }}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <h4 class="card-title">Opción 1</h4>
                                <select class="default-select form-control wide" name="user_id_1">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->short_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <h4 class="card-title">Opción 2</h4>
                                <select class="default-select form-control wide" name="user_id_2">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->short_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <h4 class="card-title">Opción 3</h4>
                                <select class="default-select form-control wide" name="user_id_3">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->short_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <h4 class="card-title">Mostrar todos las rifas en web <small>(Se le aplicara a todas las rifas la opcion seleccionada)</small></h4>
                                <select class="default-select form-control wide" name="is_visible_in_web">
                                    <option value=""> -- seleccione --  </option>
                                    <option value="si">Si</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <h4 class="card-title">Inicio</h4>
                                <input type="text" name="start" class="form-control input-default ">
                            </div>
                            <div class="mb-3 col-md-6">
                                <h4 class="card-title">Fin</h4>
                                <input type="text" name="end" class="form-control input-default">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="card-title">
                                    Puedes ingresar los numeros de rifas separados por comas (,). <small class="text-muted">
                                        Usar esta opción si no deseas usar la opción de asignación automática por rangos</small>
                                </h4>
                                <textarea name="codes" class="form-control input-default my-3" id="" cols="30" rows="4"></textarea>
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
@endsection
