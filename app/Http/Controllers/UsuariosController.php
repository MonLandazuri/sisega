<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;

class UsuariosController extends Controller
{
    public function index(): View
    {
        return view('usuarios');   //carga la vista dashboard.blade.php
    }

    public function mostrarUsuarios()
    {
        $usuarios = User::all();
        
        return view('usuarios', [
            'usuarios' => $usuarios,
        ]);
    }
}