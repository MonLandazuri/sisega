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