@extends('administration.dashboard')

{{--Section para poder trabajar con layout --}}

@section('content')

    <style>
        .pagination-container {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px; /* Aumenté el padding para hacer más evidente */
            max-width: 300px; /* Ajusta el ancho máximo según necesites */
            margin: 8px auto; /* Esto centrará el contenedor */
        }

        .btn-arrow {
            background-color: transparent;
            border: none;
            font-size: 18px;
            color: #ff4a4a;
            padding: 5px 10px;
            cursor: pointer;
        }

        .btn-arrow:disabled {
            color: #ccc;
            cursor: not-allowed;
        }

        .page-number {
            font-size: 18px;
            margin: 0 15px;
            font-weight: bold;
        }

        .custom-gap {
            display: flex;
            justify-content: start; /* Alinea los botones a la izquierda */
            gap: 15px; /* Espaciado entre los botones */
        }

        .custom-gap a {
            /* Asegúrate de que no haya margen adicional en los botones */
            margin: 0;
        }

        .btn {
            border: none; /* Elimina el borde del botón */
            text-decoration: none; /* Elimina el subrayado del texto */
            display: inline-flex; /* Asegura que el contenido se alinee correctamente */
            align-items: center; /* Centra verticalmente el contenido */
        }

        .btn i {
            margin-right: 5px; /* Ajusta el espacio entre el ícono y el texto */
            font-size: 15px; /* Ajusta el tamaño del ícono si es necesario */
        }

        /* Opcional: Estilo para la clase tooltip-text si es necesario */
        .tooltip-text {
            font-size: 13px;
            margin-left: 5px; /* Ajusta el espaciado del texto en el botón */
        }

    </style>

    <link rel="stylesheet" href="{{ asset('CSS/administracion/Inventario.css')}}">
    <link rel="stylesheet" href="{{ asset('CSS/administracion/tables.css')}}">

    <div class="container-xl custom-flex" style="margin-bottom: 20px;">
        <div class="d-flex justify-content-start custom-gap" style="margin-top: 15px;">
            <a href="{{ route('departamentos-agregar') }}" class="btn btn-success" style="height: 40px;">
                <i class="fa fa-building"></i>
                <span class="tooltip-text">Agregar Departamento</span>
            </a>
            <a href="{{ route('carreras-agregar') }}" class="btn btn-success" style="height: 40px;">
                <i class="fa fa-graduation-cap"></i>
                <span class="tooltip-text">Agregar Carrera</span>
            </a>
            <form action="" id="searchForm" style="margin-left: auto;">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
                    <button type="submit" class="btn btn-success">Buscar</button>
                </div>
            </form>
        </div>
    </div>

    <!--Titulo de la vista -->
    <div class="container-fluid" style="margin-top: 5px;">
        <div class="title">
            <h2 style="color: black;">Registro de Carreras</h2>
        </div>
    </div>
    <!-- Contenido de la vista -->
    <div class="contentInventario">
        <form method="get" id="form_carreras">
            @csrf
            <div class="opcionesInventario">

                <div class="card-body">
                    <div class="table-responsive" style="height: 100%; width: 100%;">
                        <table class="table table-bordered text-center" id="careersTable"
                               style="width: 100%; margin-bottom: 0;">
                            <thead class="table-avatar">
                            <tr>
                                <th scope="col">Carrera</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">Acciones</th>
                            </tr>
                            </thead>
                            <tbody id=""></tbody>
                        </table>
                    </div>

                    <!-- Contenedor para los botones de paginación -->
                    <div id="pagination" class="pagination-container">
                        <button id="prevPage" class="btn-arrow" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <span id="currentPage" class="page-number">1</span>
                        <button id="nextPage" class="btn-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                </div>

            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const careersTable = document.getElementById('careersTable'); // Corrected ID

            searchForm.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent form submission
            });

            searchInput.addEventListener('input', function () {
                const searchTerm = searchInput.value.trim().toLowerCase();

                // Filter table rows based on search term
                Array.from(careersTable.getElementsByTagName('tr')).forEach(function (row, index) {
                    if (index === 0) return; // Skip header row

                    const cells = row.getElementsByTagName('td');
                    let rowMatchesSearch = false;

                    Array.from(cells).forEach(function (cell) {
                        const cellText = cell.textContent.toLowerCase();

                        if (cellText.includes(searchTerm)) {
                            rowMatchesSearch = true;
                        }
                    });

                    row.style.display = rowMatchesSearch ? '' : 'none';
                });
            });
        });
    </script>

    <script type="module" src="{{asset("js/utils/alert.js")}}"></script>
    <script type="module" src="{{asset("js/utils/api.js")}}"></script>
    <script type="module" src="{{asset("js/careers/careers.js")}}"></script>
@endsection
