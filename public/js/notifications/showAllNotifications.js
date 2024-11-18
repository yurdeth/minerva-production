import {apiRequest} from "../utils/api.js";
import {showAlert, showErrorAlert, showSuccessAlert} from "../utils/alert.js";

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

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
            apiRequest(`/api/notifications/eliminar/${id}`, 'DELETE', null, headers)
                .then(response => response.json().then(data => {
                    if (!data.success) {
                        showErrorAlert('Error', data.message);
                    }
                    showSuccessAlert('Operación completada', data.message)
                        .then(() => {
                            window.location.reload();
                        });
                }))
                .catch(error => console.error(error));
        } else {
            showErrorAlert('Cancelado', 'Operación cancelada');
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('notificationsTable').getElementsByTagName('tbody')[0];
    table.innerHTML = '';
    let i = 0;

    apiRequest('/api/notifications', 'GET', null, headers)
        .then(response => response.json().then(data => {
            const notificationsTable = document.getElementById('notificationsTable');

            const tbody = document.createElement('tbody');
            data.notifications.forEach(item => {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const row = table.insertRow(-1);

                const index = row.insertCell(0);
                const from = row.insertCell(1);
                const type = row.insertCell(2);
                const description = row.insertCell(3);
                const reviewed = row.insertCell(4);
                const actions = row.insertCell(5);

                index.innerHTML = i + 1;
                from.innerHTML = item.from;
                type.innerHTML = item.type;
                if (item.description === null) {
                    description.innerHTML = '-';
                } else {
                    description.innerHTML = item.description;
                }

                if (item.reviewed){
                    reviewed.innerHTML = "Revisada";
                } else{
                    reviewed.innerHTML = "Pendiente";
                }

                actions.innerHTML = `
                    <a class="btn btn-primary" href="/dashboard/notificaciones/ver/${item.id}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form id="deleteForm-${item.id}" method="post" style="display: inline;">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_id" id="id-${item.id}" value="${item.id}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" id="btnDelete-${item.id}" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </form>
                `;

                document.getElementById(`btnDelete-${item.id}`).addEventListener('click', () => {
                    confirmDelete(item.id);
                });
                i += 1;
            });

            notificationsTable.appendChild(tbody);
        }))
        .catch(error => console.error('Error al obtener las notificaciones:', error));
});
