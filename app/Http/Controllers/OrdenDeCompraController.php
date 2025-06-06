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
        ]);     
    }

    public function agregarNuevaOC(Request $request)
    {

        $id_proyecto=$request->input("id_proyecto");
        $id_orden=$request->input("id_orden");

        $ordenCompraDetalle = new OrdenesDetalles();
        $ordenCompraDetalle->id_orden = $id_orden;
        $ordenCompraDetalle->id_partida = $request->input("codigo_oc_catalogo");
        $ordenCompraDetalle->id_extra = $request->input("codigo_oc_extra");
        $ordenCompraDetalle->cantidad_orden_detalle = $request->input("cantidad_oc");

        $ordenCompraDetalle->save();

        $partidas = Partida::where('id_proyecto', $id_proyecto)->get();
        $extras = Extra::where('id_proyecto', $id_proyecto)->get();
        $ordenDetalleListado = OrdenesDetalles::where('id_orden', $id_orden)->get();

        return view('listado-nuevaorden',[
                'id_proyecto'=>$id_proyecto,
                'partidas'=>$partidas,
                'extras'=>$extras,
                'id_orden'=>$id_orden,
        ]);         
    }
}
