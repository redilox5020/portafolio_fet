@props(['model', 'route', 'param'])

<div class="text-truncate-multiline" data-fulltext="{{ htmlspecialchars($model->name ?? $model->nombre) }}">
    <a href="{{ route($route, $param) }}" class="d-block">
        {{ $model->name?? $model->nombre }}
    </a>
</div>
