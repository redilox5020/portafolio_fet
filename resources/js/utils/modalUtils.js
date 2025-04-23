/**
 * Reemplaza __ID__ por el ID real en una plantilla de ruta.
 * @param {string} template - Ruta con marcador '__ID__'
 * @param {string|number} id - ID a insertar
 * @returns {string|null} - Ruta generada o null si inválida
 */
export function generarRutaConId(template, id) {
    if (!template || !id || !template.includes('__ID__')) return null;
    return template.replace('__ID__', id);
}

/**
 * Asigna dinámicamente el action del formulario de un modal.
 * @param {string} selectorForm - Selector del formulario 
 * @param {string} template - Ruta base con __ID__
 * @param {string|number} id - ID real del recurso
 */
export function asignarActionAlFormulario(selectorForm, template, id) {
    const url = generarRutaConId(template, id);
    if (url) {
        $(selectorForm).attr('action', url);
    } else {
        console.warn('No se pudo generar la URL de acción para el formulario.');
    }
}
