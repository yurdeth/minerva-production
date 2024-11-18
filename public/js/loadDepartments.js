document.addEventListener('DOMContentLoaded', function () {
    fetch('/api/departments', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            // console.log(data);

            // Asignar los datos al select
            let department = document.getElementById('department');
            data.forEach(d => {
                let option = document.createElement('option');
                option.value = d.id;
                option.text = d.department_name;
                department.appendChild(option);
            });
        })
        .catch((error) => {
            console.error('Error:', error);
        });

});
