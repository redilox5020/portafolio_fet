import { csrfToken } from './utils/routeUtils.js';
import { mostrarToast } from './utils/toastUtils.js';

export function subirPdf(formElement, actionUrl) {
    $('#loader-subir-container').show();
    $(formElement).hide();
    $('#btnSubirArchivo').prop('disabled', true);
    const formData = new FormData(formElement);
    formData.append('_token', csrfToken());
    $.ajax({
        url: actionUrl,
        method: 'POST',
        contentType: false,
        processData: false,
        data: formData,
        success: function (res) {
            mostrarToast('success', res.message);
            cargarMetadatosPDF();
            formElement.reset();
        },
        error: () => mostrarToast('danger', 'Error al subir el PDF.'),
        complete: function () {
            $('#loader-subir-container').hide();
            $(formElement).show();
            $('#btnSubirArchivo').prop('disabled', false);
        }
    });
}

export function cargarMetadatosPDF() {
    console.log("Cargando metadatos PDF");
    const contenedor = $('#pdf-metadata-container');
    const modelType = contenedor.data('model');
    const modelId = contenedor.data('id');

    $('#loader-container').show();
    contenedor.hide();

    let loaderTimeout = setTimeout(() => {console.log("🔵 Loader mostrado");$('#loader-container').fadeIn(200)}, 300);

    $.ajax({
        url: `/admin/archivos/${modelType}/${modelId}`,
        method: 'GET',
        success: function (res) {
            if (res.length === 0) {
                contenedor.html('<div class="card-body p-3">No hay archivos disponibles.</div>');
                return;
            }

            contenedor.html(`
                ${res.map((item) => `
                    <tr>
                        <td>${item.nombre}</td>
                        <td>${item.descripcion}</td>
                        <td>${item.tamaño}</td>
                        <td>${item.tipo}</td>
                        <td>${item.driver}</td>
                        <td>
                        <div class="d-flex gap-1 justify-content-center">
                        <button type="button"
                            class="btn btn-sm btn-danger delete-file-btn"
                            data-id="${item.id}"
                            data-toggle="modal"
                            data-target="#deleteModal">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        <a href="${item.url}" class="btn btn-sm btn-primary" target="_blank">Ver</a>
                        </div>
                        </td>
                    </tr>`).join('')}
            `);
        },
        error: () => contenedor.html(`<div class="alert alert-danger">Error al cargar metadatos.</div>`),
        complete: function () {
            console.log("complete cargado");
            /* Evita que el loader se muestre si la carga es rápida, ejemplo cuando los metadatos solicitados ya estan en caché
            un caso practico cuando salimos a otra ruta y regresamos, el navegador ya tiene la respuesta. */
            clearTimeout(loaderTimeout);
            $('#loader-container').hide();
            console.log("Loader ocultado");
            contenedor.show();
        }
    });
}
