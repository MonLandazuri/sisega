<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;
use App\Models\Partida;
use App\Models\Extra;
use App\Models\Insumo;
use App\Models\Ordenes;
use App\Models\Contratista;
use App\Models\OrdenesDetalles;
use App\Models\SublistadoContratista;
use App\Http\Controllers\Controller;


class PartidasController extends Controller
{
    //
    public function mostrarPartidasPorProyecto(Request $request, $id_proyecto)
    {
        //$proyecto = Proyecto::findOrFail($id_proyecto);
        $partidas = Partida::where('id_proyecto', $id_proyecto)->get();
        $extras = Extra::where('id_proyecto', $id_proyecto)->get();
        $insumos = Insumo::where('id_proyecto', $id_proyecto)->get();
        $proyectos = Proyecto::where('id_proyecto', $id_proyecto)->get();
        $ordenes = Ordenes::where('id_proyecto', $id_proyecto)->get();
        $contratistas = Contratista::all();
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
                ->whereIn('od.id_orden', $ids_ordenes) // Filtra por la orden de compra específica
                ->orderBy('p.no_partida','asc')
                ->orderBy('e.no_extra','asc')
                ->get();
        }
        
        //Calculo Acumulados
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
                DB::raw('SUM(od.pu_final) AS importe_final'),
                DB::raw('SUM(od.cantidad_orden_detalle * p.pu_contratista_partida) AS importe_contratista_acumulado')

            )
            ->join('partidas as p', 'od.id_partida', '=', 'p.id_partida')
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
                DB::raw('SUM(od.pu_final) AS importe_final'),
                DB::raw('SUM(od.cantidad_orden_detalle * e.pu_contratista_extra) AS importe_contratista_acumulado')

            )
            ->join('extras as e', 'od.id_extra', '=', 'e.id_extra')
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

        $acumulados = $partidasAcumuladas
            ->unionAll($extrasAcumulados)
            ->get();     
        //Fin Calculo Acumulados

        // Calcular totales generales si los necesitas
        $totalGeneralProyecto = $acumulados->sum('importe_acumulado');
        $totalContratistaProyecto = $acumulados->sum('importe_contratista_acumulado');

        $totalContratistas = Contratista::whereHas('ordenesDeCompra', function ($query) use ($id_proyecto) {
                                $query->where('id_proyecto', $id_proyecto);
                            })
                            ->with(['ordenesDeCompra' => function ($query) use ($id_proyecto) {
                                $query->where('id_proyecto', $id_proyecto)
                                      ->orderBy('ordenes.fecha_orden', 'desc')
                                      ->with('detalles');
                            },
                            'anticipos' => function ($query) use ($id_proyecto) {
                                    $query->where('id_proyecto', $id_proyecto);
                                }
                            ])
                            ->get();

        /*return view('partidas', [
            'partidas' => $partidas,
            'extras' => $extras,
            'proyectos' => $proyecto,
            'ordenes' => $ordenes,
            'totalImporte' => $totalImporte,
            'totalImporteExtra' => $totalImporteExtra,
            'id_proyecto'=>$id_proyecto,
        ]);*/

        
        /* ANTERIOR SUBLISTADO
        $catalogoAcumulado = DB::table('sublistados_contratistas as sc')
            ->select(
                DB::raw("'Partida' AS tipo_referencia"),
                'sc.id_contratista',
                'p.id_partida AS id_referencia',
                'p.no_partida AS no_referencia',
                'p.concepto_partida AS concepto_referencia',
                'p.unidad_partida AS unidad_referencia',
                'p.cantidad_partida AS cantidad_referencia',
                'p.pu_partida AS pu_base', 
                'p.pu_contratista_partida AS pu_contratista_base', 
                DB::raw('SUM(sc.cantidad) AS cantidad_acumulada'),
                DB::raw('SUM(sc.cantidad * sc.monto) AS importe_acumulado')
            )
            ->join('partidas as p', 'sc.id_partida', '=', 'p.id_partida')
            ->where('sc.id_proyecto', $id_proyecto)
            ->groupBy(
                'sc.id_contratista',
                'p.id_partida',
                'p.no_partida',
                'p.concepto_partida',
                'p.unidad_partida',
                'p.cantidad_partida',
                'p.pu_partida',
                'p.pu_contratista_partida'
            );

        // Segunda parte: Sumatoria de elementos Extraordinarios
        $extraordinarioAcumulado = DB::table('sublistados_contratistas as sc')
            ->select(
                DB::raw("'Extra' AS tipo_referencia"),
                'sc.id_contratista',
                'e.id_extra AS id_referencia',
                'e.no_extra AS no_referencia',
                'e.concepto_extra AS concepto_referencia',
                'e.unidad_extra AS unidad_referencia',
                'e.cantidad_extra AS cantidad_referencia',
                'e.pu_extra AS pu_base',
                'e.pu_contratista_extra AS pu_contratista_base',
                DB::raw('SUM(sc.cantidad) AS cantidad_acumulada'),
                DB::raw('SUM(sc.cantidad * sc.monto) AS importe_acumulado')
            )
            ->join('extras as e', 'sc.id_extra', '=', 'e.id_extra')
            ->where('sc.id_proyecto', $id_proyecto)
            ->groupBy(
                'sc.id_contratista',
                'e.id_extra',
                'e.no_extra',
                'e.concepto_extra',
                'e.unidad_extra',
                'e.cantidad_extra',
                'e.pu_extra',
                'e.pu_contratista_extra'
            );

        // Combinar los resultados de ambos catálogos
        $sublistadoAcumulado = $catalogoAcumulado
            ->unionAll($extraordinarioAcumulado)
            ->get();
        */
            
        // Primera parte: Sumatoria de elementos del Catálogo Principal
        $catalogoAcumulado = DB::table('sublistados_contratistas as sc')
            ->select(
                DB::raw("'Partida' AS tipo_referencia"),
                'sc.id_contratista',
                'sc.id_sub', // <--- NUEVO: Selecciona el ID del sublistado
                'p.id_partida AS id_referencia',
                'p.no_partida AS no_referencia',
                'p.concepto_partida AS concepto_referencia',
                'p.unidad_partida AS unidad_referencia',
                'p.cantidad_partida AS cantidad_referencia',
                'p.pu_partida AS pu_base', 
                'p.pu_contratista_partida AS pu_contratista_base', 
                DB::raw('SUM(sc.cantidad) AS cantidad_acumulada'),
                DB::raw('SUM(sc.cantidad * sc.monto) AS importe_acumulado')
            )
            ->join('partidas as p', 'sc.id_partida', '=', 'p.id_partida')
            ->where('sc.id_proyecto', $id_proyecto)
            ->groupBy(
                'sc.id_contratista',
                'sc.id_sub', // <--- NUEVO: Agrupa por ID del sublistado
                'p.id_partida',
                'p.no_partida',
                'p.concepto_partida',
                'p.unidad_partida',
                'p.cantidad_partida',
                'p.pu_partida',
                'p.pu_contratista_partida'
            );

        // Segunda parte: Sumatoria de elementos Extraordinarios
        $extraordinarioAcumulado = DB::table('sublistados_contratistas as sc')
            ->select(
                DB::raw("'Extra' AS tipo_referencia"),
                'sc.id_contratista',
                'sc.id_sub', // <--- NUEVO: Selecciona el ID del sublistado
                'e.id_extra AS id_referencia',
                'e.no_extra AS no_referencia',
                'e.concepto_extra AS concepto_referencia',
                'e.unidad_extra AS unidad_referencia',
                'e.cantidad_extra AS cantidad_referencia',
                'e.pu_extra AS pu_base',
                'e.pu_contratista_extra AS pu_contratista_base',
                DB::raw('SUM(sc.cantidad) AS cantidad_acumulada'),
                DB::raw('SUM(sc.cantidad * sc.monto) AS importe_acumulado')
            )
            ->join('extras as e', 'sc.id_extra', '=', 'e.id_extra')
            ->where('sc.id_proyecto', $id_proyecto)
            ->groupBy(
                'sc.id_contratista',
                'sc.id_sub', // <--- NUEVO: Agrupa por ID del sublistado
                'e.id_extra',
                'e.no_extra',
                'e.concepto_extra',
                'e.unidad_extra',
                'e.cantidad_extra',
                'e.pu_extra',
                'e.pu_contratista_extra'
            );

        // Combinar los resultados de ambos catálogos
        $sublistadoAcumulado = $catalogoAcumulado
            ->unionAll($extraordinarioAcumulado)
            ->get();

        return view('partidas', 
        compact('acumulados',
                'partidas',
                'extras',
                'insumos',
                'proyectos',
                'ordenes',
                'totalImporte',
                'totalContratistaImporte',
                'totalImporteExtra',
                'totalContratistaImporteExtra',
                'totalContratistaProyecto',
                'totalGeneralProyecto',
                'id_proyecto',
                'todosLosDetallesDeOrdenes',
                'totalContratistas',
                'contratistas',
                'sublistadoAcumulado',
            ));
        // O para una API:
        // return response()->json(['partidas' => $partidas]);
    }

    public function nuevoPartida($id_proyecto){
        
        return view('nuevopartida',[
                'id_proyecto'=>$id_proyecto,
        ]);
    }

    public function editarPartida($id_partida){
        
        $partida = Partida::find($id_partida);

        return view('editarpartida',[
                'id_partida'=>$id_partida,
                'partida' => $partida,
        ]);
    }

    public function guardarNuevoPartida(Request $request)
    {
        $request->validate([
            'no_partida' => 'required|string|max:255',
            'concepto_partida' => 'required|string|max:500',
            'unidad_partida' => 'required|string|max:255',
            'cantidad_partida' => 'required|numeric',
            'pu_partida' => 'required|numeric',
            'pu_contratista_partida' => 'required|numeric',
            'id_proyecto' => 'required|exists:proyectos,id_proyecto',
            // Puedes agregar más reglas de validación para otros campos si los tuvieras
        ]);
        
        $nuevoPartida = new Partida();
        
        $nuevoPartida->id_proyecto=$request->input("id_proyecto");
        $nuevoPartida->no_partida=$request->input("no_partida");
        $nuevoPartida->concepto_partida=$request->input("concepto_partida");
        $nuevoPartida->unidad_partida=$request->input("unidad_partida");
        $nuevoPartida->cantidad_partida=$request->input("cantidad_partida");
        $nuevoPartida->pu_partida=$request->input("pu_partida");
        $nuevoPartida->pu_contratista_partida=$request->input("pu_contratista_partida");

        $nuevoPartida->save();

        $id_proyecto=$request->input("id_proyecto");
        
        return redirect()->route('proyecto.partidas',['id_proyecto' => $id_proyecto])->with('success', 'Partida creada exitosamente.');
    }

    public function guardarEditarPartida(Request $request)
    {
        $request->validate([
            'no_partida' => 'required|string|max:255',
            'concepto_partida' => 'required|string|max:500',
            'unidad_partida' => 'required|string|max:255',
            'cantidad_partida' => 'required|numeric',
            'pu_partida' => 'required|numeric',
            'pu_contratista_partida' => 'required|numeric',
            'id_proyecto' => 'required|exists:proyectos,id_proyecto',
            // Puedes agregar más reglas de validación para otros campos si los tuvieras
        ]);
        
        $id_partida=$request->input("id_partida");

        $partida = Partida::find($id_partida);
        
        $partida->id_proyecto=$request->input("id_proyecto");
        $partida->no_partida=$request->input("no_partida");
        $partida->concepto_partida=$request->input("concepto_partida");
        $partida->unidad_partida=$request->input("unidad_partida");
        $partida->cantidad_partida=$request->input("cantidad_partida");
        $partida->pu_partida=$request->input("pu_partida");
        $partida->pu_contratista_partida=$request->input("pu_contratista_partida");

        $partida->save();

        $id_proyecto=$request->input("id_proyecto");
        
        return redirect()->route('proyecto.partidas',['id_proyecto' => $id_proyecto])->with('success', 'Partida editada exitosamente.');
    }

    public function eliminarPartida(Partida $partida)
    {
        // El Route Model Binding ya nos da la instancia del modelo,
        // por lo que no necesitamos usar find().
        // dd($partida); // Puedes descomentar esto para verificar que es la partida correcta

        $id_proyecto = $partida->id_proyecto; // Guardamos el ID del proyecto para la redirección
        $partida->delete(); // Elimina el registro de la base de datos

        return redirect()->route('proyecto.partidas', ['id_proyecto' => $id_proyecto])
                         ->with('success', 'Partida eliminada exitosamente.');
    }

    public function nuevoExtra($id_proyecto){
        
        return view('nuevoextra',[
                'id_proyecto'=>$id_proyecto,
        ]);
    }

    public function editarExtra($id_extra){
        
        $extra = Extra::find($id_extra);

        return view('editarextra',[
                'id_extra'=>$id_extra,
                'extra'=>$extra,
        ]);
    }

    
    public function guardarNuevoExtra(Request $request)
    {
        $request->validate([
            'no_extra' => 'required|string|max:255',
            'concepto_extra' => 'required|string|max:500',
            'unidad_extra' => 'required|string|max:255',
            'cantidad_extra' => 'required|numeric',
            'pu_extra' => 'required|numeric',
            'pu_contratista_extra' => 'required|numeric',
            'id_proyecto' => 'required|exists:proyectos,id_proyecto',
            // Puedes agregar más reglas de validación para otros campos si los tuvieras
        ]);
        
        $nuevoExtra = new Extra();
        
        $nuevoExtra->id_proyecto=$request->input("id_proyecto");
        $nuevoExtra->no_extra=$request->input("no_extra");
        $nuevoExtra->concepto_extra=$request->input("concepto_extra");
        $nuevoExtra->unidad_extra=$request->input("unidad_extra");
        $nuevoExtra->cantidad_extra=$request->input("cantidad_extra");
        $nuevoExtra->pu_extra=$request->input("pu_extra");
        $nuevoExtra->pu_contratista_extra=$request->input("pu_contratista_extra");

        $nuevoExtra->save();

        $id_proyecto=$request->input("id_proyecto");
        
        return redirect()->route('proyecto.partidas',['id_proyecto' => $id_proyecto])->with('success', 'Extraordinario creada exitosamente.');
    }

    public function guardarEditarExtra(Request $request)
    {
        $request->validate([
            'no_extra' => 'required|string|max:255',
            'concepto_extra' => 'required|string|max:500',
            'unidad_extra' => 'required|string|max:255',
            'cantidad_extra' => 'required|numeric',
            'pu_extra' => 'required|numeric',
            'pu_contratista_extra' => 'required|numeric',
            'id_proyecto' => 'required|exists:proyectos,id_proyecto',
            // Puedes agregar más reglas de validación para otros campos si los tuvieras
        ]);
        
        $id_extra=$request->input("id_extra");

        $extra = Extra::find($id_extra);
        
        $extra->id_proyecto=$request->input("id_proyecto");
        $extra->no_extra=$request->input("no_extra");
        $extra->concepto_extra=$request->input("concepto_extra");
        $extra->unidad_extra=$request->input("unidad_extra");
        $extra->cantidad_extra=$request->input("cantidad_extra");
        $extra->pu_extra=$request->input("pu_extra");
        $extra->pu_contratista_extra=$request->input("pu_contratista_extra");

        $extra->save();

        $id_proyecto=$request->input("id_proyecto");
        
        return redirect()->route('proyecto.partidas',['id_proyecto' => $id_proyecto])->with('success', 'Extraordinario editado exitosamente.');
    }

    public function eliminarExtra(Extra $extra)
    {
        // El Route Model Binding ya nos da la instancia del modelo,
        // por lo que no necesitamos usar find().
        // dd($partida); // Puedes descomentar esto para verificar que es la partida correcta

        $id_proyecto = $extra->id_proyecto; // Guardamos el ID del proyecto para la redirección
        $extra->delete(); // Elimina el registro de la base de datos

        return redirect()->route('proyecto.partidas', ['id_proyecto' => $id_proyecto])
                         ->with('success', 'Extraordinario eliminado exitosamente.');
    }

    //---INSUMOS

    public function nuevoInsumo($id_proyecto){
        
        return view('nuevoinsumo',[
                'id_proyecto'=>$id_proyecto,
        ]);
    }

    public function editarInsumo($id_extra){
        
        $extra = Insumo::find($id_extra);

        return view('editarinsumo',[
                'id_insumo'=>$id_extra,
                'insumo'=>$extra,
        ]);
    }

    
    public function guardarNuevoInsumo(Request $request)
    {
        $request->validate([
            'no_insumo' => 'required|string|max:255',
            'concepto_insumo' => 'required|string|max:500',
            'unidad_insumo' => 'required|string|max:255',
            'cantidad_insumo' => 'required|numeric',
            'zonadeuso_insumo' => 'required|string|max:255',
            'id_proyecto' => 'required|exists:proyectos,id_proyecto',
        ]);
        
        $nuevoInsumo = new Insumo();
        
        $nuevoInsumo->id_proyecto=$request->input("id_proyecto");
        $nuevoInsumo->no_insumo=$request->input("no_insumo");
        $nuevoInsumo->concepto_insumo=$request->input("concepto_insumo");
        $nuevoInsumo->unidad_insumo=$request->input("unidad_insumo");
        $nuevoInsumo->cantidad_insumo=$request->input("cantidad_insumo");
        $nuevoInsumo->zonadeuso_insumo=$request->input("zonadeuso_insumo");

        $nuevoInsumo->save();

        $id_proyecto=$request->input("id_proyecto");
        
        return redirect()->route('proyecto.partidas',['id_proyecto' => $id_proyecto])->with('success', 'Insumo creada exitosamente.');
    }

    public function guardarEditarInsumo(Request $request)
    {
        $request->validate([
            'no_insumo' => 'required|string|max:255',
            'concepto_insumo' => 'required|string|max:500',
            'unidad_insumo' => 'required|string|max:255',
            'cantidad_insumo' => 'required|numeric',
            'zonadeuso_insumo' => 'required|string|max:255',
            'id_proyecto' => 'required|exists:proyectos,id_proyecto',
        ]);
        
        $id_insumo=$request->input("id_insumo");

        $insumo = Insumo::find($id_insumo);
        
        $insumo->id_proyecto=$request->input("id_proyecto");
        $insumo->no_insumo=$request->input("no_insumo");
        $insumo->concepto_insumo=$request->input("concepto_insumo");
        $insumo->unidad_insumo=$request->input("unidad_insumo");
        $insumo->cantidad_insumo=$request->input("cantidad_insumo");
        $insumo->zonadeuso_insumo=$request->input("zonadeuso_insumo");

        $insumo->save();

        $id_proyecto=$request->input("id_proyecto");
        
        return redirect()->route('proyecto.partidas',['id_proyecto' => $id_proyecto])->with('success', 'Insumo editado exitosamente.');
    }

    public function eliminarInsumo(Insumo $insumo)
    {
        $id_proyecto = $insumo->id_proyecto;
        $insumo->delete(); 

        return redirect()->route('proyecto.partidas', ['id_proyecto' => $id_proyecto])
                         ->with('success', 'Insumo eliminado exitosamente.');
    }
}
