import {apiRequest} from '../utils/api.js'
import {showAlert, showErrorAlert, showSuccessAlert} from '../utils/alert.js'

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

const department_name_input = document.getElementById('department_name');
const submitButton = document.getElementById('submitButton');

function confirmDelete(id) {
    showAlert(
        'warning',
        '¿Estás seguro?',
        "¡No podrás revertir esto!",
        true,
        'Sí, eliminar',
        'Cancelar')
        .then((result) => {
            if (result.isConfirmed) {
                apiRequest(`/api/departments/eliminar/${id}`, 'DELETE', null, headers)
                    .then(response => {
                        response.json().then(data => {
                            if (!data.success) {
                                showErrorAlert('Error', data.message);
                                return;
                            }

                            showSuccessAlert('Operación completada', 'El departamento se ha eliminado del sistema')
                                .then(() => {
                                    window.location.reload();
                                });
                        })
                    }).catch(error => console.error(error));
            } else {
                showErrorAlert('Cancelado', 'Operación cancelada');
            }
        });
}

document.addEventListener('DOMContentLoaded', function () {
    apiRequest('/api/departments', 'GET', null, headers)
        .then(response => {
            response.json().then(data => {
                data.forEach(item => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const departmentsTable = document.getElementById('departmentsTable');
                    const row = departmentsTable.insertRow(-1);

                    const name = row.insertCell(0);
                    const actions = row.insertCell(1);

                    name.innerHTML = item.department_name;
                    actions.innerHTML = `
                    <a href="/dashboard/departamentos/ver/${item.id}" class="btn btn-primary">Editar</a>
                    <form id="deleteForm-${item.id}" method="post" style="display: inline;">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_id" id="id-${item.id}" value="${item.id}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" id="btnDelete-${item.id}" class="btn btn-danger">Eliminar</button>
                    </form>
                `;
                    document.getElementById(`btnDelete-${item.id}`).addEventListener('click', function () {
                        confirmDelete(item.id);
                    });

                });
            });
        }).catch(error => console.error("Error: " + error));
})

function submitForm() {
    const department_name = department_name_input.value;

    if (department_name.trim() === '') {
        showErrorAlert('Error', 'El nombre del departamento es requerido');
        return;
    }

    const body = {
        department_name: department_name.trim()
    };

    apiRequest('/api/departments/nuevo', 'POST', body, headers)
        .then(response => {
            response.json().then(data => {

                console.log(data.error);

                if (!data.success) {
                    if (data.error) {
                        if (data.error.department_name[0].includes('has already been taken')) {
                            showErrorAlert('Error', 'El nombre del departamento ya ha sido registrado');
                            return;
                        }
                        showErrorAlert('Error', "Ha ocurrido un error al intentar crear el departamento");
                        return;
                    }

                    showErrorAlert('Error', data.message);
                    return;
                }

                showSuccessAlert('Operación completada', 'El departamento se ha creado correctamente')
                    .then(() => {
                        window.location.reload();
                    });
            })
        }).catch(error => console.error(error));
}

submitButton.addEventListener('click', function (event) {
    event.preventDefault();
    submitForm();
});

department_name_input.addEventListener('keydown', function (event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        submitForm();
    }
});
