
    const url = "/api/";

    fetch(url + "statuses", {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data !== null && Array.isArray(data.statuses)) {
                // Asignar los datos al select
                let statusElements = Array.from(document.getElementsByClassName('status'));
                if (statusElements) {
                    console.log(statusElements);
                }
                statusElements.forEach(s => {
                    data.statuses.forEach(d => {
                        let option = document.createElement('option');
                        option.value = d.id;
                        option.text = d.status;
                        s.appendChild(option);
                    });
                });
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });

    fetch(url + "room", {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    }).then(response => response.json())
        .then(data => {
            let selectRoom = document.getElementById('room');

            data.rooms.forEach(room => {
                let option = document.createElement('option');
                option.value = room.id;
                option.text = room.name;
                selectRoom.appendChild(option);
            });
        });

    fetch(url + "resourcesTypes", {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    }).then(response => response.json())
        .then(data => {
            let selectResourceType = document.getElementById('resource_type');

            data.resourceTypes.forEach(resourceType => {
                let option = document.createElement('option');
                option.value = resourceType.id;
                option.text = resourceType.resource_name;
                selectResourceType.appendChild(option);
            });
    });
