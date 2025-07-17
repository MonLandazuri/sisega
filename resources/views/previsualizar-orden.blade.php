@extends('layouts.master')

@section('content')
<section class="section">
          <div class="section-header">
            <h1></h1>
          </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>TIPO</th>
                    <th>NO.</th>
                    <th>CONCEPTO</th>
                    <th>CANTIDAD</th>
                    <th>P.U.</th>
                    <th>IMPORTE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->tipo }}</td>
                        <td>{{ $detalle->no_partida }}</td>
                        <td>
                            <div data-toggle="tooltip" title="{{ $concepto=$detalle->concepto_partida}}">
                            {{ substr($concepto,0,110) }}...
                        </td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>$ {{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td>$ {{ number_format($detalle->importe, 2) }}</td>
                    </tr>
                @endforeach
                @foreach ($detallesExtra as $detalle)
                    <tr>
                        <td>{{ $detalle->tipo }}</td>
                        <td>{{ $detalle->no_extra}}</td>
                        <td>
                            <div data-toggle="tooltip" title="{{ $conceptoExtra=$detalle->concepto_extra}}">
                            {{ substr($conceptoExtra,0,110) }}...
                        </td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>$ {{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td>$ {{ number_format($detalle->importe, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">SUBTOTAL:</th>
                    <th>$ {{ number_format(($totalGeneral+$totalGeneralExtra), 2) }}</th>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">IVA:</th>
                    <th>$ {{ number_format(($totalGeneral+$totalGeneralExtra)*0.16, 2) }}</th>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">TOTAL:</th>
                    <th>$ {{ number_format(($totalGeneral+$totalGeneralExtra)*1.16, 2) }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="col-12 text-right">
            {{-- Formulario para confirmar la orden --}}
            <form action="{{ route('agregar.nuevaoc') }}" method="POST">
                @csrf

                {{-- Re-enviar todas las cantidades y precios como campos ocultos --}}
                @foreach ($detalles as $detalle)
                    <input type="hidden" name="cantidades_partida[{{ $detalle->id_partida }}]" value="{{ $detalle->cantidad }}">
                    <input type="hidden" name="precios_partida[{{ $detalle->id_partida }}]" value="{{ $detalle->precio_unitario }}">
                    {{-- Si necesitas el ID de la orden principal, también lo envías oculto --}}
                @endforeach
                @foreach ($detallesExtra as $detalle)
                    <input type="hidden" name="cantidades_extra[{{ $detalle->id_extra }}]" value="{{ $detalle->cantidad }}">
                    <input type="hidden" name="precios_extra[{{ $detalle->id_extra }}]" value="{{ $detalle->precio_unitario }}">
                @endforeach
                    
                <input type="hidden" name="id_orden" value="{{ $id_orden ?? '' }}">
                    
                <input type="hidden" name="id_proyecto" value="{{ $id_proyecto }}">

                <button type="button" class="btn btn-secondary ms-2" onclick="history.back()">
                    <i class="fas fa-arrow-left"></i> Volver
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Orden
                </button>
            </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection()