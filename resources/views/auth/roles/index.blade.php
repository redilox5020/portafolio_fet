{{-- @extends("layouts.dashboard_admin")
@section("main")
<div class="card">
    <div class="card-header">
        <h2>Administrar Roles</h2>
    </div>

    <div class="card-body" style="display: flex; flex-wrap: wrap; justify-content: space-around">
        <!-- Formulario para crear nuevo rol -->
        <form method="POST" action="{{ route('roles.store') }}">
            @csrf
            <div class="form-group">
                <label>Nombre del Rol</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <h4>Permisos</h4>
            @foreach($permissions as $permission)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                    <label class="form-check-label">{{ $permission->name }}</label>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary mt-3">Crear Rol</button>
        </form>


        <div class="container">
            <!-- Lista de roles existentes -->
            <h3>Roles Existentes</h3>
            <div style="display: flex; gap: 10px; flex-wrap: wrap">

                @foreach($roles as $role)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>{{ $role->name }}</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('roles.update', $role->id) }}">
                                @csrf @method('PUT')
                                @foreach($permissions as $permission)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                               value="{{ $permission->name }}"
                                               {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                                <button type="submit" class="btn btn-sm btn-info mt-2">Actualizar Permisos</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection
@section('css')
@endsection
@section('scripts')
@endsection
 --}}
 @extends("layouts.dashboard_admin")
@section("main")
<div class="card">
    <div class="card-header">
        <h2>Administrar Roles</h2>
    </div>

    <div class="row g-0">
        <div class="col-md-3">
            <div class="card-body">
                <!-- Formulario para crear nuevo rol -->
                  <form method="POST" action="{{ route('roles.store') }}">
                      @csrf
                      <div class="form-group">
                          <label>Nombre del Rol</label>
                          <input type="text" name="name" class="form-control" required>
                      </div>

                      <h4>Permisos</h4>
                      @foreach($permissions as $permission)
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                              <label class="form-check-label">{{ $permission->name }}</label>
                          </div>
                      @endforeach

                      <button type="submit" class="btn btn-primary mt-3">Crear Rol</button>
                  </form>
            </div>
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h3>Roles Existentes</h3>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: space-between;">

                @foreach($roles as $role)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>{{ $role->name }}</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('roles.update', $role->id) }}">
                                @csrf @method('PUT')
                                @foreach($permissions as $permission)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                               value="{{ $permission->name }}"
                                               {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                                <button type="submit" class="btn btn-sm btn-info mt-2">Actualizar Permisos</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
          </div>
        </div>
    </div>


</div>
@endsection
@section('css')
@endsection
@section('scripts')
@endsection

