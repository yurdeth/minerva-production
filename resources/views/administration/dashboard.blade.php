<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="{{ asset('CSS/administracion/dashboard.css')}}">
    <link rel="stylesheet" href="{{ asset('CSS/administracion/responsiveDashboard.css')}}">
</head>
<body>
<!-- New control panel design -->
<section>
    <!--Menu vertical-->
    <div class="menuVertical">
        <ul>
            <li>
                <div class="logo_container">
                    <img class="logo" src="{{ asset('IMG/Logo.png') }}" alt="Logo">
                    <span class="logo_title"> Minerva VR Web</span>
                </div>
            </li>
            <li>
                <a href="{{ route("inicio") }}" onclick="cambiarMensaje('inicio')">
                    <span><i class="fa-solid fa-house"></i></span>
                    <span class="Opciones">Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('carreras') }}" onclick="cambiarMensaje('carreras')">
                    <i class="fa-solid fa-school"></i>
                    <span class="Opciones">Carreras</span>
                </a>
            </li>
            <li>
                <a href="{{route("usuarios")}}" onclick="cambiarMensaje('usuarios')">
                    <span><i class="fa-solid fa-user-group"></i></span>
                    <span class="Opciones">Usuarios</span>
                </a>
            </li>
            <li>
                <a href="{{ route("citas_dashboard") }}" onclick="cambiarMensaje('citas')">
                    <span><i class="fa-solid fa-calendar-days"></i></span>
                    <span class="Opciones">Citas</span>
                </a>
            </li>
            <li>
                <a href="{{route("inventario")}}" onclick="cambiarMensaje('inventario')">
                    <span><i class="fa-solid fa-vr-cardboard"></i></span>
                    <span class="Opciones">Inventario</span>
                </a>
            </li>
            <li>
                <a href="{{route("notificaciones")}}" onclick="cambiarMensaje('notificaciones')">
                    <span><i class="fa-solid fa-bell"></i></span>
                    <span class="Opciones">Notificaciones</span>
                    <span id="notification-count"></span>
                </a>
            </li>
            <li>
                <a href="{{route("mensajes")}}" onclick="cambiarMensaje('Mensaje')">
                    <span><i class="fa-solid fa-paper-plane"></i></span>
                    <span class="Opciones">Mensajes</span>

                </a>
            </li>
        </ul>
    </div>
    <!-- Fin del Menu Vertical -->
    <!------------------------------------------------------------------------------------------------------------->

    <!-- Navbar Horizontal -->
    <div class="container">
        <div class="navHorizontal">
            <ul>
                <li>
                    <a class="nav-link" href="{{ route('profile', ['id' => Auth::user()->id]) }}">
                        <span><i class="fa-solid fa-user"></i></span>
                        <span class="title">Admin</span>
                    </a>
                </li>
                <li>
                    {{--                    <button><a class="nav-link" href="{{ route("logout") }}">Cerrar Sesión</a></button>--}}
                    <a class="nav-link" href="{{ route("logout") }}">
                        <span><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                        <span class="title">Salir</span>
                    </a>
                </li>
                <li>
                    <button type="button" class="btn" id="Tema">
                        <img class="lentes" src="{{ asset('IMG/Minerva.png') }}" alt="Logo">
                    </button>
                </li>
            </ul>
        </div>
        <br><br>
        <!-- Fin del Navbar Horizontal -->
        <!------------------------------------------------------------------------------------------------------------->

        <!-- Contenidos del Dashboard -->
        <div class="contenido">
            <div class="datos">
                <!-- Definimos una variable para el mensaje a mostrar -->
                @php
                    $mensaje = '';
                @endphp
                    <!-- Verificamos si la variable mensaje no está vacía -->
                @if(!empty($mensaje))
                    <!-- Si mensaje tiene contenido, se mostramos un encabezado con dicho mensaje -->
                    <h1 id="mensaje">{{ $mensaje }}</h1>
                    <hr>
                @else
                    <!-- Si mensaje está vacío mostramos un mensaje de bienvenida por defecto -->
                    <h1 id="mensaje">Bienvenido</h1>
                    <hr>
                @endif
                <div id="imagen-contenedor" style="display:flex; justify-content:center; margin-top:10px;">
                    <img id="imagen" src="{{ asset('IMG/bienvenida.png') }}"
                        alt="Imagen de bienvenida"
                        style="max-width: 80%; height: auto; mask-image: linear-gradient(to right, transparent, white 50%, white 70%, transparent);">
                </div>
                <div id="content">
                    @yield('content')
                </div>

            </div>
        </div>
</section>

<script>
    // Función que se encarga de cambiar el mensaje mostrado en la página
    function cambiarMensaje(opcion) {
        let mensaje = '';
        let ruta = '';
        let imagen = document.getElementById('imagen');
        //Estructura switch para asignar un mensaje basado en la opción seleccionada
        switch (opcion) {
            case 'inicio':
                mensaje = 'Bienvenido';
                ruta = '{{ asset('IMG/bienvenida.png') }}';
                break;
            case 'carreras':
                mensaje = 'Bienvenido a Carreras';
                ruta = '';
                break;
            case 'usuarios':
                mensaje = 'Usuarios Minerva RV Web';
                ruta = '';
                break;
            case 'citas':
                mensaje = 'Registro de Citas para Capacitación';
                ruta = '';
                break;
            case 'inventario':
                mensaje = 'Inventario de Equipo';
                ruta = '';
                break;
            case 'notificaciones':
                mensaje = 'Notificaciones';
                ruta = '';
                break;
            case 'Mensaje':
                mensaje = 'Minerva RV Chat';
                ruta = '';
                break;
            default:
                mensaje = 'Bienvenido'; // Mensaje por defecto si la opción no coincide con ningúna
                ruta = '{{ asset('IMG/bienvenida.png') }}';
        }
        document.querySelector('.datos h1').innerText = mensaje;

        // Si hay una ruta de imagen, la mostramos, si no, ocultamos la imagen
        if (ruta) {
            imagen.src = ruta;
            imagen.style.display = 'block';
        } else {
            imagen.style.display = 'none';
        }
        // Guardamos el mensaje e imagen en localStorage
        localStorage.setItem('mensaje', mensaje);
        localStorage.setItem('rutaImagen', ruta);
    }

    // Evento que se ejecuta cuando el contenido del DOM ha sido completamente cargado
    document.addEventListener('DOMContentLoaded', function () {
        // Recuperamos el mensaje e imagen guardados en localStorage
        let mensajeGuardado = localStorage.getItem('mensaje');
        let rutaImagenGuardada = localStorage.getItem('rutaImagen');
        let imagen = document.getElementById('imagen');
        // Si hay un mensaje guardado, actualiza el contenido del elemento <h1> con ese mensaje
        if (mensajeGuardado) {
            document.querySelector('.datos h1').innerText = mensajeGuardado;
        }

        // Si hay una ruta de imagen guardada, actualiza el src de la imagen
        if (rutaImagenGuardada && rutaImagenGuardada !== '') {
            imagen.src = rutaImagenGuardada;
            imagen.style.display = 'block';
        } else {
            imagen.style.display = 'none';
        }
    });
</script>
<script type="module" src="{{ asset('js/notifications/countAllNotifications.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/1.1.6/choices.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset("js/themes/dashboardThemes.js")}}"></script>
</body>
</html>
