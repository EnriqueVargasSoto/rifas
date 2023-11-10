@extends('intranet.layouts.layout')

@section('content')
<!-- Column starts -->
<div class="col-xl-12">
    <div class="card dz-card" id="accordion-four">
        <div class="card-header flex-wrap d-flex justify-content-between">
            <div>
                <h4 class="card-title">Lista de Rifas</h4>
            </div>
            <ul class="" id="myTab-3" role="tablist">
                {{--<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal"><i class="fa-solid fa-plus me-2"></i>Nuevo Responsable</button>--}}
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
                                        <th>Código</th>
                                        <th style="width:25px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($raffles as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->code}}</td>
                                        <td style="width:25px">
                                            <button type="button" class="btn btn-info"  data-bs-toggle="modal" data-bs-target="#basicModalEdit{{$item->id}}"><i class="fa-solid fa-pen me-2"></i>Editar</button>
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
@endsection
