@extends('intranet.layouts.layout')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Rifa</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($changeStatusRequest->changeStatusRaffles as $key => $orderItem)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">{{ $orderItem->raffle->code }}</td>
                                            <td class="text-right">{{ $orderItem->raffle->price }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->


                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="{{ route('change-status-requests.index') }}" role="button" class="btn btn-danger"><i
                                        class="fas fa-backward"></i> Volver</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

@endsection

