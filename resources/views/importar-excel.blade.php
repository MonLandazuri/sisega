@extends('layouts.master')

@section('content')
<section class="section">
            <div class="section-header">
                <h1>Importar Archivo Excel</h1>
            </div>
    @if ($errors->any())
        <div class="row">
            <strong>¡Ups! Algo salió mal.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="row">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
    <form method="POST" action="{{ route('import.process',['id_proyecto' => $id_proyecto]) }}" enctype="multipart/form-data">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label for="archivo_excel">Seleccionar Archivo Excel:</label><br>
                <input type="file" name="archivo_excel" id="archivo_excel" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-dark">Importar</button>  |  
                <a class="btn btn-warning" href="{{ route('inicio') }}">Volver al Inicio</a>
            </div>
        </div>
    </form>
@endsection()