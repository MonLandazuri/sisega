<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenesDetalles extends Model
{
    use HasFactory;
    
    protected $table = 'ordenes_detalles';
    protected $fillable = [
        'id_orden', 
        'id_partida', 
        'id_extra', 
        'cantidad_orden_detalle', 
    ];
}
