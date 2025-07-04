<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Extra; // Reemplaza con el nombre de tu modelo

class TuImportadorDeExtras implements ToModel, WithHeadingRow
{
    protected $id_proyecto;
    public function __construct(int $id_proyecto)
    {
        $this->id_proyecto = $id_proyecto;
    }

    public function model(array $row)
    {        
        return new Extra([
            'no_extra' => $row['no'],
            'concepto_extra' => $row['concepto'], 
            'unidad_extra' => $row['unidad'],
            'cantidad_extra' => $row['cantidad'],
            'pu_extra' => $row['pu'],
            'pu_contratista_extra' => $row['pu_contratista'],
            'id_proyecto' => $this->id_proyecto,
        ]);
    }

    public function headingRow(): int
    {
        return 1; // Asume que la primera fila de tu Excel contiene los encabezados
    }
}