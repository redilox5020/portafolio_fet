<div class="card border-info shadow">
    <div class="card-header bg-info text-white">
        <h6 class="m-0 font-weight-bold">Ficheros en este {{ $modelType }}:</h6>
    </div>
    <div id="loader-container" style="display: none;">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status">
            </div>
        </div>
        <p class="text-center mt-2">Cargando archivos...</p>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm mb-0">
                <colgroup>
                    <col style="width: 22.74%;">
                    <col style="width: 37.9%;">
                    <col style="width: 7.58%;">
                    <col style="width: 7.58%;">
                    <col style="width: 7.58%;">
                    <col style="width: 7.58%;">
                </colgroup>
                <thead><tr>
                    <th>Fichero</th><th>Descripción</th><th>Tamaño</th><th>Formato</th><th>Destino</th><th>Acciones</th>
                </tr></thead>
                <tbody id="pdf-metadata-container" data-model="{{ $modelType }}" data-id="{{ $model->id }}">
                </tbody>
            </table>
        </div>
    </div>

</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on("click", ".delete-file-btn", function() {
                let file_id = $(this).data("id");
                let deleteUrl = "{{ route('archivos.eliminar', ':id') }}".replace(':id', file_id);
                $("#deleteForm").attr("action", deleteUrl);
            });
        })
    </script>
@endpush
