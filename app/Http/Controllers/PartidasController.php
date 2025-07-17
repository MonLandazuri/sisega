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

        $totales = Partida::where('id_proyecto', $id_proyecto)
                               ->select(
                                    DB::raw('SUM(cantidad_partida * pu_partida) as total_importe'),
                                    DB::raw('SUM(cantidad_partida * pu_contratista_partida) as total_contratista_importe')
                                )
                               ->first();

        $totalImporte = $totales->total_importe;
        $totalContratistaImporte = $totales->total_contratista_importe;

        // Opcional: Manejar si no hay resultados para evitar errores si first() devuelve null
        if ($totales) {
            $totalImporte = $totales->total_importe ?? 0; // Usar ?? 0 para manejar NULLs si no hay partidas
            $totalContratistaImporte = $totales->total_contratista_importe ?? 0;
        } else {
            $totalImporte = 0;
            $totalContratistaImporte = 0;
        }

        $totalesExtra = Extra::where('id_proyecto', $id_proyecto)
                               ->select(
                                    DB::raw('SUM(cantidad_extra * pu_extra) as total_importeExtra'),
                                    DB::raw('SUM(cantidad_extra * pu_contratista_extra) as total_contratista_importeExtra')
                               )
                               ->first();

        $totalImporteExtra = $totales->total_importeExtra;
        $totalContratistaImporteExtra = $totales->total_contratista_importeExtra;

        // Opcional: Manejar si no hay resultados para evitar errores si first() devuelve null
        if ($totalesExtra) {
            $totalImporteExtra = $totalesExtra->total_importeExtra ?? 0; // Usar ?? 0 para manejar NULLs si no hay partidas
            $totalContratistaImporteExtra = $totalesExtra->total_contratista_importeExtra ?? 0;
        } else {
            $totalImporteExtra = 0;
            $totalContratistaImporteExtra = 0;
        }

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
                    'p.unidad_partida',
                    'p.pu_partida',
                    'p.pu_contratista_partida',
                    'e.id_extra as extra_real_id',
                    'e.no_extra',
                    'e.concepto_extra',
                    'e.unidad_extra',
                    'e.pu_extra',
                    'e.pu_contratista_extra',
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
                ->orderBy('p.no_partida','asc')
                ->orderBy('e.no_extra','asc')
                ->get();
        }
        
        $partidasAcumuladas = DB::table('ordenes_detalles as od')
            ->select(
                DB::raw("'Partida' AS tipo_referencia"),
                'p.id_partida AS id_referencia',
                'p.no_partida AS numero_referencia',
                'p.concepto_partida AS concepto_referencia',
                'p.unidad_partida AS unidad_referencia',
                'p.cantidad_partida AS cantidad_referencia',
                'p.pu_partida AS precio_unitario_base',
                'p.pu_contratista_partida AS precio_unitario_contratista_base',
                DB::raw('SUM(od.cantidad_orden_detalle) AS cantidad_acumulada'),
                DB::raw('SUM(od.cantidad_orden_detalle * p.pu_partida) AS importe_acumulado'),
                DB::raw('SUM(od.cantidad_orden_detalle * p.pu_contratista_partida) AS importe_contratista_acumulado')
            )
            ->join('partidas as p', 'od.id_partida', '=', 'p.id_partida')
            // Filtra por órdenes de compra asociadas a este proyecto
            ->join('ordenes as oc', 'od.id_orden', '=', 'oc.id_orden')
            ->where('oc.id_proyecto', $id_proyecto)
            ->whereNotNull('od.id_partida')
            ->groupBy(
                'p.id_partida',
                'p.no_partida',
                'p.concepto_partida',
                'p.unidad_partida',
                'p.cantidad_partida',
                'p.pu_partida',
                'p.pu_contratista_partida'
            )
            ->orderBy('numero_referencia');

        // Segunda parte: Acumulado de Extras
        $extrasAcumulados = DB::table('ordenes_detalles as od')
            ->select(
                DB::raw("'Extra' AS tipo_referencia"),
                'e.id_extra AS id_referencia',
                'e.no_extra AS numero_referencia',
                'e.concepto_extra AS concepto_referencia',
                'e.unidad_extra AS unidad_referencia',
                'e.cantidad_extra AS cantidad_referencia',
                'e.pu_extra AS precio_unitario_base',
                'e.pu_contratista_extra AS precio_unitario_contratista_base',
                DB::raw('SUM(od.cantidad_orden_detalle) AS cantidad_acumulada'),
                DB::raw('SUM(od.cantidad_orden_detalle * e.pu_extra) AS importe_acumulado'),
                DB::raw('SUM(od.cantidad_orden_detalle * e.pu_contratista_extra) AS importe_contratista_acumulado') // Asumo pu_contratista_extra
            )
            ->join('extras as e', 'od.id_extra', '=', 'e.id_extra')
            // Filtra por órdenes de compra asociadas a este proyecto
            ->join('ordenes as oc', 'od.id_orden', '=', 'oc.id_orden')
            ->where('oc.id_proyecto', $id_proyecto)
            ->whereNotNull('od.id_extra')
            ->groupBy(
                'e.id_extra',
                'e.no_extra',
                'e.concepto_extra',
                'e.unidad_extra',
                'e.cantidad_extra',
                'e.pu_extra',
                'e.pu_contratista_extra'
            )
            ->orderBy('numero_referencia');

        // Combinar los resultados y ordenar
        $acumulados = $partidasAcumuladas
            ->unionAll($extrasAcumulados)
            ->get();
                        

        // Calcular totales generales si los necesitas
        $totalGeneralProyecto = $acumulados->sum('importe_acumulado');
        $totalContratistaProyecto = $acumulados->sum('importe_contratista_acumulado');

        /*return view('partidas', [
            'partidas' => $partidas,
            'extras' => $extras,
            'proyectos' => $proyecto,
            'ordenes' => $ordenes,
            'totalImporte' => $totalImporte,
            'totalImporteExtra' => $totalImporteExtra,
            'id_proyecto'=>$id_proyecto,
        ]);*/

        return view('partidas', 
        compact('acumulados',
                'partidas',
                'extras',
                'proyectos',
                'ordenes',
                'totalImporte',
                'totalContratistaImporte',
                'totalImporteExtra',
                'totalContratistaImporteExtra',
                'totalContratistaProyecto',
                'totalGeneralProyecto',
                'id_proyecto',
                'todosLosDetallesDeOrdenes'
            ));
        // O para una API:
        // return response()->json(['partidas' => $partidas]);
    }
}
