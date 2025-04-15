<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin-access');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        $permissions = Permission::all();
        return view('auth.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array',
        ]);
        /* En caso de manajar permisos por id
        $newPermissions = collect($request->permissions)->map(fn($id) => (int) $id)->unique()->sort()->values();
        $currentPermissions = $role->permissions->pluck('id')->sort()->values(); */

        // Normaliza entrada
        $newPermissions = collect($request->permissions)
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $currentPermissions = $role->permissions
            ->pluck('name')
            ->sort()
            ->values();


        if ($newPermissions->toArray() === $currentPermissions->toArray()) {
            return redirect()->route('roles.index')->with('info', 'No hubo cambios en los permisos.');
        }

        // diff -> Devuelve un nuevo arreglo con todos los elementos de la izquierda que no esten en el de la derecha.
        // ej: newPermissions = [2,3,4,5]; currentPermissions: [1,2,3,4]
        $toAdd = $newPermissions->diff($currentPermissions);    // [5]
        $toRemove = $currentPermissions->diff($newPermissions); // [1]

        if ($toAdd->isNotEmpty()) {
            $role->givePermissionTo($toAdd);
        }

        if ($toRemove->isNotEmpty()) {
            // Obtiene todos los permisios que estan en el array de nombres
            $permissionsToRevoke = Permission::whereIn('name', $toRemove->toArray())->get();
            $role->revokePermissionTo($permissionsToRevoke);
        }
        /* $role->syncPermissions($request->permissions); > No es optimo; Porque Elimina todos los registros (detach) e inserta un nuevo array (attach)
        sin verificar si este cambia con respecto a los que ya teniamos */

        return redirect()->route('roles.index')->with('success', 'Permisos actualizados');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rol = Role::findOrFail($id);

        if ($rol->users()->exists()){
            return redirect()->back()->withErrors(['error' => "No se puede eliminar {$rol->name} porque está asociado a uno o más usuarios."]);
        }

        $rol->delete();

        return redirect()->back()->with('success', "Rol eliminado correctamente.");
    }
}
