<x-modal id="modal-crear-producto" title="Agregar producto resultante" size="xl">
    <div id="alert-producto" class="alert alert-dismissible fade show d-none" role="alert">
        <span class="alert-message"></span>
    </div>
    <form action="{{ route('productos.store') }}" method="post" class="ajax-form"
    data-modal="producto" data-select="tipologia_id"
    data-table="productoTable" id="formProducto">
        @csrf
        <input type="hidden" name="proyecto_id" id="proyecto_id" value="{{ $proyecto_id }}">
        <div class="group-form input-group">
            <label for="titulo_producto">Titulo</label>
            <input
                class="form-control"
                type="text"
                name="titulo"
                id="titulo_producto"
                placeholder="Ingresa el nombre del producto"
                required>
        </div>
        <div class="group-form input-group">
            <label for="tipologia_id">Tipología:</label>
            <select class="form-select @error('tipologia_id') is-invalid @enderror" id="tipologia_id"
                name="tipologia_id" data-model="producto" required>
                <option value="" disabled
                    {{ old('tipologia_id', $producto->tipologia->id ?? '') == '' ? 'selected' : '' }}>
                    -- Selecciona una tipología --
                </option>
                @foreach ($tipologias as $tipologia)
                    <option value="{{ $tipologia->id }}" @selected(old('tipologia_id', $producto->tipologia->id ?? '') == $tipologia->id)>
                        {{ $tipologia->opcion }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tipologia" data-desde="modal-crear-producto"><i
                    class="fa-solid fa-plus"></i></button>
            @error('procedencia_codigo_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="group-form input-group">
            <label for="enlace_recurso">Enlace</label>
            <input
                class="form-control"
                type="text"
                name="enlace"
                id="enlace_recurso"
                placeholder="Ingresa el enlace del producto (repositorio, web, etc.)"
                required>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect2">Seleccionar Autores: </label>
            <select multiple class="form-control"  name="autores_ids[]" id="exampleFormControlSelect2">
                @foreach ($investigadores as $investigador)
                <option value="{{ $investigador->id }}">{{ $investigador->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="descripcion_producto">Descripcion</label>
            <textarea
                class="form-control"
                id="descripcion_producto"
                name="descripcion"
                placeholder="Ingresa una breve descripción del producto"
                rows="3"></textarea>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-secondary volver-modal-anterior" type="button" disabled>Volver</button>
        <button type="submit" class="btn btn-primary" form="formProducto">Guardar cambios</button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
$(document).on('click', '#btn-abrir-modal-crear-producto', function () {
    const form = $('#formProducto')[0];
    form.reset();
    $('#formProducto select[name="autores_ids[]"]').val([]).trigger('change');
    $('#formProducto input[name="_method"]').remove();
    $('#formProducto').attr('action', '{{ route('productos.store') }}');
});
$(document).on('click', '.edit-btn', function () {
    const id = $(this).data('id');

    console.log(id);

    $.ajax({
        url: `/admin/productos/${id}/view`,
        method: 'GET',
        success: function (producto) {
            console.log(producto);
            $('#formProducto input[name="titulo"]').val(producto.titulo);
            $('#formProducto select[name="tipologia_id"]').val(producto.tipologia_id).trigger('change');
            $('#formProducto input[name="enlace"]').val(producto.enlace);
            $('#formProducto textarea[name="descripcion"]').val(producto.descripcion);

            const $autoresSelect = $('#formProducto select[name="autores_ids[]"]');
            $autoresSelect.val([]); // deselecciona todos
            if (producto.autores && Array.isArray(producto.autores)) {
                $autoresSelect.val(producto.autores.map((autor)=>autor.id));
            }


            const updateRouteTemplate = @json(route('productos.update', ['producto_id' => '__ID__']));
            let action = updateRouteTemplate.replace('__ID__', id);
            $('#formProducto').attr('action', action);

            if(!$('#formProducto input[name="_method"]').length)
                $('#formProducto').append('<input type="hidden" name="_method" value="PUT">');
        },
        error: function () {
            alert('Error al cargar el producto.');
        }
    });
});
</script>
@endpush
