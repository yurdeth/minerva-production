const url = "/api/appointments/available/";
let loadAvailableSchedulesDiv = document.getElementById('loadAvailableSchedules');

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

// Eliminar todos los elementos del div
function removeAllChildNodes(parent) {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}

function showAvailableShedules() {
    const dateInput = document.getElementById('date').value;
    removeAllChildNodes(loadAvailableSchedulesDiv);

    if (!dateInput) {
        return;
    }
    console.log(dateInput);

    fetch(`${url}?date=${dateInput}`, {
        method: 'GET',
        headers: headers
    })
        .then(response => {
            response.json().then(data => {

                if (data.length > 0) {
                    let p = document.createElement('p');
                    p.classList.add("text-start");
                    p.innerHTML = "Horarios previamente seleccionados por otros usuarios para este día: ";

                    let table = document.createElement('table');
                    let topRow = table.insertRow();
                    let th1 = document.createElement('th');
                    let th2 = document.createElement('th');
                    let th3 = document.createElement('th');
                    th1.innerHTML = "Fecha";
                    th2.innerHTML = "Hora de inicio";
                    th3.innerHTML = "Hora de finalización";
                    topRow.appendChild(th1);
                    topRow.appendChild(th2);
                    topRow.appendChild(th3);

                    table.classList.add("table", "table-bordered", "text-center");
                    data.forEach(element => {

                        const dateParts = element.date.split('-');
                        const formatedDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                        formatedDate.setDate(formatedDate.getDate());

                        // Mostrar fecha de manera textual:
                        const months = [
                            'Enero',
                            'Febrero',
                            'Marzo',
                            'Abril',
                            'Mayo',
                            'Junio',
                            'Julio',
                            'Agosto',
                            'Septiembre',
                            'Octubre',
                            'Noviembre',
                            'Diciembre'
                        ];
                        const monthName = months[formatedDate.getMonth()];
                        const dateText = `${formatedDate.getDate()} de ${monthName} de ${formatedDate.getFullYear()}`;

                        // Formatear la hora en formato de 12 horas
                        let timeParts = element.start_time.split(':');
                        let hours = parseInt(timeParts[0], 10);
                        let minutes = timeParts[1];
                        let ampm = hours >= 12 ? 'PM' : 'AM';
                        hours = hours % 12;
                        hours = hours = hours ? hours : 12; // Si hours es 0, cambiar a 12
                        let formatedStartTime = hours + ':' + minutes + ' ' + ampm;

                        timeParts = element.end_time.split(':');
                        hours = parseInt(timeParts[0], 10);
                        minutes = timeParts[1];
                        ampm = hours >= 12 ? 'PM' : 'AM';
                        hours = hours % 12;
                        hours = hours ? hours : 12; // Si hours es 0, cambiar a 12
                        let formatedEndTime = hours + ':' + minutes + ' ' + ampm;

                        let row = table.insertRow();
                        let cell1 = row.insertCell(0);
                        let cell2 = row.insertCell(1);
                        let cell3 = row.insertCell(2);

                        // Formatear la fecha de element.date de YYYY-MM-DD a DD/MM/YYYY
                        cell1.innerHTML = dateText;
                        cell2.innerHTML = formatedStartTime;
                        cell3.innerHTML = formatedEndTime;
                    });

                    loadAvailableSchedulesDiv.appendChild(p);
                    loadAvailableSchedulesDiv.appendChild(table);
                } else {
                    let p = document.createElement('p');
                    p.classList.add("text-center");
                    p.innerHTML = "Selecciona cualquier horario dentro del rango de 8:00 AM a 5:00 PM";
                    loadAvailableSchedulesDiv.appendChild(p);
                }
            });
        })
        .catch(error => console.error('Error:', error));
}

function formatDate(dateString) {
    const [year, month, day] = dateString.split('-');
    return `${day}/${month}/${year}`;
}
