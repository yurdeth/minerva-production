import {showErrorAlert, showSuccessAlert} from './utils/alert.js';
import {apiRequest} from "./utils/api.js";

// const remoteApiURL = process.env.REMOTE_API_URL;
const remoteApiURL = "https://api-rest.tests.engineer/api";
// const adminEmail = process.env.ADMIN_EMAIL;
const adminEmail = "admin@admin.com";

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
};

document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('form').addEventListener('submit', function (event) {
        event.preventDefault();

        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        if (!email) {
            showErrorAlert('Error', 'Ingresa tu correo electronico');
            return;
        }

        if (!password) {
            showErrorAlert('Error', 'Ingresa tu contraseña');
            return;
        }

        const body = {
            email: email,
            password: password
        };

        if (email === adminEmail) {
            login(body);
        } else {
            checkUser(body).then(r => {

                if(!r.success && !r.enabled){
                    showErrorAlert('Error', r.message).then(() => {
                        window.location.reload();
                    })
                    return;
                }

                if(!r.enabled){
                    showSuccessAlert('Usuario habilitado', 'Usuario habilitado correctamente').then((result) => {
                        if(result.isConfirmed){
                            localStorage.setItem('user_id', r.user.id);
                            localStorage.setItem('career_id', r.user.career_id);
                            localStorage.setItem('career_name', r.user.career_name);
                            localStorage.setItem('department_name', r.user.department_name);
                            localStorage.setItem('department_id', r.user.department_id);
                            localStorage.setItem('email', r.user.email);
                            localStorage.setItem('name', r.user.name);
                            window.location.href = '/actualizar-informacion';
                        }
                    });
                    return;
                }

                login(body);
            });
        }

    });
});

const checkUser = async (body) => {
    try {
        let response = await fetch(`/get-key`, {
            method: 'GET',
            headers: {
                ...headers,
                'randKey': document.getElementById('rand').value
            }
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        let data = await response.json();

        response = await fetch(`${remoteApiURL}/verifyUser?email=${body.email}&password=${body.password}`, {
            method: 'GET',
            headers: {
                ...headers,
                'x-api-key': data.xKey,
            }
        });

        return response.json();
    } catch (error) {
        console.error('Error:', error);
        showErrorAlert('Error', 'No ha podido establecerse una conexión con el servidor').then(() => {
            window.location.reload();
        });
        return null;
    }
};

const login = (body) => {
    apiRequest('/signin', 'POST', body, headers)
        .then(function (response) {
            response.json().then(data => {
                if (!data.success) {
                    showErrorAlert('Error', data.message).then(result => {
                        if (result.isConfirmed) {
                            window.location.reload(); // <- Forzar recarga de la página para re-generar el key del middleware.
                        }
                    });
                    return;
                }

                localStorage.setItem('token', data.token);
                window.location.href = data.redirectTo;

            });
        })
        .catch(function (error) {
            console.error('Error: ', error);
        });
};
