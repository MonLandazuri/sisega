<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;
    
    protected $table = 'extras';
    protected $primaryKey = 'id_extra';
    protected $fillable = [
        'no_extra',
        'concepto_extra', 
        'unidad_extra', 
        'cantidad_extra', 
        'pu_extra', 
        'pu_contratista_extra', 
        'id_proyecto',
    ];
}
