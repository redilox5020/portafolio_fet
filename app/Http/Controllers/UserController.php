<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Spatie\Permission\Models\Role;

use App\Models\Procedencia;
use App\Models\ProcedenciaCodigo;
use App\Models\Tipologia;
use App\Models\Programa;
use App\Models\Proyecto;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:edit-user,user')->only('edit', 'update');
        $this->middleware('can:admin-access')->only('index', 'destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $search = $request->input('search.value');
            $orderColumn = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir');

            $query = User::select(["id", "name", "email"]);

            //Búsqueda
            if(!empty($search)){
                $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            }

            //Ordenamiento
            $columns = ['id', 'name', 'email'];
            if(isset($columns[$orderColumn])) {
                $orderField = $columns[$orderColumn];
                $query->orderBy($orderField, $orderDir);
            }

            $total = $query->count();
            $usuarios = $query->skip($start)->take($length)->get();

            $data = $usuarios->map(function($usuario){
                $csrfToken = csrf_token();
                return [
                    'id' => $usuario->id,
                    'nombre'=> $usuario->name,
                    'email'=> $usuario->email,
                    'acciones'=> '<div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <a href="'.route('user.edit', $usuario->id).'" class="btn btn-success btn-circle">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a  class="btn btn-danger btn-circle delete-btn"
                                    data-id="'.$usuario->id.'"
                                    data-toggle="modal"
                                    data-target="#deleteModal">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>'
                ];
            });

            return response()->json([
                'draw'=> $request->input('draw'),
                'recordsTotal' => User::count(),
                'recordsFiltered' => $total,
                'data' => $data
            ]);
        }
        $usuarios = User::paginate();

        return view('auth.user.usuarios', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
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
