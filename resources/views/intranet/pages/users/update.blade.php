<!-- resources/views/users/edit.blade.php -->
@extends('intranet.layouts.layout')

@section('content')
    <div class="container">
        <h2>Editar Datos</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif


        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" name="dni" class="form-control" value="{{ $user->dni }}">
            </div>

            <div class="form-group">
                <label for="short_name">Nombre Corto:</label>
                <input type="text" name="short_name" class="form-control" value="{{ $user->short_name }}">
            </div>

            <div class="form-group">
                <label for="phone">Teléfono:</label>
                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
            </div>

            <div class="form-group">
                <label for="unit">Unidad:</label>
                <input type="text" name="unit" class="form-control" value="{{ $user->unit }}">
            </div>

            <div class="form-group">
                <label for="area">Área:</label>
                <input type="text" name="area" class="form-control" value="{{ $user->area }}">
            </div>

            <div class="form-group">
                <label for="position">Posición:</label>
                <input type="text" name="position" class="form-control" value="{{ $user->position }}">
            </div>
            <div class="form-group">
                <label for="position">Direccion:</label>
                <input type="text" name="address" class="form-control" value="{{ $user->address }}">
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" class="form-control" readonly value="{{ $user->email }}" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="text" name="password" class="form-control" value="{{ $user->clave }}">
            </div>
            <button type="submit" class="btn btn-primary mb-4">Actualizar</button>
        </form>
    </div>
@endsection
