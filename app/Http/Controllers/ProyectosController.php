<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Proyecto;

class ProyectosController extends Controller
{
    public function index(): View
    {
        return view('proyectos');   //carga la vista dashboard.blade.php
    }

    public function nuevoProyecto(){
        return view('nuevoproyecto');
    }

    public function guardarNuevoProyecto(Request $request)
    {
        // 1. Validar los datos del formulario (opcional pero muy recomendado)
        $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'dependencia_proyecto' => 'required|string|max:255',
            // Puedes agregar más reglas de validación para otros campos si los tuvieras
        ]);

        // 2. Crear una nueva instancia del modelo Proyecto
        $nuevoProyecto = new Proyecto();

        // 3. Asignar los valores de los campos del formulario a las propiedades del modelo
        $nuevoProyecto->nombre_proyecto = $request->input('nombre_proyecto');
        $nuevoProyecto->dependencia_proyecto = $request->input('dependencia_proyecto');

        // 5. Guardar el nuevo proyecto en la base de datos
        $nuevoProyecto->save();

        // 6. Redireccionar al usuario a otra página o mostrar un mensaje de éxito
        return redirect()->route('proyectos')->with('success', 'Proyecto creado exitosamente.');
        // O podrías redirigir a la página de detalles del proyecto recién creado:
        // return redirect()->route('proyectos.show', ['proyecto' => $nuevoProyecto->id])->with('success', 'Proyecto creado exitosamente.');
    
    }

    public function mostrarProyectos()
    {
        // Utilizando Eloquent para obtener todos los productos
        $proyectos = Proyecto::all();
        $totalProyectos = Proyecto::count();

        $totalProyectosActivos = Proyecto::where('status_proyecto', 'activo')->count();
        $totalProyectosCancelados = Proyecto::where('status_proyecto', 'cancelado')->count();
        $totalProyectosFinalizados = Proyecto::where('status_proyecto', 'finalizado')->count();

        // También puedes usar otras consultas de Eloquent
        // $productos = Producto::where('activo', true)->orderBy('precio', 'desc')->get();
        // $primerProducto = Producto::first();
        // $productoPorId = Producto::find(1);

        // Pasar los productos a la vista
        return view('proyectos', [
            'proyectos' => $proyectos,
            'totalProyectos'=>$totalProyectos,
            'totalProyectosActivos'=>$totalProyectosActivos,
            'totalProyectosCancelados'=>$totalProyectosCancelados,
            'totalProyectosFinalizados'=>$totalProyectosFinalizados,
        ]);
    }
}