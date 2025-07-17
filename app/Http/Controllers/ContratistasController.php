<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Contratista;
use Illuminate\Support\Facades\Storage;


class ContratistasController extends Controller
{
    public function index(): View
    {
        return view('contratistas');   //carga la vista dashboard.blade.php
    }

    public function nuevoContratista(){
        return view('nuevocontratista');
    }

    public function guardarNuevoContratista(Request $request)
    {
        // 1. Validar los datos del formulario (opcional pero muy recomendado)
        $request->validate([
            'nombre_contratista' => 'required|string|max:255',
            'direccion_contratista' => 'required|string|max:255',
            'banco_contratista' => 'required|string|max:255',
            'clabe_contratista' => 'required|string|max:255',
            'cuenta_contratista' => 'required|string|max:255',
            // Puedes agregar más reglas de validación para otros campos si los tuvieras
        ]);

        // 2. Crear una nueva instancia del modelo Proyecto
        $nuevoContratista = new Contratista();

        // 3. Asignar los valores de los campos del formulario a las propiedades del modelo
        $nuevoContratista->nombre_contratista = $request->input('nombre_contratista');
        $nuevoContratista->direccion_contratista = $request->input('direccion_contratista');
        $nuevoContratista->banco_contratista = $request->input('banco_contratista');
        $nuevoContratista->clabe_contratista = $request->input('clabe_contratista');
        $nuevoContratista->cuenta_contratista = $request->input('cuenta_contratista');

        // 5. Guardar el nuevo proyecto en la base de datos
        $nuevoContratista->save();

        // 6. Redireccionar al usuario a otra página o mostrar un mensaje de éxito
        return redirect()->route('contratistas')->with('success', 'Contratista creado exitosamente.');
        // O podrías redirigir a la página de detalles del proyecto recién creado:
        // return redirect()->route('proyectos.show', ['proyecto' => $nuevoProyecto->id])->with('success', 'Proyecto creado exitosamente.');
    
    }

    public function mostrarContratistas()
    {
        $contratistas = Contratista::all();
        $totalContratistas = Contratista::count();

        return view('contratistas', [
            'contratistas' => $contratistas,
            'totalContratistas'=>$totalContratistas,
        ]);
    }

    public function infoContratista($id_contratista)
    {
        $contratista = Contratista::where('id_contratista',$id_contratista)->get();

        return view('info-contratista', [
            'contratista' => $contratista,
        ]);
    }
}
