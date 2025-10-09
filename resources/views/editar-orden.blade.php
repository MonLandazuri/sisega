@extends('layouts.master')

@section('content')
<section class="section">
          <div class="section-header">
            <h1>Editar Orden No. {{$id_orden}}</h1>
          </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <!--<table class="table table-bordered table-striped datos-editar">
          <thead>
            <tr>
              <th class="col-id">TIPO</th>
              <th class="col-id">NO.</th>
              <th class="col-concepto">CONCEPTO</th>
              <th class="col-cantidad">CANTIDAD</th>
              <th class="col-pu">P.U.</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($detallesDeLaOrden as $detalle)
              <tr>
                <td></td>
                <td>{{ $detalle->numero_referencia }}</td>
                <td>
                    <div data-toggle="tooltip" title="{{ $concepto=$detalle->concepto}}">
                    {{ substr($concepto,0,90) }}...
                </td>
                <td><input type="number" name="cantidad_editar[{{ $detalle->id_referencia }}]" value="{{ number_format($detalle->cantidad,2) }}" class="form-control precio-input"></td>
                <td>$ {{ number_format($detalle->precio_unitario, 2) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>-->

      <form action="{{ route('agregar.editaroc') }}" method="POST">
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
        <div class="tab-content tab-padding" id="myTab2Content">
          <div class="tab-pane fade active show" id="catalogo_opc" role="tabpanel" aria-labelledby="catalogo-tab4">
            <table class="table table-bordered table-striped datos-revision">
              <thead>
                <tr>
                  <th class="col-id">TIPO</th>
                  <th class="col-id">NO.</th>
                  <th class="col-concepto">CONCEPTO</th>
                  <th class="col-cantidad">CANTIDAD</th>
                  <th class="col-pu">P.U.</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($partidasDisponibles as $detalle)
                    @php
                        $cantidadEnOrden = $cantidadesMapeadas['partidas'][$detalle->id_partida] ?? 0;
                    @endphp
                    <tr>
                      <td>Catalogo</td>
                      <td>{{ $detalle->no_partida }}</td>
                      <td>
                        <div data-toggle="tooltip" title="{{ $concepto=$detalle->concepto_partida}}">
                        {{ substr($concepto,0,90) }}...
                      </td>
                      <td>
                        @if ($cantidadEnOrden > 0)
                          <input type="number" 
                                    name="cantidad_partida[{{ $detalle->id_partida }}]" 
                                    value="{{ $cantidadEnOrden }}"
                                    class="form-control precio-input">
                        @else
                          <input type="number" 
                                    name="cantidad_partida[{{ $detalle->id_partida }}]" 
                                    value="0"
                                    class="form-control precio-input">
                        @endif
                      </td>
                      <td>$ {{ number_format($detalle->pu_partida, 2) }}</td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade show" id="extra_opc" role="tabpanel" aria-labelledby="extra-tab4">
            <table class="table table-bordered table-striped datos-revision">
              <thead>
                  <tr>
                      <th class="col-id">TIPO</th>
                      <th class="col-id">NO.</th>
                      <th class="col-concepto">CONCEPTO</th>
                      <th class="col-cantidad">CANTIDAD</th>
                      <th class="col-pu">P.U.</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($extrasDisponibles as $detalle)
                      @php
                          $cantidadEnOrden = $cantidadesMapeadas['extras'][$detalle->id_extra] ?? 0;
                      @endphp
                      <tr>
                          <td>Extraordinario</td>
                          <td>{{ $detalle->no_extra}}</td>
                          <td>
                              <div data-toggle="tooltip" title="{{ $conceptoExtra=$detalle->concepto_extra}}">
                              {{ substr($conceptoExtra,0,90) }}...
                          </td>
                          <td>
                            @if ($cantidadEnOrden > 0)
                              <input type="number" 
                                        name="cantidad_extra[{{ $detalle->id_extra }}]" 
                                        value="{{ $cantidadEnOrden }}"
                                        class="form-control precio-input">
                            @else
                              <input type="number" 
                                        name="cantidad_extra[{{ $detalle->id_extra }}]" 
                                        value="0"
                                        class="form-control precio-input">
                            @endif
                          </td>
                          <td>$ {{ number_format($detalle->pu_extra, 2) }}</td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="col-12 text-right">
          @csrf
          <div class="text-center"><strong>COMENTARIO</strong></div><textarea class="form-control" name="comentario_orden"></textarea><br>
          
          <input type="hidden" name="id_orden" value="{{ $id_orden }}">
              
          <input type="hidden" name="id_proyecto" value="{{ $id_proyecto }}">

          <input type="hidden" name="id_contratista" value="{{ $id_contratista }}">

          <button type="button" class="btn btn-secondary ms-2" onclick="history.back()">
              <i class="fas fa-arrow-left"></i> Volver
          </button>
          <button type="submit" class="btn btn-success">
              <i class="fas fa-save"></i> Guardar Orden
          </button>
        </div>
      </form>
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

  .datos-revision .titulo{
    font-weight: bold;
    font-size: 16px;
    padding: 5px 0 5px 10px;
  }

  .datos-revision .dato{
    font-size: 16px;
    padding: 5px 0 5px 10px;
  }
</style>
@endsection()