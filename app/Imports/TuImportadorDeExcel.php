<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Partida; // Reemplaza con el nombre de tu modelo

class TuImportadorDeExcel implements ToModel, WithHeadingRow
{
    protected $id_proyecto;
    public function __construct(int $id_proyecto)
    {
        $this->id_proyecto = $id_proyecto;
    }
    
    public function model(array $row)
    {        
        return new Partida([
            'no_partida' => $row['no'],
            'concepto_partida' => $row['concepto'], 
            'unidad_partida' => $row['unidad'],
            'cantidad_partida' => $row['cantidad'],
            'pu_partida' => $row['pu'],
            'pu_contratista_partida' => $row['pu_contratista'],
            'id_proyecto' => $this->id_proyecto,
        ]);
    }

    public function headingRow(): int
    {
        return 1; // Asume que la primera fila de tu Excel contiene los encabezados
    }
}