<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;
use App\Models\Partida;
use App\Models\Extra;
use App\Http\Controllers\Controller;


class PartidasController extends Controller
{
    //
    public function mostrarPartidasPorProyecto(Request $request, $id_proyecto)
    {
        //$proyecto = Proyecto::findOrFail($id_proyecto);
        $partidas = Partida::where('id_proyecto', $id_proyecto)->get();
        $extras = Extra::where('id_proyecto', $id_proyecto)->get();
        $proyecto = Proyecto::where('id_proyecto', $id_proyecto)->get();

        $totalImporte = Partida::where('id_proyecto', $id_proyecto)
                               ->select(DB::raw('SUM(cantidad_partida * pu_partida) as total_importe'))
                               ->first()
                               ->total_importe;

        $totalImporteExtra = Extra::where('id_proyecto', $id_proyecto)
                               ->select(DB::raw('SUM(cantidad_extra * pu_extra) as total_importeExtra'))
                               ->first()
                               ->total_importeExtra;

        // Opcional: Si quieres un valor por defecto si no hay partidas
        $totalImporte = $totalImporte ?? 0; // Asegura que sea 0 si no hay resultados o es null


        return view('partidas', [
            'partidas' => $partidas,
            'extras' => $extras,
            'proyectos' => $proyecto,
            'totalImporte' => $totalImporte,
            'totalImporteExtra' => $totalImporteExtra,
            'id_proyecto'=>$id_proyecto,
        ]);
        // O para una API:
        // return response()->json(['partidas' => $partidas]);
    }
}
