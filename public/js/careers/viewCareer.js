import {apiRequest} from '../utils/api.js'
import {showAlert, showErrorAlert, showSuccessAlert} from '../utils/alert.js'

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

const career = document.getElementById('career');
const department = document.getElementById('department');
const actionsButtons = document.getElementById('actionsButtons');

/**
 * Obtiene el valor de un parámetro de la URL.
 * @param {string} name - El nombre del parámetro.
 * @returns {string|null} - El valor del parámetro o null si no se encuentra.
 */
function getQueryParam(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

/**
 * Maneja la edición de un usuario.
 * @param {number} id - El ID del usuario a editar.
 */
function handleEdit(id) {
    if (!career.value) {
        showErrorAlert('Error', 'Por favor, ingrese el nombre de la carrera');
        return;
    }

    if (!department.value) {
        showErrorAlert('Error', 'Por favor, seleccione un departamento');
        return;
    }

    const body = {
        career_name: career.value,
        department_id: department.value
    }

    apiRequest(`/api/careers/editar/${id}`, 'PUT', body, headers)
        .then(response => {
            response.json().then(data => {
                console.log(data);

                if(!data.success){
                    if (data.message.includes('carrera no encontrada')){
                        showErrorAlert('Error', 'Ingrese el nombre de la carrera');
                        return;
                    }

                    if(data.message.includes('departamento')){
                        showErrorAlert('Error', 'Seleccione un departamento');
                        return;
                    }

                    else{
                        showErrorAlert('Error', data.message);
                        return;
                    }
                }

                showSuccessAlert('Operación completada', 'Carrera actualizada correctamente')
                    .then(() => {
                        window.location.href = '/dashboard/carreras';
                    });
            });
        })
        .catch(error => console.error(error));
}

/**
 * Maneja la eliminación de un usuario.
 * @param {number} id - El ID de la carrera a eliminar.
 */
function handleDelete(id) {
    showAlert(
        'warning',
        '¿Estás seguro?',
        '¡No podrás deshacer esta acción!',
        true,
        'Sí, eliminar',
        'Cancelar')
        .then(result => {
            if (result.isConfirmed) {
                apiRequest(`/api/careers/eliminar/${id}`, 'DELETE', null, headers)
                    .then(response => {
                        response.json().then(data => {
                            if (!data.success){
                                showErrorAlert('Error', 'No se puede eliminar la carrera, ya que tiene registros asociados');
                                return;
                            }

                            showSuccessAlert('Operación completada', 'Usuario eliminado correctamente')
                                .then(() => {
                                    window.location.href = '/dashboard/carreras';
                                });
                        })
                    }).catch(error => console.error(error));
            } else {
                showErrorAlert('Cancelado', 'Operación cancelada');
            }
        });
}

document.addEventListener('DOMContentLoaded', function (){
    let id = getQueryParam('id');
    if (!id) {
        let urlParts = window.location.pathname.split('/');
        id = urlParts[urlParts.length - 1];
    }

    apiRequest(`/api/careers/ver/${id}`, 'GET', null, headers)
        .then(response => {
            response.json().then(data => {

                if (!data || data.length === 0) {
                    showErrorAlert('Oops...', 'No se encontraron datos de la carrera.')
                        .then(() => {
                            window.location.href = '/dashboard/carreras';
                        });
                    return;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                career.value = data[0].career_name;

                department.value = data[0].department_id;

                actionsButtons.innerHTML = `
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <form id="editForm-${data[0].id}">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_id" id="id-${data[0].id}" value="${data[0].id}">
                            <button type="button" id="btnUpdate-${data[0].id}" class="btn btn-primary">Actualizar</button>
                        </form>
                        <form id="deleteForm-${data[0].id}" method="post">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_id" id="id-${data[0].id}" value="${data[0].id}">
                            <button type="button" id="btnDestroy-${data[0].id}" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                `;

                document.getElementById(`btnUpdate-${data[0].id}`).addEventListener('click', function () {
                    handleEdit(data[0].id);
                });

                document.getElementById(`btnDestroy-${data[0].id}`).addEventListener('click', function () {
                    handleDelete(data[0].id);
                });

            })
        }).catch(error => console.error("Error: " + error));
});
