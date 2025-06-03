<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Para acceder al usuario autenticado
use Illuminate\Support\Facades\Hash; // Para hashear la nueva contraseña
use Illuminate\Validation\ValidationException; // Para manejar errores de validación específicos

class PerfilController extends Controller
{
    /**
     * Muestra el formulario para cambiar la contraseña.
     *
     * @return \Illuminate\View\View
     */
    public function editPassword()
    {
        return view('usuarios.editar-password'); // La vista donde estará el formulario
    }

    /**
     * Actualiza la contraseña del usuario autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        // 1. Validar las entradas del formulario
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' asegura que 'password_confirmation' coincida
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La nueva contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        // 2. Verificar que la contraseña actual sea correcta
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => __('La contraseña actual es incorrecta.'),
            ]);
        }

        // 3. Actualizar la contraseña
        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        // 4. Redirigir con un mensaje de éxito
        return back()->with('status', 'password-updated'); // 'back()' redirige a la página anterior (el formulario)
        // O podrías redirigir a un dashboard:
        // return redirect()->route('dashboard')->with('success', 'Contraseña actualizada exitosamente.');
    }
}