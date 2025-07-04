<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;
    //
    protected $table = 'partidas';
    protected $primaryKey = 'id_partida';
    protected $fillable = [
        'no_partida',
        'concepto_partida', 
        'unidad_partida', 
        'cantidad_partida', 
        'pu_partida', 
        'pu_contratista_partida', 
        'id_proyecto',
        // ... otros campos ...
    ];
}
