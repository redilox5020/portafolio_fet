/**
 * Sistema de gestión de selects dependientes
 * Maneja la carga dinámica de opciones basadas en un select padre
 */

export default class SelectsDependientes {
    constructor() {
        this.selectsConfig = {
            procedencia_detalle_id: {
                parent: 'procedencia_id',
                endpoint: '/admin/procedencia-codigos/{parentId}',
                emptyMessage: 'No hay detalles disponibles para esta procedencia',
                placeholderMessage: 'Selecciona un detalle',
                initialMessage: 'Primero selecciona una procedencia',
                required: true
            }
        };

        this.init();
    }

    /**
     * Inicializa los selects dependientes
     */
    init() {
        const self = this;

        $.each(this.selectsConfig, function(childName, config) {
            const $childSelect = $(`select[name="${childName}"]`);
            const $parentSelect = $(`select[id="${config.parent}"]`);

            if ($childSelect.length && $parentSelect.length) {
                $childSelect.attr('data-parent', config.parent);
                $childSelect.attr('data-model', childName.replace('_id', ''));

                const valorAnterior = $childSelect.data('old-value') || $childSelect.val();

                if ($parentSelect.val()) {
                    self.cargarOpciones($childSelect, $parentSelect.val(), config, valorAnterior);
                } else {
                    self.resetSelectHijo($childSelect, config.initialMessage);
                }

                $parentSelect.on('change', function() {
                    const parentValue = $(this).val();
                    if (parentValue) {
                        self.cargarOpciones($childSelect, parentValue, config);
                    } else {
                        self.resetSelectHijo($childSelect, config.initialMessage);
                    }
                });
            }
        });
    }

    /**
     * Resetea el select hijo a su estado inicial
     */
    resetSelectHijo($select, mensaje) {
        $select.html(`<option value="" disabled selected>-- ${mensaje} --</option>`);
        $select.prop('disabled', true);
        $select.removeAttr('required');
    }

    /**
     * Carga las opciones del select hijo vía AJAX
     */
    cargarOpciones($select, parentId, config, seleccionado = null) {
        if (!parentId) {
            this.resetSelectHijo($select, config.initialMessage);
            return;
        }

        $select.html('<option value="" disabled selected>Cargando...</option>');
        $select.prop('disabled', true);

        const endpoint = config.endpoint.replace('{parentId}', parentId);

        $.ajax({
            url: endpoint,
            method: 'GET',
            success: function(data) {
                if (data.length === 0) {
                    $select.html(`<option value="" disabled selected>-- ${config.emptyMessage} --</option>`);
                    $select.prop('disabled', true);
                    $select.removeAttr('required');
                    return;
                }

                let options = `<option value="" disabled selected>-- ${config.placeholderMessage} --</option>`;

                $.each(data, function(index, item) {
                    const selected = seleccionado == item.id ? 'selected' : '';
                    options += `<option value="${item.id}" ${selected} data-parent-id="${parentId}">${item.opcion}</option>`;
                });

                $select.html(options);
                $select.prop('disabled', false);

                if (config.required) {
                    $select.attr('required', 'required');
                }

                console.log(`Opciones cargadas para ${$select.attr('name')}:`, data.length);
            },
            error: function(xhr) {
                console.error('Error al cargar opciones:', xhr);
                $select.html('<option value="" disabled selected>-- Error al cargar detalles --</option>');
                $select.prop('disabled', true);
                $select.removeAttr('required');
            }
        });
    }

    /**
     * Agrega una nueva opción al select si corresponde
     */
    agregarOpcion(selectName, nuevaOpcion) {
        const $select = $(`select[name="${selectName}"]`);

        if (!$select.length) {
            console.warn('Select no encontrado:', selectName);
            return false;
        }

        const config = this.selectsConfig[selectName];

        if (!config) {
            console.warn('Configuración no encontrada para:', selectName);
            return false;
        }

        const $parentSelect = $(`select[name="${config.parent}"]`);
        const parentValue = $parentSelect.val();

        if (!parentValue) {
            console.log('No hay padre seleccionado');
            return false;
        }

        if (!nuevaOpcion.parent_id || parentValue != nuevaOpcion.parent_id) {
            console.log('El registro no pertenece al padre seleccionado');
            return false;
        }

        if ($select.prop('disabled')) {
            $select.prop('disabled', false);
            if (config.required) {
                $select.attr('required', 'required');
            }
        }

        if ($select.find('option').length === 1) {
            $select.find('option:first').text(`-- ${config.placeholderMessage} --`);
        }

        const $newOption = $('<option></option>')
            .val(nuevaOpcion.id)
            .text(nuevaOpcion.label)
            .attr('data-parent-id', nuevaOpcion.parent_id);

        $select.append($newOption);
        $select.val(nuevaOpcion.id).trigger('change');

        console.log('Nueva opción agregada:', nuevaOpcion.label);
        return true;
    }
}

let instance = null;

export function initSelectsDependientes() {
    if (!instance) {
        instance = new SelectsDependientes();
    }
    return instance;
}

export function agregarOpcionSelectDependiente(selectName, nuevaOpcion) {
    if (!instance) {
        console.warn('SelectsDependientes no está inicializado');
        return false;
    }
    return instance.agregarOpcion(selectName, nuevaOpcion);
}
