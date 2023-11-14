@extends('intranet.layouts.layout')

@section('content')
    <!-- Column starts -->
    <div class="col-xl-12">
        <div class="card dz-card" id="accordion-four">
            <div class="card-header">

                <div class="w-100 d-flex justify-content-between">
                    <h3 class="card-title">Lista de clientes</h3>
                    <div class="card-tools">
                    </div>
                </div>

                <form action="{{ route('clients.index') }}" method="GET">
                    <div class="row mt-3">
                        <div class="col-md-3 mb-3">
                            <label for="search">Buscar </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{{ $search }}">
                            </div>
                        </div>

                        <div class="col-md-2 mt-4">

                            <button type="submit" class="btn btn-primary btn-block">Buscar</button>

                        </div>
                        <div class="col-md-2 mt-4">
                            <a href="{{ route('clients.index') }}" class="btn btn-danger"><i class="fa fa-undo"></i>
                                Restabler filtros</a>
                        </div>
                    </div>
                </form>
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
                                        <th>Nombres</th>
                                        <th>Telefono</th>
                                        <th>Direccion</th>
                                        <th style="width:25px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td style="width:40px">
                                                <i role="button" data-toggle="modal"
                                                    data-target="#basicModalEdit{{ $item->id }}"><i
                                                        class="fa-solid fa fa-pen"></i></i>

                                                {{-- <a href="">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </a> --}}
                                                {{-- <a href="{{route('serials.destroy', $item->id)}}" class="btn btn-danger"><i class="fa-solid fa-trash me-2"></i>Eliminar</a> --}}
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div class="mt-2">
                                <p>Mostrando {{ $clients->firstItem() }} a {{ $clients->lastItem() }} de
                                    {{ $clients->total() }} registros</p>
                            </div>

                            {{ $clients->appends(['search' => $search])->links() }}
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Nuevo Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('clients.store') }}" method="post" id="formCreateClient">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Nombre
                                    </label>
                                    <input type="text" name="name" class="form-control input-default ">
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Apellidos
                                    </label>
                                    <input type="text" name="last_name" class="form-control input-default ">
                                </div>
                            </div>


                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Teléfono
                                    </label>
                                    <input type="text" name="phone" class="form-control input-default">
                                </div>

                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Direccion
                                    </label>
                                    <input type="text" name="address" class="form-control input-default">
                                </div>

                            </div>
                        </div>


                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Contraseña
                                    </label>
                                    <input type="text" name="password" class="form-control input-default">
                                </div>

                            </div>
                        </div>
                        <div class="row">

                            <div class="mb-3 col-md-12">
                                <div class="form-group">
                                    <label for="">
                                        Observación
                                    </label>
                                    <textarea name="observation" class="form-control input-default " id="" rows="3"></textarea>
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

    @foreach ($clients as $item)
        <!-- Modal -->
        <div class="modal fade" id="basicModalEdit{{ $item->id }}">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('users.update', $item->id) }}" method="post"
                        id="formUpdateClient{{ $item->id }}">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="">Nombre</label>
                                        <input type="text" name="name" class="form-control input-default"
                                            value="{{ $item->name }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="">Apellidos</label>
                                        <input type="text" name="last_name" class="form-control input-default"
                                            value="{{ $item->last_name }}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <div class="form-group">


                                        <h4 class="card-title">Teléfono</h4>
                                        <input type="text" name="phone" class="form-control input-default"
                                            value="{{ $item->phone }}">
                                    </div>
                                </div>


                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title">Direccion</h4>
                                        <input type="text" name="address" class="form-control input-default"
                                            value="{{ $item->address }}">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title">Password</h4>
                                        <input type="text" name="password" class="form-control input-default"
                                            value="{{ $item->clave }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <h4 class="card-title">Observación</h4>
                                    <textarea name="observation" class="form-control input-default " id="" rows="3">{{ $item->observation }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    <script>
        $(function() {
            $.validator.setDefaults({
                submitHandler: function() {
                    // submit form
                    $('#formCreateClient').submit();
                }
            });
            $('#formCreateClient').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Por favor ingrese un nombre",
                    },
                    last_name: {
                        required: "Por favor ingrese un apellido",
                    },
                    phone: {
                        required: "Por favor ingrese un teléfono",
                    },
                    password: {
                        required: "Por favor ingrese una contraseña",
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

    @foreach ($clients as $client)
        <script>
            $(function() {
                $.validator.setDefaults({
                    submitHandler: function() {
                        // submit form
                        $('#formUpdateClient' + {{ $client->id }}).submit();
                    }
                });
                $('#formUpdateClient' + {{ $client->id }}).validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        last_name: {
                            required: true,
                        },
                        phone: {
                            required: true,
                        },
                        password: {
                            required: true,
                        }

                    },
                    messages: {
                        name: {
                            required: "Por favor ingrese un nombre",
                        },
                        last_name: {
                            required: "Por favor ingrese un apellido",
                        },
                        phone: {
                            required: "Por favor ingrese un teléfono",
                        },
                        password: {
                            required: "Por favor ingrese una contraseña",
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
