@extends('intranet.layouts.layout')

@section('content')
    <!-- Column starts -->
    <div class="col-xl-12">
        <div class="card dz-card" id="accordion-four">

            <div class="card-header">
                <div class="w-100 d-flex justify-content-between">
                    <h3 class="card-title">Lista de Rifas</h3>
                    <div class="card-tools">
                    </div>
                </div>
                <form action="{{ route('rifas.status') }}" method="GET">
                    <div class="row mt-3">
                        <div class="col-md-3 mb-3">
                            <label for="search">Buscar por código</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{{ $search }}"
                                    placeholder="Ingrese el código">
                            </div>
                        </div>


                        <div class="col-md-3 mb-3">
                            <label>Estado</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="Liquidada" id="status-liquidada" @if(in_array('Liquidada', $status)) checked @endif>
                                <label class="form-check-label" for="status-liquidada">
                                    Liquidada
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="Stock" id="status-stock" @if(in_array('Stock', $status)) checked @endif>
                                <label class="form-check-label" for="status-stock">
                                    Stock
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="Pagada" id="status-pagada" @if(in_array('Pagada', $status)) checked @endif>
                                <label class="form-check-label" for="status-pagada">
                                    Pagada
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="Reservada" id="status-reservada" @if(in_array('Reservada', $status)) checked @endif>
                                <label class="form-check-label" for="status-reservada">
                                    Reservada
                                </label>
                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="user_id"> Ingrese un rango de numeros</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="start" value="{{ $start }}"
                                    placeholder="Desde">
                                <input type="text" class="form-control" name="end" value="{{ $end }}"
                                    placeholder="Hasta">
                            </div>
                        </div>

                        @if (auth('web')->user()->role->role == 'Super Admin')
                            <div class="col-md-3 mb-3">
                                <label for="is_visible_in_web">Visible en la web</label>
                                <select name="is_visible_in_web" class="form-control" value="{{ $is_visible_in_web }}">
                                    <option value="" selected>Seleccione</option>
                                    <option value="1" @if ($is_visible_in_web == 1) selected @endif>Si</option>
                                    <option value="0" @if ($is_visible_in_web == 0) selected @endif>No</option>
                                </select>
                            </div>
                        @endif

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
                            <a href="{{ route('rifas.status') }}" class="btn btn-danger"><i class="fa fa-undo"></i>
                                Restabler
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
                <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab-3">
                    <div class="card-body pt-0">
                        <form action="{{ route('rifas.requestChangeStatus') }}" id="formCreateRequestChangeStatus"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="w-100">
                                <div class="row my-2">
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <label for="status">Mover a: </label>
                                            <select name="status" class="form-control" 
                                                id="selectStatusDestinatation">
                                                <option value="Liquidada"
                                                    @if ($status == 'Liquidada') selected @endif>
                                                    Liquidada</option>
                                                <option value="Stock" @if ($status == 'Stock') selected @endif>
                                                    Stock
                                                </option>
                                                {{-- <option value="Fiada" @if ($status == 'Fiada') selected @endif>
                                                    Fiada
                                                </option> --}}
                                                <option value="Pagada" @if ($status == 'Pagada') selected @endif>
                                                    Pagada</option>
                                                <option value="Reservada"
                                                    @if ($status == 'Reservada') selected @endif>
                                                    Reservada</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-3" id="image_request">
                                        <div class="form-group">

                                            <label for="">
                                                Seleccione imagen de comprobante
                                            </label>
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="transaction_id_request">
                                        <div class="form-group">
                                            <label for="">
                                                Codigo de transacción
                                            </label>
                                            <input type="text" class="form-control" name="transaction_id">
                                        </div>

                                    </div>

                                    <div class="col-md-3 mt-4"><button type="submit"
                                            class="btn btn-primary">Solicitar</button></div>
                                </div>

                            </div>
                            <div class="table-responsive">
                                <table id="example4" class="display table" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th style="width: 15px">#</th>
                                            <th>
                                                <input type="checkbox" id="selectAll">
                                            </th>
                                            <th>Codigo</th>
                                            <th>Estado</th>
                                            <th>Precio</th>
                                            <th>Usuario 1</th>
                                            <th>Usuario 2</th>
                                            <th>Usuario 3</th>
                                            <th>Cod. operación</th>
                                            <th>Fecha creación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($raffles as $key => $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>
                                                    <input type="checkbox" class="selectItem" name="selectedItems[]"
                                                        value="{{ $item->id }}">
                                                </td>
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
                                                <td>{{ $item->transaction_id }}</td>
                                                <td>{{ $item->created_at->format('d/m/Y') }}</td>

                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td colspan="3"></td>
                                            <td>Total</td>
                                            <td>{{number_format(($raffles->total() * 20),2)}}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div class="mt-2">
                                    <p>Mostrando {{ $raffles->firstItem() }} a {{ $raffles->lastItem() }} de
                                        {{ $raffles->total() }} registros</p>
                                </div>
                                {{ $raffles->appends(['search' => $search, 'status' => $status, 'is_visible_in_web' => $is_visible_in_web, 'user_id_1' => $user_id_1, 'user_id_2' => $user_id_2, 'user_id_3' => $user_id_3])->links() }}
                            </div>
                        </form>
                    </div>
                </div>


            </div>
            <!-- /tab-content -->

        </div>
    </div>
    <!-- Column ends -->
@endsection
@section('scripts')
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            var checkboxes = document.getElementsByClassName('selectItem');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });

        document.getElementById('selectStatusDestinatation').addEventListener('change', function() {
            var status = this.value;
            if (status == 'Liquidada') {
                document.getElementById('image_request').style.display = 'block';
                document.getElementById('transaction_id_request').style.display = 'block';
            } else {
                document.getElementById('image_request').style.display = 'none';
                document.getElementById('transaction_id_request').style.display = 'none';
            }
        });

        $.validator.setDefaults({
            submitHandler: function(form) {
                // submit form
                form.submit();
            }
        });

        $.validator.addMethod("requiredIfLiquidada", function(value, element, param) {
            // Verifica si el estado es "Liquidada"
            var status = $(param).val();
            // Si el estado es "Liquidada", este campo es requerido
            // Si el estado no es "Liquidada", este campo no es requerido
            return status !== "Liquidada" || value !== "";
        }, "Este campo es requerido si el estado es 'Liquidada'.");
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


        $(function() {
            $('#formCreateRequestChangeStatus').validate({
                rules: {
                    status: {
                        required: true,
                    },
                    image: {
                        requiredIfLiquidada: "#selectStatusDestinatation"
                    },
                    transaction_id: {
                        requiredIfLiquidada: "#selectStatusDestinatation"
                    }
                },
                messages: {
                    status: {
                        required: "Por favor seleccione un estado"
                    },
                    image: {
                        requiredIfLiquidada: "Por favor seleccione una imagen si el estado es 'Liquidada'"
                    },
                    transaction_id: {
                        requiredIfLiquidada: "Por favor ingrese un código de transacción si el estado es 'Liquidada'"
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
