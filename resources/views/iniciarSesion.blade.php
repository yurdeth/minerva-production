<!--Incluimos el header y footer del layout-->
@extends('layouts.layout')

{{--Section para poder trabajar con layout --}}
@section('content')
    <br>
    <div class="container-sm mt-5 mb-5 border border-dark rounded" style="max-width: 950px; height: auto;">
        <div class="row">
            <div class="col-12 col-md-6 d-flex align-items-center text-white p-4 text-center" id="contenedorImagen">
                <div class="mx-auto" style="max-width: 90%;">
                    <img class="logoInicio img-fluid m-2" src="{{ asset('IMG/LogoLentes.png') }}" alt="Logo" id="logoInicio" style="max-width: 100%; height: auto;">
                    <h2 class="fs-4">FACULTAD MULTIDISCIPLINARIA ORIENTAL</h2>
                </div>
            </div>

            <div class="col-12 col-md-6 bg-white p-5 text-center">
                <br>
                <h2>Iniciar sesión</h2>
                <input type="hidden" value="{{ $randKey }}" id="rand">

                <form class="" method="post" action="{{ route("signin") }}">
                    @csrf
                    <div class="form-group position-relative p-2">
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="Correo electrónico" style="padding-left: 30px;">
                        <i class="fas fa-envelope position-absolute"
                           style="top: 50%; transform: translateY(-50%); left: 10px; padding-left: 5px;"></i>
                    </div>

{{--                    <div class="form-group position-relative p-2">--}}
{{--                        <input type="password" class="form-control" id="password" name="password"--}}
{{--                               placeholder="Contraseña" style="padding-left: 30px;">--}}
{{--                        <i class="fas fa-key position-absolute"--}}
{{--                           style="top: 50%; transform: translateY(-50%); left: 10px; padding-left: 5px;"></i>--}}
{{--                    </div>--}}

                    <div class="form-group position-relative p-2">
                        <span class="fas fa-key position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%);"></span>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Contraseña" style="padding-left: 30px; padding-right: 35px">
                        <!-- Ícono de ojo, inicialmente oculto -->
                        <span toggle="#password" class="fa fa-fw fa-eye toggle-password"
                              style="position: absolute; margin-left:10px; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; display: none;"></span>
                    </div>

                    <button type="submit" class="btn text-white m-2 form-control" id="submitButton">
                        Ingresar
                    </button>

                    <p class="mt-3"><strong>¿No tienes cuenta?</strong>
                        <a href="{{ route("contactar-administrador") }}" style="text-decoration: none; color: #660D04;">
                            <strong>Contactar con un administrador</strong>
                        </a>
                    </p>
                </form>

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

        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordField = document.querySelector('#password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Cambiar el ícono entre "mostrar" y "ocultar" contraseña
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

    <script type="module" src="{{ asset('js/login.js') }}"></script>
    <script type="module" src="{{asset("js/utils/alert.js")}}"></script>
    <script type="module" src="{{asset("js/utils/api.js")}}"></script>

    <br><br>

@endsection
