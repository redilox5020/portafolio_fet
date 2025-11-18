import { initSelectsDependientes, agregarOpcionSelectDependiente } from './select-dependientes';

if (typeof $ === 'undefined') {
    throw new Error('jQuery debe cargarse antes de este script');
}

window.agregarOpcionSelectDependiente = agregarOpcionSelectDependiente;

$(document).ready(function () {
    // ==================== TOOLTIPS ====================
    if ($.fn.tooltip && $.fn.tooltip.Constructor) {
        const defaultOptions = $.fn.tooltip.Constructor.Default;

        if (defaultOptions) {
            defaultOptions.trigger = 'hover';
            defaultOptions.delay = { show: 150, hide: 100 };
            defaultOptions.boundary = 'window';
        } else {
            console.warn('No se pudo acceder a $.fn.tooltip.Constructor.Default para modificar los tooltips.');
        }
    } else {
        console.warn('Bootstrap tooltips no están cargados correctamente.');
    }


    const initTooltips = (context) => {
        $(context).find('[data-toggle="tooltip"]').each(function() {
            const $el = $(this);
            $el.tooltip('dispose');
            $el.tooltip({
                title: $el.attr('data-original-title') || $el.attr('title')
            });
        });
    };

    initTooltips(document);

    $(document).on('draw.dt', function(e, settings) {
        setTimeout(() => initTooltips(settings.nTable), 50);
    });

    $(document).on('mouseenter', '[data-toggle="tooltip"]', function() {
        $(this).tooltip('show');
    });

    // ==================== GESTIÓN DE MODALES ====================
    $('[data-target="#modal-tipologia"]').on('click', function () {
        let targetModal = $(this).data('target');
        let desde = $(this).data('desde') ?? 'externo';
        let paddingRight = $('body').css('padding-right');

        $('#modal-crear-producto').modal('hide');

        $('#modal-crear-producto').on('hidden.bs.modal', function () {
            $('body').addClass('modal-open').css('padding-right', paddingRight);
            $('#modal-crear-producto').off('hidden.bs.modal');
        });

        $(targetModal).attr('data-desde', desde);
    });

    // Stack de modales para navegación
    let modalStack = [];
    $('[id^="modal-"]').on('show.bs.modal', function () {
        const id = $(this).attr('id');

        modalStack = modalStack.filter(modalId => modalId !== id);
        modalStack.push(id);

        const hayAnterior = modalStack.length > 1;
        const $btnVolver = $(this).find('.volver-modal-anterior');
        $btnVolver.prop('disabled', !hayAnterior);

        console.log('Stack actualizado:', modalStack);
    });

    $('.volver-modal-anterior').on('click', function () {
        const modalActual = $('.modal.show');
        const idActual = modalActual.attr('id');

        modalActual.modal('hide');

        modalActual.on('hidden.bs.modal', function () {
            modalStack.pop();
            const idAnterior = modalStack[modalStack.length - 1];

            console.log('Volver a modal:', idAnterior);

            if (idAnterior) {
                $('#' + idAnterior).modal('show');
            }
            modalActual.off('hidden.bs.modal');
        });
    });

    // ==================== CARGA DINÁMICA DE SELECTS ====================
    function cargarOpcionesSelect($select, $loading) {
        const endpoint = $select.data('endpoint');

        if (!endpoint) {
            console.warn('Select sin endpoint definido:', $select);
            return;
        }

        if ($loading && $loading.length) {
            $loading.removeClass('d-none');
        }

        $select.prop('disabled', true);

        $.ajax({
            url: endpoint,
            method: 'GET',
            success: function (data) {
                $select.find('option:not(:first)').remove();

                $.each(data, function (index, item) {
                    $select.append(new Option(item.opcion, item.id));
                });

                if ($loading && $loading.length) {
                    $loading.addClass('d-none');
                }

                $select.prop('disabled', false);
                console.log('Opciones cargadas:', data.length);
            },
            error: function (xhr) {
                console.error('Error al cargar opciones:', xhr);

                if ($loading && $loading.length) {
                    $loading.removeClass('d-none text-muted')
                        .addClass('text-danger')
                        .html('<i class="fas fa-exclamation-circle"></i> Error al cargar opciones');

                    setTimeout(() => {
                        $loading.addClass('d-none');
                    }, 3000);
                }

                $select.prop('disabled', false);
            }
        });
    }

    // Cargar opciones cuando se abre el modal de procedenciaCodigo
    $('#modal-procedenciaCodigo').on('show.bs.modal', function () {
        const $select = $(this).find('select[data-endpoint]');
        const $loading = $('#procedencia-loading');

        if ($select.length && $select.find('option').length <= 1) {
            cargarOpcionesSelect($select, $loading);
        }
    });

    // Cargar opciones en selects visibles al cargar la página
    $('select[data-endpoint]').each(function() {
        const $this = $(this);
        if ($this.is(':visible') && $this.find('option').length <= 1) {
            const selectId = $this.attr('id');
            const $loading = $(`#${selectId}-loading`);
            cargarOpcionesSelect($this, $loading);
        }
    });

    // ==================== FORMULARIOS AJAX ====================
    $('.ajax-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let actionUrl = form.attr('action');
        let modalId = form.data('modal');
        let selectName = form.data('select');
        let tableId = form.data('table');
        let formData = form.serialize();

        console.log('Enviando formulario:', formData);

        const $submitBtn = form.find('button[type="submit"]');
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            success: function (response) {
                let $alert = $('#alert-' + modalId);
                $alert.stop(true, true)
                    .removeClass('d-none alert-danger')
                    .addClass('alert-success alert-dismissible fade show')
                    .hide()
                    .fadeIn(500);
                $alert.find('.alert-message').text(response.success);

                setTimeout(function () {
                    $alert.stop(true, true)
                        .fadeOut(500)
                        .queue(function(next) {
                            $(this).addClass('d-none');
                            next();
                        });
                }, 3000);

                let nuevaOpcion = response.data;
                if (selectName) {
                    if (typeof window.agregarOpcionSelectDependiente === 'function') {
                        const agregado = window.agregarOpcionSelectDependiente(selectName, nuevaOpcion);

                        if (!agregado) {
                            let $select = $('select[id="' + selectName + '"]');
                            console.log($select.data('model'),nuevaOpcion.model);
                            if ($select.length && $select.data('model') === nuevaOpcion.model) {
                                $select.append(new Option(nuevaOpcion.label, nuevaOpcion.id));
                                $select.val(nuevaOpcion.id).trigger('change');
                            }
                        }
                    } else {
                        let $select = $('select[id="' + selectName + '"]');
                        if ($select.length && $select.data('model') === nuevaOpcion.model) {
                            $select.append(new Option(nuevaOpcion.label, nuevaOpcion.id));
                            $select.val(nuevaOpcion.id).trigger('change');
                        }
                    }
                }

                if (tableId && $.fn.DataTable && $.fn.DataTable.isDataTable('#' + tableId)) {
                    $('#' + tableId).DataTable().ajax.reload(null, false, () => {
                        initTooltips('#' + tableId);
                    });
                }

                form[0].reset();

                $submitBtn.prop('disabled', false).html('Guardar');
            },
            error: function (xhr) {
                let $alert = $('#alert-' + modalId);
                $alert.removeClass('d-none alert-success')
                    .addClass('alert-danger alert-dismissible fade show');

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    $.each(errors, function (key, value) {
                        errorMessages += value + '<br>';
                    });
                    $alert.find('.alert-message').html(errorMessages);
                } else {
                    $alert.find('.alert-message').text('Error en la petición AJAX');
                }

                $submitBtn.prop('disabled', false).html('Guardar');
            }
        });
    });

    // ==================== ALERTAS DE SESIÓN ====================
    let $alert = $('#session-alert');
    if ($alert.length) {
        setTimeout(function () {
            $alert.fadeOut(500);
        }, 3000);
    }

    initSelectsDependientes();
});
