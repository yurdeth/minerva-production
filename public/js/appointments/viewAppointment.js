import {showAlert, showSuccessAlert, showErrorAlert, showWarningAlert} from '../utils/alert.js'
import {apiRequest} from '../utils/api.js'

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

const min_limit = 1;
const max_limit = 72;

/**
 * Maneja la edición de una cita.
 * @param {number} id - El ID de la cita a editar.
 */
function handleEdit(id) {
    const date = document.getElementById("date");
    const startTime = document.getElementById("start-time");
    const endTime = document.getElementById("end-time");
    const number_of_assistants = document.getElementById("number_of_assistants");

    const numAssistants = parseInt(number_of_assistants.value, 10);
    const selectedDate = new Date(date.value);
    const today = new Date();

    today.setHours(0, 0, 0, 0);

    if (number_of_assistants < min_limit) {
        showErrorAlert('Oops...', `El número de asistentes no puede ser menor a ${min_limit}.`);
        return;
    }

    if (number_of_assistants > max_limit) {
        showErrorAlert('Oops...', `El número de asistentes no puede ser mayor a ${max_limit}.`);
        return;
    }

    // Establecer la hora de hoy a las 00:00:00 para comparar solo las fechas
    today.setHours(0, 0, 0, 0);

    if (selectedDate <= today) {
        showErrorAlert('Oops...', 'La fecha debe ser posterior a hoy.');
        return;
    }

    if (startTime.value.slice(0, 5) < '08:00' || endTime.value.slice(0, 5) > '17:00') {
        showErrorAlert('Oops...', 'Solo puedes agendar citas entre las 8:00 AM y las 5:00 PM');
        return;
    }

    const body = {
        date: date.value,
        start_time: startTime.value,
        end_time: endTime.value,
        number_of_assistants: number_of_assistants.value
    };

    apiRequest(`/api/appointments/editar/${id}`, 'PUT', body, headers)
        .then(response => {
            response.json().then(data => {
                if (!data.success) {
                    if (data.error) {
                        if (data.error.time) {
                            showErrorAlert('Oops...',
                                data.error.time[0]);
                            return;
                        }

                        if (data.error.date && data.error.date[0].includes("after today")) {
                            showErrorAlert('Oops...',
                                'La cita debe ser una fecha posterior a hoy');
                            return;
                        }

                        if (data.error.number_of_assistants) {
                            showErrorAlert('Oops...',
                                data.error.number_of_assistants[0]);
                            return;
                        }

                        if (data.error.end_time) {
                            showErrorAlert('Oops...',
                                data.error.end_time[0]);
                            return;
                        }
                    } else {
                        showErrorAlert('Oops...',
                            'Ha ocurrido un error al intentar registrar la cita.');
                        return;
                    }
                }

                showSuccessAlert('Éxito', '¡Cita actualizada exitosamente!')
                    .then(() => {
                        window.location.href = data.redirect_to;
                    });
            });
        })
        .catch(error => {
            console.error(error);
        });
}

/**
 * Maneja la eliminación de una cita.
 * @param {number} id - El ID de la cita a eliminar.
 */
function handleDelete(id) {
    showAlert(
        'warning',
        '¡Cuidado!',
        '¿Estás seguro de que deseas eliminar esta cita?',
        true,
        'Sí, eliminar',
        'Cancelar')
        .then(result => {
            if (result.isConfirmed) {
                apiRequest(`/api/appointments/eliminar/${id}`, 'DELETE', null, headers)
                    .then(response => {
                        response.json().then(data => {
                            showSuccessAlert('Eliminando...', 'Cita eliminada correctamente.')
                                .then(() => {
                                    window.location.href = '/citas';
                                });
                        });
                    }).catch(error => console.error(error));
            } else {
                showErrorAlert('Cancelado', 'Operación cancelada');
            }
        });
}

document.addEventListener('DOMContentLoaded', function () {
    const urlParts = window.location.pathname.split('/');
    const id = urlParts[urlParts.length - 1];

    if (id) {
        apiRequest(`/api/appointments/ver/${id}`, 'GET', null, headers)
            .then(response => response.json())
            .then(data => {

                if (!data || data.message && data.message.includes('Route [citas] not defined')) {
                    showErrorAlert('Oops...', 'No se encontraron datos de la cita.')
                        .then(() => {
                            window.location.href = '/citas';
                        });
                    return;
                }

                if (Array.isArray(data)) {
                    data.forEach(item => {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        const name = document.getElementById('name');
                        const date = document.getElementById('date');
                        const startTime = document.getElementById('start-time');
                        const endTime = document.getElementById('end-time');
                        const number_of_assistants = document.getElementById('number_of_assistants');

                        if (name) name.value = item.name;
                        date.value = item.date;
                        startTime.value = item.start_time;
                        endTime.value = item.end_time;
                        number_of_assistants.value = item.number_of_assistants;

                        const actionsButtons = document.getElementById('actionsButtons');
                        actionsButtons.classList.add('row');

                        actionsButtons.innerHTML = `
                            <div class="d-flex justify-content-center gap-3 mt-3">

                                <form id="editForm-${item.id}">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_id" id="id-${item.id}" value="${item.id}">
                                    <button type="button" id="btnUpdate-${item.id}" class="btn btn-primary">Actualizar</button>
                                </form>

                                <form id="deleteForm-${item.id}" method="post">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_id" id="id-${item.id}" value="${item.id}">
                                    <button type="button" id="btnDestroy-${item.id}" class="btn btn-danger">Eliminar</button>
                                </form>

                            <div>
                        `;

                        document.getElementById(`btnUpdate-${item.id}`).addEventListener('click', function () {
                            handleEdit(item.id);
                        });

                        document.getElementById(`btnDestroy-${item.id}`).addEventListener('click', function () {
                            handleDelete(item.id);
                        });
                    });
                }
            })
            .catch(error => {
                console.error(error);
            });
    }
});
