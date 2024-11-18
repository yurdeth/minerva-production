let selectedDate = null; // Variable para almacenar la fecha seleccionada actualmente
function ajaxpage(url, containerid) {

    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById(containerid).innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function numberRandom(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

function createCards(date) {
    return `
    <div class="col-2 col-md-5 mb-5">
        <div class="date-card">
            <div class="barcode-icon">
                <i class="fa-solid fa-calendar-week"></i>
            </div>
            <h5 class="date-title">${date.date}</h5>
            <p class="date-description">${date.description}</p>
        </div>
    </div>
    `;
}

console.log('calendar.js loaded');

const calendarEl = document.getElementById('calendar');
const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth', locale: 'es', headerToolbar: {
        left: 'prev,next,today', center: 'title', right: 'prev,next'
    }, events: function (fetchInfo, successCallback, failureCallback) {
        const apiUrl = '/api/appointments/calendar-items';
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        fetch(apiUrl, {
            method: 'GET',
            headers: headers
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => successCallback(data.data))
            .catch(error => {
                console.error('Error fetching events:', error);
                failureCallback(error);
            });
    }, dateClick: function (info) {

        // Verificar si hay eventos en la fecha seleccionada
        let eventsOnDate = calendar.getEvents().filter(function (event) {
            return event.start.toDateString() === info.date.toDateString();
        });

        // Ejecutar ajaxpage si hay eventos en la fecha seleccionada
        if (eventsOnDate.length > 0) {

            const dateModalBody = document.getElementById('selectedDate');

            // Limpiar el contenido actual del modal
            dateModalBody.innerHTML = '';

            fetch("/api/appointments/filtrar?date=" + info.dateStr, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                for (const datum of data) {
                    const date = {
                        date: "Hora de inicio: " + datum.start_time,
                        description: "Hora final: " + datum.end_time
                    };
                    dateModalBody.innerHTML += createCards(date);
                }
            }).
            catch(error => {
                    console.error('Error:', error);
                });



            /*// Crear las tarjetas de eventos
            for (let i = 0; i < numberRandom(1, 5); i++) {
                const date = {
                    date: '10-10-202 ' + i,
                    description: 'Descripción del evento ' + i
                };
                dateModalBody.innerHTML += createCards(date);
            }*/

            const dateModal = document.getElementById('dateModal');
            const modal = new bootstrap.Modal(dateModal);
            modal.show();

            // Restaurar el color de la fecha seleccionada anteriormente
            if (selectedDate) {
                const prevBgHarness = selectedDate.querySelector('.fc-daygrid-bg-harness');
                if (prevBgHarness) {
                    prevBgHarness.style.backgroundColor = 'rgb(255,255,255)'; // Restaurar color original
                }
            }

            // Actualizar la fecha seleccionada actual
            selectedDate = info.dayEl;
            // Acceder al elemento con la clase fc-daygrid-bg-harness dentro de la celda actual
            const bgHarness = info.dayEl.querySelector('.fc-daygrid-bg-harness');
            if (bgHarness) {
                // Cambiar el color de fondo de la etiqueta fc-daygrid-bg-harness
                bgHarness.style.backgroundColor = 'rgb(229,145,145)'; // Cambiar a un color diferente
            } else {
                console.log('Elemento fc-daygrid-bg-harness no encontrado en la celda');
            }
            const dateParam = encodeURIComponent(info.dateStr);
            //ajaxpage('events.php?date=' + dateParam, 'Events');
        }
    }, eventDidMount: function (info) {
        // Obtener la celda correspondiente a la fecha del evento
        const cell = info.el.parentNode;

        // Cambiar el color de fondo de la celda
        cell.style.backgroundColor = 'rgb(255,255,255)';
    }, eventMouseEnter: function (info) {
        info.el.style.cursor = 'pointer';
    },
});
calendar.render();

let myModalEl = document.getElementById('calendarModal');
myModalEl.addEventListener('shown.bs.modal', function () {
    calendar.render();
    calendar.updateSize();
});
