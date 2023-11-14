@extends('layouts.public-layout.layout')
@section('content')
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">

            <div class="login-box">
                <!-- /.login-logo -->
                <div class="card card-outline card-primary">

                    <div class="card-body">
                        <p class="login-box-msg">Inicia sesion para continuar</p>

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error-login'))
                            <div class="alert alert-info">{{ session('error-login') }}</div>
                        @endif

                        <form action="{{ route('login-client') }}" method="post">
                            @csrf
                            <div class="input-group mb-4">
                                <input type="text" name="phone" class="form-control" placeholder="Usuario">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-4">
                                <input type="password" name="password" class="form-control" placeholder="Contraseña"
                                    autocomplete="current-password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- /.col -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                                </div>
                                <!-- /.col -->
                            </div>

                            <small class="text-center">Si olvidaste tu contraseña solicitalo al WhatsApp</small>


                        </form>
                        <p class="mb-0 mt-5">
                        </p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>




        </div>
        <div class="col-md-4"></div>
    </div>
@endsection
