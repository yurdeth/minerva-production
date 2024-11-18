<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Minerva VR Web</title>
    <!--Links empleados-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/choices.js/1.1.6/styles/css/choices.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="{{ asset('CSS/home.css')}}">
    <link rel="stylesheet" href="{{ asset('CSS/floating-span.css')}}">
    <link rel="icon" href="{{ asset('IMG/LogoUES.png') }}">
    @vite(['resources/js/app.js'])
</head>
<body>
    <style>
        .date-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background: white;
            width: 250px;
            transition: all 0.3s ease;
        }

        .date-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .barcode-icon {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .date-title {
            font-weight: 500;
            margin-bottom: 4px;
            color: #333;
        }

        .date-description {
            color: #757575;
            font-size: 14px;
        }
    </style>
    <div class="mb-4" id="app">
        <!--Navbar de la pagina-->
        <nav class="navbar navbar-expand-lg shadow-sm fixed-top mb-4">
            <div class="container-fluid">
                <div class="logo_title">
                    <a class="navbar-brand text-light" href="{{ route("inicio") }}">
                        <img class="logo" src="{{ asset('IMG/Logo.png') }}" alt="Logo">
                        Minerva RV Lab FMO
                    </a>
                </div>
                <!-- Button que aparece en dispositivos moviles-->
                <button class="navbar-toggler text-warning bg-white" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Opciones del navbar-->
                 <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @auth
                            <button> <a class="nav-link text-light" href="{{ route("HomeVR") }}">Inicio</a> </button>
                            <button class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Citas
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route("agendar") }}">Agendar Citas</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route("citas-ver") }}">Mis citas</a>
                                    </li>
                                    @if( Auth::user()->roles_id == 1 )
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{route("dashboard")}}">Calendario de citas </a>
                                    </li>
                                    @endif
                                </ul>
                            </button>
                                <!-- Verificamos el rol del usuario-->
                                @if( Auth::user()->roles_id == 1 )
                                    <button>
                                        <a class="nav-link text-light" href="{{ route("dashboard") }}">Panel de Administración</a>
                                    </button>
                                @endif
                                    <button>
                                        <a class="nav-link text-light" href="{{ route("logout") }}">Cerrar Sesión</a>
                                    </button>
                                    <button>
                                        <a class="nav-link" href="{{ route('profile', ['id' => Auth::user()->id]) }}">
                                            <span class="navbar-text" style="color: white">{{ Auth::user()->name }}</span>
                                        </a>
                                    </button>
                                    <label for="toggle" class="toggle" id="toggle">
                                        <i class="rv">
                                             <img class="lentes" src="{{ asset('IMG/Lentes.png') }}" alt="Logo">
                                        </i>
                                        <i class="minerva">
                                            <img class="lentes" src="{{ asset('IMG/Minerva.png') }}" alt="Logo">
                                        </i>
                                        <span class="ball"></span>
                                    </label>
                        @else
                            <li class="nav-item">
                                <button>
                                    <a class="nav-link text-light " href="{{ route('iniciarSesion') }}">Iniciar sesión</a>
                                </button>
                            </li>
                            {{--<li class="nav-item">
                                <button>
                                    <a class="nav-link text-light" href="{{ route('registrarse') }}">Registrarse</a>
                                </button>
                            </li>--}}
                             <!--Button para cambiar el color de la pagina-->
                             <li class="nav-item">
                                <label for="toggle" class="toggle" id="toggle">
                                    <i class="rv">
                                        <img class="lentes" src="{{ asset('IMG/Lentes.png') }}" alt="Logo">
                                    </i>
                                        <i class="minerva">
                                            <img class="lentes" src="{{ asset('IMG/Minerva.png') }}" alt="Logo">
                                        </i>
                                        <span class="ball"></span>
                                </label>
                             </li>
                        @endauth
                    </ul>
                 </div>
            </div>
        </nav>
    </div>
    <br><br>

    @include('layouts.loader')

    <!--Fin del Navbar de la pagina-->
    {{-- Contenido de la pagina --}}
    @yield('content')

    <!--Para el loader-->
    <script>
        window.onload = function() {
            document.getElementById('loader').style.display = 'none';
        };
    </script>

    <!-- Footer de la página-->
    <footer class="pt-5 pb-4" id="FooterCambio">
        <div class="container text-center text-md-start">
            <div class="row text-center text-md-start">

                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto- mt-3">
                    <h5 class="mb-4 font-weigth-bold text-center">Información</h5>
                    <hr class="mb-4">
                    <ul class="opcionesFo">
                        <li>
                            <a href="{{ route('quienes_somos') }}">Quiénes somos</a></li>
                        <li><a href="{{ route('servicios') }}">Servicios</a></li>
                        <li><a href="{{ route('contactos') }}">Contacto</a></li>
                    </ul>
                </div>

                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="mb-4 font-weigth-bold text-center">Horarios de Atención</h5>
                    <br>
                    <p class="text-light" style="text-align: center;">Lunes-Viernes: <br>8.00 a.m. - 5.00 p.m.</p>
                    <br>
                    <h5 class="font-weigth-bold text-center text-light">Minerva RV Lab</h5>
                    <div style="text-align: center;  font-size: 30px;">
                        <a style="text-decoration:none;" href="https://www.facebook.com/people/Minerva-RV-LAB-FMO/61564360994481/">
                        <i class="fa-brands fa-facebook"></i>
                        </a>

                        <a style="text-decoration:none;" href="https://www.instagram.com/minervarvfmo/">
                            <i class="fa-brands fa-square-instagram"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto- mt-3">
                    <h5 class="mb-4 font-weigth-bold text-center">Enlaces Rapidos</h5>
                    <hr class="mb-4">
                    <ul class="opcionesFo">
                        @auth
                            <li><a class="text-white text-decoration-none" href="{{ route('profile', ['id' => Auth::user()->id]) }}">Mi cuenta</a></li>
                        @endauth
                        <li>
                            <a href="{{ route('location') }}">Ubicación</a>
                        </li>
                        @auth
                            <li><a class="text-white text-decoration-none" href="{{ route('citas-ver') }}">Mis citas</a></li>
                        @endauth
                    </ul>
                </div>

                <hr class="mb-4">

                <div class="text-center mb-2">
                    <p class="font-weigth-bold text-white"><i class="fa-regular fa-copyright"></i> UNIVERSIDAD DE EL SALVADOR FACULTAD MULTIDISCIPLINARIA
                    ORIENTAL <br> Minerva RV Lab </p>
                </div>

            </div>
        </div>
    </footer>

    <!--Scripts para el layout y más-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/1.1.6/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset("js/main.js")}}"></script>
    <script src="{{asset("js/themes/temas.js")}}"></script>
</body>
</html>
