<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class InicioController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Asegúrate de que tu vista se llama login.blade.php
    }

    /**
     * Procesa la solicitud de inicio de sesión del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Autenticación exitosa
            $request->session()->regenerate();
            return redirect()->intended('/'); // Redirige a la página 'home' o a la URL que el usuario intentó acceder
        }

        // Autenticación fallida
        return Redirect::back()->withErrors(['email' => 'Las credenciales proporcionadas son incorrectas.']);
    }

    /**
     * Muestra la página de inicio para usuarios autenticados.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('inicio'); // Crea una vista llamada home.blade.php
    }

    /**
     * Cierra la sesión del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
