import { removerFilas, removerFilasPorPivot, deshabilitarControles } from './utils/tablaUtils.js';
import { asignarActionAlFormulario } from './utils/modalUtils.js';
import { cargarMetadatosPDF, subirPdf } from './archivos.js';
import { csrfToken, eliminarHistoricoRoute, reactivarRoute } from './utils/routeUtils.js';
import { mostrarAlerta } from './utils/toastUtils.js';

document.addEventListener('DOMContentLoaded', function () {
    const $lucesDelCirculo = document.querySelectorAll('.luces-circulo');

    const estadoFinal = window.appData.estadoColor;

    let contadorDeLuz = 0;
    let intervalo;

    const mostrarLuz = () => {
        $lucesDelCirculo.forEach(luz => {
            luz.classList.remove('red', 'yellow', 'green');
        });

        const luzActual = $lucesDelCirculo[contadorDeLuz];
        const colorActual = luzActual.getAttribute('color');

        luzActual.classList.add(colorActual);

        if (colorActual === estadoFinal) {
            clearInterval(intervalo);
        } else {
            contadorDeLuz++;
        }
    };

    intervalo = setInterval(mostrarLuz, 300);

    inicializarEventos();
    cargarMetadatosPDF();
});

function inicializarEventos() {
    $('#formSubirArchivo').on('submit', function (e) {
        e.preventDefault();
        const actionUrl = $(this).attr('action');
        subirPdf(this, actionUrl);

    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        cargarPaginaInvestigadores(url);
    });

    $(window).on('popstate', function(event) {
        if (event.state?.url) {
            cargarPaginaInvestigadores(event.state.url);
        }
        else {
            const currentUrl = window.location.href;
            cargarPaginaInvestigadores(currentUrl);
        }
    });

    $(document).on('click', '.delete-proyecto-btn', function (event) {
        event.preventDefault();

        const userId = $(this).data('id');
        const template = window.appData.rutas.eliminar;

        asignarActionAlFormulario('#deleteForm', template, userId);
    });


    $('#selectAllCheckbox').on('change', toggleSeleccionMasiva);

    $('#deleteButton').on('click', eliminarSeleccionados);
    $('#reactivateButton').on('click', reactivarSeleccionados);

    $(document).on('hidden.bs.modal', function () {
        $('.toast').toast('hide');
    });
}

function toggleSeleccionMasiva() {
    const isChecked = $(this).is(':checked');
    $('.form-check-input').not(this).prop('checked', isChecked);
}

function recogerSeleccionados() {
    const ids = [];
    const rows = [];

    $('.form-check-input:checked').not('#selectAllCheckbox').each(function () {
        ids.push($(this).val());
        rows.push($(this).closest('tr'));
    });
    return { ids, rows };
}

function eliminarSeleccionados() {
    const { ids, rows } = recogerSeleccionados();

    if (ids.length === 0) return mostrarToast('warning', 'Selecciona al menos un investigador.');
    if (!confirm('¿Seguro que deseas eliminar los investigadores seleccionados?')) return;

    deshabilitarControles(true);

    $.ajax({
        url: eliminarHistoricoRoute(),
        method: 'DELETE',
        data: {
            selectedIds: ids,
            _token: csrfToken(),
        },
        success: function (response) {
            mostrarAlerta('success', response.message);
            mostrarToast('success', response.message, true, true);
            removerFilas(rows);
        },
        error: function (xhr) {
            manejarErrores(xhr);
        },
        complete: function () {
            deshabilitarControles(false);
        }
    });
}

function reactivarSeleccionados() {
    const { ids, rows } = recogerSeleccionados();
    const todosActivos = rows.every(row =>
        row.find('td').eq(5).text().trim().toLowerCase() === 'si'
    );
    if (todosActivos) return mostrarToast('warning', 'No puedes reactivar investigadores activos.');
    if (ids.length === 0) return mostrarToast('warning', 'Selecciona al menos un investigador.');
    if (!confirm('¿Deseas reactivar los investigadores seleccionados?')) return;

    deshabilitarControles(true);

    $.ajax({
        url: reactivarRoute(),
        method: 'POST',
        data: {
            selectedIds: ids.map(id => $(`#investigador-${id}`).data('investigador-id')),
            _token: csrfToken(),
        },
        success: function (response) {
            mostrarToast('success', response.message, true, true);
            mostrarAlerta('success', response.message);
            removerFilasPorPivot(response.investigadoresRestaurados, rows);
            insertarActivos(response.investigadoresRestaurados);
            if(response.errores && response.errores.length > 0){
                response.errores.forEach(function(error) {
                    mostrarToast('warning', error, false);
                });
            }
        },
        error: function (xhr) {
            manejarErrores(xhr);
        },
        complete: function () {
            deshabilitarControles(false);
        }
    });
}

let index = parseInt(indexActual()) ?? 1;
function insertarActivos(investigadores) {
    investigadores.forEach((inv) => {
        const card = `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-user mr-2"></i> Investigador ${index}
                        </h5>
                        <p class="card-text text-muted mb-0">${inv.nombre}</p>
                    </div>
                </div>
            </div>
        `;
        $('#container-investigadores-activos').append(card).hide().fadeIn(500);
        index += 1;
    });
}

function manejarErrores(xhr) {
    if (xhr.status === 422 || xhr.status === 400) {
        const errores = Object.values(xhr.responseJSON.errors).join('\n');
        mostrarAlerta('danger', errores);
        mostrarToast('danger', errores);
    } else if (xhr.status === 404) {
        mostrarAlerta('danger', xhr.responseJSON.message);
    } else {
        mostrarAlerta('danger', 'Error inesperado.');
    }
}

function cargarPaginaInvestigadores(url) {
    const containerTarjetas = $('#tarjetas-investigadores');
    const containerPaginacion = $('#paginacion-investigadores');

    $.ajax({
        url: url,
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        beforeSend: function () {
            containerPaginacion.html('<div class="col-12 text-center my-3"><div class="spinner-border text-info" role="status"></div></div>');
            containerTarjetas.fadeTo(200, 0.5);
        },
        success: function (response) {
            if (response?.tarjetas?.trim() && response?.paginacion?.trim()) {
                containerTarjetas.html(response.tarjetas).fadeTo(300, 1);
                containerPaginacion.html(response.paginacion);

                if (window.location.href !== url) {
                    window.history.pushState({ url: url }, '', url);
                }
            } else {
                containerTarjetas.html('<p class="text-danger">No se encontraron investigadores.</p>').fadeTo(300, 1);
                containerPaginacion.html('');
            }
        },
        error: function (xhr) {
            containerPaginacion.html('<p class="text-danger">Error al cargar los investigadores.</p>');
            manejarErrores(xhr);
        }
    });
}

function indexActual() {
    return window.appData.indexActual;
}

