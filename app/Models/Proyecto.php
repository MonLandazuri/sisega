<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    
    protected $table = 'proyectos';
    protected $primaryKey = 'id_proyecto';
    protected $fillable = [
        'nombre_proyecto', 
        'dependencia_proyecto', 
        'constructora_proyecto', 
        'fecha_proyecto', 
        'status_proyecto',
    ];

    protected $casts = [
        'fecha_proyecto' => 'datetime',
    ];
    public $timestamps = false; 

    public function anticipos()
    {
        return $this->hasMany(Anticipo::class, 'id_proyecto');
    }
}
