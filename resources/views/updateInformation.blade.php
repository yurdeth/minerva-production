<!--Incluimos el header y footer del layout-->
@extends('layouts.layout')

{{--Section para poder trabajar con layout --}}
{{--@section('content')--}}

@section('content_header')
    <h1>Perfil</h1>
@stop

@section('content')
    @vite(['resources/js/app.js'])

    <style>
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            padding: 8px 18px;
            cursor: pointer;
            border-radius: 3px;
            border: none #007bff;
            text-decoration: none;
            width: 100%;
            display: block;
            margin-bottom: 5px;
        }

        .btn-danger {
            background-color: #d33;
            color: white;
            border: none #f65e3f;
            padding: 8px 18px;
            cursor: pointer;
            border-radius: 3px;
            width: 100%;
            display: block;
            margin-bottom: 5px;
        }
    </style>

    <div class="container-xl" style="margin-top: 50px; margin-bottom: 70px;">

        <div class="row justify-content-center">

            <div class="col-md-6">
                <div class="card">

                    <div class="card-header">
                        <h2 class="text-center">Datos</h2>
                    </div>

                    <div class="card-body">

                        <form id="updateForm" method="POST">
                            <input type="hidden" value="{{ $randKey }}" id="rand">
                            @csrf
                            @method("POST")

                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="email" name="email" readonly>
                            </div>

                            <div class="form-group position-relative">
                                <label for="department" class="form-label">Departamento</label>
                                <select name="department" id="department" class="form-control" required>
                                    <option disabled>Seleccione un departamento</option>
                                </select>
                            </div>

                            <div class="form-group position-relative">
                                <label for="career" class="form-label">Carrera</label>
                                <select name="career" id="career" class="form-control" required>
                                    <option disabled>Carrera</option>
                                </select>
                            </div>

{{--                            <div class="mb-3">--}}
{{--                                <label for="password" class="form-label">Contraseña: </label>--}}
{{--                                <input type="password" class="form-control" id="password" name="password"--}}
{{--                                       placeholder="Ingrese su nueva contraseña">--}}
{{--                            </div>--}}

{{--                            <div class="mb-3">--}}
{{--                                <label for="password_confirmation" class="form-label">Repita su nueva contraseña: </label>--}}
{{--                                <input type="password" class="form-control" id="password_confirmation"--}}
{{--                                       name="password_confirmation" placeholder="Confirmar">--}}
{{--                            </div>--}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña: </label>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Ingrese su nueva contraseña" style="padding-right: 35px">
                                <span toggle="#password" class="fa fa-fw fa-eye toggle-password"
                                      style="position: absolute; margin-left:10px; right: 21px; top: 70.7%; transform: translateY(-50%); cursor: pointer; display: none;"></span>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Repita su nueva
                                    contraseña: </label>
                                <input type="password" class="form-control" id="password_confirmation"
                                       name="password_confirmation" placeholder="Confirmar" style="padding-right: 35px">
                                <span toggle="#password" class="fa fa-fw fa-eye toggle-password-confirmation"
                                      style="position: absolute; margin-left:10px; right: 21px; top: 84.5%; transform: translateY(-50%); cursor: pointer; display: none;"></span>
                            </div>
                        </form>
                        <div id="actionsButtons" class="row">
                            <button class="btn-primary" id="updateButton">Actualizar contraseña</button>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

    <script>
        document.querySelector('#password').addEventListener('focus', function () {
            // Mostrar el ícono del ojo cuando el campo de contraseña recibe foco
            document.querySelector('.toggle-password').style.display = 'block';
        });

        document.querySelector('#password').addEventListener('blur', function () {
            // Ocultar el ícono del ojo si el campo está vacío cuando se pierde el foco
            if (this.value === "") {
                document.querySelector('.toggle-password').style.display = 'none';
            }
        });

        document.querySelector('#password_confirmation').addEventListener('focus', function () {
            // Mostrar el ícono del ojo cuando el campo de contraseña recibe foco
            document.querySelector('.toggle-password-confirmation').style.display = 'block';
        });

        document.querySelector('#password_confirmation').addEventListener('blur', function () {
            // Ocultar el ícono del ojo si el campo está vacío cuando se pierde el foco
            if (this.value === "") {
                document.querySelector('.toggle-password-confirmation').style.display = 'none';
            }
        });

        // Para el campo de "password"
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordField = document.querySelector('#password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Cambiar el ícono entre "mostrar" y "ocultar" contraseña
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Para el campo de "password_confirmation"
        document.querySelector('.toggle-password-confirmation').addEventListener('click', function () {
            const passwordConfirmationField = document.querySelector('#password_confirmation');
            const typeConfirmation = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmationField.setAttribute('type', typeConfirmation);

            // Cambiar el ícono entre "mostrar" y "ocultar" contraseña
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

    <script type="module" src="{{asset("js/utils/alert.js")}}"></script>
    <script type="module" src="{{asset("js/utils/api.js")}}"></script>
    <script src="{{ asset('js/loadDepartments.js') }}"></script>
    <script src="{{ asset('js/loadCareers.js') }}"></script>
    <script type="module" src="{{ asset('js/register.js') }}"></script>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('CSS/administracion.css')}} ">
@stop
