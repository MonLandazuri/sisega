<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Proyecto;
use App\Models\User;

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
        $nuevoProyecto->constructora_proyecto = $request->input('constructora_proyecto');
        $nuevoProyecto->fecha_proyecto = $request->input("fecha_proyecto");
        $nuevoProyecto->status_proyecto = 'activo';

        // 5. Guardar el nuevo proyecto en la base de datos
        $nuevoProyecto->save();

        // 6. Redireccionar al usuario a otra página o mostrar un mensaje de éxito
        return redirect()->route('proyectos')->with('success', 'Proyecto creado exitosamente.');
        // O podrías redirigir a la página de detalles del proyecto recién creado:
        // return redirect()->route('proyectos.show', ['proyecto' => $nuevoProyecto->id])->with('success', 'Proyecto creado exitosamente.');
    
    }

    public function mostrarProyectos()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        if ($user->is_admin) {
            // Si el usuario es administrador, mostrar todos los proyectos
            $proyectos = Proyecto::all();
            
        } else {
            // Si no es administrador, mostrar solo los proyectos asignados a él
            // Usamos la relación belongsToMany que creamos
            $proyectos = $user->proyectos;
        }

        // Utilizando Eloquent para obtener todos los productos
        //$proyectos = Proyecto::all();
        $totalProyectos = $proyectos->count();

        $proyectosActivos = $proyectos->where('status_proyecto', 'activo');
        $totalProyectosActivos = $proyectosActivos->where('status_proyecto', 'activo')->count();
        
        $proyectosFinalizados = $proyectos->where('status_proyecto', 'finalizado');
        $totalProyectosFinalizados = $proyectosFinalizados->where('status_proyecto', 'finalizado')->count();

        // También puedes usar otras consultas de Eloquent
        // $productos = Producto::where('activo', true)->orderBy('precio', 'desc')->get();
        // $primerProducto = Producto::first();
        // $productoPorId = Producto::find(1);

        // Obtener todos los usuarios para la lista de selección
        $usuarios = User::all();

        // Puedes cargar las relaciones del proyecto que necesites
        //$proyectos->load('usuarios');

        // Pasar los productos a la vista
        return view('proyectos', compact(
                    'proyectos', 
                    'totalProyectos', 
                    'proyectosActivos', 
                    'totalProyectosActivos', 
                    'proyectosFinalizados', 
                    'totalProyectosFinalizados', 
                    'usuarios'));
    }

    public function finalizarProyecto(Proyecto $proyecto)
    {
        $proyecto->status_proyecto="finalizado";

        $proyecto->save();
                
        return redirect()->back()->with('success', 'El proyecto ha sido finalizado correctamente.');

    }

    public function actualizarUsuarios(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            'usuarios_residentes' => 'array', // Valida que el input es un array
            'usuarios_residentes.*' => 'exists:users,id', // Valida que cada ID de usuario existe
        ]);

        // Sincroniza los usuarios con el proyecto.
        // Los IDs que no están en el array se desvinculan
        // y los nuevos IDs se vinculan.
        $proyecto->usuarios()->sync($request->usuarios_residentes);

        return redirect()->back()->with('success', 'Residentes de proyecto actualizados.');
    }

    public function show(Proyecto $proyecto)
    {
        // Obtener todos los usuarios para la lista de selección
        $usuarios = User::all();

        // Puedes cargar las relaciones del proyecto que necesites
        $proyecto->load('usuarios');

        // Pasar el proyecto y la lista de usuarios a la vista
        return view('proyectos.show', compact('proyecto', 'usuarios'));
    }

    // En app/Http/Controllers/ProyectoController.php
    public function getUsuariosAsignados(Proyecto $proyecto)
    {
        // Devuelve los IDs de los usuarios asignados en formato JSON
        return response()->json($proyecto->usuarios->pluck('id'));
    }
}