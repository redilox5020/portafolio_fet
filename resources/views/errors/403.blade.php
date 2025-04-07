@extends('layouts.dashboard_admin')
@section('main')
<!-- 404 Error Text -->
<div class="text-center">
    <div class="error mx-auto" data-text="403">403</div>
    <p class="lead text-gray-800 mb-5">Acceso no autorizado</p>
    <p class="text-gray-500 mb-0">Esta acción no está autorizada.</p>
    <a href="{{ route('inicio') }}">&larr; Ir al inicio</a>
</div>
@endsection
