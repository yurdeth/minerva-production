@extends('administration.dashboard')

{{--Section para poder trabajar con layout --}}

@section('content')

    <link rel="stylesheet" href="{{ asset('CSS/administracion/Inventario.css')}}">
    <link rel="stylesheet" href="{{ asset('CSS/administracion/tables.css')}}">

    <!--Titulo de la vista -->
    <div class="container-fluid" style="margin-top: 5px;">
        <div class="title">
            <h2 style="color: black;">Agregar una Carrera</h2>
        </div>
    </div>
    <!-- Contenido de la vista -->
    <div class="contentInventario">
        <form method="get" id="form_carreras">
            @csrf
            <div class="opcionesInventario">

                <div class="col">
                    <p>Seleccione el departamento</p>
                    <select class="form-select status" id="department" name="department_name">
                        <option value="" selected disabled>Seleccionar departamento</option>
                    </select>
                </div>

                <div class="col">
                    <p>Nombre de la carrera</p>
                    <input type="text" name="career_name" class="form-control" id="career_name"
                           placeholder="Ingrese tipo de carrera" style="width: 400px; padding: 10px;" required>
                </div>

                <div class="buttonContainer">
                    <input type="button" value="Registrar Carrera" class="btn-success" id="submitButton">
                </div>

            </div>
        </form>
    </div>

    <script type="module" src="{{ asset('js/loadDepartments.js') }}"></script>
    <script type="module" src="{{asset("js/utils/alert.js")}}"></script>
    <script type="module" src="{{asset("js/utils/api.js")}}"></script>
    <script type="module" src="{{asset("js/careers/addNewCareer.js")}}"></script>
@endsection
