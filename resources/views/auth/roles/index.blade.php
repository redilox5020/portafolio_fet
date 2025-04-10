@extends('layouts.dashboard_admin')
@section('main')
    <div class="card">
        <div class="card-header">
            <h2>Administrar Roles</h2>
        </div>

        <div class="row g-0">
            <div class="col-lg-auto">
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
                        <div id="session-alert" class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Formulario para crear nuevo rol -->
                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Nombre del Rol</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <h4>Permisos</h4>
                        @foreach ($permissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    value="{{ $permission->name }}">
                                <label class="form-check-label">{{ $permission->name }}</label>
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary mt-3">Crear Rol</button>
                    </form>
                </div>
            </div>
            <div class="col-md">
                <div class="card-body">
                    <h3>Roles Existentes</h3>
                    <div class="container_grid">

                        @foreach ($roles as $role)
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ $role->name }}</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                                        @csrf @method('PUT')
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                    value="{{ $permission->name }}"
                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                        <button type="submit" class="btn btn-sm btn-info mt-2">Actualizar Permisos</button>
                                        <a class="btn btn-sm btn-danger delete-btn mt-2" data-id="{{ $role->id }}"
                                            data-toggle="modal" data-target="#deleteModal">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{ $roles->links('pagination::bootstrap-4') }}
            </div>
        </div>

    </div>
@endsection
@section('css')
    <style>
        .container_grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-right: -.75rem;
            margin-left: -.75rem;
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on("click", ".delete-btn", function() {
                let userId = $(this).data("id");
                let deleteUrl = "{{ route('roles.delete', ':id') }}".replace(':id', userId);
                $("#deleteForm").attr("action", deleteUrl);
            });
        })
    </script>
@endsection
