<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;
use App\Models\Partida;
use App\Models\Extra;
use App\Models\Contratista;
use App\Models\Ordenes;
use App\Models\OrdenesDetalles;
use App\Http\Controllers\Controller;

class OrdenDeCompraController extends Controller
{
    public function mostrarOC($id_proyecto){
        return view('nuevaorden'); 
    }

    public function nuevaOC($id_proyecto)
    {
        $contratistas = Contratista::all();

        return view('nuevaorden',[
                'id_proyecto'=>$id_proyecto,
                'contratistas'=>$contratistas,
        ]);    
    }

    private function obtenerSiguienteNoOrden(int $id_proyecto): int
    {
        // 1. Buscar el valor MÁXIMO de la columna 'no_orden'
        //    solo para las órdenes que pertenecen al proyecto actual.
        $ultimoNoOrden = Ordenes::where('id_proyecto', $id_proyecto)
                            ->max('no_orden');

        // 2. Si es la primera orden del proyecto (MAX devuelve null), empezamos en 1.
        //    De lo contrario, incrementamos el último número encontrado.
        if ($ultimoNoOrden === null) {
            return 1;
        }

        return $ultimoNoOrden + 1;
    }
    //public function listadoNuevaOC(Request $request)
    public function listadoNuevaOC($id_proyecto)
    {
        //$validatedData = $request->validate([
        //    'id_proyecto'    => 'required|exists:proyectos,id_proyecto', 
        //    'fecha_oc'       => 'required|date',
        //    'contratista_oc' => 'required|exists:contratistas,id_contratista', 
        //]);

        $contratistas = Contratista::all();

        //$id_proyecto=$request->input("id_proyecto");
        //$contadorOC=$request->input("contadorOC");

        //$ordenCompra = new Ordenes();
        //$ordenCompra->id_proyecto = $request->input("id_proyecto");
        //$ordenCompra->fecha_orden = $request->input("fecha_oc");
        //$ordenCompra->id_contratista = $request->input("contratista_oc");

        //$ordenCompra->save();
        //$id_orden=$ordenCompra->id_orden;

        $partidas = Partida::where('id_proyecto', $id_proyecto)->get();
        $extras = Extra::where('id_proyecto', $id_proyecto)->get();

        return view('listado-nuevaorden',[
                'id_proyecto'=>$id_proyecto,
                'partidas'=>$partidas,
                'extras'=>$extras,
                //'id_orden'=>$id_orden,
                //'id_contratista'=>$request->input("contratista_oc"),
                'detalles'=>null,
                'contratistas'=>$contratistas,
        ]);     
    }

    public function revisionNuevaOC(Request $request)
    {

        $id_proyecto = $request->input("id_proyecto");
        $fecha_oc = $request->input("fecha_oc");
        //$id_orden = $request->input("id_orden");
        $id_contratista = $request->input("id_contratista");
        $iva = $request->input("iva");

        $cantidadesPartida = $request->input('cantidades_partida',[]);
        $preciosPartida = $request->input('pu_partida', []);

        $cantidadesExtra = $request->input('cantidades_extra',[]);
        $preciosExtra = $request->input('pu_extra', []);

        $detallesParaPrevisualizar = collect();
        $totalGeneral = 0; 
        
        foreach ($cantidadesPartida as $partidaId => $cantidad) {

            $cantidad = (float) $cantidad;

            if ($cantidad > 0) {

                $partida=Partida::find($partidaId);

                if ($partida) {
                    $precioUnitario = $preciosPartida[$partidaId] ?? $partida->pu_partida; // Preferir el precio enviado, si no, el de la DB
                    $importe = $cantidad * $precioUnitario;
                    $totalGeneral += $importe;

                    // Añadir el "detalle" a la colección de previsualización
                    $detallesParaPrevisualizar->push((object)[ // Convertimos a objeto para facilitar acceso en Blade
                        'id_partida' => $partida->id_partida,
                        'no_partida' => $partida->no_partida,
                        'concepto_partida' => $partida->concepto_partida,
                        'cantidad' => $cantidad,
                        'precio_unitario' => $precioUnitario,
                        'importe' => $importe,
                        'tipo' => 'Partida', // Para diferenciar si mezclas con Extras
                    ]);
                }
            }
        }

        $detallesParaPrevisualizarExtra = collect();
        $totalGeneralExtra = 0; 

        foreach ($cantidadesExtra as $extraId => $cantidad) {

            $cantidad = (float) $cantidad;

            if ($cantidad > 0) {

                $extra=Extra::find($extraId);

                if ($extra) {
                    $precioUnitario = $preciosExtra[$extraId] ?? $extra->pu_extra; // Preferir el precio enviado, si no, el de la DB
                    $importe = $cantidad * $precioUnitario;
                    $totalGeneralExtra += $importe;

                    // Añadir el "detalle" a la colección de previsualización
                    $detallesParaPrevisualizarExtra->push((object)[ // Convertimos a objeto para facilitar acceso en Blade
                        'id_extra' => $extra->id_extra,
                        'no_extra' => $extra->no_extra,
                        'concepto_extra' => $extra->concepto_extra,
                        'cantidad' => $cantidad,
                        'precio_unitario' => $precioUnitario,
                        'importe' => $importe,
                        'tipo' => 'Extra', // Para diferenciar si mezclas con Extras
                    ]);
                }
            }
        }

        return view('previsualizar-orden',[
            'detalles' => $detallesParaPrevisualizar,
            'totalGeneral' => $totalGeneral,
            'detallesExtra' => $detallesParaPrevisualizarExtra,
            'totalGeneralExtra' => $totalGeneralExtra,
            // Si necesitas pasar el Request original para re-enviar, puedes hacerlo:
            'originalRequest' => $request->all(),
            // 'orden' => $orden, // Si ya estabas editando una orden
            'id_proyecto' => $id_proyecto,
            'id_contratista' => $id_contratista,
            'fecha_oc'=>$fecha_oc,
            'iva'=>$iva,
        ]);
    }

    public function agregarNuevaOC(Request $request)
    {

        $id_proyecto=$request->input("id_proyecto");
        $id_orden=$request->input("id_orden");
        $cantidadesPartida=$request->input('cantidades_partida',[]);
        $cantidadesExtra=$request->input('cantidades_extra',[]);
        $comentario_orden=$request->input("comentario_orden");
        $id_contratista=$request->input("id_contratista");
        $siguienteNoOrden = $this->obtenerSiguienteNoOrden($id_proyecto);

        if($request->input("iva")=="on")
        $iva=FALSE;
        else
        $iva=TRUE;

        $ordenCompra = new Ordenes();
        $ordenCompra->id_proyecto = $request->input("id_proyecto");
        $ordenCompra->no_orden = $siguienteNoOrden = $this->obtenerSiguienteNoOrden($id_proyecto);
        $ordenCompra->fecha_orden = $request->input("fecha_oc");
        $ordenCompra->id_contratista = $request->input("id_contratista");
        $ordenCompra->iva = $iva;
        $ordenCompra->save();
        $id_orden=$ordenCompra->id_orden;

        $ordenMod = Ordenes::find($id_orden);

        $ordenMod->comentario_orden=$comentario_orden;

        $ordenMod->save();
        
        foreach ($cantidadesPartida as $partidaId => $cantidad) {
            // Solo procesa las cantidades si son mayores que 0 (o algún otro criterio)
            if ($cantidad > 0) {

                // Guarda el detalle de la orden
                OrdenesDetalles::create([
                    'id_orden' => $id_orden, // Usa el ID de la orden principal
                    'id_partida' => $partidaId, // El ID de la partida viene de la clave del array
                    'id_extra' => 0, // Esto es un detalle de partida, no de extra
                    'cantidad_orden_detalle' => $cantidad,
                    'iva' => $iva,
                    // Otros campos de OrdenDetalle si tienes
                ]);
            }
        }
        foreach ($cantidadesExtra as $extraId => $cantidad) {
            // Solo procesa las cantidades si son mayores que 0 (o algún otro criterio)
            if ($cantidad > 0) {

                // Guarda el detalle de la orden
                OrdenesDetalles::create([
                    'id_orden' => $id_orden, // Usa el ID de la orden principal
                    'id_partida' => 0, // El ID de la partida viene de la clave del array
                    'id_extra' => $extraId, // Esto es un detalle de partida, no de extra
                    'cantidad_orden_detalle' => $cantidad,
                    'iva' => $iva,
                    // Otros campos de OrdenDetalle si tienes
                ]);
            }
        }

        $id_orden_detalle=$id_orden;

        $partidas = Partida::where('id_proyecto', $id_proyecto)->get();
        $extras = Extra::where('id_proyecto', $id_proyecto)->get();
        //$ordenDetalleListado = OrdenesDetalles::where('id_orden', $id_orden)->get();

        $detalles = DB::table('ordenes_detalles as od') // Alias 'od' para ordenes_detalle
            ->select(
                'od.*', // Selecciona todas las columnas de ordenes_detalle
                'p.no_partida',
                'p.id_partida',
                'p.concepto_partida',
                'p.unidad_partida',
                'p.pu_partida',
                'e.no_extra',
                'e.id_extra',
                'e.concepto_extra',
                'e.unidad_extra',
                'e.pu_extra'
            )
            ->leftJoin('partidas as p', function ($join) {
                $join->on('od.id_partida', '=', 'p.id_partida')
                     ->whereNotNull('od.id_partida'); // Solo une si partida_id no es nulo
            })
            ->leftJoin('extras as e', function ($join) {
                $join->on('od.id_extra', '=', 'e.id_extra')
                     ->whereNotNull('od.id_extra'); // Solo une si extra_id no es nulo
            })
            ->where('od.id_orden', $id_orden) // Filtra por la orden de compra específica
            ->orderBy('p.no_partida','asc')
            ->orderBy('e.no_extra','asc')
            ->get();

        return redirect()->route('proyecto.partidas', ["id_proyecto" => $id_proyecto, 'id_contratista' => $id_contratista])->with('success', 'Orden guardada exitosamente.');

        //return view('partidas', compact("detalles","id_proyecto","partidas","extras"));         
    }

    public function revisionEditarOC($id_proyecto, $id_contratista, $id_orden)
    {

        // Obtener los detalles de la orden (partidas y extras)
        $detallesDeLaOrden = $this->obtenerDetallesOrden($id_orden);
        
        // Obtener las partidas y extras disponibles para mostrar el catálogo completo
        $partidasDisponibles = Partida::where('id_proyecto', $id_proyecto)->get();
        $extrasDisponibles = Extra::where('id_proyecto', $id_proyecto)->get();

        $cantidadesMapeadas = [
            'partidas' => [],
            'extras' => [],
        ];

        foreach ($detallesDeLaOrden as $detalle) {
            if ($detalle->tipo === 'Partida') {
                // La clave es el id_referencia (que es el id_partida)
                $cantidadesMapeadas['partidas'][$detalle->id_referencia] = $detalle->cantidad;
            } elseif ($detalle->tipo === 'Extra') {
                // La clave es el id_referencia (que es el id_extra)
                $cantidadesMapeadas['extras'][$detalle->id_referencia] = $detalle->cantidad;
            }
        }

        return view('editar-orden', compact(
            'id_proyecto',
            'id_contratista',
            'id_orden', 
            'detallesDeLaOrden', 
            'partidasDisponibles', 
            'extrasDisponibles',
            'cantidadesMapeadas',
        ));
    }

    private function obtenerDetallesOrden($id_orden)
    {
        // Partidas
        $partidasDeLaOrden = DB::table('ordenes_detalles as od')
            ->select(
                DB::raw("'Partida' AS tipo"),
                'p.id_partida AS id_referencia',
                'p.no_partida AS numero_referencia',
                'p.concepto_partida AS concepto',
                'p.unidad_partida AS unidad',
                'p.pu_partida AS precio_unitario',
                'od.cantidad_orden_detalle AS cantidad',
                DB::raw('od.cantidad_orden_detalle * p.pu_partida AS subtotal')
            )
            ->join('partidas as p', 'od.id_partida', '=', 'p.id_partida')
            ->where('od.id_orden', $id_orden)
            ->whereNotNull('od.id_partida');

        // Extras
        $extrasDeLaOrden = DB::table('ordenes_detalles as od')
            ->select(
                DB::raw("'Extra' AS tipo"),
                'e.id_extra AS id_referencia',
                'e.no_extra AS numero_referencia',
                'e.concepto_extra AS concepto',
                'e.unidad_extra AS unidad',
                'e.pu_extra AS precio_unitario',
                'od.cantidad_orden_detalle AS cantidad',
                DB::raw('od.cantidad_orden_detalle * e.pu_extra AS subtotal')
            )
            ->join('extras as e', 'od.id_extra', '=', 'e.id_extra')
            ->where('od.id_orden', $id_orden)
            ->whereNotNull('od.id_extra');

        return $partidasDeLaOrden->unionAll($extrasDeLaOrden)->get();
    }

    public function agregarEditarOC(Request $request)
    {

        $id_proyecto=$request->input("id_proyecto");
        $id_orden=$request->input("id_orden");
        $cantidadesPartida=$request->input('cantidad_partida',[]);
        $cantidadesExtra=$request->input('cantidad_extra',[]);
        $comentario_orden=$request->input("comentario_orden");
        $id_contratista=$request->input("id_contratista");

        $ordenMod = Ordenes::find($id_orden);

        $ordenMod->comentario_orden=$comentario_orden;

        $ordenMod->save();

        DB::table('ordenes_detalles')
        ->where('id_orden', $id_orden)
        ->delete();
        
        foreach ($cantidadesPartida as $partidaId => $cantidad) {
            // Solo procesa las cantidades si son mayores que 0 (o algún otro criterio)
            if ($cantidad > 0) {

                // Guarda el detalle de la orden
                OrdenesDetalles::create([
                    'id_orden' => $id_orden, // Usa el ID de la orden principal
                    'id_partida' => $partidaId, // El ID de la partida viene de la clave del array
                    'id_extra' => 0, // Esto es un detalle de partida, no de extra
                    'cantidad_orden_detalle' => $cantidad,
                    // Otros campos de OrdenDetalle si tienes
                ]);
            }
        }
        foreach ($cantidadesExtra as $extraId => $cantidad) {
            // Solo procesa las cantidades si son mayores que 0 (o algún otro criterio)
            if ($cantidad > 0) {

                // Guarda el detalle de la orden
                OrdenesDetalles::create([
                    'id_orden' => $id_orden, // Usa el ID de la orden principal
                    'id_partida' => 0, // El ID de la partida viene de la clave del array
                    'id_extra' => $extraId, // Esto es un detalle de partida, no de extra
                    'cantidad_orden_detalle' => $cantidad,
                    // Otros campos de OrdenDetalle si tienes
                ]);
            }
        }

        $partidas = Partida::where('id_proyecto', $id_proyecto)->get();
        $extras = Extra::where('id_proyecto', $id_proyecto)->get();
        //$ordenDetalleListado = OrdenesDetalles::where('id_orden', $id_orden)->get();

        $detalles = DB::table('ordenes_detalles as od') // Alias 'od' para ordenes_detalle
            ->select(
                'od.*', // Selecciona todas las columnas de ordenes_detalle
                'p.no_partida',
                'p.id_partida',
                'p.concepto_partida',
                'p.unidad_partida',
                'p.pu_partida',
                'e.no_extra',
                'e.id_extra',
                'e.concepto_extra',
                'e.unidad_extra',
                'e.pu_extra'
            )
            ->leftJoin('partidas as p', function ($join) {
                $join->on('od.id_partida', '=', 'p.id_partida')
                     ->whereNotNull('od.id_partida'); // Solo une si partida_id no es nulo
            })
            ->leftJoin('extras as e', function ($join) {
                $join->on('od.id_extra', '=', 'e.id_extra')
                     ->whereNotNull('od.id_extra'); // Solo une si extra_id no es nulo
            })
            ->where('od.id_orden', $id_orden) // Filtra por la orden de compra específica
            ->orderBy('p.no_partida','asc')
            ->orderBy('e.no_extra','asc')
            ->get();

        return redirect()->route('proyecto.partidas', ["id_proyecto" => $id_proyecto, 'id_contratista' => $id_contratista])->with('success', 'Orden guardada exitosamente.');

        //return view('partidas', compact("detalles","id_proyecto","partidas","extras"));         
    }

    public function showDetailsForModal(Ordenes $ordenDeCompra)
    {
        // Tu consulta existente para obtener los detalles de una orden de compra específica.
        // Asegúrate de que selecciona 'id_partida' o 'id_extra' para saber si es partida o extra
        // y que selecciona todos los campos necesarios para mostrar.
        $detalles = DB::table('ordenes_detalles as od')
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
                ->where('od.id_orden', $ordenDeCompra->id_orden) // Filtra por la orden de compra específica
                ->orderBy('p.no_partida','asc')
                ->orderBy('e.no_extra','asc')
                ->get();

                // 1. Obtener la Orden de Compra por su ID
                $orden = Ordenes::findOrFail($ordenDeCompra->id_orden); // Usamos findOrFail para un error 404 si no existe

                // 2. Acceder a la relación del contratista a través de la orden
                $contratista = $orden->contratista; // Asume que tienes una relación 'contratista' en tu modelo Ordenes


        // Puedes pasar la instancia de la orden de compra si necesitas su número o concepto en el modal
        return view('detalles_modal', compact('ordenDeCompra', 'detalles', 'contratista'));
    }
}
