<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordenes extends Model
{
    use HasFactory;
    
    protected $table = 'ordenes';
    protected $fillable = [
        'id_orden',
        'id_proyecto', 
        'fecha_orden', 
        'id_contratista', 
    ];
}
