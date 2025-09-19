<?php

namespace App\Http\Controllers;

use App\Models\Contratista;
use App\Models\SublistadoContratista;
use App\Models\Partida;
use App\Models\Extra;
use App\Models\Anticipo;
use Illuminate\Http\Request;

class SublistadoContratistaController extends Controller
{
    public function show($id_proyecto)
    {
        // Carga el sublistado actual del contratista para mostrarlo en la tabla.
        //$contratista->load('sublistados');

        $contratistasConSublistado = SublistadoContratista::where('id_proyecto', $id_proyecto)
                                                      ->pluck('id_contratista')
                                                      ->unique();

        // Obtén la lista de contratistas, excluyendo aquellos con un sublistado.
        $contratistas = Contratista::whereNotIn('id_contratista', $contratistasConSublistado)->get();
    
        // Obtiene todos los elementos de los catálogos para que el usuario pueda seleccionarlos.
        //$contratistas = Contratista::all();
        $partidas = Partida::where('id_proyecto', $id_proyecto)->get();
        $extraordinarios = Extra::where('id_proyecto', $id_proyecto)->get();

        return view('nuevo-sublistado', compact('contratistas', 'partidas', 'extraordinarios', 'id_proyecto'));
    }

    
    public function store(Request $request)
    {
        // Valida que los datos enviados sean correctos.
        /*$request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.tipo' => 'required|string|in:catalogo,extraordinario',
            'items.*.cantidad' => 'required|numeric|min:0.01',
            'items.*.monto' => 'required|numeric|min:0',
        ]);*/

        // Elimina el sublistado anterior para reemplazarlo con el nuevo.
        // Esto simplifica la lógica y evita duplicados.
        // $contratista->sublistados()->delete();

        // Itera sobre los elementos enviados y los crea en la base de datos.

        foreach ($request->items as $item) {
            $data = [
                'id_contratista' => $request->id_contratista,
                'id_proyecto' => $request->id_proyecto,
                'cantidad' => $item['cantidad'],
                //'monto' => $item['monto'],
            ];

            // Asigna la clave foránea correcta según el tipo de elemento.
            if ($item['tipo'] === 'partida') {
                $data['id_partida'] = $item['id'];
            } else {
                $data['id_extra'] = $item['id'];
            }

            SublistadoContratista::create($data);

        }
            
        Anticipo::create([
            'id_proyecto' => $request->id_proyecto,
            'id_contratista' => $request->id_contratista,
            'porcentaje' => $request->anticipo,
        ]);

        return redirect()->route('proyecto.partidas', ["id_proyecto" => $request->id_proyecto])->with('success', 'Sublistado guardado exitosamente.');
        //return redirect()->route('sublistado.show', $contratista)->with('success', 'Sublistado guardado con éxito.');
    }

    public function mostrarSublistado($id_proyecto, $id_contratista)
    {
        $sublistado = SublistadoContratista::where('id_proyecto', $id_proyecto)
                                            ->where('id_contratista',$id_contratista)
                                            ->with(['partidas', 'extra'])
                                            ->get();
    }
}