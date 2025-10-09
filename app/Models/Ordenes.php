<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordenes extends Model
{
    use HasFactory;
    
    protected $table = 'ordenes';
    protected $primaryKey = 'id_orden';
    protected $fillable = [
        'id_orden',
        'id_proyecto', 
        'fecha_orden', 
        'id_contratista', 
        'iva',
    ];

    protected $casts = [
        'fecha_orden' => 'datetime',
    ];
    
    protected $dates = ['fecha_orden'];

    public function contratista()
    {
        return $this->belongsTo(Contratista::class, 'id_contratista');
    }

    /**
     * Una orden de compra pertenece a un proyecto.
     */
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }

    /**
     * Una orden de compra tiene muchos detalles (partidas/extras).
     */
    public function detalles()
    {
        return $this->hasMany(OrdenesDetalles::class, 'id_orden'); // Asume un modelo OrdenDetalle para los ítems de la OC
    }
}
