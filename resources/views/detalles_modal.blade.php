@if($detalles->isEmpty())
    <div class="alert alert-info">No se encontraron detalles para esta orden de compra.</div>
@else
    <h4>Orden de Compra {{ $ordenDeCompra->fecha_orden->format('d/m/Y') }}</h4>
    <table class="table table-striped table-bordered">
                  <tr>
                    <td><strong>Contratista:</strong></td>
                    <td colspan="3">{{ $contratista->nombre_contratista}}</td>
                  </tr>
                  <tr>
                    <td><strong>Dirección:</strong></td>
                    <td colspan="3">{{ $contratista->direccion_contratista}}</td>
                  </tr>
                  <tr>
                    <td><strong>Banco:</strong></td>
                    <td>{{ $contratista->banco_contratista}}</td>
                    <td><strong>CLABE:</strong></td>
                    <td>{{ $contratista->clabe_contratista}}</td>
                  </tr>
                  <tr>
                    <td><strong>Cuenta:</strong></td>
                    <td>{{ $contratista->cuenta_contratista}}</td>
                    <td><strong>Tarjeta:</strong></td>
                    <td>{{ $contratista->tarjeta_contratista}}</td>
                  </tr>
                </table>
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
            $acumuladoOrdenDetalleImporte=0;
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
                        {{ substr($concepto,0,60) }}...
                        </div>
                    @elseif ($detalle->id_extra)
                        <div data-toggle="tooltip" title="{{ $concepto=$detalle->concepto_extra}}">
                        {{ substr($concepto,0,60) }}...
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
                <th colspan="8" rowspan="3"><div class="text-center"><strong>COMENTARIO:</strong> @if($ordenDeCompra->comentario_orden=="") No hay comentario @else {{$ordenDeCompra->comentario_orden}} @endif</div></th>
                <th>SUBTOTAL</th>
                <th>${{ number_format($acumuladoOrdenDetalleImporte,2) }}</th>
            </tr>
            @if($ordenDeCompra->iva)
            <tr>
                <th>IVA</th>
                <th>${{ number_format($acumuladoOrdenDetalleImporte*0.16,2) }}</th>
            </tr>
            <tr>
                <th>TOTAL</th>
                <th>${{ number_format($acumuladoOrdenDetalleImporte*1.16,2) }}</th>
            </tr>
            @endif
        </tfoot>
        </table>  
@endif