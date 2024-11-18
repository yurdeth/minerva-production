<!--Incluimos el header y footer del layout-->
@extends('layouts.layout')

{{--Section para poder trabajar con layout --}}
@section('content')

    <!-- <div class="row justify-content-center align-items-center" style="height: 100vh;"> -->
    <div class="container-sm"
         style="margin-top: 70px; margin-bottom: 70px; border: 2px solid #242525; border-radius: 4px; max-width: 950px;">

        <div class="row">

            <div class="col-6 d-flex align-items-center text-white p-5 text-center" id="contenedorImagen">
                <div class="mx-auto">
                    <h2>MINERVA VR <br>LAB</h2>
                    <img class="logo" src="{{ asset('IMG/Logo.png') }}" alt="Logo" style="width: 100px; height: 120px;">
                </div>
            </div>

            <div class="col-6 bg-white p-5 text-center">
                <h2>Crear una cuenta</h2>

                <form class="" method="post" action="{{ route("signup") }}">
                    @csrf

                    <div class="form-group position-relative p-2">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre"
                               style="padding-left: 30px;">
                        <i class="fas fa-user position-absolute"
                           style="top: 50%; transform: translateY(-50%); left: 10px; padding-left: 5px;"></i>
                    </div>

                    <div class="form-group position-relative p-2">
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="Correo electrónico" style="padding-left: 30px;">
                        <i class="fas fa-envelope position-absolute"
                           style="top: 50%; transform: translateY(-50%); left: 10px; padding-left: 5px;"></i>
                    </div>

                    <div class="form-group position-relative p-2">
                        <select name="department" id="department" class="form-control">
                            <option value="" selected disabled>Seleccione un departamento</option>
                        </select>
                    </div>

                    <div class="form-group position-relative p-2">
                        <select name="career" id="career" class="form-control">
                            <option value="" selected disabled>Seleccione una carrera</option>
                        </select>
                    </div>

                    <div class="form-group position-relative p-2">
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Contraseña" style="padding-left: 30px;">
                        <i class="fas fa-key position-absolute"
                           style="top: 50%; transform: translateY(-50%); left: 10px; padding-left: 5px;"></i>
                    </div>

                    <div class="form-group position-relative p-2">
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation"
                               placeholder="Repita su contraseña" style="padding-left: 30px;">
                        <i class="fas fa-key position-absolute"
                           style="top: 50%; transform: translateY(-50%); left: 10px; padding-left: 5px;"></i>
                    </div>

                    <button type="submit" class="btn text-white m-2 form-control" id="submitButton"
                            style="background-color: #242525;">
                        Registrarse
                    </button>

                    <p class="mt-3"><strong>¿Ya tienes una cuenta?</strong> <a href="{{ route('iniciarSesion') }}"
                                                                           style="text-decoration: none; color: #660D04;">
                            <strong>Iniciar sesión</strong> </a></p>
                </form>

            </div>

        </div>

    </div>

    <script type="module" src="{{ asset('js/loadDepartments.js') }}"></script>
    <script type="module" src="{{ asset('js/loadCareers.js') }}"></script>
    <script type="module" src="{{ asset('js/register.js') }}"></script>
    <script type="module" src="{{asset("js/utils/alert.js")}}"></script>
    <script type="module" src="{{asset("js/utils/api.js")}}"></script>

@endsection
