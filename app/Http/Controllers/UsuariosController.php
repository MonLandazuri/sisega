<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class UsuariosController extends Controller
{
    public function index(): View
    {
        return view('usuarios');
    }

    public function mostrarUsuarios()
    {
        $usuarios = User::all();
        
        return view('usuarios', [
            'usuarios' => $usuarios,
        ]);
    }

    public function create()
    {
        return view('users-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|string|in:usuario,admin', // Valida que el rol sea 0 o 1
        ]);

        $username = strtolower(str_replace(' ', '', $request->name));

        $isAdmin = ($request->role === 'admin') ? true : false;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'username' => $username,
            'role' => $request->role, // O el valor que necesites
            'is_admin' => $isAdmin,
        ]);

        return redirect()->route('usuarios')->with('success', 'Usuario creado con éxito.');
    }
}