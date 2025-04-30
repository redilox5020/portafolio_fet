@props(['id_model', 'route'])

<div class="d-flex flex-wrap gap-1 justify-content-center">
    <a href="{{ route($route.'.edit', $id_model) }}" class="btn btn-success btn-circle">
        <i class="fa-solid fa-pen"></i>
    </a>

    <button type="button"
        class="btn btn-danger btn-circle delete-btn"
        data-id="{{ $id_model }}"
        data-toggle="modal"
        data-target="#deleteModal">
        <i class="fa-solid fa-trash"></i>
    </button>
</div>
