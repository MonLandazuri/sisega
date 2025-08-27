@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="row">
        {{-- Tarjeta 1: Total Proyectos --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-building"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Proyectos</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalProyectos }}
                    </div>
                    <a href="{{route('proyectos')}}">Ver Proyectos</a>
                </div>
            </div>
        </div>

        {{-- Tarjeta 2: Total Contratistas --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Contratistas</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalContratistas }}
                    </div>
                    <a href="{{route('contratistas')}}">Ver Contratistas</a>
                </div>
            </div>
        </div>

        {{-- Tarjeta 3: Total Órdenes de Compra --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Órdenes Compra</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalOrdenes }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 4: Total Partidas --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Partidas</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalPartidas }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Gráfico de Órdenes de Compra por Mes (ejemplo con Chart.js) --}}
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Proyectos por Mes</h4>
                </div>
                <div class="card-body">
                    <canvas id="ordenesChart" height="150"></canvas>
                </div>
            </div>
        </div>

        {{-- Última Actividad / Accesos Rápidos --}}
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Últimas Órdenes de Compra</h4>
                    <div class="card-header-action">
                        <a href="{{ route('proyectos') }}" class="btn btn-primary">Ver todas <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border">
                        @forelse ($ultimasOrdenes as $orden)
                            <li class="media">
                                <i class="far fa-file-invoice mr-3 text-primary" style="font-size: 24px;"></i>
                                <div class="media-body">
                                    <div class="media-title mb-1">Orden #{{ $orden->id_orden }}</div>
                                    <div class="text-small text-muted">Proyecto: {{ $orden->proyecto->nombre_proyecto ?? 'N/A' }}</div>
                                    <div class="text-small text-muted">Contratista: {{ $orden->contratista->nombre_contratista ?? 'N/A' }}</div>
                                    <div class="text-small text-muted">
                                        Creada el {{ $orden->created_at->format('d/m/Y') }}
                                        <!--<div class="bullet"></div>
                                        Importe: ${{ number_format($orden->total, 2) }}-->
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="media">No hay órdenes de compra recientes.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection()

@section('scripts')
{{-- Incluye Chart.js desde CDN si no lo tienes instalado --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Script para el gráfico de órdenes de compra
    var ctx = document.getElementById('ordenesChart').getContext('2d');
    var ordenesChart = new Chart(ctx, {
        type: 'bar', // Puedes cambiar a 'line', 'pie', etc.
        data: {
            labels: @json($labelsProyectos), // Tus etiquetas de meses
            datasets: [{
                label: 'Proyectos',
                data: @json($dataProyectos), // Tus datos de conteo
                backgroundColor: '#3abaf4',
                borderColor: '#3abaf4',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) { if (value % 1 === 0) { return value; } }
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
@endsection