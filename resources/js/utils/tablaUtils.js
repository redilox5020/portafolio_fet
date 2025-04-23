/**
 * Elimina filas del DOM con animación fadeOut.
 * @param {Array} rows - Lista de filas jQuery
 * @param {string} bodyTSelector - Selector del tbody de la tabla
 */
export function removerFilas(rows, bodyTSelector = '#historicoTable') {
    const bodyTable = $(bodyTSelector);
    let rowsProcessed = 0;

    rows.forEach(row => {
        row.fadeOut(500, function () {
            console.log('Antes de eliminar:', $('#historicoTable').children().length);
            $(this).remove();
            console.log('Después de eliminar:', $('#historicoTable').children().length);
            rowsProcessed++;

            if (rowsProcessed === rows.length) {
                if (bodyTable.children().length === 0) {
                    const emptyRow = `
                        <tr>
                            <td colspan="7" class="text-center">No hay investigadores historicos.</td>
                        </tr>
                    `;
                    bodyTable.append(emptyRow);
                    deshabilitarControles(true);
                }
            }
        });
    });
}

/**
 * Elimina filas con base en objetos recibidos del backend (requiere pivot_id y restore).
 * @param {Array} investigadores - Lista de objetos con { pivot_id, restore }
 * @param {string} bodyTSelector - Selector del tbody de la tabla
 */
export function removerFilasPorPivot(investigadores, bodyTSelector = '#historicoTable') {
    const bodyTable = $(bodyTSelector);
    let filasProcesadas = 0;
    let filasTotales = 0;

    investigadores.forEach(inv => {
        if (!inv.restore || !inv.pivot_id) return;

        const filaAEliminar = $(`${bodyTSelector} tr[data-pivot-id="${inv.pivot_id}"]`);

        const filasHistoricas = $(`${bodyTSelector} tr`).filter(function () {
            return (
                $(this).data('investigador-id') === inv.investigador_id &&
                $(this).data('pivot-id') !== inv.pivot_id
            );
        });

        filasHistoricas.each(function () {
            $(this).find('td').eq(5).text('si');
        });

        if (filaAEliminar.length) {
            filasTotales++;
            filaAEliminar.fadeOut(500, function () {
                $(this).remove();
                filasProcesadas++;

                if (filasProcesadas === filasTotales) {
                    if (bodyTable.children().length === 0) {
                        const emptyRow = `
                            <tr>
                                <td colspan="7" class="text-center">No hay investigadores historicos.</td>
                            </tr>
                        `;
                        bodyTable.append(emptyRow);
                        deshabilitarControles(true);
                    }
                }
            });
        }
    });
}

/**
 * Deshabilita o habilita los controles globales del histórico.
 * @param {boolean} flag
 */
export function deshabilitarControles(flag) {
    $('#deleteButton, #reactivateButton, #selectAllCheckbox').prop('disabled', flag);
}
