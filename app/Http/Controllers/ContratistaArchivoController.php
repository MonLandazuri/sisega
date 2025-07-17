<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contratista;        // Importa el modelo Contratista
use App\Models\ContratistaArchivo; // Importa el modelo ContratistaArchivo
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Para Str::slug() u otros helpers de string

class ContratistaArchivoController extends Controller
{
    // Asegúrate de que este método reciba la instancia de Contratista
    public function store(Request $request, Contratista $contratista)
    {
        $request->validate([
            'file' => 'required|file|max:20480', // 'file' es más genérico, 20480 KB = 20 MB
            // Considera tipos MIME específicos si solo quieres ciertos tipos de archivo:
            // 'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:20480',
        ]);

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $originalName = $uploadedFile->getClientOriginalName();
            $mimeType = $uploadedFile->getMimeType();
            $fileSize = $uploadedFile->getSize(); // Tamaño en bytes

            // Genera un nombre de archivo único para el almacenamiento
            // Usamos time() para unicidad y Str::slug para limpiar el nombre original
            $uniqueFileName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $uploadedFile->getClientOriginalExtension();

            // Define la ruta de almacenamiento específica para el contratista
            // Ejemplo: 'contratistas/1/documentos'
            $storageFolder = 'contratistas/' . $contratista->id . '/documentos';

            // Guarda el archivo
            // storeAs() te permite especificar el nombre de la carpeta y el nombre del archivo
            $path = $uploadedFile->storeAs($storageFolder, $uniqueFileName, 'public');

            // Guarda la información del archivo en la base de datos
            $contratistaArchivo = ContratistaArchivo::create([
                'contratista_id' => $contratista->id,
                'nombre_original' => $originalName,
                'nombre_guardado' => $uniqueFileName,
                'ruta_archivo' => $storageFolder, // Solo la carpeta, el nombre_guardado va aparte
                'tipo_archivo' => $mimeType,
                'tamano_archivo' => $fileSize,
            ]);

            // Devuelve una respuesta exitosa con datos útiles del archivo
            return response()->json([
                'success' => true,
                'message' => 'Archivo subido correctamente.',
                'file' => [
                    'id' => $contratistaArchivo->id,
                    'name' => $contratistaArchivo->nombre_original,
                    'size' => $contratistaArchivo->tamano_archivo,
                    'type' => $contratistaArchivo->tipo_archivo,      
                    'url' => $contratistaArchivo->url,  
                    'created_at' => $contratistaArchivo->created_at->format('Y-m-d H:i:s'),
                ]
            ], 200);
        }

        return response()->json(['success' => false, 'message' => 'No se pudo subir el archivo.'], 400);
    }

    // Método para listar archivos (necesitarías crear la vista correspondiente)
    public function index(Contratista $contratista)
    {
        $archivos = $contratista->archivos; // Obtiene todos los archivos del contratista
        return view('contratistas.archivos.index', compact('contratista', 'archivos'));
    }

    // Método para eliminar un archivo
    public function destroy(ContratistaArchivo $contratistaArchivo)
    {
        try {
            // Eliminar el archivo del almacenamiento físico
            Storage::disk('public')->delete($contratistaArchivo->ruta_archivo . '/' . $contratistaArchivo->nombre_guardado);

            // Eliminar el registro de la base de datos
            $contratistaArchivo->delete();

            return response()->json(['success' => true, 'message' => 'Archivo eliminado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el archivo: ' . $e->getMessage()], 500);
        }
    }
}