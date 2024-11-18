@extends('administration.dashboard')

{{--Section para poder trabajar con layout --}}

@section('content')

    <link rel="stylesheet" href="{{ asset('CSS/administracion/inventario.css')}}">
    <link rel="stylesheet" href="{{ asset('CSS/administracion/tables.css')}}">

    <!--Titulo de la vista -->
    <div class="container-fluid" style="margin-top: 5px;">
        <div class="title">
            <h2 style="color: black;">Agregar un Departamento</h2>
        </div>
    </div>
    <!-- Contenido de la vista -->
    <div class="contentInventario">
        <form method="get" id="form_carreras">
            @csrf
            <div class="opcionesInventario">
                <div class="col">
                    <p>Nombre del nuevo departamento</p>
                    <input type="text" name="department_name" class="form-control" id="department_name"
                           placeholder="Ingrese el nombre del departamento"
                           style="width: 400px; padding: 10px;">
                </div>
                <br>

                <div class="buttonContainer">
                    <input type="button" value="Registrar Departamento" class="btn-success" id="submitButton">
                </div><br>

                <div class="card-body">
                    <div class="table-responsive" style="height: 100%; width: 100%;">
                        <table class="table table-bordered text-center" id="departmentsTable"
                               style="width: 100%; margin-bottom: 0;">
                            <thead class="table-avatar">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Acciones</th>
                            </tr>
                            </thead>
                            <tbody id=""></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script type="module" src="{{asset("js/utils/alert.js")}}"></script>
    <script type="module" src="{{asset("js/utils/api.js")}}"></script>
    <script type="module" src="{{asset("js/departments/departments.js")}}"></script>
@endsection
