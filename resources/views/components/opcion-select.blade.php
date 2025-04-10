<div class="modal fade show" id="modal-{{ $modalId }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route($routeName . '.store') }}" method="post" class="ajax-form"
                data-modal="{{ $modalId }}" data-select="{{ $selectName ?? '' }}"
                data-table="{{ $dataTableId ?? '' }}">
                <div class="modal-header">
                    <h3 class="modal-title">Crear {{ $title }}</h3>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="alert-{{ $modalId }}" class="alert alert-dismissible fade show d-none" role="alert">
                        <span class="alert-message"></span>
                    </div>
                    @csrf
                    <div class="group-form input-group">
                        <label for="{{ $modalId !== 'programa' ? 'opcion' : 'nombre' }}">{{ $title }}</label>
                        <input class="form-control" type="text"
                            name="{{ $modalId !== 'programa' ? 'opcion' : 'nombre' }}" required>
                    </div>
                    @if ($modalId === 'programa')
                        <div class="group-form input-group">
                            <label for="sufijo">Sufijo</label>
                            <input class="form-control" type="text" name="sufijo" required>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
