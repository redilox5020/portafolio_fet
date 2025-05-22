export function mostrarAlerta(tipo, mensaje) {
    const $alert = $('#alert');
    $alert.removeClass('d-none alert-success alert-danger')
        .addClass(`alert-${tipo} alert-dismissible fade show`);
    $alert.find('.alert-message').text(mensaje);
    setTimeout(() => $alert.fadeOut(500), 3000);
}

export function mostrarToast(tipo, mensaje, autohide = true, startNew = false, duracion = 5000) {
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
