import {showAlert, showErrorAlert, showSuccessAlert} from '../utils/alert.js';
import {apiRequest} from '../utils/api.js';

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

const remoteApiURL = 'http://localhost:3000/api';

/**
 * Muestra un mensaje de confirmación para eliminar un usuario.
 *
 * @param {number} id - El ID del usuario a eliminar.
 */
function confirmDelete(id, remote_user_id) {
    showAlert(
        'warning',
        '¿Estás seguro?',
        "¡No podrás revertir esto!",
        true,
        'Sí, eliminar',
        'Cancelar'
    ).then((result) => {
        if (result.isConfirmed) {
            apiRequest(`/api/users/eliminar/${id}`, 'DELETE', null, headers)
                .then(response => {
                    response.json().then(() => {
                        showSuccessAlert('Operación completada', 'El usuario se ha eliminado del sistema')
                            .then(async () => {
                                await changeStatus(remote_user_id);
                            });
                    });
                }).catch(error => console.error(error));
        } else {
            showErrorAlert('Cancelado', 'Operación cancelada');
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    let currentPage = 1;
    const rowsPerPage = 6; // Puedes ajustar cuántos usuarios mostrar por página
    let usersData = [];

    const prevPageButton = document.getElementById('prevPage');
    const nextPageButton = document.getElementById('nextPage');
    const currentPageSpan = document.getElementById('currentPage');

    /**
     * Función para mostrar la tabla de usuarios de acuerdo a la página actual.
     */
    function displayTable(page) {
        const table = document.getElementById('usersTable').getElementsByTagName('tbody')[0];
        table.innerHTML = ''; // Limpiar la tabla antes de añadir nuevos datos

        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedItems = usersData.slice(start, end);

        paginatedItems.forEach(item => {
            const row = table.insertRow(-1);

            const code = row.insertCell(0);
            const name = row.insertCell(1);
            const email = row.insertCell(2);
            const department_name = row.insertCell(3);
            const career_name = row.insertCell(4);
            const actions = row.insertCell(5);

            code.innerHTML = item.id;
            name.innerHTML = item.name;
            email.innerHTML = item.email;
            department_name.innerHTML = item.department_name;
            career_name.innerHTML = item.career_name;

            actions.innerHTML = `
                <a href="/usuarios/ver/${item.id}" class="btn btn-primary">Editar</a>
                <form id="deleteForm-${item.id}" method="post" style="display: inline;">
                    <input type="hidden" name="_token" value="${headers['X-CSRF-TOKEN']}">
                    <button type="button" id="btnDelete-${item.id}" class="btn btn-danger">Eliminar</button>
                </form>
            `;

            document.getElementById(`btnDelete-${item.id}`).addEventListener('click', function () {
                confirmDelete(item.id, item.remote_user_id);
            });
        });

        currentPageSpan.innerText = currentPage;
    }

    /**
     * Función para actualizar el estado de los botones de paginación.
     */
    function updatePaginationButtons() {
        const totalPages = Math.ceil(usersData.length / rowsPerPage);
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
        const totalPages = Math.ceil(usersData.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayTable(currentPage);
            updatePaginationButtons();
        }
    });

    // Obtener la lista de usuarios
    apiRequest('/api/users', 'GET', null, headers)
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                usersData = data;
                displayTable(currentPage);
                updatePaginationButtons();
            } else {
                console.error("Error: Data is not an array");
            }
        })
        .catch(error => {
            console.error("Error: " + error);
        });
});

const changeStatus = async (remote_user_id) => {
    let response = await fetch(`/api/get-key`, {
        method: 'GET',
        headers: {
            ...headers,
            'randKey': document.getElementById('rand').value
        }
    });

    console.log(response);

    // Comprobar si la respuesta es exitosa
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }

    // Obtener el JSON de la respuesta
    let data = await response.json();

    apiRequest(`${remoteApiURL}/disableUser/${remote_user_id}`, 'PUT', null, {
        ...headers, 'x-api-key': data.xKey,
    })
        .then(response => response.json().then(data => {

            if (!data.success) {
                showErrorAlert('Error', data.message);
            }

            window.location.reload();

        }))
        .catch(error => {
            console.log(error);
        });
}
