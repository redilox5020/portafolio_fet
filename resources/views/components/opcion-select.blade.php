<div id="modal-{{ $modalId }}" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Crear {{ $title }}</h1>
        <form action="{{ route($routeName . '.store') }}" method="post">
            @csrf
            <div>
                <label for="{{ $modalId !== 'programa' ? 'opcion' : 'nombre' }}">{{ $title }}</label>
                <input type="text" name="{{ $modalId !== 'programa' ? 'opcion' : 'nombre' }}" required>
            </div>
            @if ($modalId === 'programa')
            <div>
                <label for="sufijo">Sufijo</label>
                <input type="text" name="sufijo" required>
            </div>
            @endif
            <button type="submit">Guardar</button>
        </form>
    </div>
</div>
