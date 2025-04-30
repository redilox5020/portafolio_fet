@props(['proyecto'])

<div class="text-truncate-multiline" data-fulltext="{{ htmlspecialchars($proyecto->nombre) }}">
    <a href="{{ route('proyecto.por.codigo', $proyecto->codigo) }}" class="d-block">
        {{ $proyecto->nombre }}
    </a>
</div>
