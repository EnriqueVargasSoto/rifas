@extends('layouts.public-layout.layout')

@section('content')
    <div class="container">
        <div class="w-100 my-3">
            <form action="{{ route('welcome') }}" method="GET">
                <label for="">
                    Buscar por un rango de números
                </label>
                <div class="input-group">
                    <input type="text" class="form-control" name="start" placeholder="Inicio" value="{{ $start }}">
                    <input type="text" class="form-control" name="end" placeholder="Fin" value="{{ $end }}">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </form>

        </div>
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
            @if (count(session('cart', [])))
                <div class="alert alert-info">
                    <b>Mi carrito: </b> <b>Rifas: </b> {{ count(session('cart')) }} <b>Total</b> :
                    {{ count(session('cart')) * 20 }}  <a href="{{route('cart.index')}}">
                        <i class="fa fa-shopping-cart"></i> Ver carrito
                    </a>
                </div>
            @endif
        @endauth

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($raffles as $rifa)
                <div class="col">
                    <div class="card text-white bg-dark mb-2">
                        <div class="text-center">
                            <!-- Contenido de cada elemento -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                                <!-- Círculo exterior -->
                                <circle cx="50" cy="50" r="45" fill="white" stroke="black"
                                    stroke-width="2" />

                                <!-- Número en el centro -->
                                <text x="50" y="60" font-size="25" text-anchor="middle"
                                    fill="black">{{ $rifa->number }}</text>
                            </svg>

                            <h2 class="mt-4 h4 font-semibold text-gray-900">Rifa #{{ $rifa->code }}</h2>
                            <form action="{{ route('cart.addItem') }}" method="POST" class="my-3">
                                @csrf
                                <input type="hidden" value="{{ $rifa->id }}" name="id">
                                <button class="btn btn-outline-light">
                                    <i class="fa fa-shopping-cart"></i> Agregar al carrito
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="w-100 d-flex justify-content-between">
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
