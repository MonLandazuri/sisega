<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Ordenes; // Tu modelo de Orden de Compra

use Illuminate\Http\Request;

class PdfController extends Controller
{
  // app/Http/Controllers/OrdenesController.php

    public function exportarPDF($orden)
    {
      $ordenDetalle = DB::table('ordenes_detalles as od')
            ->select(
                    'od.id_orden_detalle as detalle_id',
                    'od.id_orden', // Es importante seleccionar el ID de la orden para agrupar en la vista
                    'od.id_partida',
                    'od.id_extra',
                    'od.cantidad_orden_detalle',
                    'o.id_orden',
                    'o.fecha_orden',
                    'o.id_contratista',
                    'p.id_partida as partida_real_id',
                    'p.no_partida',
                    'p.concepto_partida',
                    'p.unidad_partida',
                    'p.cantidad_partida as cantidad_referencia_partida',
                    'p.pu_partida',
                    'p.pu_contratista_partida',
                    'e.id_extra as extra_real_id',
                    'e.no_extra',
                    'e.concepto_extra',
                    'e.unidad_extra',
                    'e.cantidad_extra as cantidad_referencia_extra',
                    'e.pu_extra',
                    'e.pu_contratista_extra',
                )
                ->join('ordenes as o', 'od.id_orden', '=', 'o.id_orden')
                ->leftJoin('partidas as p', function ($join) {
                    $join->on('od.id_partida', '=', 'p.id_partida')
                        ->whereNotNull('od.id_partida'); // Solo une si partida_id no es nulo
                })
                ->leftJoin('extras as e', function ($join) {
                    $join->on('od.id_extra', '=', 'e.id_extra')
                        ->whereNotNull('od.id_extra'); // Solo une si extra_id no es nulo
                })
                ->where('od.id_orden', $orden) // Filtra por la orden de compra específica
                ->orderBy('p.no_partida','asc')
                ->orderBy('e.no_extra','asc')
                ->get();

        // 1. Cargar las relaciones necesarias (si las hay)
        // $orden->load('proyecto', 'contratista', 'partidas');

        // 2. Cargar la vista Blade con los datos de la orden
        $pdf = Pdf::loadView('oc_pdf', compact('ordenDetalle'))->setPaper('A4', 'landscape');;

        // 3. Devolver el PDF para ser descargado
        return $pdf->download('orden_de_compra_' . $orden . '.pdf');
    }
}
