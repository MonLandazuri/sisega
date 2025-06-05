<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TuImportadorDeExtras; // Creamos esta clase en el siguiente paso
use Illuminate\Support\Facades\Redirect;

class ExcelImportControllerExtra extends Controller
{
    public function showImportFormExtra(Request $request, $id_proyecto)
    {
        return view('importar-extra',['id_proyecto'=>$id_proyecto]); 
    }

    public function importExcelExtra(Request $request, $id_proyecto)
    {
        $request->validate([
            'archivo_excel' => 'required|mimes:xlsx,xls', 
        ]);

        try {
            Excel::import(new TuImportadorDeExtras($id_proyecto), $request->file('archivo_excel'));

            return Redirect::route('proyecto.partidas',['id_proyecto'=>$id_proyecto])->with('success', '¡Datos importados exitosamente!');
        } catch (\Maatwebsite\Excel\Exceptions\NoTypeDetectedException $e) {
            return Redirect::back()->withErrors(['archivo_excel' => 'Formato de archivo no soportado.']);
        } catch (\Exception $e) {
            // Log del error para depuración
            \Log::error('Error al importar Excel: ' . $e->getMessage());
            return Redirect::back()->withErrors(['general' => 'Ocurrió un error al importar los datos. Por favor, inténtalo de nuevo.']);
        }
    }
}