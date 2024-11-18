import { apiRequest } from '../utils/api.js';
import { showAlert, showErrorAlert, showSuccessAlert } from '../utils/alert.js';

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

let currentPage = 1;
const rowsPerPage = 6; // Número de carreras por página
let careersData = [];

function confirmDelete(id) {
    showAlert(
        'warning',
        '¿Estás seguro?',
        "¡No podrás revertir esto!",
        true,
        'Sí, eliminar',
        'Cancelar'
    ).then((result) => {
        if (result.isConfirmed) {
            apiRequest(`/api/careers/eliminar/${id}`, 'DELETE', null, headers)
                .then(response => {
                    response.json().then(data => {
                        console.log(data);
                        if (!data.success) {
                            showErrorAlert('Error', data.message);
                        }

                        showSuccessAlert('Operación completada', 'La carrera se ha eliminado del sistema')
                            .then(() => {
                                window.location.reload();
                            });
                    });
                }).catch(error => console.error(error));
        } else {
            showErrorAlert('Cancelado', 'Operación cancelada');
        }
    });
}

// Función para mostrar la tabla de acuerdo a la página actual
function displayTable(page) {
    const table = document.getElementById('careersTable').getElementsByTagName('tbody')[0];
    table.innerHTML = ''; // Limpiar la tabla antes de añadir nuevos datos

    // Calcular el índice de los elementos a mostrar en la página actual
    let start = (page - 1) * rowsPerPage;
    let end = start + rowsPerPage;
    let paginatedItems = careersData.slice(start, end);

    // Agregar las filas a la tabla
    paginatedItems.forEach((career) => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const row = table.insertRow(-1);

        const careerName = row.insertCell(0);
        const departmentName = row.insertCell(1);
        const actions = row.insertCell(2);

        careerName.innerHTML = career.career_name;
        departmentName.innerHTML = career.department_name;
        actions.innerHTML = `
            <a href="/dashboard/carreras/ver/${career.id}" class="btn btn-primary">Editar</a>
            <form id="deleteForm-${career.id}" method="post" style="display: inline;">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="_id" id="id-${career.id}" value="${career.id}">
                <input type="hidden" name="_method" value="DELETE">
                <button type="button" id="btnDelete-${career.id}" class="btn btn-danger">Eliminar</button>
            </form>
        `;

        document.getElementById(`btnDelete-${career.id}`).addEventListener('click', () => {
            confirmDelete(career.id);
        });
    });

    updatePaginationButtons(); // Actualizar el estado de los botones de paginación
}

function updatePaginationButtons() {
    const totalPages = Math.ceil(careersData.length / rowsPerPage);

    const prevPageButton = document.getElementById('prevPage');
    const nextPageButton = document.getElementById('nextPage');
    const currentPageSpan = document.getElementById('currentPage');

    prevPageButton.disabled = currentPage === 1;
    nextPageButton.disabled = currentPage === totalPages;

    currentPageSpan.innerText = currentPage;
}

document.addEventListener('DOMContentLoaded', function () {
    event.preventDefault();
    event.stopPropagation();

    // Llamada a la API para obtener las carreras
    apiRequest('/api/careers/', 'GET', null, headers)
        .then(response => {
            response.json().then(data => {
                careersData = data; // Guardar los datos de las carreras
                displayTable(currentPage); // Mostrar la primera página de la tabla
            });
        })
        .catch(error => console.error(error));

    // Manejar el botón de página anterior
    const prevPageButton = document.getElementById('prevPage');
    prevPageButton.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            displayTable(currentPage);
        }
    });

    // Manejar el botón de página siguiente
    const nextPageButton = document.getElementById('nextPage');
    nextPageButton.addEventListener('click', () => {
        const totalPages = Math.ceil(careersData.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayTable(currentPage);
        }
    });
});
