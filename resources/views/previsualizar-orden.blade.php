@extends('layouts.master')

@section('content')
<section class="section">
          <div class="section-header">
            <h1></h1>
          </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <p>No has seleccionado cantidades para ninguna partida.</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>No.</th>
                    <th>Concepto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->tipo }}</td>
                        <td>{{ $detalle->no_partida }}</td>
                        <td>{{ $detalle->concepto_partida ?? $detalle->concepto_extra }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>$ {{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td>$ {{ number_format($detalle->importe, 2) }}</td>
                    </tr>
                @endforeach
                @foreach ($detallesExtra as $detalle)
                    <tr>
                        <td>{{ $detalle->tipo }}</td>
                        <td>{{ $detalle->no_extra}}</td>
                        <td>{{ $detalle->concepto_extra }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>$ {{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td>$ {{ number_format($detalle->importe, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">Total General:</th>
                    <th>$ {{ number_format($totalGeneral, 2) }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="mt-6">
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

                <button type="submit" class="btn btn-success">
                    Guardar Orden
                </button>
                <a href="{{ route('listado.nuevaoc') }}" class="btn btn-secondary ms-2">
                    Volver
                </a>
            </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection()