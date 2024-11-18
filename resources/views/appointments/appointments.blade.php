<?php
if (!isset($dashboard)) {
    $layout = 'layouts.layout';
} else {
    $layout = 'administration.dashboard';
}
?>

@extends($layout)

@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/General/citas.css')}}">
<section>

    <!-- Contenedor principal -->
    <div class="container-xl">
        <div class="container-sm">
            <!-- Contenedor de opciones -->
             <div class="opcionesCitas">
                <div class="container-sm">
                    <div class="row">
                        <div class="col-auto">
                            <a href="{{ route("agendar") }}" class="btn-success" title="Agendar cita">
                                <i class="fa fa-address-book"></i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route("export") }}" class="btn-info" title="Generar reporte en Excel">
                                <i class="fa fa-file-excel"></i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route("pdf") }}" class="btn-danger" title="Generar reporte en PDF">
                                <i class="fa fa-file-pdf"></i>
                             </a>
                        </div>
                    </div>
                    <!-- Parte de la busqueda -->
                </div>
                <div>
                    <form action="action=" id="searchForm">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder=" Buscar...">
                            <button type="submit" class="btn-info">Buscar</button>
                        </div>
                    </form>
                </div>
             </div>
        </div>



        <div class="card-header mb-3">
            <h2 class="titleCitas">Todas tus Citas</h2>
        </div>

        <div class="card-body">
            <div class="table-responsive" style="height: 100%; width: 100%;">
                <table id="appointmentsTable" class="table table-bordered text-center"
                       style="width: 100%; margin-bottom: 0;">
                    <thead class="table-avatar">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Encargado</th>
                        <th scope="col">Carrera</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora de inicio</th>
                        <th scope="col">Hora de finalización</th>
                        <th scope="col">Participantes</th>
                        <th scope="col">Acciones</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const appointmentsTable = document.getElementById('appointmentsTable'); // Corrected ID

            searchForm.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent form submission
            });

            searchInput.addEventListener('input', function () {
                const searchTerm = searchInput.value.trim().toLowerCase();

                // Filter table rows based on search term
                Array.from(appointmentsTable.getElementsByTagName('tr')).forEach(function (row, index) {
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
    <script type="module" src="{{ asset('js/appointments/appointments.js') }}"></script>

    <br><br>
</section>
<br><br>
@endsection
