<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rifas</title>


    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        
    <link rel="stylesheet" href="{{ asset('plugins/viewerjs/viewer.min.css') }}">
    <style>
        /* Estilo para el icono flotante */
        .whatsapp-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366; /* Color de fondo de WhatsApp */
            color: #fff; /* Color del ícono */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            text-decoration: none;
        }
    </style>

</head>

<body>
    {{-- header --}}

    @include('layouts.public-layout.header')
    <div class="pricing-header px-3 py-4 pt-md-5 pb-md-4 mx-auto text-center" style="margin-top: 30px">

    </div>

    <div class="container">
        @yield('content')

        @include('layouts.public-layout.footer')
    </div>
    <?php
        $usuario = App\Models\User::where('show_information_in_web', 1)->first();
        $telefono = $usuario? $usuario->phone : '51924061643';
    ?>
    <a href="https://api.whatsapp.com/send?phone={{$telefono}}" style="text-decoration: none !important;" target="_blank" class="whatsapp-icon">
        <i class="fab fa-whatsapp"></i>
    </a>
    {{-- Footer --}}
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    
    <script src="{{ asset('plugins/viewerjs/viewer.min.js') }}"></script>
    @yield('scripts')
</body>

</html>
