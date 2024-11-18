/**
 * Enum para los tipos de iconos en alertas SweetAlert2.
 * @enum {string}
 * @readonly
 * @property {string} SUCCESS - 'success'
 * @property {string} ERROR - 'error'
 * @property {string} WARNING - 'warning'
 * @property {string} INFO - 'info'
 * @property {string} QUESTION - 'question'
 **/
const AlertIconTypes = Object.freeze({
    SUCCESS: 'success',
    ERROR: 'error',
    WARNING: 'warning',
    INFO: 'info',
    QUESTION: 'question'
});

/**
 * Enum para los tipos de iconos de las alertas de SweetAlert2
 * @enum {string}
 * @readonly
 * @property {string} SUCCESS - Icono de éxito
 * @property {string} ERROR - Icono de error
 * @property {string} WARNING - Icono de advertencia
 * @property {string} INFO - Icono de información
 * @property {string} QUESTION - Icono de pregunta
 * @example <caption>Uso de los tipos de iconos</caption>
 * import {AlertIconTypes} from './alert.js';
 * import {showAlert} from './alert.js';
 * showAlert(AlertIconTypes.SUCCESS, 'Título', 'Texto de la alerta');
 * showAlert(AlertIconTypes.ERROR, 'Título', 'Texto de la alerta');
 * showAlert(AlertIconTypes.WARNING, 'Título', 'Texto de la alerta');
 */

/**
 * Importar SweetAlert2
 *
 * @param {string} icon Icono de la alerta, valores posibles: 'success', 'error', 'warning', 'info', 'question'
 * @param {string} title Título de la alerta
 * @param {string} text Texto de la alerta
 * @param {boolean} showCancelButton Establece si se muestra el botón de cancelar o no, por defecto es false
 * @param {string}confirmButtonText Texto del botón de confirmar, por defecto es 'Aceptar'
 * @param {string} cancelButtonText Texto del botón de cancelar, por defecto es 'Cancelar'
 * @returns {*} Devuelve la alerta con los parámetros establecidos
 */
export function showAlert(icon, title, text, showCancelButton = false, confirmButtonText = 'Aceptar',
                          cancelButtonText = 'Cancelar') {
    return Swal.fire({
        icon: icon,
        title: title,
        text: text,
        showCancelButton: showCancelButton,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        allowOutsideClick: false,
        allowEscapeKey: false,
    });
}

/**
 * Muestra una alerta de éxito
 * @param {string} title Título de la alerta
 * @param {string} text Texto de la alerta
 * @returns {*} Devuelve la alerta de éxito, icono por defecto: 'success'
 */
export function showSuccessAlert(title, text) {
    return showAlert(AlertIconTypes.SUCCESS, title, text);
}

/**
 * Muestra una alerta de error
 * @param {string} title Título de la alerta
 * @param {string} text Texto de la alerta
 * @returns {*} Devuelve la alerta de error, icono por defecto: 'error'
 */
export function showErrorAlert(title, text) {
    return showAlert(AlertIconTypes.ERROR, title, text);
}

/**
 * Muestra una alerta de información
 * @param {string} title Título de la alerta
 * @param {string} text Texto de la alerta
 * @returns {*} Devuelve la alerta de información, icono por defecto: 'warning'
 */
export function showWarningAlert(title, text) {
    return showAlert(AlertIconTypes.WARNING, title, text);
}

export {AlertIconTypes}
