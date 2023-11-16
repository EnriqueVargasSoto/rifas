@extends('layouts.public-layout.layout')

@section('content')
    <div class="container">

        @if (session('success-add-cart'))
            <div class="alert alert-success">
                {{ session('success-add-cart') }}
            </div>
        @endif

        @if (session('error-add-cart'))
            <div class="alert alert-danger">
                {{ session('error-add-cart') }}
            </div>
        @endif

        @auth('client')
            <div class="w-100">


                <a href="{{ route('purchases.index') }}" class="btn btn-primary d-md-none btn-block">
                    Ver mis compras
                </a>
            </div>

            @if (count(session('cart', [])))
                <div class="alert alert-info">
                    <b>Mi carrito: </b> <b>Rifas: </b> {{ count(session('cart')) }} <b>Total</b> :
                    {{ count(session('cart')) * 20 }} <a href="{{ route('cart.index') }}">
                        <i class="fa fa-shopping-cart"></i> Ver carrito
                    </a>
                </div>
            @endif
        @else
            <div class="w-100">
                <a href="{{ route('register-client') }}" class="btn btn-primary d-md-none btn-block">
                    Ingresar
                </a>

                <a href="{{ route('register-client') }}" class="btn btn-primary d-md-none btn-block">
                    Ver mis compras
                </a>
            </div>
        @endauth



        <div class="container">
            <div class="row">
                @foreach ($raffles as $rifa)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 my-1">
                        <div class="card text-white bg-dark">
                            <div class="text-center">
                                <!-- Contenido de cada elemento -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="110" height="110" viewBox="0 0 100 100">
                                    <!-- Círculo exterior con radio 45 -->
                                    <circle cx="50" cy="50" r="45" fill="white" stroke="white"
                                        stroke-width="2" />

                                    <!-- Número en el centro con posición ajustada -->
                                    <text x="50" y="55" font-size="20" text-anchor="middle"
                                        fill="black">{{ $rifa->number }}</text>
                                </svg>

                                <h2 class="mt-2 h4 font-semibold text-gray-900">#{{ $rifa->code }}</h2>
                                <form action="{{ route('cart.addItem') }}" method="POST" class="my-3">
                                    @csrf
                                    <input type="hidden" value="{{ $rifa->id }}" name="id">
                                    <button type="submit" class="btn btn-outline-light">
                                        <i class="fa fa-shopping-cart"></i> Agregar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>






        <div class="d-flex justify-content-between container">
            @if (count($raffles))
                <p>Mostrando {{ $raffles->firstItem() }} a {{ $raffles->lastItem() }} de
                    {{ $raffles->total() }} resultados</p>
            @endif
            {{ $raffles->appends(['start' => $start, 'end' => $end])->links() }}
        </div>



        {{-- Mensaje no existen items --}}

        @if (count($raffles) == 0)
            <div class="alert alert-info mt-5">
                No existen rifas disponibles
            </div>
        @endif
    </div>
@endsection
