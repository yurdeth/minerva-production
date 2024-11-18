@extends('administration.dashboard')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Control de Usuarios</h1>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/administracion/tables.css')}}">
    <div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row align-items-center"> <!-- Ensure vertical alignment -->
                            <div class="col-6 col-md-8 text-center"> <!-- Adjust the size as needed -->
                                <br>
                                <h2>Todos los Usuarios</h2>
                                <br>
                            </div>
                            <input type="hidden" value="{{ $randKey }}" id="rand">
                            <div class="col-6 col-md-4">
                                <form action="" id="searchForm">
                                    <div class="input-group">
                                        <input type="text" id="searchInput" class="form-control"
                                               placeholder="Buscar...">
                                        <button type="submit" class="btn btn-success">Buscar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="height: 100%; width: 100%;">
                            <table class="table table-bordered text-center" id="usersTable"
                                   style="width: 100%; margin-bottom: 0;">
                                <thead class="table-avatar">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Departamento</th>
                                    <th scope="col">Carrera</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                                </thead>
                                <tbody id="users-table-body"></tbody>
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
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const usersTable = document.getElementById('usersTable'); // Corrected ID

            searchForm.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent form submission
            });

            searchInput.addEventListener('input', function () {
                const searchTerm = searchInput.value.trim().toLowerCase();

                // Filter table rows based on search term
                Array.from(usersTable.getElementsByTagName('tr')).forEach(function (row, index) {
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
    <script type="module" src="{{ asset('js/users/users.js') }}"></script>
@stop

