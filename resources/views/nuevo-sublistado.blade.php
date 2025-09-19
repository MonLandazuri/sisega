@extends('layouts.master')

@section('content')
<section class="section">
  <div class="section-header">
  </div>

<form action="{{ route('sublistado.store') }}" method="POST">
    @csrf
    
  <div class="card">
        <div class="form-group row align-items-center">
            <label class="col-lg-6 text-md-right text-left">Contratista</label>
            <div class="col-lg-6  col-md-6">
                <select class="form-control" name="id_contratista">
                <option value="0">Selecciona un contratista</option>
                @foreach ($contratistas as $contratista)
                    <option value="{{ $contratista->id_contratista}}">
                        {{ $contratista->nombre_contratista }} 
                    </option>
                @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h3></h3>
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
                        <table class="table table-striped table-bordered table-partidas" id="table-partidas">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>CONCEPTO</th>
                                    <th>UNIDAD</th>
                                    <th>CANTIDAD</th>
                                    <th>PU</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($partidas as $item)
                                <tr>
                                    <td>{{ $item->no_partida }}</td>
                                    <td>{{ substr($item->concepto_partida,0,60) }}</td>
                                    <td>{{ $item->unidad_partida }}</td>
                                    <td>{{ number_format($item->cantidad_partida,2) }}</td>
                                    <td>$ {{ number_format($item->pu_partida,2) }}</td>
                                    <td>
                                        <button type="button" 
                                                class="btn btn-success btn-sm add-item" 
                                                data-id="{{ $item->id_partida }}" 
                                                data-no="{{ $item->no_partida }}" 
                                                data-tipo="partida" 
                                                data-descripcion="{{ substr($item->concepto_partida,0,60) }}" 
                                                data-unidad="{{ $item->unidad_partida }}" 
                                                data-cantidad="{{ number_format($item->cantidad_partida,2) }}" 
                                                data-monto="{{ number_format($item->pu_partida,2) }}">
                                            Agregar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade active show" id="extra_opc" role="tabpanel" aria-labelledby="extra-tab4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>CONCEPTO</th>
                                    <th>UNIDAD</th>
                                    <th>CANTIDAD</th>
                                    <th>PU</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($extraordinarios as $item)
                                <tr>
                                    <td>{{ $item->no_extra }}</td>
                                    <td>{{ substr($item->concepto_extra,0,60) }}</td>
                                    <td>{{ $item->unidad_extra }}</td>
                                    <td>{{ number_format($item->cantidad_extra,2) }}</td>
                                    <td>$ {{ number_format($item->pu_extra,2) }}</td>
                                    <td>
                                        <button type="button" 
                                                class="btn btn-success btn-sm add-item" 
                                                data-id="{{ $item->id_extra }}" 
                                                data-no="{{ $item->no_extra }}" 
                                                data-tipo="extra" 
                                                data-descripcion="{{ substr($item->concepto_extra,0,60) }}" 
                                                data-unidad="{{ $item->unidad_extra }}" 
                                                data-cantidad="{{ number_format($item->cantidad_extra,2) }}" 
                                                data-monto="{{ number_format($item->pu_extra,2) }}">
                                            Agregar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>            
            </div>
        </div>
        <hr>
        <div class="flotante-sublistado">
            <table class="table f" id="sublistado-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>CONCEPTO</th>
                        <th>CANTIDAD</th>
                        <th>UNIDAD</th>
                        <!--<th>Monto Unitario</th>
                        <th>Subtotal</th>-->
                        <th>ACCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
                <!--<tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td>Total: <span id="total-general">0.00</span></td>
                        <td></td>
                    </tr>
                </tfoot>-->
            </table>
            <input type="hidden" id="id_proyecto" name="id_proyecto" value="{{$id_proyecto}}">
            <div class="form-group row align-items-center">
                <label class="col-lg-6 text-md-right text-left">Porcentaje de Anticipo(%)</label>
                <div class="col-lg-6  col-md-6">
                    <input type="text" class="form-control" id="anticipo" name="anticipo">
                </div>
            </div>
            <button type="button" class="btn btn-danger ms-2" onclick="history.back()">
                <i class="fas fa-times"></i> CANCELAR
            </button>
            <button type="submit" class="btn btn-dark"><i class="fas fa-save"></i> GUARDAR</button>
        </div>
    </div>
</form>
</section>
<style>
    .flotante-sublistado {
        position: fixed; /* O position: sticky; */
        bottom: 20px;       /* Distancia desde la parte superior de la ventana */
        right: 20px;     /* Distancia desde el lado derecho de la ventana */
        width: 70%;    /* Ancho del div flotante */
        background-color: white;
        padding: 15px;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        z-index: 1000;   /* Asegura que esté por encima de otros elementos */
        max-height: 80vh; /* Limita la altura para evitar que se desborde */
        overflow-y: auto; /* Agrega un scroll si el contenido es muy largo */
    }
</style>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sublistadoTableBody = document.querySelector('#sublistado-table tbody');
        const totalGeneralElement = document.getElementById('total-general');
        let nextIndex = 0;

        function updateTotals() {
            let total = 0;
            document.querySelectorAll('input[name^="items"][name$="[cantidad]"]').forEach(input => {
                const row = input.closest('tr');
                const monto = parseFloat(row.querySelector('input[name^="items"][name$="[monto]"]').value);
                const cantidad = parseFloat(input.value);

                if (!isNaN(cantidad) && !isNaN(monto)) {
                    const subtotal = cantidad * monto;
                    //row.querySelector('.subtotal-cell').textContent = subtotal.toFixed(2);
                    total += subtotal;

                }
            });
            totalGeneralElement.textContent = total.toFixed(2);
        }

        document.querySelectorAll('.add-item').forEach(button => {
            button.addEventListener('click', function () {
                //this.disabled=true;  
                //this.textContent="Agregado";
                //this.classList.add("btn-dark");
                //this.classList.remove("btn-success");

                const id = this.dataset.id;
                const no = this.dataset.no;
                const tipo = this.dataset.tipo;
                const descripcion = this.dataset.descripcion;
                const cantidad = this.dataset.cantidad;
                const unidad = this.dataset.unidad;
                const monto = parseFloat(this.dataset.monto);

                const newRow = `
                    <tr>
                        <td>${no}</td>
                        <td>
                            ${descripcion}
                            <input type="hidden" name="items[${nextIndex}][id]" value="${id}">
                            <input type="hidden" name="items[${nextIndex}][tipo]" value="${tipo}">
                            <input type="hidden" name="items[${nextIndex}][cantidad]" value="${cantidad}">
                        </td>
                        <td>${cantidad}</td>
                        <td>${unidad}</td>
                        <!--<td>${monto.toFixed(2)}</td>
                        <td class="subtotal-cell">${monto.toFixed(2)*cantidad}</td>-->
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-item">Eliminar</button>
                        </td>
                    </tr>
                `;

                sublistadoTableBody.insertAdjacentHTML('beforeend', newRow);
                nextIndex++;
                updateTotals();
            });
        });

        sublistadoTableBody.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('tr').remove();
                updateTotals();
            }
        });
        
        sublistadoTableBody.addEventListener('input', function (e) {
            if (e.target.name.includes('[cantidad]')) {
                updateTotals();
            }
        });

        // Asegúrate de que los totales se calculen al cargar la página
        updateTotals();
    });
</script>
@endsection

