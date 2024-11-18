import {getResponse} from '../getResponsePromise.js';
import {showSuccessAlert, showErrorAlert} from '../utils/alert.js'

let roomList = ["Sala 1", "Sala 2"];
let resourceTypelist = ["Lente", "Computadora"];
let statusList = ["Buen estado", "Mal estado", "En reparación"];

document.addEventListener("DOMContentLoaded", function () {

    //Room process
    getResponse('/api/room')
        .then((response) => {

            if (response.total === 0) {
                roomList.forEach((room, index) => {
                    fetch("/api/room/create", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${localStorage.getItem('token')}`,
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            name: room,
                            id: index + 1
                        })
                    })
                        .then(() => console.log('Ok'))
                        .catch(error => console.error("Error:", error));
                });
            }
        }).catch((error) => {
        console.error("Error:", error);
    });

    //Status process
    getResponse("/api/statuses")
        .then(response => {
            if (response.total === 0) {
                console.log("No hay estados");
                statusList.forEach((status, index) => {
                    fetch("/api/statuses/create", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${localStorage.getItem('token')}`,
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            status: status,
                            id: index + 1
                        })
                    })
                        .then(() => console.log('Ok'))
                        .catch(error => console.error("Error:", error));
                });
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });

    //Resource Type process
    getResponse("/api/resourcesTypes")
        .then(response => {
            if (response.total === 0) {
                console.log("No hay tipos de recursos");
                resourceTypelist.forEach((resourceType, index) => {
                    fetch("/api/resourcesTypes/create", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${localStorage.getItem('token')}`,
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            resource_name: resourceType,
                            id: index + 1
                        })
                    })
                        .then(() => console.log('Ok'))
                        .catch(error => console.error("Error: " + error));
                });
            }
        })
        .then(data => {

        }).catch((error) => {
        console.error("Error:", error);
    });


    //Dar un tiempo para que se cree la sala
    setTimeout(function () {

        getResponse('/api/room')
            .then(response => {
                response.rooms.forEach(room => {
                    let selectRoom = document.getElementById('room');
                    let option = document.createElement('option');
                    option.value = room.id;
                    option.text = room.name;
                    selectRoom.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });

        getResponse('/api/statuses')
            .then(response => {
                response.statuses.forEach(status => {
                    let selectStatus = document.getElementById('status');
                    let option = document.createElement('option');
                    option.value = status.id;
                    option.text = status.status;
                    selectStatus.appendChild(option);
                });
            })
            .catch((error) => {
                console.error("Error:", error);
            });

        getResponse('/api/resourcesTypes')
            .then(response => {
                let selectResourceType = document.getElementById('resource_type');

                response.resourceTypes.forEach(resourceType => {
                    let option = document.createElement('option');
                    option.value = resourceType.id;
                    option.text = resourceType.resource_name;
                    selectResourceType.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }, 100);


    let formulario = document.getElementById("form_inventario");

    formulario.addEventListener("submit", function (event) {
        event.preventDefault();

        const resourceTypeId = document.getElementById("resource_type").value;
        const statusId = document.getElementById("status").value;
        const roomId = document.getElementById("room").value;
        const fixed_asset_code = document.getElementById("fixed_asset_code").value;

        if (fixed_asset_code === '') {
            showErrorAlert('Error', 'Ingrese el código de activo fijo').then(() => {
                document.getElementById('fixed_asset_code').focus();
            });
            return;
        }

        const data = {
            resource_type_id: resourceTypeId,
            status_id: statusId,
            room_id: roomId,
            fixed_asset_code: fixed_asset_code
        };

        fetch("/api/resources/create", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                response.json().then(data => {

                    if (data.message.includes('Error validating data')) {
                        if (data.errors.room_id) {
                            showErrorAlert('Error', 'Seleccione la sala a la que pertenece el artículo').then(() => {
                                document.getElementById('room').focus();
                            });
                            return;
                        }

                        if (data.errors.fixed_asset_code) {
                            showErrorAlert('Error', 'El código de activo fijo ya ha sido tomado').then(() => {
                                document.getElementById('fixed_asset_code').focus();
                            });
                            return;
                        }

                        if (data.errors.resource_type_id) {
                            showErrorAlert('Error', 'Seleccione el tipo de recurso').then(() => {
                                document.getElementById('resource_type').focus();
                            });
                            return;
                        }

                        if (data.errors.status_id) {
                            showErrorAlert('Error', 'Seleccione el estado en que se encuentra del artículo').then(() => {
                                document.getElementById('status').focus();
                            });
                            return;
                        }
                    }

                    showSuccessAlert('Recurso creado', 'El articulo se registró correctamente').then(() => {
                        window.location.href = '/dashboard/inventario';
                    });
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});
