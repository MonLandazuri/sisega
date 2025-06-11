<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;
use App\Models\Partida;
use App\Models\Extra;
use App\Models\Ordenes;
use App\Models\OrdenesDetalles;
use App\Http\Controllers\Controller;


class PartidasController extends Controller
{
    //
    public function mostrarPartidasPorProyecto(Request $request, $id_proyecto)
    {
        //$proyecto = Proyecto::findOrFail($id_proyecto);
        $partidas = Partida::where('id_proyecto', $id_proyecto)->get();
        $extras = Extra::where('id_proyecto', $id_proyecto)->get();
        $proyectos = Proyecto::where('id_proyecto', $id_proyecto)->get();
        $ordenes = Ordenes::where('id_proyecto', $id_proyecto)->get();
        $ids_ordenes = $ordenes->pluck('id_orden')->toArray();

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

        if (empty($ids_ordenes)) {
            $todosLosDetallesDeOrdenes = collect();
        } else {
            $todosLosDetallesDeOrdenes = DB::table('ordenes_detalles as od') // Alias 'od' para ordenes_detalle
                ->select(
                    'od.id_orden_detalle as detalle_id',
                    'od.id_orden', // Es importante seleccionar el ID de la orden para agrupar en la vista
                    'od.id_partida',
                    'od.id_extra',
                    'od.cantidad_orden_detalle',
                    'p.id_partida as partida_real_id',
                    'p.no_partida',
                    'p.concepto_partida',
                    'p.pu_partida',
                    'e.id_extra as extra_real_id',
                    'e.no_extra',
                    'e.concepto_extra',
                    'e.pu_extra',
                )
                ->leftJoin('partidas as p', function ($join) {
                    $join->on('od.id_partida', '=', 'p.id_partida')
                        ->whereNotNull('od.id_partida'); // Solo une si partida_id no es nulo
                })
                ->leftJoin('extras as e', function ($join) {
                    $join->on('od.id_extra', '=', 'e.id_extra')
                        ->whereNotNull('od.id_extra'); // Solo une si extra_id no es nulo
                })
                ->whereIn('od.id_orden', $ids_ordenes) // Filtra por la orden de compra específica
                ->get();
        }

        /*return view('partidas', [
            'partidas' => $partidas,
            'extras' => $extras,
            'proyectos' => $proyecto,
            'ordenes' => $ordenes,
            'totalImporte' => $totalImporte,
            'totalImporteExtra' => $totalImporteExtra,
            'id_proyecto'=>$id_proyecto,
        ]);*/
        return view('partidas', compact('partidas','extras','proyectos','ordenes','totalImporte','totalImporteExtra','id_proyecto','todosLosDetallesDeOrdenes'));
        // O para una API:
        // return response()->json(['partidas' => $partidas]);
    }
}
