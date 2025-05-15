<div class="modal fade" id="modal-{{ $modalId }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route($routeName . '.store') }}" method="post" class="ajax-form"
                data-modal="{{ $modalId }}" data-select="{{ $selectName ?? '' }}"
                data-table="{{ $dataTableId ?? '' }}">
                @csrf
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
                    @php
                        $inputName = $modalId !== 'programa' ? 'opcion' : 'nombre';
                    @endphp
                    <div class="group-form input-group">
                        <label for="{{ $inputName }}">{{ $title }}</label>
                        <input class="form-control" type="text" name="{{ $inputName }}" id="{{ $inputName }}" required>
                    </div>
                    @if ($modalId === 'programa')
                        <div class="group-form input-group">
                            <label for="sufijo">Sufijo</label>
                            <input class="form-control" type="text" name="sufijo" id="sufijo" required>
                        </div>
                    @elseif ($modalId === 'tipologia')
                    <div class="row">
                        <label for="roles" class="col-sm-4 col-form-label pl-3">Elegir Modelo:</label>
                        <div class="col-sm-8">
                                <div class="form-check">
                                    <input id="proyecto_model" class="form-check-input" type="radio" name="model_type" value="proyecto" checked>
                                    <label for="proyecto_model" class="form-check-label">
                                        Proyecto
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input id="producto_model" class="form-check-input" type="radio" name="model_type" value="producto">
                                    <label for="producto_model" class="form-check-label">
                                        Producto
                                    </label>
                                </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">

                    <button class="btn btn-secondary volver-modal-anterior" type="button" disabled>Volver</button>

                    <button class="btn btn-success" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
