<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Proyecto;     // Importa tus modelos
use App\Models\Contratista;
use App\Models\Ordenes;
use App\Models\Partida;
use Carbon\Carbon; 

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
        // 1. Obtener datos para las Tarjetas de Resumen
        $totalProyectos = Proyecto::count();
        $totalContratistas = Contratista::count();
        $totalOrdenes = Ordenes::count();
        $totalPartidas = Partida::count();

        // 2. Datos para Gráficos Sencillos (ej. Órdenes de Compra por mes)
        // Esto es un ejemplo, puedes adaptarlo a tus necesidades.
        // Contaremos las órdenes creadas en los últimos 6 meses.
        $proyectosPorMes = Proyecto::selectRaw('MONTH(fecha_proyecto) as mes, COUNT(*) as total')
                                ->where('fecha_proyecto', '>=', Carbon::now()->subMonths(6))
                                ->groupBy('mes')
                                ->orderBy('mes')
                                ->get()
                                ->mapWithKeys(function ($item) {
                                    return [Carbon::create()->month($item->mes)->format('M') => $item->total];
                                });

        $labelsProyectos = $proyectosPorMes->keys()->all();
        $dataProyectos = $proyectosPorMes->values()->all();

        // 3. Accesos Rápidos (No requieren lógica de controlador compleja, son solo enlaces en la vista)

        // 4. Última Actividad (ej. Últimas 5 Órdenes de Compra)
        $ultimasOrdenes = Ordenes::with(['contratista', 'proyecto']) // Carga relaciones si las necesitas
                                 ->latest('created_at') // Ordena por la más reciente
                                 ->take(5) // Limita a los últimos 5
                                 ->get();

        // Puedes añadir más lógica aquí para otros elementos del dashboard

        // Pasa los datos a la vista
        return view('inicio', compact(
            'totalProyectos',
            'totalContratistas',
            'totalOrdenes',
            'totalPartidas',
            'labelsProyectos',
            'dataProyectos',
            'ultimasOrdenes'
        ));

        //return view('inicio'); // Crea una vista llamada home.blade.php
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
