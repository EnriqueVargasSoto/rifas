@extends('intranet.layouts.layout')

@section('content')
    <!-- Column starts -->
    <div class="col-xl-12">
        <div class="card dz-card" id="accordion-four">
            <div class="card-header">
                <div class="w-100 d-flex justify-content-between">
                    <h3 class="card-title">Lista de Responsables</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#basicModal"><i
                                class="fa-solid fa fa-plus mx-2"></i>Nuevo Responsable</button>
                    </div>
                </div>
                <form action="{{ route('users.index') }}" method="GET">
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
                            <a href="{{ route('users.index') }}" class="btn btn-danger"><i class="fa fa-undo"></i>
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
                                        <th>Rol</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Unidad</th>
                                        <th>Área</th>
                                        <th>Posición</th>
                                        <th style="width:25px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->role->role }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->unit }}</td>
                                            <td>{{ $item->area }}</td>
                                            <td>{{ $item->position }}</td>
                                            <td style="width:40px">
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#basicModalEdit{{ $item->id }}"><i
                                                        class="fa-solid fa fa-pen"></i></button>
                                                {{-- <a href="{{route('serials.destroy', $item->id)}}" class="btn btn-danger"><i class="fa-solid fa-trash me-2"></i>Eliminar</a> --}}
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div class="mt-2">
                                <p>Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de
                                    {{ $users->total() }} registros</p>
                            </div>

                            {{ $users->appends(['search' => $search])->links() }}
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
                    <h5 class="modal-title">Crear Nuevo Responsable</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.store') }}" method="post" id="formCreateUser">
                    @csrf
                    <div class="modal-body">

                        <div class="row">
                            <div class="mb-3 col-md-6">

                                <div class="form-group">
                                    <label for="">
                                        Nombres Completos
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
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Nombre Corto
                                    </label>

                                    <input type="text" name="short_name" class="form-control input-default ">
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
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Unidad
                                    </label>
                                    <input type="text" name="unit" class="form-control input-default ">
                                </div>

                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Área
                                    </label>
                                    <input type="text" name="area" class="form-control input-default ">
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Direccion
                                    </label>
                                    <input type="text" name="address" class="form-control input-default ">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Posición
                                    </label>
                                    <input type="text" name="position" class="form-control input-default ">
                                </div>

                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Contraseña
                                    </label>
                                    <input type="text" name="password" class="form-control input-default ">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Email
                                    </label>
                                    <input type="text" name="email" class="form-control input-default">
                                </div>
                            </div>
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

    @foreach ($users as $item)
        <!-- Modal -->
        <div class="modal fade" id="basicModalEdit{{ $item->id }}">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Responsable</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ route('users.update', $item->id) }}" method="post"
                        id="formUpdateUser{{ $item->id }}">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="">Nombres completos</label>
                                        <input type="text" name="name" class="form-control input-default"
                                            value="{{ $item->name }}" placeholder="Ingrese Nombres Completos">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title">DNI</h4>
                                        <input type="text" name="dni" class="form-control input-default"
                                            value="{{ $item->dni }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title">Nombre Corto</h4>
                                        <input type="text" name="short_name" class="form-control input-default"
                                            value="{{ $item->short_name }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">


                                        <h4 class="card-title">Teléfono</h4>
                                        <input type="text" name="phone" class="form-control input-default"
                                            value="{{ $item->phone }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">


                                        <h4 class="card-title">Correo</h4>
                                        <input type="text" name="email" class="form-control input-default"
                                            value="{{ $item->email }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <div class="form group">


                                        <h4 class="card-title">Unidad</h4>
                                        <input type="text" name="unit" class="form-control input-default"
                                            value="{{ $item->unit }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title">Área</h4>
                                        <input type="text" name="area" class="form-control input-default"
                                            value="{{ $item->area }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title">Direccion</h4>
                                        <input type="text" name="address" class="form-control input-default"
                                            value="{{ $item->address }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title">Posición</h4>
                                        <input type="text" name="position" class="form-control input-default"
                                            value="{{ $item->position }}">
                                    </div>

                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title">Password</h4>
                                        <input type="text" name="password" class="form-control input-default"
                                            value="{{ $item->clave }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title">Mostrar informacion en la web</h4>

                                        <select name="show_information_in_web" class="form-control input-default">
                                            <option value="">Seleccione</option>
                                            <option value="1"
                                                {{ $item->show_information_in_web == 1 ? 'selected' : '' }}>
                                                Si</option>
                                            <option value="0"
                                                {{ $item->show_information_in_web == 0 ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3 col-md-12">
                                <h4 class="card-title">Observación</h4>
                                <textarea name="observation" class="form-control input-default " id="" rows="3">{{ $item->observation }}</textarea>
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
        $.validator.setDefaults({
            submitHandler: function(form) {
                // submit form
                form.submit();
            }
        });

        $(function() {
            $('#formCreateUser').validate({
                rules: {
                    phone: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                    email: {
                        required: true,
                    }
                },
                messages: {
                    phone: {
                        required: "Por favor ingrese un teléfono",
                    },
                    password: {
                        required: "Por favor ingrese un password",
                    },
                    email: {
                        required: "Por favor ingrese un email",
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

    @foreach ($users as $user)
        <script>
            $(function() {
                $('#formUpdateUser' + {{ $user->id }}).validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        dni: {
                            required: true,
                        },
                        short_name: {
                            required: true,
                        },
                        phone: {
                            required: true,
                        },
                        unit: {
                            required: true,
                        },
                        area: {
                            required: true,
                        },
                        position: {
                            required: true,
                        },
                        password: {
                            required: true,
                        },
                        email: {
                            required: true,
                        }

                    },
                    messages: {
                        name: {
                            required: "Por favor ingrese un nombre",
                        },
                        dni: {
                            required: "Por favor ingrese un dni",
                        },
                        short_name: {
                            required: "Por favor ingrese un nombre corto",
                        },
                        phone: {
                            required: "Por favor ingrese un teléfono",
                        },
                        unit: {
                            required: "Por favor ingrese una unidad",
                        },
                        area: {
                            required: "Por favor ingrese un área",
                        },
                        position: {
                            required: "Por favor ingrese una posición",
                        },
                        password: {
                            required: "Por favor ingrese un password",
                        },
                        email: {
                            required: "Por favor ingrese un email",
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
