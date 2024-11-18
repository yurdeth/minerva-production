import {showSuccessAlert, showErrorAlert} from '../utils/alert.js'
import {apiRequest} from '../utils/api.js'

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

document.addEventListener('DOMContentLoaded', function () {
    let currentPage = 1;
    const rowsPerPage = 6;
    let appointmentsData = [];

    const prevPageButton = document.getElementById('prevPage');
    const nextPageButton = document.getElementById('nextPage');
    const currentPageSpan = document.getElementById('currentPage');

    // Función para confirmar eliminación de citas
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                apiRequest(`/api/appointments/eliminar/${id}`, 'DELETE', null, headers)
                    .then(response => response.json())
                    .then(() => {
                        showSuccessAlert('Operación completada', 'La cita se ha eliminado correctamente')
                            .then(() => {
                                window.location.reload();
                            });
                    }).catch(error => console.error(error));
            } else {
                showErrorAlert('Cancelado', 'La cita no ha sido eliminada.');
            }
        });
    }

    // Función para mostrar la tabla de citas de acuerdo a la página actual
    function displayTable(page) {
        let table = document.getElementById("appointmentsTable").getElementsByTagName('tbody')[0];
        table.innerHTML = ''; // Limpiar la tabla antes de añadir nuevos datos

        let start = (page - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        let paginatedItems = appointmentsData.slice(start, end);

        paginatedItems.forEach(item => {
            const row = table.insertRow(-1);

            const code = row.insertCell(0);
            const name = row.insertCell(1);
            // const department = row.insertCell(2);
            const career = row.insertCell(2);
            const date = row.insertCell(3);
            const startTime = row.insertCell(4);
            const endTime = row.insertCell(5);
            const number_of_assistants = row.insertCell(6);
            const actions = row.insertCell(7);

            // Formatear fecha y hora
            const dateParts = item.date.split('-');
            const formatedDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
            const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            const monthName = months[formatedDate.getMonth()];
            const dateText = `${formatedDate.getDate()} de ${monthName} de ${formatedDate.getFullYear()}`;

            let timeParts = item.start_time.split(':');
            let hours = timeParts[0];
            let minutes = timeParts[1];
            let ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;
            let formatedStartTime = hours + ':' + minutes + ' ' + ampm;

            timeParts = item.end_time.split(':');
            hours = timeParts[0];
            minutes = timeParts[1];
            ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;
            let formatedEndTime = hours + ':' + minutes + ' ' + ampm;

            code.innerHTML = item.id;
            name.innerHTML = item.name;
            career.innerHTML = item.career_name;
            date.innerHTML = dateText;
            startTime.innerHTML = formatedStartTime;
            endTime.innerHTML = formatedEndTime;
            number_of_assistants.innerHTML = item.number_of_assistants;

            actions.innerHTML = `
                <a href="/citas/ver/${item.id}" class="btn btn-primary">Editar</a>
                <form id="deleteForm-${item.id}" method="post" style="display: inline;">
                    <input type="hidden" name="_token" value="${headers['X-CSRF-TOKEN']}">
                    <button type="button" id="btnDelete-${item.id}" class="btn btn-danger">Eliminar</button>
                </form>
            `;

            document.getElementById(`btnDelete-${item.id}`).addEventListener('click', function () {
                confirmDelete(item.id);
            });
        });

        currentPageSpan.innerText = currentPage;
    }

    // Función para actualizar el estado de los botones de paginación
    function updatePaginationButtons() {
        const totalPages = Math.ceil(appointmentsData.length / rowsPerPage);
        prevPageButton.disabled = currentPage === 1;
        nextPageButton.disabled = currentPage === totalPages;
    }

    // Manejar el botón de página anterior
    prevPageButton.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            displayTable(currentPage);
            updatePaginationButtons();
        }
    });

    // Manejar el botón de página siguiente
    nextPageButton.addEventListener('click', () => {
        const totalPages = Math.ceil(appointmentsData.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayTable(currentPage);
            updatePaginationButtons();
        }
    });

    // Solicitar las citas y almacenarlas para la paginación
    apiRequest('/api/appointments', 'GET', null, headers)
        .then(response => response.json())
        .then(data => {
            appointmentsData = data.data;
            displayTable(currentPage);
            updatePaginationButtons();
        })
        .catch(error => {
            console.error("Error: " + error);
        });
});
