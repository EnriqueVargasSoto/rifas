@extends('intranet.layouts.layout')

@section('content')
<!-- Column starts -->
<div class="col-xl-12">
    <div class="card dz-card" id="accordion-four">
        <div class="card-header flex-wrap d-flex justify-content-between">
            <div>
                <h4 class="card-title">Rifas Asignadas</h4>
            </div>
            <ul class="" id="myTab-3" role="tablist">
                <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#basicModal"><i class="fa-solid fa-plus me-2"></i>Nuevo Asignacion</button>-->
            </ul>
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
                                        <th>Opción 1</th>
                                        <th>Opción 2</th>
                                        <th>Opción 3</th>
                                        <th>Rifa</th>
                                        <th>Estado</th>
                                        <th style="width:25px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($details as $key => $detail)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$detail->option1->name}}</td>
                                        <td>{{$detail->option2->name}}</td>
                                        <td>{{$detail->option3->name}}</td>
                                        <td>{{$detail->raffle->code}}</td>
                                        <td>{{$detail->raffle->selected == '0' ? 'Libre' : 'Ocupada'}}</td>
                                        <td style="width:25px">
                                            {{--<button type="button" class="btn btn-info"  data-toggle="modal" data-target="#basicModalEdit{{$assignment->id}}"><i class="fa-solid fa-pen me-2"></i>Editar</button>--}}
                                            {{--<a href="{{route('serials.destroy', $item->id)}}" class="btn btn-danger"><i class="fa-solid fa-trash me-2"></i>Eliminar</a>--}}
                                        </td>
                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        <!-- /tab-content -->

    </div>
</div>
<!-- Column ends -->



{{--@foreach ($users as $item)
<!-- Modal -->
<div class="modal fade" id="basicModalEdit{{$item->id}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Responsable</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{route('users.update', $item->id)}}" method="post">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <h4 class="card-title">Nombres Completos</h4>
                            <input type="text" name="name" class="form-control input-default" value="{{$item->name}}" placeholder="Ingrese Nombres Completos">
                        </div>
                        <div class="mb-3 col-md-6">
                            <h4 class="card-title">DNI</h4>
                            <input type="text" name="dni" class="form-control input-default" value="{{$item->dni}}" placeholder="Ingrese DNI">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <h4 class="card-title">Nombre Corto</h4>
                            <input type="text" name="short_name" class="form-control input-default" value="{{$item->short_name}}" placeholder="Ingrese Nombre Corto">
                        </div>
                        <div class="mb-3 col-md-6">
                            <h4 class="card-title">Teléfono</h4>
                            <input type="text" name="phone" class="form-control input-default" value="{{$item->phone}}" placeholder="Ingrese Teléfono">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <h4 class="card-title">Unidad</h4>
                            <input type="text" name="unit" class="form-control input-default" value="{{$item->unit}}" placeholder="Ingrese Unidad">
                        </div>
                        <div class="mb-3 col-md-6">
                            <h4 class="card-title">Área</h4>
                            <input type="text" name="area" class="form-control input-default" value="{{$item->area}}" placeholder="Ingrese Área">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <h4 class="card-title">Posición</h4>
                            <input type="text" name="position" class="form-control input-default" value="{{$item->position}}" placeholder="Ingrese Posición">
                        </div>
                        <div class="mb-3 col-md-6">
                            <h4 class="card-title">Password</h4>
                            <input type="text" name="password" class="form-control input-default" value="{{$item->clave}}" placeholder="Ingrese Password">
                        </div>
                    </div>
                    <div class="mb-3 col-md-12">
                        <h4 class="card-title">Observación</h4>
                        <textarea name="observation" class="form-control input-default " id=""  rows="3">{{$item->observation}}</textarea>
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
@endforeach--}}
@endsection
