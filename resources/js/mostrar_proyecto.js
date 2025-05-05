import { removerFilas, removerFilasPorPivot, deshabilitarControles } from './utils/tablaUtils.js';
import { asignarActionAlFormulario } from './utils/modalUtils.js';

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

    $(document).on('click', '.delete-btn', function (event) {
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

function mostrarAlerta(tipo, mensaje) {
    const $alert = $('#alert');
    $alert.removeClass('d-none alert-success alert-danger')
        .addClass(`alert-${tipo} alert-dismissible fade show`);
    $alert.find('.alert-message').text(mensaje);
    setTimeout(() => $alert.fadeOut(500), 3000);
}

function mostrarToast(tipo, mensaje, autohide = true, startNew = false, duracion = 5000) {
    if (startNew) $('#toast-container').empty();

    const iconos = {
        success: '✅', warning: '⚠️', danger: '❌', info: 'ℹ️'
    };
    const colores = {
        success: '#e4ffc4', warning: '#FFEB3B', danger: '#dc3545', info: '#17a2b8'
    };

    const id = `toast-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
    const toastHTML = `
        <div id="${id}" class="toast font-weight-bold text-gray-900 mb-2" role="alert"
            data-delay="${duracion}" data-autohide="${autohide}"
            style="background-color: ${colores[tipo]} !important;">
            <div class="toast-header text-gray-900" style="background-color: ${colores[tipo]} !important;">
                <strong class="mr-auto">${iconos[tipo]} ${tipo.toUpperCase()}</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">${mensaje}</div>
        </div>`;

    $('#toast-container').append(toastHTML);
    $(`#${id}`).toast('show').on('hidden.bs.toast', function () {
        $(this).remove();
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

function cargarMetadatosPDF() {
    console.log("🔵 Cargando metadatos PDF");
    const contenedor = $('#pdf-metadata-container');
    const pdfUrl = contenedor.data('url');
    if (!pdfUrl) return;

    $('#loader-container').show();
    contenedor.hide();

    let loaderTimeout = setTimeout(() => {console.log("🔵 Loader mostrado");$('#loader-container').fadeIn(200)}, 300);

    $.ajax({
        url: 'pdf/metadatos',
        method: 'GET',
        headers: { 'X-PDF-Url': pdfUrl },
        success: function (res) {
            contenedor.html(`
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead><tr>
                            <th>Fichero</th><th>Descripción</th><th>Tamaño</th><th>Formato</th><th></th>
                        </tr></thead>
                        <tbody><tr>
                            <td>${res.nombre}</td>
                            <td>${res.descripcion}</td>
                            <td>${res.tamaño}</td>
                            <td>Adobe PDF</td>
                            <td><a href="${res.url}" class="btn btn-success btn-sm">Descargar</a></td>
                        </tr></tbody>
                    </table>
                </div>
            `);
        },
        error: () => contenedor.html(`<div class="alert alert-danger">Error al cargar metadatos.</div>`),
        complete: function () {
            console.log("🔵 complete cargado");
            /* Evita que el loader se muestre si la carga es rápida, ejemplo cuando los metadatos solicitados ya estan en caché
            un caso practico cuando salimos a otra ruta y regresamos, el navegador ya tiene la respuesta. */
            clearTimeout(loaderTimeout);
            $('#loader-container').hide();
            console.log("🔵 Loader ocultado");
            contenedor.show();
        }
    });
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

function eliminarHistoricoRoute() {
    return window.appData.rutas.eliminarRegistroHistorico;
}

function reactivarRoute() {
    return window.appData.rutas.reactivar;
}

function csrfToken() {
    return window.appData.csrf;
}

function indexActual() {
    return window.appData.indexActual;
}
