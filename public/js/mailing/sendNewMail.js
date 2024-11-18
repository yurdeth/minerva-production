import {apiRequest} from '../utils/api.js'
import {showAlert, showErrorAlert, showSuccessAlert, showWarningAlert} from '../utils/alert.js'
import {envVars} from "../envVars.js";

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

const remoteApiURL = envVars().REMOTE_API_URL;

document.addEventListener('DOMContentLoaded', async function () {
    document.getElementById('cancelButton').addEventListener('click', function () {
        window.location.href = '/dashboard';
    });

    const users = await fetchMails();
    const sendMailButton = document.getElementById('sendMailButton');
    const sendPasswordButton = document.getElementById('sendPasswordButton');

    const emailInput = document.getElementById('email');
    const subject = document.getElementById('subject');
    const message = document.getElementById('message');
    const datalist = document.getElementById('emails');

    // Llenar el datalist con las opciones
    users.forEach(user => {
        user.forEach(email => {
            const option = document.createElement('option');
            option.value = email.email;
            datalist.appendChild(option);
        });
    });

    if (sendMailButton) {
        sendMailButton.addEventListener('click', async function () {
            const selectedEmail = emailInput.value;

            if (!selectedEmail || selectedEmail === '') {
                showErrorAlert('Error', 'Por favor, introduce un correo electrónico.');
                return;
            }
            if (!subject.value || subject.value === '') {
                showErrorAlert('Error', 'Por favor, introduce un asunto.');
                return;
            }
            if (!message.value || message.value === '') {
                showErrorAlert('Error', 'Por favor, introduce un mensaje.');
                return;
            }

            await sendMail(selectedEmail, subject.value, message.value, '');
        });
    }

    let currentUser = null; // Variable para almacenar el usuario actual
    let userStatus = false;

    if (sendPasswordButton) {
        sendPasswordButton.addEventListener('click', async function () {
            const emailInput = document.getElementById('emailModal');
            const selectedEmail = emailInput.value;
            const tableBody = document.getElementById('table-body');

            if (!selectedEmail || selectedEmail === '') {
                await showErrorAlert('Error', 'Por favor, introduce un correo electrónico.');
                return;
            }

            try {
                currentUser = await requestPassword(selectedEmail);

                if (!currentUser) {
                    await showErrorAlert('Error', 'No se encontró el usuario');
                    return;
                }

                // Limpiar la tabla antes de agregar nueva información
                tableBody.innerHTML = '';

                const row = document.createElement('tr');

                const nameCell = document.createElement('td');
                nameCell.textContent = currentUser.name;
                row.appendChild(nameCell);

                const emailCell = document.createElement('td');
                emailCell.textContent = currentUser.email;
                row.appendChild(emailCell);

                const departmentCell = document.createElement('td');
                departmentCell.textContent = currentUser.department;
                row.appendChild(departmentCell);

                const careerCell = document.createElement('td');
                careerCell.textContent = currentUser.career;
                row.appendChild(careerCell);

                const statusCell = document.createElement('td');

                let status = 'Sin registrar aún';
                userStatus = currentUser.enabled;
                if (currentUser.enabled) status = 'Registrado'

                statusCell.textContent = status;
                row.appendChild(statusCell);

                tableBody.appendChild(row);

            } catch (error) {
                console.error('Error:', error);
                await showErrorAlert('Error', 'Ocurrió un error al buscar el usuario');
            }
        });
    }

    // Mover el event listener del botón de confirmación fuera del otro event listener
    const confirmPasswordSubmition = document.getElementById('confirmPasswordSubmition');
    if (confirmPasswordSubmition) {
        confirmPasswordSubmition.addEventListener('click', async function () {
            if (!currentUser) {
                await showErrorAlert('Error', 'No se encontraron datos del usuario buscado');
                return;
            }

            if (userStatus) { // userStatus por default es false
                await showAlert(
                    'warning',
                    'Atención',
                    "Este usuario ya ha sido activado. ¿Deseas proceder con el envío de la contraseña?",
                    true,
                    'Sí, enviar',
                    'Cancelar'
                ).then(async (result) => {
                        if (result.isConfirmed) {
                            await sendMail(
                                currentUser.email,
                                "Clave de acceso",
                                "Tu clave de acceso por defecto es: ",
                                currentUser.password
                            );
                            window.location.href = '/dashboard';
                        } else{
                            showSuccessAlert('Cancelado', 'Operación cancelada').then(response => {
                                if (response.isConfirmed){
                                    window.location.reload();
                                }
                            });
                        }
                    }
                );
            } else {
                await sendMail(
                    currentUser.email,
                    "Clave de acceso",
                    "Tu clave de acceso por defecto es: ",
                    currentUser.password
                );
            }
        });
    }
});

const fetchKey = async () => {
    let response = await fetch('/api/get-key', {
        method: 'GET',
        headers: headers
    });

    // Comprobar si la respuesta es exitosa
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }

    return await response.json();
}

const requestPassword = async (email) => {
    try {

        // Obtener el JSON de la respuesta
        let data = await fetchKey();

        let response = await fetch(`${remoteApiURL}/findByMail?email=${email}`, {
            method: 'GET',
            headers: {
                ...headers,
                'x-api-key': data.xKey,
            }
        });
        data = await response.json();

        if (!data.success) {
            showErrorAlert('Error', data.message);
            return null;
        }

        return data;
    } catch (error) {
        console.error('Error:', error);
        return null;
    }
}

const fetchData = async (value) => {
    const body = {
        value: value
    };

    try {
        const response = await fetch(`/api/get-decrypted/`, {
            method: 'POST',
            body: JSON.stringify(body),
            headers: headers
        });

        const data = await response.json();

        if (!data.success) {
            showErrorAlert('Error', data.message);
            return null;
        }

        return data.password;
    } catch (error) {
        console.error(error);
        return null;
    }
};

const sendMail = async (email, subject, message, password) => {

    if (password !== '') {
        password = await fetchData(password);
    }

    const body = {
        subject: subject,
        email: email,
        message: message,
        password: password
    };

    fetch(`/api/sendmail/`, {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(body)
    })
        .then(response => response.json().then(data => {
            if (!data.success) {
                showErrorAlert('Error', data.message);
                return;
            }
            showSuccessAlert('Correo enviado', data.message).then(() => {
                window.location.href = '/dashboard/';
            });
        }))
        .catch(error => console.error('Error:', error));
};

const fetchMails = async () => {
    try {
        // Obtener el JSON de la respuesta
        let data = await fetchKey();

        const response = await fetch(`${remoteApiURL}/getMails`, {
            method: 'GET',
            headers: {
                ...headers,
                'x-api-key': data.xKey,
            }
        });

        let dataArray = [];

        const responseData = await response.json();

        if (!responseData.success) {
            showErrorAlert('Error', responseData.message);
            return null;
        }

        dataArray.push(responseData.data);

        return dataArray;
    } catch (error) {
        console.error('Error:', error);
        return null;
    }
}
