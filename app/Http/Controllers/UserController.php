<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\DataTable\BaseJoinDataTableController;

class UserController extends BaseJoinDataTableController
{

    public function __construct()
    {
        $this->middleware('can:edit-user,user')->only('edit', 'update');
        $this->middleware('can:admin-access')->only('index', 'destroy');

        $this->model = User::class;
        $this->view = 'auth.user.usuarios';
        $this->columns = [
            'users.id',
            'users.name',
            'users.email',
            'roles.name'
        ];
        $this->selectFields = [
            'users.id',
            'users.name',
            'users.email',
            'roles.name as role_name'
        ];
        $this->joins = [
            ['model_has_roles', function($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.model_type', '=', User::class);
            }],
            ['roles', 'model_has_roles.role_id', '=', 'roles.id']
        ];
    }
    protected function transformResults($usuarios)
    {
        return $usuarios->map(function($usuario) {
            return [
                'id' => $usuario->id,
                'nombre' => view('components.opcion-link', ['model' => $usuario, 'route' => 'proyectos', 'param'=>['search'=>$usuario->name]])->render(),
                'email' => $usuario->email,
                'rol' => $usuario->role_name,
                'acciones' => view('components.action-buttons', ['id_model' => $usuario->id, 'route' => 'user', 'is_modal'=>false])->render()
            ];
        });
    }


    public function edit(User $user)
    {
        $roles = Role::all();
        return view('auth.user.editar', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     * ['required', 'email', Rule::unique('users')->ignore($user->id)],
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email,'.$user->id,
            'role' => 'sometimes|string',
        ]);

        $userData = collect($validatedData)->except(['role'])->toArray();

        $user->fill($userData);
        if($user->isDirty()){
            $user->update($userData);
        }
        if($request->has('role') && auth()->user()->can('admin-access')){
            $newRole = $request->input('role');
            if(!$user->hasRole($newRole)){
                $user->syncRoles([$newRole]);
            }
        }
        return redirect()->back()->with('success', 'Usuario actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('users')->with('success', "Usuario eliminado correctamente");
    }
}
