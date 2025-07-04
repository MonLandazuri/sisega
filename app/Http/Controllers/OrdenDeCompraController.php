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

    public function listadoNuevaOC(Request $request)
    {
        $id_proyecto=$request->input("id_proyecto");
        //$contadorOC=$request->input("contadorOC");

        $ordenCompra = new Ordenes();
        $ordenCompra->id_proyecto = $request->input("id_proyecto");
        $ordenCompra->fecha_orden = $request->input("fecha_oc");
        $ordenCompra->id_contratista = $request->input("contratista_oc");

        $ordenCompra->save();
        $id_orden=$ordenCompra->id;

        $partidas = Partida::where('id_proyecto', $id_proyecto)->get();
        $extras = Extra::where('id_proyecto', $id_proyecto)->get();

        return view('listado-nuevaorden',[
                'id_proyecto'=>$id_proyecto,
                'partidas'=>$partidas,
                'extras'=>$extras,
                'id_orden'=>$id_orden,
                'detalles'=>null,
        ]);     
    }

    public function revisionNuevaOC(Request $request)
    {

        $id_proyecto = $request->input("id_proyecto");
        $id_orden = $request->input("id_orden");

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
            'id_orden' => $id_orden,
        ]);
    }

    public function agregarNuevaOC(Request $request)
    {

        $id_proyecto=$request->input("id_proyecto");
        $id_orden=$request->input("id_orden");
        $cantidadesPartida=$request->input('cantidades_partida',[]);
        $cantidadesExtra=$request->input('cantidades_extra',[]);
        
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

        return redirect()->route('proyecto.partidas', ["id_proyecto" => $id_proyecto])->with('success', 'Orden guardada exitosamente.');

        //return view('partidas', compact("detalles","id_proyecto","partidas","extras"));         
    }
}
