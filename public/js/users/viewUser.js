import {showAlert, showSuccessAlert, showErrorAlert, showWarningAlert} from '../utils/alert.js'
import {apiRequest} from '../utils/api.js'

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

const remoteApiURL = 'http://localhost:3000/api';

/**
 * Maneja la edición de un usuario.
 * @param {number} id - El ID del usuario a editar.
 */
function handleEdit(id) {
    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const career = document.getElementById("career");
    const password = document.getElementById("password");
    const password_confirmation = document.getElementById("password_confirmation");

    if (!name.value) {
        showWarningAlert('error', 'Por favor, ingrese su nombre.');
        return;
    }

    if (!email.value) {
        showWarningAlert('error', 'Por favor, ingrese su correo electrónico.');
        return;
    }

    if (password.value !== "" || password_confirmation.value !== "") {
        if (password.value !== password_confirmation.value) {
            showWarningAlert('error', 'Las contraseñas no coinciden.');
            return;
        }

        if (password.value.length < 8) {
            showWarningAlert('error', 'La contraseña debe tener al menos 8 caracteres.');
            return;
        }

        if (password_confirmation.value.length < 8) {
            showWarningAlert('error', 'La confirmación de la contraseña debe tener al menos 8 caracteres.');
            return;
        }
    }

    const body = {
        name: name.value,
        email: email.value,
        career: career.options[career.selectedIndex].value,
        password: password.value,
        password_confirmation: password_confirmation.value
    }

    apiRequest(`/api/users/editar/${id}`, 'PUT', body, headers)
        .then(response => {
            response.json().then(data => {

                console.log(data);

                if (!data.success) {
                    if (data.error) {
                        if (data.error.career[0].includes("The career field is required")) {
                            showErrorAlert('Oops...', 'Por favor, selecciona la carrera').then(() => {
                                document.getElementById('career').focus();
                            });
                            return;
                        }
                    } else {
                        showErrorAlert('Oops...', data.message).then(() => {
                            document.getElementById('career').focus();
                        });
                        return;
                    }
                }

                showSuccessAlert(
                    '¡Perfil actualizado!',
                    'El perfil se ha actualizado correctamente.')
                    .then(() => {
                        window.location.href = data.redirectTo;
                    });
            })
        })
        .catch(error => {
            console.error(error);
        });
}

/**
 * Maneja la eliminación de un usuario.
 * @param {number} id - El ID del usuario a eliminar.
 * @param remote_user_id
 */
function handleDelete(id, remote_user_id) {
    showAlert(
        'warning',
        '¿Estás seguro?',
        '¡No podrás deshacer esta acción!',
        true,
        'Sí, eliminar',
        'Cancelar')
        .then(async result => {
            if (result.isConfirmed) {
                await changeStatus(remote_user_id).then(() => {
                    apiRequest(`/api/users/eliminar/${id}`, 'DELETE', null, headers)
                        .then(response => {
                            response.json().then(data => {
                                if (!data.success) {
                                    showErrorAlert('Error', data.message);
                                    return;
                                }

                                showSuccessAlert('Operación completada', data.message)
                                    .then((result) => {
                                        if (result.ok) {
                                            window.location.href = data.redirect_to;
                                        }
                                    });
                            })
                        }).catch(error => console.error(error));
                });
            } else {
                showErrorAlert('Cancelado', 'Operación cancelada');
            }
        });
}

/**
 * Obtiene el valor de un parámetro de la URL.
 * @param {string} name - El nombre del parámetro.
 * @returns {string|null} - El valor del parámetro o null si no se encuentra.
 */
function getQueryParam(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

document.addEventListener('DOMContentLoaded', function () {

    let id = getQueryParam('id');
    if (!id) {
        let urlParts = window.location.pathname.split('/');
        id = urlParts[urlParts.length - 1];
    }

    apiRequest(`/api/users/ver/${id}`, 'GET', null, headers)
        .then(response => response.json())
        .then(data => {
            if (!data || !data.success || data.user.length === 0) {
                showErrorAlert('Oops...', 'No se encontraron datos del usuario.')
                    .then(() => {
                        window.location.href = '/dashboard/';
                    });
                return;
            }

            let user = data.user[0];

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const department_name = document.getElementById('department');
            const career = document.getElementById('career');

            name.value = user.name;
            email.value = user.email;
            department_name.value = user.department_id;
            career.innerHTML = '';

            let option = document.createElement('option');
            option.value = '';
            option.text = 'Seleccione una carrera';
            career.appendChild(option);

            apiRequest(`/api/careers/${user.department_id}`, 'GET', null, headers)
                .then(response => response.json())
                .then(data => {
                    data.forEach(d => {
                        let option = document.createElement('option');
                        option.value = d.id;
                        option.text = d.career_name;
                        career.appendChild(option);
                    });
                    career.value = user.career_id;
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

            const actionsButtons = document.getElementById('actionsButtons');
            actionsButtons.classList.add('row');

            actionsButtons.innerHTML = `
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <form id="editForm-${user.id}">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_id" id="id-${user.id}" value="${user.id}">
                            <button type="button" id="btnUpdate-${user.id}" class="btn btn-primary">Actualizar</button>
                        </form>
                        <form id="deleteForm-${user.id}" method="post">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_id" id="id-${user.id}" value="${user.id}">
                            <button type="button" id="btnDestroy-${user.id}" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                `;

            document.getElementById(`btnUpdate-${user.id}`).addEventListener('click', function () {
                handleEdit(user.id);
            });

            document.getElementById(`btnDestroy-${user.id}`).addEventListener('click', function () {
                handleDelete(user.id, user.remote_user_id);
            });

        })
        .catch(error => {
            console.error(error);
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

            window.location.href = '/dashboard/usuarios';

        }))
        .catch(error => {
            console.error(error);
        });

    localStorage.removeItem('user_id');
}
