<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anticipo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_anticipo';

    protected $fillable = [
        'id_proyecto',
        'id_contratista',
        'porcentaje',
    ];

    // Relaciones: un anticipo pertenece a un proyecto y a un contratista
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }

    public function contratista()
    {
        return $this->belongsTo(Contratista::class, 'id_contratista');
    }
}
