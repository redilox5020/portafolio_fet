@extends('layouts.dashboard_admin')
@section('main')
<!-- 404 Error Text -->
<div class="text-center">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mb-5">Pagina no Encontrada</p>
    <p class="text-gray-500 mb-0">Parece que encontraste un fallo en la matriz...</p>
    <a href="{{ route('inicio') }}">&larr; Ir al inicio</a>
</div>
@endsection
