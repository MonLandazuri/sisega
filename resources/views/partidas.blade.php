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
        <li class="nav-item">
          <a class="nav-link active show" id="catalogo-tab" data-toggle="tab" href="#catalogo" role="tab" aria-controls="catalogo" aria-selected="true">CATALOGO</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="extra-tab" data-toggle="tab" href="#extra" role="tab" aria-controls="extra" aria-selected="false">EXTRAORDINARIOS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="acumulado-tab" data-toggle="tab" href="#acumulado" role="tab" aria-controls="acumulado" aria-selected="false">ACUMULADO</a>
        </li>
        @foreach ($ordenes as $orden)  
        <li class="nav-item">
          <a class="nav-link" id="oc{{$orden->id_orden}}-tab" data-toggle="tab" href="#oc{{ $orden->id_orden}}" role="tab" aria-controls="oc{{$orden->id_orden}}" aria-selected="false">O.C. {{$contadorOC+=1}}</a>
        </li>
        @endforeach
      </ul>
      <div class="tab-content tab-bordered" id="tabProyectoContenido">

        <!--  Catalogo-->
        <div class="tab-pane fade active show" id="catalogo" role="tabpanel" aria-labelledby="catalogo-tab">
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
                </tr>
                <tr>
                  <th class="col-pu">PU</th>
                  <th class="col-importe">TOTAL</th>
                  <th class="col-pu">PU</th>
                  <th class="col-importe">TOTAL</th>
                </tr>
              </thead>
              <tbody>   
              @if ($partidas->count() > 0)  
                @foreach ($partidas as $partida)                              
                <tr>
                  <td data-order="{{$partida->id_partida}}">
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
                  <td>
                    {{ $partida->cantidad_partida }}
                  </td>
                  <td>
                    ${{ number_format($partida->pu_partida,2) }}
                  </td>
                  <td>
                    ${{ number_format($partida->cantidad_partida*$partida->pu_partida,2) }}
                  </td>
                  <td>
                    ${{ number_format($partida->pu_contratista_partida,2) }}
                  </td>
                  <td>
                    ${{ number_format($partida->cantidad_partida*$partida->pu_contratista_partida,2) }}
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
                </tr>
                <tr>
                  <th class="col-pu">PU</th>
                  <th class="col-importe">TOTAL</th>
                  <th class="col-pu">PU</th>
                  <th class="col-importe">TOTAL</th>
                </tr>
              </thead>
              <tbody>   
              @if ($extras->count() > 0)  
                @foreach ($extras as $extra)                              
                <tr>
                  <td data-order="{{$extra->id_extra}}">
                    {{ $extra->no_extra }}
                  </td>
                  <td>
                    <div data-toggle="tooltip" title="{{ $conceptoExtra=$extra->concepto_extra}}">
                      {{ substr($conceptoExtra,0,110) }}...
                    </div>
                  </td>
                  <td>
                    {{ $extra->unidad_extra }}
                  </td>
                  <td>
                    {{ $extra->cantidad_extra }}
                  </td>
                  <td>
                    ${{ number_format($extra->pu_extra,2) }}
                  </td>
                  <td>
                    ${{ number_format($extra->cantidad_extra*$extra->pu_extra,2) }}
                  </td>
                  <td>
                    ${{ number_format($extra->pu_contratista_extra,2) }}
                  </td>
                  <td>
                    ${{ number_format($extra->cantidad_extra*$extra->pu_contratista_extra,2) }}
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
                          <th class="col-cantidad">CANTIDAD</th>
                          <th class="col-pu">PU SISEGA</th>
                          <th class="col-pu">PU COMPRA</th>
                          <th class="col-importe">TOTAL</th>
                          <th class="col-importe">TOTAL</th>
                      </tr>
                  </thead>
                  <tbody>
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
                              <td>{{ $item->cantidad_acumulada }}</td>
                              <td>$ {{ number_format($item->precio_unitario_base, 2) }}</td>
                              <td>$ {{ number_format($item->precio_unitario_contratista_base, 2) }}</td>
                              <td>$ {{ number_format($item->importe_acumulado, 2) }}</td>
                              <td>$ {{ number_format($item->importe_contratista_acumulado, 2) }}</td>
                          </tr>
                      @endforeach
                  </tbody>
                  <tfoot>
                      <tr class="total-row">
                          <th colspan="6"></th>
                          <th>SUBTOTAL</th>
                          <th>$ {{ number_format($totalGeneralProyecto, 2) }}</th>
                          <th>$ {{ number_format($totalContratistaProyecto, 2) }}</th>
                      </tr>
                      <tr class="total-row">
                          <th colspan="6"></th>
                          <th>IVA</th>
                          <th>$ {{ number_format($totalGeneralProyecto*0.16, 2) }}</th>
                          <th>$ {{ number_format($totalContratistaProyecto*0.16, 2) }}</th>
                      </tr>
                      <tr class="total-row">
                          <th colspan="6"></th>
                          <th>TOTAL</th>
                          <th>$ {{ number_format($totalGeneralProyecto*1.16, 2) }}</th>
                          <th>$ {{ number_format($totalContratistaProyecto*1.16, 2) }}</th>
                      </tr>
                  </tfoot>
              </table>
          @endif
        </div>

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
                <th class="">PU</th>
                <th class="">TOTAL</th>
              </tr>
            </thead>
            <tbody>
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
                        $ {{ number_format($detalle->cantidad_orden_detalle * $detalle->pu_partida, 2) }}
                    @elseif ($detalle->id_extra)
                        $ {{ number_format($detalle->cantidad_orden_detalle * $detalle->pu_extra, 2) }}
                    @else
                        -
                    @endif
                  </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<style>
  .table .col-id{
    width: 5% !important;
  }
  .table .col-concepto{
    width: 40% !important;
  }
  .table .col-unidad{
    width: 5% !important;
  }
  .table .col-cantidad{
    width: 5% !important;
  }
  .table .col-pu{
    width: 5% !important;
  }
  .table .col-importe{
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
</style>
@endsection