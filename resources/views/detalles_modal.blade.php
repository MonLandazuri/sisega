@if($detalles->isEmpty())
    <div class="alert alert-info">No se encontraron detalles para esta orden de compra.</div>
@else
    <h4>Orden de Compra {{ $ordenDeCompra->id_orden }}</h4>
    <table class="table table-bordered table-oc">
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
            @endphp
            @foreach($detalles as $detalle)
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
                <td>{{ $detalle->cantidad_orden_detalle }}</td>
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
                    $ {{ number_format($detalle->cantidad_orden_detalle * $detalle->pu_contratista_partida, 2) }}
                @elseif ($detalle->id_extra)
                    $ {{ number_format($detalle->cantidad_orden_detalle * $detalle->pu_contratista_extra, 2) }}
                @else
                    -
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>  
@endif