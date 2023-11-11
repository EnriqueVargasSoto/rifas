@extends('layouts.public-layout.layout')

@section('content')
    <div class="container-fluid">
        <h4>
            Mis compras
        </h4>
        <div class="w-100 my-3">
            <form action="{{ route('purchases.index') }}" method="GET">
                <label for="">
                    Buscar por documento de identidad
                </label>
                <div class="input-group">
                    <input type="text" class="form-control" name="identity_number" placeholder=""
                        value="{{ $identity_number }}">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </form>
        </div>

        @if ($client_not_found)
            <div class="alert alert-danger">
                Cliente no encontrado
            </div>
        @endif

        <div class="row">
            @foreach ($orders as $item)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header  text-white {{$item->status == 'reservado'?'bg-warning':'bg-success'  }}">
                            <h4 class="my-0 font-weight-normal">#{{ str_pad($item->id, 8, '0', STR_PAD_LEFT) }}</h4>
                        </div>
                        <div class="card-body">
                            <span class="card-text"><strong>Total:</strong> {{ $item->total }}</span><br>
                            <span class="card-text"><strong>Fecha:</strong>
                                {{ $item->created_at->format('d/m/Y H:i') }}</span><br>
                            <span class="card-text"><strong>Estado:</strong> 
                                @if ($item->status == 'reservado')
                                    Revisando su compra
                                @else
                                    Su compra esta confirmada
                                @endif  
                            </span>
                            <br>
                            <strong>Rifas:</strong>
                            <ul class="list-unstyled">
                                @foreach ($item->order_items as $order_item)
                                    <li>Rifa: # {{ $order_item->raffle->code }}</li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    @endsection
