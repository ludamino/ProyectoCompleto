<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="https://proyectostics.com/wp-content/uploads/2022/03/favicon.png" />
</head>

<body>

    <div class="conteiner">
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

        <br><br><br>
        <center>
            <img class="img-fluid" src="https://proyectostics.com/wp-content/uploads/2022/03/logo_transparent-e1648418375769.png" width="25%" height="100%" alt="">
        </center>
        <br><br><br>


        <div class="container">
            <div class="row">
                <div class="col">
                    <br>
                    <div class="card">
                        <br>
                        <center>
                            <x-icon-pasos />
                        </center>
                        <div class="card-body">
                            <h3 class="card-text text-center"><span class="badge rounded-pill bg-success">Primeros Pasos</span></h3>
                            <br>
                            <p class="card-text"> La participación del alumno en clase, la forma en la que se involucran con las actividades en el aula, la distribución de las actividades y tareas todo en sí, es el juego</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <br>
                    <div class="card">
                        <br>
                        <center>
                            <x-icon-centro-ayuda />
                        </center>
                        <div class="card-body">
                            <h3 class="card-text text-center"><span class="badge rounded-pill bg-success">Centro de ayuda</span></h3>
                            <br>
                            <p class="card-text"> ¿Tienes preguntas sobre Ludamino?
                                Tenemos las respuestas a preguntas mas frecuentes aquí. También puedes escribirnos directamente al correo de ludamino3@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <br>
                    <div class="card">
                        <br>
                        <center>
                            <x-icon-recorrido />
                        </center>
                        <div class="card-body">
                            <h3 class="card-text text-center"><span class="badge rounded-pill bg-success">Tour</span></h3>
                            <br>
                            <p class="card-text">Un recorrido rapido por el sistema web. Nada mejor que un Tour para conocer la herramienta web. Empezar a usar Ludamino es la mejor opcion de aprendizaje.</p>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <br>
                    <div class="card">
                        <br>
                        <center>
                            <x-icon-profesores />
                        </center>
                        <div class="card-body">
                            <h3 class="card-text text-center"><span class="badge rounded-pill bg-success">Primeros Pasos</span></h3>
                            <br>
                            <p class="card-text"> Contando con un staff de docentes con un nivel de preparación mínimo de maestría, activos dentro de los sistemas docentes de las universidades más prestigiosas en del país.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>