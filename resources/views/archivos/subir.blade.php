<x-modal id="modal-subir-archivo" title="Agregar nuevo archivo" size="xl">
    <div id="loader-subir-container" style="display: none;">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status">
            </div>
        </div>
        <p class="text-center mt-2">Subiendo archivo...</p>
    </div>
    <form action="{{ route('archivos.subir', ['modelType'=>$modelType, 'modelId'=>$modelId]) }}" method="post" id="formSubirArchivo" enctype="multipart/form-data">
        <div class="group-form input-group col-auto">
            <label for="pdf_file">Anexar PDF</label>
            <input class="form-control @error('pdf_file') is-invalid @enderror" type="file" name="archivo"
                id="pdf_file" accept="application/pdf">
            <input class="form-control" type="text" name="descripcion" placeholder="Descripción" required />
            @error('pdf_file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="group-form col-auto">
            <div class="input-group">
                <label for="storage_type" class="form-label">Destino del archivo:</label>
                <select name="driver" id="storage_type" class="form-select" required>
                    <option value="cloudinary" {{ old('driver') == 'cloudinary' ? 'selected' : '' }}>Cloudinary (proveedor externo)</option>
                    <option value="local" {{ old('driver', 'local') == 'local' ? 'selected' : '' }}>Almacenamiento local</option>
                </select>
            </div>
            <div class="form-text text-muted">
                Seleccione dónde desea almacenar el archivo PDF del proyecto
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <button id="btnSubirArchivo" type="submit" class="btn btn-primary" form="formSubirArchivo">Subir</button>
    </x-slot>
</x-modal>
