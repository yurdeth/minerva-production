@extends('administration.dashboard')
@section('title', 'Inventario')

@section('content_header')
    <h1>Notificaciones</h1>
@stop

@section('content')

    <link rel="stylesheet" href="{{ asset('CSS/administracion/tables.css')}}">
    <link rel="stylesheet" href="{{ asset('CSS/administracion/responsiveInventory.css')}}">
    <link rel="stylesheet" href="{{ asset('CSS/administracion/notificaciones.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <div class="button-container">
        <form  action="" id="searchForm" style="margin-left: auto;">
            <div class="input-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>
    </div>

    <div class="card-body">
        <div class="table-responsive" style="height: 100%; width: 100%;">
            <table class="table table-bordered text-center" id="notificationsTable"
                   style="width: 100%; margin-bottom: 0;">
                <thead class="table-avatar">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Correo del solicitante</th>
                    <th scope="col">Tipo de solicitud</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Estado</th>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const notificationsTable = document.getElementById('notificationsTable');

            searchForm.addEventListener('submit', function (event) {
                event.preventDefault();
            });

            searchInput.addEventListener('input', function () {
                const searchTerm = searchInput.value.trim().toLowerCase();

                // Filter table rows based on search term
                Array.from(notificationsTable.getElementsByTagName('tr')).forEach(function (row, index) {
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

    <script src="{{ asset('js/notifications/showAllNotifications.js') }}" type="module"></script>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('CSS/administracion.css')}}">
@stop
