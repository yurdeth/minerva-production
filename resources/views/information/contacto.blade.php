<!--Incluimos el header y footer del layout-->
@extends('layouts.layout')

{{--Section para poder trabajar con layout --}}
@section('content')
    <br>
    <div class="container-sm mt-5 mb-5 " style="max-width: 650px; height: auto;">
        <div class="row">
            <div class="col-12 bg-white p-5 text-center" style="border-radius: 10px;">
                <br>
                <h2>Contáctanos a través de nuestro correo:</h2>
                <h3 class="emailInfo">minervarvlab.fmo@ues.edu.sv</h3><br>
                <p>
                    También puedes contactarnos a través del siguiente formulario.
                    Estamos abiertos a cualquier sugerencia o consulta que desees compartir con nosotros.
                </p><br>

                <form class="" method="post" action="{{ route("enviar-solicitud") }}">
                    @csrf

                    <div class="form-group position-relative p-2">
                        <input type="email" class="form-control" id="email" name="from"
                               placeholder="Ingresa tu correo electrónico" style="padding-left: 30px;" required>
                        <i class="fas fa-envelope position-absolute"
                           style="top: 50%; transform: translateY(-50%); left: 10px; padding-left: 5px;"></i>
                    </div>

                    <div class="form-group position-relative p-2">
                        <i class="fas fa-pencil-alt position-absolute" style="top: 50%; transform: translateY(-50%); left: 10px; padding-left: 5px;"></i>
                        <select class="form-select" id="tipo" name="type_id" style="padding-left: 30px;" required>
                            <option value="" selected disabled>Selecciona una opción</option>
                            <option value="1">Recuperación de contraseña</option>
                            <option value="2">Solicitar contraseña inicial</option>
                            <option value="3">Otro</option>
                        </select>
                    </div>

                    <div id="other-option" class="form-group position-relative p-2"></div>

                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-success text-white m-2 form-control" id="submitButton">
                            Enviar
                        </button>

                        <button type="button" class="btn btn-danger text-white m-2 form-control" id="cancelButton">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <br>
    </div>

    <style>
        .emailInfo {
            color: black;
            transition: color 0.3s ease;
        }

        .emailInfo:hover {
            color: blue;
        }

        p{
            text-align:justify ;
        }

        .col-12{
        border: 1px solid rgb(139, 139, 139);
        box-shadow: 0 4px 8px rgba(117, 124, 133, 0.5) , 0 6px 20px rgba(117, 124, 133, 0.5);
    }
    </style>

    <br><br>

    <script type="module" src="{{ asset('js/contactAdmin.js') }}"></script>
    <script type="module" src="{{asset("js/utils/alert.js")}}"></script>
    <script type="module" src="{{asset("js/utils/api.js")}}"></script>

    <br><br>
@endsection
