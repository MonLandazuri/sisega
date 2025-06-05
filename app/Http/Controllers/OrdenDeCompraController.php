<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;
use App\Models\Partida;
use App\Models\Extra;
use App\Models\Contratista;
use App\Http\Controllers\Controller;

class OrdenDeCompraController extends Controller
{
    public function mostrarOC($id_proyecto){
        return view('nuevaorden'); 
    }

    public function nuevaOC($id_proyecto)
    {
        $partidas = Partida::where('id_proyecto', $id_proyecto)->get();
        $extras = Extra::where('id_proyecto', $id_proyecto)->get();
        $contratistas = Contratista::all();

        return view('nuevaorden',[
                'id_proyecto'=>$id_proyecto,
                'partidas'=>$partidas,
                'extras'=>$extras,
                'contratistas'=>$contratistas,
        ]);    
    }
    public function agregarNuevaOC(Request $request, $id_proyecto)
    {
        return view('nuevaorden');    
    }
}
