@extends('layouts.dashboard_admin')

@section('main')
    <h1 class="h3 mb-2 text-gray-800">Gestión de Rutas y Permisos</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Rutas</h6>
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
                <div id="session-alert" class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="routesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>URI</th>
                            <th>Métodos</th>
                            <th>Permiso en Archivo</th>
                            <th>Permiso en BD</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routes as $route)
                            <tr>
                                <td>{{ $route['name'] }}</td>
                                <td>{{ $route['uri'] }}</td>
                                <td>{{ implode(', ', $route['methods']) }}</td>
                                <td>
                                    @if ($route['file_permission'])
                                        <span class="badge badge-primary">{{ $route['file_permission'] }}</span>
                                    @else
                                        <span class="badge badge-secondary">Ninguno</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($route['db_permission'])
                                        <span class="badge badge-success">{{ $route['db_permission'] }}</span>
                                    @else
                                        <span class="badge badge-secondary">Ninguno</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!$route['file_permission'])
                                        {{-- Solo permitir editar si no tiene permiso en archivo --}}
                                        <button class="btn btn-sm btn-primary edit-permission"
                                            data-route="{{ $route['name'] }}"
                                            data-current-permission="{{ $route['db_permission'] ?? '' }}">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                    @else
                                        <span class="text-muted">Definido en archivo</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPermissionModal" tabindex="-1" role="dialog"
        aria-labelledby="editPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="permissionForm" method="POST" action="{{ route('routes.update-permissions') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPermissionModalLabel">Editar Permiso para Ruta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="route_name" id="routeName">
                        <div class="form-group">
                            <label for="permissionSelect">Permiso Requerido</label>
                            <select class="form-control" id="permissionSelect" name="permission">
                                <option value="">Ningún permiso requerido</option>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission }}">{{ $permission }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.edit-permission').click(function() {
                let routeName = $(this).data('route');
                let currentPermission = $(this).data('current-permission');

                $('#routeName').val(routeName);
                $('#permissionSelect').val(currentPermission);

                $('#editPermissionModal').modal('show');
            });
        });
    </script>
@endsection
