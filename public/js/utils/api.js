/**
 * Realiza una solicitud fetch a una API.
 *
 * @param {string} url La URL de la API.
 * @param {string} method El método HTTP (GET, POST, PUT, DELETE, etc.).
 * @param {Object|FormData} [body] El cuerpo de la solicitud, opcional.
 * @param {Object} [headers] Los encabezados de la solicitud, opcional.
 * @returns {Promise<Response>} La respuesta de la API.
 */
export async function apiRequest(url, method, body = null, headers = {}) {
    const options = {
        method: method,
        headers: headers,
    };

    if (body) {
        if (body instanceof FormData) {
            options.body = body;
            delete options.headers['Content-Type'];
        } else {
            options.body = JSON.stringify(body);
        }
    }

    return fetch(url, options);
}
