@extends('layouts.master')

@section('content')
<section class="section">
  <div class="section-header">
  </div>

  <div class="card">
    <div class="card-header">
      @foreach ($proyectos as $proyecto)       
      <h2>{{ $proyecto->nombre_proyecto}}</h2>
      <hr><br>
      <p>Dependencia: {{$proyecto->dependencia_proyecto}}</p>
      @endforeach
    </div>
    <div class="card-body">
      <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
          <a class="nav-link active show" id="catalogo-tab2" data-toggle="tab" href="#catalogo" role="tab" aria-controls="catalogo" aria-selected="true">CATALOGO</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="extra-tab2" data-toggle="tab" href="#extras" role="tab" aria-controls="extraordinarios" aria-selected="false">EXTRAORDINARIOS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="acumulado-tab2" data-toggle="tab" href="#acumulado" role="tab" aria-controls="acumulado" aria-selected="false">ACUMULADO</a>
        </li>
        @foreach ($ordenes as $orden)     
        <li class="nav-item">
          <a class="nav-link" id="oc{{$orden->id_orden}}-tab2" data-toggle="tab" href="#oc{{ $orden->id_orden}}" role="tab" aria-controls="oc{{$orden->id_orden}}" aria-selected="false">O.C. {{ $orden->id_orden}}</a>
        </li>
        @endforeach
      </ul>
      <div class="tab-content tab-bordered" id="myTab3Content">
        <div class="tab-pane fade active show" id="catalogo" role="tabpanel" aria-labelledby="home-tab2">
          <div class="mt-4 mb-4 p-1 buttons"> 
            @if ($partidas->count() > 0) 
            <a href="{{ route('import.form', ['id_proyecto' => $id_proyecto]) }}" class="btn disabled btn-info icon-left" data-toggle="tooltip" title="Importar Catalogo"><i class="far fa-file"></i> CATALOGO</a>
            @else 
            <a href="{{ route('import.form', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-info icon-left" data-toggle="tooltip" title="Importar Catalogo"><i class="far fa-file"></i> CATALOGO</a>
            @endif
            <a href="{{ route('nueva.oc', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-info icon-left" data-toggle="tooltip" title="Nueva OC"><i class="far fa-file"></i> NUEVA OC</a>
          </div>
          <div class="row col-12">
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Subtotal</h4>
                  </div>
                  <div class="card-body">
                    $<span id="totalImporte">{{ number_format($totalImporte, 2) }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>I.V.A.</h4>
                  </div>
                  <div class="card-body">
                    $<span id="totalImporte">{{ number_format(($totalImporte*0.16), 2) }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total</h4>
                  </div>
                  <div class="card-body">
                    $<span id="totalImporte">{{ number_format(($totalImporte*1.16), 2) }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-partidas" id="table-1">
              <thead>                                 
                <tr>
                  <th class="text-center col-id">
                    #
                  </th>
                  <th class="col-concepto">Concepto</th>
                  <th class="col-unidad">Unidad</th>
                  <th class="col-cantidad">Cantidad</th>
                  <th class="col-pu">PU</th>
                  <th class="col-importe">Importe</th>
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
                      {{ substr($concepto,0,100) }}
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
                </tr>
                @endforeach 
                @else
                    <p>No hay partidas disponibles.</p>
                @endif
              </tbody>
            </table>
          </div>
        </div>

        <div class="tab-pane fade show" id="extras" role="tabpanel" aria-labelledby="home-tab2">
          <div class="row col-12"> 
            <div class="mt-4 mb-4 p-1 buttons">
              <a href="{{ route('import.form.extra', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-icon icon-left btn-dark" data-toggle="tooltip" title="Importar Extraordinarios"><i class="far fa-file"></i> EXTRAS</a>
            </div>
          </div>
          <div class="row col-12">
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Subtotal</h4>
                  </div>
                  <div class="card-body">
                    $<span id="totalImporte">{{ number_format($totalImporteExtra, 2) }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>I.V.A.</h4>
                  </div>
                  <div class="card-body">
                    $<span id="totalImporte">{{ number_format(($totalImporteExtra*0.16), 2) }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total</h4>
                  </div>
                  <div class="card-body">
                    $<span id="totalImporte">{{ number_format(($totalImporteExtra*1.16), 2) }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-extras" id="table-2">
              <thead>                                 
                <tr>
                  <th class="text-center col-id">
                    #
                  </th>
                  <th class="col-concepto">Concepto</th>
                  <th class="col-unidad">Unidad</th>
                  <th class="col-cantidad">Cantidad</th>
                  <th class="col-pu">PU</th>
                  <th class="col-importe">Importe</th>
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
                      {{ substr($conceptoExtra,0,100) }}
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
                </tr>
                @endforeach 
                @else
                    <p>No hay extras disponibles.</p>
                @endif
              </tbody>
            </table>
          </div>
        </div>

        <div class="tab-pane fade show" id="acumulado" role="tabpanel" aria-labelledby="home-tab2">
          Acumulado
        </div>

        @foreach ($ordenes as $orden)  
        <div class="tab-pane fade show" id="oc{{$orden->id_orden}}" role="tabpanel" aria-labelledby="home-tab2">
          @php
              // Filtrar los detalles que corresponden a esta orden específica
              $detallesDeEstaOrden = $todosLosDetallesDeOrdenes->where('id_orden', $orden->id_orden);
          @endphp
          <table class="table table-striped table-oc dataTable" id="table-2">
            <thead>                                 
              <tr>
                <th class="text-center col-id">
                  #
                </th>
                <th class="sorting">Tipo</th>
                <th class="sorting">Concepto</th>
                <th class="">Unidad</th>
                <th class="">Cantidad</th>
                <th class="">PU</th>
                <th class="">Importe</th>
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
                          Catálogo
                      @elseif ($detalle->id_extra)
                          Extra
                      @else
                          N/A
                      @endif
                  </td>
                  <td>
                      @if ($detalle->id_partida)
                          {{ $detalle->concepto_partida }}
                      @elseif ($detalle->id_extra)
                          {{ $detalle->concepto_extra }}
                      @else
                          -
                      @endif
                  </td>
                  <td>{{ $detalle->cantidad_orden_detalle }}</td>
                  <td>
                    @if ($detalle->id_partida)
                          {{ number_format($detalle->pu_partida, 2) }}
                    @elseif ($detalle->id_extra)
                        {{ number_format($detalle->pu_extra, 2) }}
                    @else
                        -
                    @endif 
                  </td>
                  <td> 
                    @if ($detalle->id_partida)
                        {{ number_format($detalle->cantidad_orden_detalle * $detalle->pu_partida, 2) }}
                    @elseif ($detalle->id_extra)
                        {{ number_format($detalle->cantidad_orden_detalle * $detalle->pu_extra, 2) }}
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
  .table-partidas .col-id{
    width: 5% !important;
  }
  .table-partidas .col-concepto{
    width: 60% !important;
  }
  .table-partidas .col-unidad{
    width: 5% !important;
  }
  .table-partidas .col-cantidad{
    width: 10% !important;
  }
  .table-partidas .col-pu{
    width: 10% !important;
  }
  .table-partidas .col-importe{
    width: 20% !important;
  }
  .table-extras .col-id{
    width: 5% !important;
  }
  .table-extras .col-concepto{
    width: 60% !important;
  }
  .table-extras .col-unidad{
    width: 5% !important;
  }
  .table-extras .col-cantidad{
    width: 10% !important;
  }
  .table-extras .col-pu{
    width: 10% !important;
  }
  .table-extras .col-importe{
    width: 20% !important;
  }
</style>
@endsection()