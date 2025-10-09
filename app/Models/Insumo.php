<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;
    //
    protected $table = 'insumos';
    protected $primaryKey = 'id_insumo';
    protected $fillable = [
        'no_insumo',
        'concepto_insumo', 
        'unidad_insumo', 
        'cantidad_insumo', 
        'pu_insumo', 
        'zonadeuso_insumo', 
        'id_proyecto',
        // ... otros campos ...
    ];
}
