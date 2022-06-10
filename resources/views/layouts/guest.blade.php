<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="https://proyectostics.com/wp-content/uploads/2022/03/favicon.png"/>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body>
<nav class="navbar navbar-light bg-light fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Ludamino</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Ludamino</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            @if (Route::has('login'))
                            @auth

                            @if (auth()->user()->clv_tipo_usuario == 1)
                            <li class="nav-item">
                                <a href="{{ url('/inicio') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Panel de Administración</a>
                            </li>
                            @elseif (auth()->user()->clv_tipo_usuario == 2)
                            <li class="nav-item">
                                <a href="{{ url('/maestro') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Panel de Maestro</a>
                            </li>
                            @elseif (auth()->user()->clv_tipo_usuario == 3)
                            <li class="nav-item">
                                <a href="{{ url('/alumno') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Panel del Alumno</a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a href="{{ url('/espera') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">En espera</a>
                            </li>

                            @endif



                            @else


                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="https://proyectostics.com/">▶ Visita nuestra WEB</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">▶ Iniciar sesion</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">▶ Registrarse</a>
                            </li>
                            @endif


                            @endauth

                            @endif

                        </ul>

                    </div>
                </div>
            </div>
        </nav>
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>