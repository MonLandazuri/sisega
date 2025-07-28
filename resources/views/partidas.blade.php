@extends('layouts.master')

@section('content')
<section class="section">
  <div class="section-header">
  </div>

  <div class="card">
    <div class="">
      @foreach ($proyectos as $proyecto)  
      <table class="datos-proyecto">
        <tr>
          <td class="titulo">Proyecto:</td>
          <td><span class="dato">{{ $proyecto->nombre_proyecto}}</span></td>
        </tr>     
        <tr>
          <td class="titulo">Dependencia:</td>
          <td><span class="dato"> {{$proyecto->dependencia_proyecto}}</span></td>
        </tr>
        <tr>
          <td class="titulo">Fecha:</td>
          <td><span class="dato"> {{$proyecto->fecha_proyecto}}</span></td>
        </tr>
      </table>
      @endforeach
    </div>
    <div class="card-body">
      <div class="mt-4 mb-4 p-1 buttons"> 
        @php
        $contadorOC=0;
        @endphp
        @if ($partidas->count() > 0) 
        <a href="{{ route('import.form', ['id_proyecto' => $id_proyecto]) }}" class="btn disabled btn-info icon-left" title="Importar Catalogo">IMPORTAR CATALOGO</a>
        @else 
        <a href="{{ route('import.form', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-info icon-left" title="Importar Catalogo">IMPORTAR CATALOGO</a>
        @endif
        <a href="{{ route('import.form.extra', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-icon icon-left btn-dark"  title="Importar Extraordinarios">IMPORTAR EXTRAS</a>
        <a href="{{ route('nueva.oc', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-info icon-left" title="Nueva OC">NUEVA OC</a>
      </div>
      <ul class="nav nav-tabs" id="tabsProyecto" role="tablist">
        <li class="nav-item azul-claro">
          <a class="nav-link active show" id="catalogo-tab" data-toggle="tab" href="#catalogo" role="tab" aria-controls="catalogo" aria-selected="true">CATALOGO</a>
        </li>
        <li class="nav-item azul-oscuro">
          <a class="nav-link" id="extra-tab" data-toggle="tab" href="#extra" role="tab" aria-controls="extra" aria-selected="false">EXTRAORDINARIOS</a>
        </li>
        <li class="nav-item negro">
          <a class="nav-link" id="acumulado-tab" data-toggle="tab" href="#acumulado" role="tab" aria-controls="acumulado" aria-selected="false">ACUMULADO</a>
        </li>
        @foreach ($totalContratistas as $contratista)
          <li class="nav-item naranja">
            <a class="nav-link" id="{{ $contratista->id_contratista}}-tab" data-toggle="tab" href="#contratista{{ $contratista->id_contratista}}" role="tab" aria-controls="acumulado" aria-selected="false">{{ $contratista->nombre_contratista }} <a>
          </li>
        @endforeach
        @foreach ($ordenes as $orden)  
        <!--<li class="nav-item">
          <a class="nav-link" id="oc{{$orden->id_orden}}-tab" data-toggle="tab" href="#oc{{ $orden->id_orden}}" role="tab" aria-controls="oc{{$orden->id_orden}}" aria-selected="false">O.C. {{$contadorOC+=1}}</a>
        </li>-->
        @endforeach
      </ul>
      <div class="tab-content tab-bordered" id="tabProyectoContenido">

        <!--  Catalogo-->
        <div class="tab-pane fade active show" id="catalogo" role="tabpanel" aria-labelledby="catalogo-tab">
          <a href="{{ route('nuevo.partida', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-danger icon-left" title="Nuevo Elemento Catalogo"><i class="fas fa-plus"></i> NUEVO ELEMENTO</a> 
          <div class="row col-12 justify-content-end">
            <div class="">
              <table class="table table-striped">
                <tr>
                  <th></th>
                  <th class="text-center">{{$proyecto->constructora_proyecto}}</th>
                  <th></th>
                  <th class="text-center">CONTRATISTA</th>
                </tr>
                <tr>
                  <td>
                    <h4>SUBTOTAL</h4>
                  </td>
                  <td>
                    <span class="card-body"  id="totalImporte">$ {{ number_format($totalImporte, 2) }}</span>
                  </td>
                  <td></td>
                  <td>
                    <span class="card-body" id="totalImporte">$ {{ number_format($totalContratistaImporte, 2) }}</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h4>I.V.A.</h4>
                  </td>
                  <td>
                    <span class="card-body"  id="totalImporte">$ {{ number_format(($totalImporte*0.16), 2) }}</span>
                  </td>
                  <td></td>
                  <td>
                    <span class="card-body"  id="totalImporte">$ {{ number_format(($totalContratistaImporte*0.16), 2) }}</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h4>TOTAL</h4>
                  </td>
                  <td>
                    <span class="card-body" id="totalImporte">$ {{ number_format(($totalImporte*1.16), 2) }}</span>
                  </td>
                  <td></td>
                  <td>
                    <span class="card-body" id="totalImporte">$ {{ number_format(($totalContratistaImporte*1.16), 2) }}</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-12">
            <table class="table table-striped table-bordered table-partidas" id="table-partidas">
              <thead>                                 
                <tr>
                  <th rowspan="2" class="text-center col-id">NO</th>
                  <th rowspan="2" class="col-concepto">CONCEPTO</th>
                  <th rowspan="2" class="col-unidad">UNIDAD</th>
                  <th rowspan="2" class="col-cantidad">CANTIDAD</th>
                  <th colspan="2" class="text-center">{{$proyecto->constructora_proyecto}}</th>
                  <th colspan="2" class="text-center">CONTRATISTA</th>
                  <th></th> 
                </tr>
                <tr>
                  <th class="col-importe">PU</th>
                  <th class="col-importe">TOTAL</th>
                  <th class="col-importe">PU</th>
                  <th class="col-importe">TOTAL</th>
                  <th class="col-pu"></th>
                </tr>
              </thead>
              <tbody>   
              @if ($partidas->count() > 0)  
                @foreach ($partidas as $partida)                              
                <tr>
                  <td class="text-center" data-order="{{$partida->id_partida}}">
                    {{ $partida->no_partida }}
                  </td>
                  <td>
                    <div data-toggle="tooltip" title="{{ $concepto=$partida->concepto_partida}}">
                      {{ substr($concepto,0,110) }}...
                    </div>
                  </td>
                  <td>
                    {{ $partida->unidad_partida }}
                  </td>
                  <!--<td class="align-middle">
                    <div class="progress" data-height="4" data-toggle="tooltip" title="100%">
                      <div class="progress-bar bg-success" data-width="100%"></div>
                    </div>
                  </td>-->
                  <td class="text-right">
                    {{ $partida->cantidad_partida }}
                  </td>
                  <td class="text-right">
                    ${{ number_format($partida->pu_partida,2) }}
                  </td>
                  <td class="text-right">
                    ${{ number_format($partida->cantidad_partida*$partida->pu_partida,2) }}
                  </td>
                  <td class="text-right">
                    ${{ number_format($partida->pu_contratista_partida,2) }}
                  </td>
                  <td class="text-right">
                    ${{ number_format($partida->cantidad_partida*$partida->pu_contratista_partida,2) }}
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-info view-details-btn"
                            data-toggle="modal" data-target="#ocDetailsModal"
                            data-id="{{ $partida->id_partida }}"
                            title="Editar">
                        <i class="fas fa-pen"></i> 
                    </button>
                    <button type="button" class="btn btn-sm btn-info view-details-btn"
                            data-toggle="modal" data-target="#ocDetailsModal"
                            data-id="{{ $partida->id_partida }}"
                            title="Eliminar">
                        <i class="fas fa-trash"></i> 
                    </button>
                  </td>
                </tr>
                @endforeach 
                @else
                    <p>No hay partidas disponibles.</p>
                @endif
              </tbody>
            </table>
          </div>
        </div>

        <!-- Extraordinarios-->
        <div class="tab-pane fade show" id="extra" role="tabpanel" aria-labelledby="extra-tab">
          <div class="row col-12 justify-content-end">
            <div class="">
              <table class="table table-striped">
                <tr>
                  <th></th>
                  <th class="text-center">{{$proyecto->constructora_proyecto}}</th>
                  <th></th>
                  <th class="text-center">CONTRATISTA</th>
                </tr>
                <tr>
                  <td>
                    <h4>SUBTOTAL</h4>
                  </td>
                  <td>
                    <span class="card-body"  id="totalImporte">$ {{ number_format($totalImporteExtra, 2) }}</span>
                  </td>
                  <td></td>
                  <td>
                    <span class="card-body" id="totalImporte">$ {{ number_format($totalContratistaImporteExtra, 2) }}</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h4>I.V.A.</h4>
                  </td>
                  <td>
                    <span class="card-body"  id="totalImporte">$ {{ number_format(($totalImporteExtra*0.16), 2) }}</span>
                  </td>
                  <td></td>
                  <td>
                    <span class="card-body"  id="totalImporte">$ {{ number_format(($totalContratistaImporteExtra*0.16), 2) }}</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h4>TOTAL</h4>
                  </td>
                  <td>
                    <span class="card-body" id="totalImporte">$ {{ number_format(($totalImporteExtra*1.16), 2) }}</span>
                  </td>
                  <td></td>
                  <td>
                    <span class="card-body" id="totalImporte">$ {{ number_format(($totalContratistaImporteExtra*1.16), 2) }}</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-12">
            <table class="table table-striped table-bordered table-extras" id="table-extras">
              <thead>                              
                <tr>
                  <th rowspan="2" class="text-center col-id">NO</th>
                  <th rowspan="2" class="col-concepto">CONCEPTO</th>
                  <th rowspan="2" class="col-unidad">UNIDAD</th>
                  <th rowspan="2" class="col-cantidad">CANTIDAD</th>
                  <th colspan="2" class="text-center">{{$proyecto->constructora_proyecto}}</th>
                  <th colspan="2" class="text-center">CONTRATISTA</th>
                  <th class="col-pu"></th>
                </tr>
                <tr>
                  <th class="col-importe">PU</th>
                  <th class="col-importe">TOTAL</th>
                  <th class="col-importe">PU</th>
                  <th class="col-importe">TOTAL</th>
                  <th class="col-pu"></th>
                </tr>
              </thead>
              <tbody>   
              @if ($extras->count() > 0)  
                @foreach ($extras as $extra)                              
                <tr>
                  <td class="text-center" data-order="{{$extra->id_extra}}">
                    {{ $extra->no_extra }}
                  </td>
                  <td>
                    <div data-toggle="tooltip" title="{{ $conceptoExtra=$extra->concepto_extra}}">
                      {{ substr($conceptoExtra,0,110) }}...
                    </div>
                  </td>
                  <td class="text-center">
                    {{ $extra->unidad_extra }}
                  </td>
                  <td class="text-right">
                    {{ $extra->cantidad_extra }}
                  </td>
                  <td class="text-right">
                    ${{ number_format($extra->pu_extra,2) }}
                  </td>
                  <td class="text-right">
                    ${{ number_format($extra->cantidad_extra*$extra->pu_extra,2) }}
                  </td>
                  <td class="text-right">
                    ${{ number_format($extra->pu_contratista_extra,2) }}
                  </td>
                  <td class="text-right">
                    ${{ number_format($extra->cantidad_extra*$extra->pu_contratista_extra,2) }}
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-info view-details-btn"
                            data-toggle="modal" data-target="#ocDetailsModal"
                            data-id="{{ $partida->id_extra }}"
                            title="Editar">
                        <i class="fas fa-pen"></i> 
                    </button>
                    <button type="button" class="btn btn-sm btn-info view-details-btn"
                            data-toggle="modal" data-target="#ocDetailsModal"
                            data-id="{{ $partida->id_extra }}"
                            title="Eliminar">
                        <i class="fas fa-trash"></i> 
                    </button>
                  </td>
                </tr>
                @endforeach 
                @else
                    <p>No hay extras disponibles.</p>
                @endif
              </tbody>
            </table>
          </div>
        </div>

        <!-- Acumulado-->
        <div class="tab-pane fade show" id="acumulado" role="tabpanel" aria-labelledby="acumulado-tab">
          @if($acumulados->isEmpty())
              <p>No se encontraron partidas o extras en órdenes de compra para este proyecto.</p>
          @else
              <table class="table table-striped table-bordered" id="tablaAcumulados">
                  <thead>
                      <tr>
                          <th class="col-id">NO</th>
                          <th class="col-concepto">CONCEPTO</th>
                          <th class="col-unidad">UNIDAD</th>
                          <th class="col-cantidad">CANTIDAD</th>
                          <th class="col-pu">P.U.</th>
                          <th class="col-pu">IMPORTE</th>
                          <th class="col-pu">CANT. TOTAL</th>
                          <th class="col-pu">IMP. TOTAL</th>
                          <th class="col-pu">DIF. CANT.</th>
                          <th class="col-pu">DIFERENCIA</th>
                          <th class="col-pu" style="display: none">PU COMPRA</th>
                          <th class="col-pu" style="display: none">TOTAL</th>
                      </tr>
                  </thead>
                  <tbody>
                    @php
                    $totalAcumuladoImporte=0;
                    $totalAcumuladoDiferencia=0;
                    @endphp
                      @foreach($acumulados as $item)
                          <tr>
                              <td>{{ $item->numero_referencia }}</td>
                              <td>
                                <div data-toggle="tooltip" title="{{ $concepto=$item->concepto_referencia}}">
                                {{ substr($concepto,0,110) }}...
                                </div>
                              </td>
                              <td>{{ $item->unidad_referencia }}</td>
                              <td>{{ $item->cantidad_referencia }}</td>
                              <td>$ {{ number_format($item->precio_unitario_base, 2) }}</td>
                              <td>$ {{ number_format($item->cantidad_referencia*$item->precio_unitario_base, 2) }}</td>
                              <td>{{ $item->cantidad_acumulada }}</td>
                              <td>$ {{ number_format($item->cantidad_acumulada*$item->precio_unitario_base,2) }}</td>
                              <td>
                                @if(( $item->cantidad_referencia - $item->cantidad_acumulada) < 0 )
                                <span style="color: red">
                                @else
                                  <span>
                                @endif
                                {{ $item->cantidad_referencia - $item->cantidad_acumulada }}
                                  </span>
                              </td>
                              <td>
                                @if( ($item->cantidad_referencia*$item->precio_unitario_base) - ($item->cantidad_acumulada*$item->precio_unitario_base) < 0 )
                                  <span style="color: red">
                                @else
                                  <span>
                                @endif
                                $ {{ number_format(($item->cantidad_referencia*$item->precio_unitario_base) - ($item->cantidad_acumulada*$item->precio_unitario_base) ,2) }}
                                  </span>
                              </td>
                              <td style="display: none">$ {{ number_format($item->precio_unitario_contratista_base, 2) }}</td>
                              <td style="display: none">$ {{ number_format($item->importe_contratista_acumulado, 2) }}</td>
                              @php
                              $totalAcumuladoImporte+=($item->cantidad_referencia*$item->precio_unitario_base);
                              $totalAcumuladoDiferencia+=($item->cantidad_referencia*$item->precio_unitario_base) - ($item->cantidad_acumulada*$item->precio_unitario_base);
                              @endphp
                          </tr>
                      @endforeach
                  </tbody>
                  <tfoot>
                      <tr class="total-row">
                          <th colspan="4"></th>
                          <th>SUBTOTAL</th>
                          <th>$ {{ number_format($totalAcumuladoImporte, 2) }}</th>
                          <th></th>
                          <th>$ {{ number_format($totalGeneralProyecto, 2) }}</th>
                          <th></th>
                          <th>$ {{ number_format($totalAcumuladoDiferencia, 2) }}</th>
                      </tr>
                      <tr class="total-row">
                          <th colspan="4"></th>
                          <th>IVA</th>
                          <th>$ {{ number_format($totalAcumuladoImporte*0.16, 2) }}</th>
                          <th></th>
                          <th>$ {{ number_format($totalGeneralProyecto*0.16, 2) }}</th>
                          <th></th>
                          <th>$ {{ number_format($totalAcumuladoDiferencia*0.16, 2) }}</th>
                      </tr>
                      <tr class="total-row">
                          <th colspan="4"></th>
                          <th>TOTAL</th>
                          <th>$ {{ number_format($totalAcumuladoImporte*1.16, 2) }}</th>
                          <th></th>
                          <th>$ {{ number_format($totalGeneralProyecto*1.16, 2) }}</th>
                          <th></th>
                          <th>$ {{ number_format($totalAcumuladoDiferencia*1.16, 2) }}</th>
                      </tr>
                  </tfoot>
              </table>
          @endif
        </div>

        <!--Contratistas-->
        @if($totalContratistas->isEmpty())
              <p>No se encontraron partidas o extras en órdenes de compra para este proyecto.</p>
          @else
            @foreach ($totalContratistas as $contratista)
              @php
              $detallesContratista=$todosLosDetallesDeOrdenes->where('id_contratista',$contratista->id_contratista)->sortBy('id_orden');  
              $idsDeOrdenUnicos =$detallesContratista->pluck('id_orden')->unique();
              @endphp
              <div class="tab-pane fade show" id="contratista{{$contratista->id_contratista}}" role="tabpanel" aria-labelledby="contratista{{$contratista->id_contratista}}-tab">
              <table class="table contratistas table-bordered">
                <thead>
                  <tr>
                    <th class="col-orden">ORDEN</th>
                    <th>FECHA</th>
                    <th class="col-total">SUBTOTAL</th>
                    <th>IVA</th>
                    <th>TOTAL</th>
                    <th>ACCIONES</th>
                  </tr>
                </thead>
                @foreach($idsDeOrdenUnicos as $idDeOrden)
                @php
                $detalleDeContratista=$detallesContratista->where('id_orden',$idDeOrden);
                @endphp
                <tr>
                  <td class="multi-collapse collapse" id="contenido{{$idDeOrden}}" colspan="4">
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
                        @foreach($detalleDeContratista as $detalle)
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
                  </td>
                </tr>
                <tr>
                  <td>
                    <!--<a class="btn btn-primary collapsed" data-toggle="collapse" href="#contenido{{$idDeOrden}}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">ORDEN {{$idDeOrden}}</a>-->
                    {{$idDeOrden}}
                  </td>
                  <td>
                    @php
                    $ordenEspecifico=$todosLosDetallesDeOrdenes->where('id_orden',$idDeOrden)->first();
                    @endphp
                    {{$ordenEspecifico->fecha_orden}}
                  </td>
                  <td>$ {{number_format($acumuladoOrdenDetalleContratista,2)}}</td>
                  <td>$ {{number_format($acumuladoOrdenDetalleContratista*0.16,2)}}</td>
                  <td>$ {{number_format($acumuladoOrdenDetalleContratista*1.16,2)}}</td>
                  <td>
                    <button type="button" class="btn btn-sm btn-info view-details-btn"
                            data-toggle="modal" data-target="#ocDetailsModal"
                            data-id="{{ $idDeOrden }}"
                            title="Ver Detalles de la Orden">
                        <i class="fas fa-eye"></i> Detalles
                    </button>
                  </td>
                </tr>
                @endforeach
                </table>
              </div>
            @endforeach
          @endif

        <!-- Ordenes de Compra-->
        @foreach ($ordenes as $orden)  
        <div class="tab-pane fade show" id="oc{{$orden->id_orden}}" role="tabpanel" aria-labelledby="oc{{$orden->id_orden}}-tab">
          @php
              // Filtrar los detalles que corresponden a esta orden específica
              $detallesDeEstaOrden = $todosLosDetallesDeOrdenes->where('id_orden', $orden->id_orden);
          @endphp
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
              @foreach($detallesDeEstaOrden as $detalle)
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
            <tfoot>
              <tr>
                <th colspan="8"></th>
                <th>TOTAL</th>
                <th>$ {{number_format($acumuladoOrdenDetalleContratista,2)}}</th>
              </tr>
              <tr>
                <th colspan="8"></th>
                <th>IVA</th>
                <th>$ {{number_format($acumuladoOrdenDetalleContratista*0.16,2)}}</th>
              </tr>
              <tr>
                <th colspan="8"></th>
                <th>SUBTOTAL</th>
                <th>$ {{number_format($acumuladoOrdenDetalleContratista*1.16,2)}}</th>
              </tr>
            </tfoot>
          </table>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

{{-- INICIO DEL MODAL GENÉRICO --}}
<div class="modal fade" id="ocDetailsModal" tabindex="-1" aria-labelledby="ocDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> {{-- Puedes ajustar el tamaño del modal --}}
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="ocDetailsModalLabel">Detalles de la Orden de Compra</h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Aquí se cargará el contenido dinámicamente --}}
                <div class="text-center loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p>Cargando detalles de la orden...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
{{-- FIN DEL MODAL GENÉRICO --}}


<style>
  .azul-claro{
    background: #3abaf4;
    border-radius: 10px 10px 0 0;
  } 

  .azul-claro a:not(.active){
    color: #FFFFFF !important;
  }

  .azul-oscuro{
    background: #0050bfff;
    border-radius: 10px 10px 0 0;
  }
  .azul-oscuro a:not(.active){
    color: #FFFFFF !important;
  }

  .negro{
    background: #000000;
    border-radius: 10px 10px 0 0;
  } 
  .negro a:not(.active){
    color: #FFFFFF !important;
  }

  .naranja{
    background: #ff7104ff;
    border-radius: 10px 10px 0 0;
  } 
  .naranja a:not(.active){
    color: #FFFFFF !important;
  }

  .table .col-id{
    width: 3% !important;
  }
  .table .col-concepto{
    width: 40% !important;
  }
  .table .col-unidad{
    width: 3% !important;
  }
  .table .col-cantidad{
    width: 5% !important;
  }
  .table .col-pu{
    width: 5% !important;
  }
  .table .col-importe{
    width: 7% !important;
  }

  .table.contratistas .col-orden{
    width: 10% !important;
  }

  .datos-proyecto .titulo{
    font-weight: bold;
    font-size: 16px;
    padding: 5px 0 5px 10px;
  }

  .datos-proyecto .dato{
    font-size: 16px;
    padding: 5px 0 5px 10px;
  }

  .modal-xl{
    max-width: 90% !important;
  }
</style>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        // Captura el evento 'show.bs.modal' (antes de que el modal se muestre)
        $('#ocDetailsModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var ordenId = button.data('id'); // Extrae el ID de la orden del atributo data-id

            var modal = $(this);
            var modalBody = modal.find('.modal-body');
            var modalTitle = modal.find('.modal-title');

            // Muestra el spinner de carga
            modalBody.html(`
                <div class="text-center loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p>Cargando detalles de la orden...</p>
                </div>
            `);
            modalTitle.text('Cargando Detalles de la Orden...'); // Título temporal

            // Realiza la llamada AJAX para obtener los detalles
            $.ajax({
                url: "{{ url('/ordenes') }}/" + ordenId + "/detalles-modal",
                method: 'GET',
                success: function(response) {
                    // Inyecta el HTML recibido en el cuerpo del modal
                    modalBody.html(response);
                    // Actualiza el título del modal (puedes ajustarlo si el parcial no devuelve el título específico)
                    modalTitle.text('Detalles de la Orden de Compra'); // Se actualizará desde el parcial si el partial_modal.blade.php tiene el h4
                },
                error: function(xhr) {
                    console.error("Error al cargar los detalles de la OC:", xhr.responseText);
                    modalBody.html('<div class="alert alert-danger">Error al cargar los detalles. Inténtalo de nuevo.</div>');
                    modalTitle.text('Error');
                }
            });
        });

        // Limpiar el contenido del modal cuando se cierra para evitar mostrar datos viejos
        $('#ocDetailsModal').on('hidden.bs.modal', function () {
            $(this).find('.modal-body').empty(); // Vacía el cuerpo del modal
            $(this).find('.modal-title').text('Detalles de la Orden de Compra'); // Resetea el título
        });
    });
</script>
@endsection