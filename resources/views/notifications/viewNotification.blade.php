@extends('administration.dashboard')
@section('title', 'Inventario')

@section('content_header')
    <h1>Datos de inventario</h1>
@stop

@section('content')

    <style>
        .form-control {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 8px 30px; /* Espaciado interno para el texto */
            transition: border-color 0.3s;
            width: 450px; /* Ancho fijo por defecto */
            height: 40px; /* Altura del input */
            font-size: 14px; /* Tamaño del texto */
            box-sizing: border-box; /* Incluye el padding en el ancho total */
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        .icon-input {
            position: relative;
            display: flex; /* Usar flex para alinear el input y el ícono */
            align-items: center; /* Centrar verticalmente */
            margin: 0; /* Ajustar el margen a 0 para evitar centrado */
        }

        .icon-input i {
            position: absolute;
            left: 10px; /* Espaciado desde la izquierda */
            color: #999; /* Color del ícono */
            font-size: 16px; /* Tamaño del ícono */
            pointer-events: none; /* No interfiere con clics */
        }

        .icon-input input {
            padding-left: 30px; /* Espaciado para el ícono */
        }

        .custom-btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px; /* Espaciado interno del botón */
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 38%; /* Ancho de los botones */
        }

        .custom-btn:hover {
            background-color: #2980b9;
        }

        .custom-btn:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        .form-group {
            text-align: left; /* Alinear el texto a la izquierda */
            margin-bottom: 20px; /* Espaciado inferior entre los campos */
            width: 100%; /* Asegurar que ocupe el 100% del ancho */
        }

        .form-container {
            display: flex; /* Usar flex para centrar el contenido */
            flex-direction: column; /* Orientar en columna */
            align-items: center; /* Centrar horizontalmente */
            justify-content: center; /* Centrar verticalmente */
            height: 100%; /* Asegurar que ocupe toda la altura del contenedor */
        }
    </style>

    <link rel="stylesheet" href="{{ asset('CSS/administracion/tables.css')}}">
    <link rel="stylesheet" href="{{ asset('CSS/administracion/responsiveInventory.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <div class="col-6 bg-white p-5 text-center">
        <h2 style="margin-top: 10px; margin-bottom: 10px;">Notificaciones</h2>

        <div class="form-container"> <!-- Contenedor para centrar los inputs -->
            <form method="post" class="">
                @csrf

                <div class="form-group">
                    <div class="icon-input">
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="Ingresa tu correo electrónico" readonly>
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <div class="icon-input">
                        <input type="text" class="form-control" id="asunto" name="asunto"
                               placeholder="Asunto..." readonly>
                        <i class="fas fa-pencil-alt"></i>
                    </div>
                </div>
            </form>
            <div id="actionsButtons" class="row"></div>
            <div id="passwordForms" class="row"></div>
        </div>
    </div>

    <script src="{{ asset('js/notifications/viewNotifications.js') }}" type="module"></script>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('CSS/administracion.css')}}">
@stop
