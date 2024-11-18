import {apiRequest} from "../utils/api.js";
import {showErrorAlert, showSuccessAlert} from "../utils/alert.js";

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

document.addEventListener("DOMContentLoaded", event => {
    let currentPage = 1;
    const rowsPerPage = 6;
    let inventoryData = [];

    const prevPageButton = document.getElementById('prevPage');
    const nextPageButton = document.getElementById('nextPage');
    const currentPageSpan = document.getElementById('currentPage');

    apiRequest('/api/resources', 'GET', null, headers)
        .then(response => response.json())
        .then(data => {
            console.log("Response: ", data);

            if (data.total === 0) {
                return;
            }

            inventoryData = data.resources;

            displayTable(currentPage);
            updatePaginationButtons();
        }).catch(error => {
        console.error("Error fetching resources: ", error);
    });

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
                apiRequest(`/api/resources/eliminar/${id}`, 'DELETE', null, headers)
                    .then(response => {
                        response.json().then(data => {
                            if(data.success){
                                showSuccessAlert('Operación completada', 'Recurso eliminado correctamente')
                                    .then(() => {
                                        window.location.href = '/dashboard/inventario';
                                    });
                            } else{
                                showErrorAlert('Error', 'No se pudo eliminar el recurso');
                            }
                        })
                    }).catch(error => console.error(error));
            } else {
                showErrorAlert('Cancelado', 'El recurso no ha sido eliminado.');
            }
        });
    }

    // Función para mostrar la tabla de acuerdo a la página actual
    function displayTable(page) {
        let table = document.getElementById("inventoryTable").getElementsByTagName('tbody')[0];
        table.innerHTML = ''; // Limpiar la tabla antes de añadir nuevos datos

        // Calcular el índice de los elementos a mostrar en la página actual
        let start = (page - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        let paginatedItems = inventoryData.slice(start, end);

        // Agregar las filas a la tabla
        paginatedItems.forEach((resource, index) => {
            let row = table.insertRow();
            let cell1 = row.insertCell(0);
            let cell2 = row.insertCell(1);
            let cell3 = row.insertCell(2);
            let cell4 = row.insertCell(3);
            let cell5 = row.insertCell(4);
            let cell6 = row.insertCell(5);

            cell1.innerHTML = start + index + 1; // Mostrar el número de fila correcto
            cell2.innerHTML = resource.room.name;
            cell3.innerHTML = resource.resource_type.resource_name;
            cell4.innerHTML = resource.status.status;
            cell5.innerHTML = resource.fixed_asset_code;

            // Agregar botones de acciones
            cell6.innerHTML = `
                <a href="/dashboard/inventario/ver/${resource.id}" class="btn btn-primary">Editar</a>
                <form id="deleteForm-${resource.id}" method="post" style="display: inline;">
                    <input type="hidden" name="_token" value="${headers['X-CSRF-TOKEN']}">
                    <input type="hidden" name="_id" id="id-${resource.id}" value="${resource.id}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" id="btnDelete-${resource.id}" class="btn btn-danger">Eliminar</button>
                </form>
            `;

            // Agregar evento para el botón de eliminar
            document.getElementById(`btnDelete-${resource.id}`).addEventListener('click', function () {
                confirmDelete(resource.id);
            });
        });

        // Actualizar el número de página mostrado
        currentPageSpan.innerText = currentPage;
    }

    // Actualizar el estado de los botones de paginación
    function updatePaginationButtons() {
        const totalPages = Math.ceil(inventoryData.length / rowsPerPage);

        // Habilitar o deshabilitar los botones de acuerdo a la página actual
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
        const totalPages = Math.ceil(inventoryData.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayTable(currentPage);
            updatePaginationButtons();
        }
    });
});
