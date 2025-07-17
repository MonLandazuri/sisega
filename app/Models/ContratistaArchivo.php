<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // Para helper de URL

class ContratistaArchivo extends Model
{
    use HasFactory;

    protected $table = 'contratista_archivos';

    protected $fillable = [
        'contratista_id',
        'nombre_original',
        'nombre_guardado',
        'ruta_archivo',
        'tipo_archivo',
        'tamano_archivo',
    ];

    // Relación con Contratista
    public function contratista()
    {
        return $this->belongsTo(Contratista::class);
    }

    // Accesor para obtener la URL completa del archivo para ver/descargar
    public function getUrlAttribute()
    {
        return Storage::url($this->ruta_archivo . '/' . $this->nombre_guardado);
    }

    // Accesor para un tipo de archivo más legible (opcional)
    public function getTypeAttribute()
    {
        if (str_contains($this->tipo_archivo, 'image')) return 'Imagen';
        if (str_contains($this->tipo_archivo, 'pdf')) return 'PDF';
        if (str_contains($this->tipo_archivo, 'excel') || str_contains($this->tipo_archivo, 'spreadsheet')) return 'Excel';
        if (str_contains($this->tipo_archivo, 'word')) return 'Word';
        return 'Documento';
    }
}