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
                <form action="{{ route('rifas.index') }}" method="GET">
                    <div class="row mt-3">
                        <div class="col-md-3 mb-3">
                            <label for="search">Buscar por código</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{{ $search }}"
                                    placeholder="Ingrese el código">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="is_visible_in_web">Visible en la web</label>
                            <select name="is_visible_in_web" class="form-control" value="{{ $is_visible_in_web }}">
                                <option value="" selected>Seleccione</option>
                                <option value="1" @if ($is_visible_in_web == 1) selected @endif>Si</option>
                                <option value="0" @if ($is_visible_in_web == 0) selected @endif>No</option>
                            </select>
                        </div>

                        @foreach (range(1, 3) as $index)
                            <div class="col-md-4 mb-3">
                                <label for="user_id_{{ $index }}">Usuario {{ $index }}</label>
                                <select name="user_id_{{ $index }}" class="form-control">
                                    <option value="" selected>Seleccione</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if ($user->id == ${"user_id_$index"}) selected @endif>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach

                        <div class="col-md-2 mt-4">

                            <button type="submit" class="btn btn-primary btn-block">Buscar</button>

                        </div>
                        <div class="col-md-2 mt-4">
                            <a href="{{ route('rifas.index') }}" class="btn btn-danger"><i class="fa fa-undo"></i> Restabler
                                filtros</a>
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
                                        <th>Codigo</th>
                                        <th>Estado</th>
                                        <th>Precio</th>
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
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>
                                                @if ($item->status == 'Liquidada')
                                                    <span class="badge badge-success">{{ $item->status }}</span>
                                                @elseif ($item->status == 'Stock')
                                                    <span class="badge badge-primary">{{ $item->status }}</span>
                                                @elseif ($item->status == 'Fiada')
                                                    <span class="badge badge-warning">{{ $item->status }}</span>
                                                @elseif ($item->status == 'Pagada')
                                                    <span class="badge badge-info">{{ $item->status }}</span>
                                                @elseif ($item->status == 'Reservada')
                                                    <span class="badge badge-secondary">{{ $item->status }}</span>
                                                @else
                                                    {{ $item->status }}
                                                @endif
                                            </td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->firstUser?->short_name }}</td>
                                            <td>{{ $item->secondUser?->short_name }}</td>
                                            <td>{{ $item->thirdUser?->short_name }}</td>
                                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                            <td style="width:30px" class="d-flex">
                                                <i class="fa fa-pen" data-toggle="modal" data-target="#basicModalEdit{{ $item->id }}" role="button"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <div class="d-flex justify-content-between">
                                <div class="mt-2">
                                    <p>Mostrando {{ $raffles->firstItem() }} a {{ $raffles->lastItem() }} de
                                        {{ $raffles->total() }} registros</p>
                                </div>

                                {{ $raffles->appends(['search' => $search])->links() }}
                            </div>
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
                    <h5 class="modal-title">Crear nueva rifa</h5>
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
                                        Numero
                                    </label>
                                    <input type="text" name="number" class="form-control ">
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Código
                                    </label>
                                    <input type="text" name="code" class="form-control ">
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Usuario 1
                                    </label>
                                    <select name="user_id_1" class="form-control">
                                        <option value="">Seleccione</option>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Usuario 2
                                    </label>
                                    <select name="user_id_2" class="form-control">
                                        <option value="">Seleccione</option>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Usuario 3
                                    </label>
                                    <select name="user_id_3" class="form-control">
                                        <option value="">Seleccione</option>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
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
                        <h5 class="modal-title">Editar Rifa</h5>
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
                                        <label for="">
                                            Numero
                                        </label>
                                        <input type="text" name="number" class="form-control"
                                            value="{{ $item->number }}">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="">
                                            Código
                                        </label>
                                        <input type="text" name="code" class="form-control "
                                            value="{{ $item->code }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="">
                                            Estado
                                        </label>
                                        <select name="status" class="form-control" value="{{ $item->status }}">
                                            <option value="">Seleccione</option>
                                            <option value="Liquidada" @if ($item->status == 'Liquidada') selected @endif>
                                                Liquidada</option>
                                            <option value="Stock" @if ($item->status == 'Stock') selected @endif>Stock
                                            </option>
                                            <option value="Fiada" @if ($item->status == 'Fiada') selected @endif>Fiada
                                            </option>
                                            <option value="Pagada" @if ($item->status == 'Pagada') selected @endif>
                                                Pagada</option>
                                            <option value="Reservada" @if ($item->status == 'Reservada') selected @endif>
                                                Reservada</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="">
                                            Visible en la web
                                        </label>
                                        <select name="is_visible_in_web" class="form-control"
                                            value="{{ $item->is_visible_in_web }}">
                                            <option value="">Seleccione</option>
                                            <option value="1" @if ($item->is_visible_in_web == 1) selected @endif>
                                                Si</option>
                                            <option value="0" @if ($item->is_visible_in_web == 0) selected @endif>No
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="">
                                            Usuario 1
                                        </label>
                                        <select name="user_id_1" class="form-control" value="{{ $item->user_id_1 }}">
                                            <option value="">Seleccione</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    @if ($user->id == $item->user_id_1) selected @endif>{{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="">
                                            Usuario 2
                                        </label>
                                        <select name="user_id_2" class="form-control" value="{{ $item->user_id_2 }}">
                                            <option value="">Seleccione</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    @if ($user->id == $item->user_id_2) selected @endif>{{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="">
                                            Usuario 3
                                        </label>
                                        <select name="user_id_3" class="form-control" value="{{ $item->user_id_3 }}">
                                            <option value="">Seleccione</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    @if ($user->id == $item->user_id_3) selected @endif>{{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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
        {{-- <div class="modal fade" id="basicModalGallery{{ $item->id }}">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Imagenes</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('rifas.storeFiles') }}" method="POST" enctype="multipart/form-data"
                        id="storeRaffleFile{{ $item->id }}">
                        @method('POST')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <div class="form-group">
                                        <label for="">
                                            Imagen
                                        </label>
                                        <input type="hidden" name="raffle_id" value="{{ $item->id }}">
                                        <input type="file" name="image" class="form-control-input" accept="image/*">
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
                        @foreach ($item->raffleImages as $image)
                            <div class="col-md-4 text-center" >
                                <div class="container-image">
                                    <div class="image" onclick="showImage(this)">
                                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="" class="img-fluid" style="cursor: pointer; height:250px;" >
                                    </div>
                                </div>
                                <form action="{{ route('rifas.deleteFile', $image->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="raffle_id" value="{{ $item->id }}">
                                    <input type="hidden" name="image_id" value="{{ $image->id }}">
                                    <input type="submit" value="Eliminar" class="btn btn-danger btn-block mt-2">
                                </form>
                            </div>
                        @endforeach

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>

                </div>
            </div>
        </div> --}}
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
    </script>
    @foreach ($raffles as $raffle)
        <script>
            $(function() {

                $('#storeRaffleFile' + {{ $raffle->id }}).validate({
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
    @endforeach

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
