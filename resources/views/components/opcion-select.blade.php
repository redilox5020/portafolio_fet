<div id="modal-{{ $modalId }}" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Crear {{ $title }}</h1>
        <form action="{{ route($routeName . '.store') }}" method="post">
            @csrf
            <div class="group-form input-group">
                <label for="{{ $modalId !== 'programa' ? 'opcion' : 'nombre' }}">{{ $title }}</label>
                <input class="form-control" type="text" name="{{ $modalId !== 'programa' ? 'opcion' : 'nombre' }}" required>
            </div>
            @if ($modalId === 'programa')
            <div class="group-form input-group">
                <label for="sufijo">Sufijo</label>
                <input class="form-control" type="text" name="sufijo" required>
            </div>
            @endif
            <button type="submit">Guardar</button>
        </form>
    </div>
</div>
