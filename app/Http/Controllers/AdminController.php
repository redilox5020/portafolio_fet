<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function login(){
        return view('auth.index');
    }
    public function loginPost(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|string',
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$request->has('remember'))){
            return redirect()->route('proyectos');
        };

        return Redirect::back()->withErrors(['email' => 'Email o password incorrecto']);
    }

    public function registerPost(Request $request){
        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed|string',
        ]);
        $user_data = [
            'name' => $validated_data["name"].' '.$validated_data["last_name"],
            'email' => $validated_data["email"],
            'password' => bcrypt($validated_data["password"]),
        ];

            User::create($user_data);

        return redirect()->route('login')->with('success', 'Usuario creado correctamente');
    }
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
