import {apiRequest} from '../utils/api.js'
import {showErrorAlert, showSuccessAlert} from '../utils/alert.js'

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

const career_name_input = document.getElementById('career_name');
const submitButton = document.getElementById('submitButton');

function submitForm() {
    const career_name = career_name_input.value;
    const department_name = document.getElementById('department').value;

    if (career_name.trim() === '') {
        showErrorAlert('Error', 'El nombre de la carrera es requerido');
        return;
    }

    if (department_name.trim() === '') {
        showErrorAlert('Error', 'Seleccione un departamento');
        return;
    }

    const body = {
        career_name: career_name,
        department_id: department_name
    };

    apiRequest('/api/careers/nueva', 'POST', body, headers)
        .then(response => {
            response.json().then(data => {
                console.log(data);
                if (!data.success) {
                    if (data.error) {
                        if (data.error.career_name && data.error.career_name[0].includes('has already been taken')) {
                            showErrorAlert('Error', 'El nombre de la carrera ya ha sido registrado');
                            return;
                        }

                        if (data.error.department_id && data.error.department_id[0].includes('department id field is required')) {
                            showErrorAlert('Error', 'Seleccione un departamento');
                            return;
                        }

                        showErrorAlert('Error', "Ha ocurrido un error al intentar crear la carrera");
                        return;
                    }

                    showErrorAlert('Error', data.message);
                    return;
                }

                showSuccessAlert('Operación completada', 'Carrera registrada correctamente')
                    .then(() => {
                        window.location.href = '/dashboard/carreras';
                    });
            })
        }).catch(error => console.error(error));
}

submitButton.addEventListener('click', submitForm);

career_name_input.addEventListener('keydown', function (event) {
    if (event.key === 'Enter') {
        submitForm();
    }
});
