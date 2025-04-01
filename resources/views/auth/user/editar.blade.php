@extends('layouts.dashboard_admin')
@section('main')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="h3 mb-2 text-gray-800">Editar Usuario</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('user.update', $user->id) }}" class="formulario__register" method="POST">
                @csrf @method('PUT')

                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="name" placeholder="Nombre"
                            value="{{ $user->name }}">
                    </div>
                </div>
                {{--                 <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Apellido</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="last_name" placeholder="Apellido">
                    </div>
                </div> --}}
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Correo Electronico</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="email" name="email" placeholder="Correo Electronico"
                            value="{{ $user->email }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-sm-2 col-form-label">Elegir Rol</label>
                    <div class="col-sm-10">
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" value="{{ $role->name }}"
                                    {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $role->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>


                <button class="btn btn-success" type="submit">Actualizar</button>
            </form>
        </div>
    </div>
@endsection
@section('css')
@endsection
@section('scripts')
@endsection
