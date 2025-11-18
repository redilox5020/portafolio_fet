<x-modal id="modal-crear-investigador" title="Agregar Investigador" size="xl">
    <div id="alert-investigador" class="alert alert-dismissible fade show d-none" role="alert">
        <span class="alert-message"></span>
    </div>
    <form action="{{ route('investigador.store') }}" method="post" class="ajax-form"
    data-modal="investigador" data-select="tipologia_id"
    data-table="investigadorTable" id="formInvestigador">
        @csrf

        <div class="row g-2">
            <div class="col-md-6">
                <label class="form-label small">Nombre completo *</label>
                <input class="form-control form-control-sm" type="text" name="nombre"
                    placeholder="Nombre y apellido del investigador" required="">
            </div>
            <div class="col-md-6">
                <label class="form-label small">Email *</label>
                <input class="form-control form-control-sm" type="email" name="email"
                    placeholder="correo@ejemplo.com" required="">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Tipo Documento</label>
                <select class="form-control form-control-sm" name="tipo_documento">
                    <option value="">Seleccionar</option>
                    <option value="CC">Cédula</option>
                    <option value="TI">Tarjeta Identidad</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Número Documento</label>
                <input class="form-control form-control-sm" type="text" name="documento"
                    placeholder="Número de documento">
            </div>
            <div class="col-md-6">
                <label class="form-label small">Teléfono</label>
                <input class="form-control form-control-sm" type="tel" name="telefono"
                    placeholder="Número de contacto">
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-secondary volver-modal-anterior" type="button" disabled>Volver</button>
        <button type="submit" class="btn btn-primary" form="formInvestigador">Guardar cambios</button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
$(document).on('click', '#btn-abrir-modal-crear-investigador', function () {
    const form = $('#formInvestigador')[0];
    form.reset();
    $('#formInvestigador').attr('action', '{{ route('investigador.store') }}');
});
$(document).on('click', '.edit-btn', function () {
    console.log('click')
    const id = $(this).data('id');

    console.log(id);

    $.ajax({
        url: `/admin/investigadores/${id}/view`,
        method: 'GET',
        success: function (investigador) {
            $('#formInvestigador input[name="nombre"]').val(investigador.nombre);
            $('#formInvestigador input[name="email"]').val(investigador.email);
            $('#formInvestigador select[name="tipo_documento"]').val(investigador.tipo_documento).trigger('change');
            $('#formInvestigador input[name="documento"]').val(investigador.documento);
            $('#formInvestigador input[name="telefono"]').val(investigador.telefono);


            const updateRouteTemplate = @json(route('investigador.update', ['investigador_id' => '__ID__']));
            let action = updateRouteTemplate.replace('__ID__', id);
            $('#formInvestigador').attr('action', action);

            if(!$('#formInvestigador input[name="_method"]').length)
                $('#formInvestigador').append('<input type="hidden" name="_method" value="PUT">');
        },
        error: function () {
            alert('Error al cargar el producto.');
        }
    });
});
</script>
@endpush
