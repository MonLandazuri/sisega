@extends('layouts.master')

@section('content')
<section class="section">
          <div class="section-header">
            <h1></h1>
          </div>
  <div class="row">
    <div class="col-12">
      @if ($detalles)
      <div class="card">
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
                @foreach($detalles as $detalle)
                <tr>
                  <td>
                    @if($detalle->id_partida)
                    {{ $detalle->no_partida}}
                    @elseif ($detalle->id_extra)
                    {{ $detalle->no_extra}}
                    @else
                      sin numero
                    @endif
                  </td>
                  <td>
                    @if($detalle->id_partida)
                    {{ $detalle->concepto_partida}}
                    @elseif ($detalle->id_extra)
                    {{ $detalle->concepto_extra}}
                    @else
                      sin Concepto
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
      @endif

      <div class="card">
        <div class="card-header">
          <h4></h4>
        </div>
        <div class="card-body">
          <div class="row mt-4">
            <div class="col-12 col-lg-8 offset-lg-2">
              <div class="wizard-steps">
                <div class="wizard-step wizard-step-active">
                  <div class="wizard-step-icon">
                    <i class="far fa-user"></i>
                  </div>
                  <div class="wizard-step-label">
                    Orden de Compra
                  </div>
                </div>
              </div>
            </div>
          </div>

          <form method="POST" action="{{ route('revision.nuevaoc')}}" class="wizard-content mt-2">
                @csrf
            <div class="wizard-pane"> 
              <div class="form-group row align-items-center">
                <div class="col-12">
                  <ul class="nav nav-tabs" id="myTabOpc" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active show" id="catalogo-tab4" data-toggle="tab" href="#catalogo_opc" role="tab" aria-controls="catalogo_opc" aria-selected="true">Catálogo</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="extra-tab4" data-toggle="tab" href="#extra_opc" role="tab" aria-controls="extra_opc" aria-selected="false">Extraordinarios</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="tab-content tab-padding" id="myTab2Content">
                <div class="tab-pane fade active show" id="catalogo_opc" role="tabpanel" aria-labelledby="catalogo-tab4">
                  <div class="form-group row align-items-center">
                    <div class="col-12">
                      <table class="table table-striped table-extras" id="table-partidas">
                        <thead>                                 
                          <tr>
                            <th class="text-center col-id">No.</th>
                            <th class="col-concepto">Concepto</th>
                            <th class="col-unidad">Unidad</th>
                            <th class="col-cantidad">Cantidad</th>
                            <th class="col-cantidad">PU</th>
                          </tr>
                        </thead>
                        <tbody>   
                          @foreach ($partidas as $partida)
                          <tr>
                            <td>{{ $partida->no_partida }}</td>
                            <td>{{ $partida->concepto_partida }}</td>
                            <td>{{ $partida->unidad_partida }}</td>
                            <td><input type="number"
                                       name="cantidades_partida[{{ $partida->id_partida }}]"
                                       id="cantidad_partida_{{ $partida->id_partida }}"
                                       class="form-control cantidad-input"
                                       min="0"
                                       value="0"
                                       step="any">
                            </td>
                            <td>$ {{ $partida->pu_partida }}<input type="hidden"
                                       name="pu_partida"
                                       id="pu_partida_{{ $partida->id_partida }}"
                                       class="form-control precio-input"
                                       value="{{ $partida->pu_partida }}" disabled>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade show" id="extra_opc" role="tabpanel" aria-labelledby="extra-tab4">
                  <div class="form-group row align-items-center">
                    <div class="col-12">
                      <table class="table table-striped table-extras" id="table-partidas">
                        <thead>                                 
                          <tr>
                            <th class="text-center col-id">No.</th>
                            <th class="col-concepto">Concepto</th>
                            <th class="col-unidad">Unidad</th>
                            <th class="col-cantidad">Cantidad</th>
                            <th class="col-cantidad">PU</th>
                          </tr>
                        </thead>
                        <tbody>   
                          @foreach ($extras as $extra)
                          <tr>
                            <td>{{ $extra->no_extra }}</td>
                            <td>{{ $extra->concepto_extra }}</td>
                            <td>{{ $extra->unidad_extra }}</td>
                            <td><input type="number"
                                       name="cantidades_extra[{{ $extra->id_extra }}]"
                                       id="cantidad_extra_{{ $extra->id_extra }}"
                                       class="form-control cantidad-input"
                                       min="0"
                                       value="0"
                                       step="any">
                            </td>
                            <td>$ {{ $extra->pu_extra }}<input type="hidden"
                                       name="pu_extra"
                                       id="pu_extra_{{ $extra->id_extra }}"
                                       class="form-control precio-input"
                                       value="{{ $extra->pu_extra }}" disabled>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>   
                  </div>  
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-4">
                  <input type="hidden" name="id_proyecto" class="form-control" value="{{$id_proyecto}}">
                  <input type="hidden" name="id_orden" class="form-control" value="{{$id_orden}}">
                </div>
                <div class="col-lg-4 col-md-6 text-right">
                  <button type="submit" class="btn btn-icon icon-right btn-dark">Siguiente <i class="fa fa-angle-right"></i></button>
                </div>
              </div>
            </div>
          </form>
        </div>
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