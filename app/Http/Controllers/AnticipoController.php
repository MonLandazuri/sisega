<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anticipo;

class AnticipoController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validar los datos del formulario
        $request->validate([
            'id_proyecto' => 'required|exists:proyectos,id_proyecto',
            'id_contratista' => 'required|exists:contratistas,id_contratista',
            'porcentaje' => 'required|numeric|min:0|max:100',
        ]);

        // 2. Guardar el anticipo en la base de datos
        Anticipo::create([
            'id_proyecto' => $request->id_proyecto,
            'id_contratista' => $request->id_contratista,
            'porcentaje' => $request->porcentaje,
        ]);

        // 3. Redirigir de vuelta a la vista con un mensaje de éxito
        return redirect()->back()->with('success', 'El anticipo ha sido registrado con éxito.');
    }
}