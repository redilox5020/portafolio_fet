@extends('layouts.dashboard_admin')
@section('main')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="h3 mb-2 text-gray-800">Todos los Productos</h3>
        </div>
        @include('productos.partials.product-list')
    </div>
    @include('productos.create')
@endsection
@section('css')
@stack("style")
@endsection
@section('scripts')
@stack("scripts")
@endsection
