const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

document.addEventListener('DOMContentLoaded', function () {
    // Función para obtener el conteo de notificaciones
    function fetchNotificationCount() {
        fetch('/api/count-notifications', {
            method: 'GET',
            headers: headers,
        })
            .then(response => response.json())
            .then(data => {
                // Actualiza el HTML con el número de notificaciones
                if (data.count === 0){
                    document.getElementById('notification-count').innerText = "";
                    return;
                }

                document.getElementById('notification-count').innerText = data.count;
            })
            .catch(error => {
                console.error('Error al obtener el conteo de notificaciones:', error);
            });
    }

    // Llama a la función para obtener el conteo de notificaciones cuando la página se carga
    fetchNotificationCount();
});
