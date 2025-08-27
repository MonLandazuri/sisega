
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details-table th, .details-table td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th, .items-table td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .items-table th { background-color: #f2f2f2; }
    </style>

@if($ordenDetalle->isEmpty())
    <div class="alert alert-info">No se encontraron detalles para esta orden de compra.</div>
@else
    <h4 class="header">Orden de Compra </h4>
    <table class="items-table">
        <thead>                                 
            <tr>
            <th class="text-center col-id">NO</th>
            <th class="">CONCEPTO</th>
            <th class="">UNIDAD</th>
            <th class="">CANTIDAD</th>
            <th class="">COSTO SISEGA</th>
            <th class="">TOTAL</th>
            <th class="">COSTO COMPRA</th>
            <th class="">TOTAL</th>
            <th class="">DIFERENCIA</th>
            <th class="">IMPORTE</th>
            </tr>
        </thead>
        <tbody>
            @php
            $acumuladoOrdenDetalle=0;
            $acumuladoOrdenDetalleContratista=0;
            $acumuladoOrdenDetalleDiferencia=0;
            $acumuladoOrdenDetalleImporte=0;
            @endphp
            @foreach($ordenDetalle as $detalle)
            <tr>
                <td>
                    @if ($detalle->id_partida)
                        {{ $detalle->no_partida }}
                    @elseif ($detalle->id_extra)
                        {{ $detalle->no_extra }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if ($detalle->id_partida)
                        <div data-toggle="tooltip" title="{{ $concepto=$detalle->concepto_partida}}">
                        {{ substr($concepto,0,110) }}...
                        </div>
                    @elseif ($detalle->id_extra)
                        <div data-toggle="tooltip" title="{{ $concepto=$detalle->concepto_extra}}">
                        {{ substr($concepto,0,110) }}...
                        </div>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if ($detalle->id_partida)
                        {{ $detalle->unidad_partida }}
                    @elseif ($detalle->id_extra)
                        {{ $detalle->unidad_extra }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ number_format($detalle->cantidad_orden_detalle,2) }}</td>
                <td>
                @if ($detalle->id_partida)
                    $ {{ number_format($detalle->pu_partida, 2) }}
                @elseif ($detalle->id_extra)
                    $ {{ number_format($detalle->pu_extra, 2) }}
                @else
                    -
                @endif 
                </td>
                <td> 
                @if ($detalle->id_partida)
                    @php
                    $acumuladoOrdenDetalle+=$detalle->cantidad_orden_detalle * $detalle->pu_partida;
                    @endphp
                    $ {{ number_format($detalle->cantidad_orden_detalle * $detalle->pu_partida, 2) }}
                @elseif ($detalle->id_extra)
                    @php
                    $acumuladoOrdenDetalle+=$detalle->cantidad_orden_detalle * $detalle->pu_extra;
                    @endphp
                    $ {{ number_format($detalle->cantidad_orden_detalle * $detalle->pu_extra, 2) }}
                @else
                    -
                @endif
                </td>
                <td>
                @if ($detalle->id_partida)
                    $ {{ number_format($detalle->pu_contratista_partida, 2) }}
                @elseif ($detalle->id_extra)
                    $ {{ number_format($detalle->pu_contratista_extra, 2) }}
                @else
                    -
                @endif 
                </td>
                <td> 
                @if ($detalle->id_partida)
                    @php
                    $acumuladoOrdenDetalleContratista+=$detalle->cantidad_orden_detalle * $detalle->pu_contratista_partida;
                    @endphp
                    $ {{ number_format($detalle->cantidad_orden_detalle * $detalle->pu_contratista_partida, 2) }}
                @elseif ($detalle->id_extra)
                    @php
                    $acumuladoOrdenDetalleContratista+=$detalle->cantidad_orden_detalle * $detalle->pu_contratista_extra;
                    @endphp
                    $ {{ number_format($detalle->cantidad_orden_detalle * $detalle->pu_contratista_extra, 2) }}
                @else
                    -
                @endif
                </td>
                <td> 
                @if ($detalle->id_partida)
                    @php
                    $acumuladoOrdenDetalleDiferencia+=($detalle->cantidad_orden_detalle * $detalle->pu_partida)-($detalle->cantidad_orden_detalle * $detalle->pu_contratista_partida);
                    @endphp
                    $ {{ number_format(($detalle->cantidad_orden_detalle * $detalle->pu_partida)-($detalle->cantidad_orden_detalle * $detalle->pu_contratista_partida), 2) }}
                @elseif ($detalle->id_extra)
                    @php
                    $acumuladoOrdenDetalleDiferencia+=($detalle->cantidad_orden_detalle * $detalle->pu_extra)-($detalle->cantidad_orden_detalle * $detalle->pu_contratista_extra);
                    @endphp
                    $ {{ number_format(($detalle->cantidad_orden_detalle * $detalle->pu_extra)-($detalle->cantidad_orden_detalle * $detalle->pu_contratista_extra), 2) }}
                @else
                    -
                @endif
                </td>
                <td> 
                @if ($detalle->id_partida)
                    @php
                    $acumuladoOrdenDetalleImporte+=$detalle->cantidad_orden_detalle * $detalle->pu_contratista_partida;
                    @endphp
                    $ {{ number_format($detalle->cantidad_orden_detalle * $detalle->pu_contratista_partida, 2) }}
                @elseif ($detalle->id_extra)
                    @php
                    $acumuladoOrdenDetalleImporte+=$detalle->cantidad_orden_detalle * $detalle->pu_contratista_extra;
                    @endphp
                    $ {{ number_format($detalle->cantidad_orden_detalle * $detalle->pu_contratista_extra, 2) }}
                @else
                    -
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5"></th>
                <th>$ {{ number_format($acumuladoOrdenDetalle,2) }}</th>
                <th></th>
                <th>$ {{ number_format($acumuladoOrdenDetalleContratista,2) }}</th>
                <th>$ {{ number_format($acumuladoOrdenDetalleDiferencia,2) }}</th>
                <th>$ {{ number_format($acumuladoOrdenDetalleImporte,2) }}</th>
            </tr>
            <tr>
                <th colspan="10"></th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th>SUBTOTAL</th>
                <th>${{ number_format($acumuladoOrdenDetalleImporte,2) }}</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th>IVA</th>
                <th>${{ number_format($acumuladoOrdenDetalleImporte*0.16,2) }}</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th>TOTAL</th>
                <th>${{ number_format($acumuladoOrdenDetalleImporte*1.16,2) }}</th>
            </tr>
        </tfoot>
        </table>
@endif