/**
 * Realiza una solicitud HTTP GET a la URL especificada y devuelve la respuesta en formato JSON.
 *
 * @param {string} url - La URL a la que se realizará la solicitud GET.
 * @returns {Promise<Object>} - Una promesa que se resuelve con la respuesta en formato JSON.
 * @throws {Error} - Lanza un error si la respuesta no es exitosa.
 */
async function getResponse(url) {
    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        // console.log(response);

        if (!response.ok) {
            throw new Error('Error al obtener los datos');
        }

        return await response.json();
    } catch (error) {
        console.log(error);
    }
}

export {getResponse};
