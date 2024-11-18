const selectDepartment = document.getElementById('department');

document.addEventListener('DOMContentLoaded', function () {
    if(selectDepartment.value !== ''){
        fetchCareers(selectDepartment.value);
    }
});

selectDepartment.addEventListener('change', function () {
    fetchCareers(selectDepartment.value);
});

function fetchCareers(departmentId) {
    fetch(`/api/careers/${departmentId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            populateCareers(data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

function populateCareers(data) {
    const career = document.getElementById('career');
    career.innerHTML = '';

    let option = document.createElement('option');
    option.value = '';
    option.text = 'Seleccione una carrera';
    career.appendChild(option);

    data.forEach(d => {
        let option = document.createElement('option');
        option.value = d.id;
        option.text = d.career_name;
        career.appendChild(option);
    });
}
