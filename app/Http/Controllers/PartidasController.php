<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Proyecto;
use App\Models\Partida;
use App\Http\Controllers\Controller;


class PartidasController extends Controller
{
    //
    public function mostrarPartidasPorProyecto(Request $request, $id_proyecto)
    {
        //$proyecto = Proyecto::findOrFail($id_proyecto);
        $partidas = Partida::where('id_proyecto', $id_proyecto)->get();

        $totalImporte = Partida::where('id_proyecto', $id_proyecto)
                                ->get();

        return view('partidas', [
            'partidas' => $partidas,
            'id_proyecto'=>$id_proyecto,
        ]);
        // O para una API:
        // return response()->json(['partidas' => $partidas]);
    }
}
