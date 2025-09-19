@extends('layouts.master')

@section('content')
<section class="section">
  <div class="section-header">
  </div>

  <div class="card">
    <div class="">
      @if (session('success'))
          <div class="alert alert-success"  role="alert" id="success-alert">
              {{ session('success') }}
          </div>
      @endif

      @if (session('error'))
          <div class="alert alert-danger" role="alert" id="danger-alert">
              {{ session('error') }}
          </div>
      @endif
      @foreach ($proyectos as $proyecto)  
      <table class="datos-proyecto">
        <tr>
          <td class="titulo">Razón Social</td>
          <td><span class="dato">{{ $proyecto->constructora_proyecto}}</span></td>
        </tr>   
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
          <td><span class="dato"> {{$proyecto->fecha_proyecto->format('d/m/Y')}}</span></td>
        </tr>
      </table>
      @endforeach
    </div>
    <div class="card-body">
        @php
        $contadorOC=0;
        @endphp
        <!--<a href="{{ route('nueva.oc', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-info icon-left" title="Nueva OC">NUEVA OC</a>-->
      <div class="row">
        <div class="col-2 d-flex align-items-center justify-content-center btn-group" role="group">
          <a href="{{ route('listado.nuevaoc', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-info icon-left btn-lg" title="Nueva OC">NUEVA OC</a>
          <a href="{{ route('sublistado.show', $id_proyecto) }}" class="btn btn-dark icon-left btn-lg" title="CREAR SUBLISTADO">CREAR SUBCATALOGO</a>
        </div>
      </div>
      <br>
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
        {{-- @foreach ($totalContratistas as $contratista)
          <li class="nav-item naranja">
            <a class="nav-link" id="{{ $contratista->id_contratista}}-tab" data-toggle="tab" href="#contratista-{{ $contratista->id_contratista}}" role="tab" aria-controls="acumulado" aria-selected="false">{{ $contratista->nombre_contratista }} <a>
          </li> 
        @endforeach
        @foreach ($ordenes as $orden)  
        <li class="nav-item">
          <a class="nav-link" id="oc{{$orden->id_orden}}-tab" data-toggle="tab" href="#oc{{ $orden->id_orden}}" role="tab" aria-controls="oc{{$orden->id_orden}}" aria-selected="false">O.C. {{$contadorOC+=1}}</a>
        </li>
        @endforeach --}}
        <li class="nav-item">
            <a class="nav-link" id="contratistas-tab" data-toggle="tab" href="#contratistas-content" role="tab">
                <select class="form-control" id="contratistaSelector">
                    <option value="" disabled selected>Selecciona un Contratista</option>
                    @foreach ($totalContratistas as $contratista)
                        <option value="contratista-{{ $contratista->id_contratista }}">
                            {{ $contratista->nombre_contratista }}
                        </option>
                    @endforeach
                </select>
            </a>
        </li>
      </ul>
      <div class="tab-content tab-bordered" id="tabProyectoContenido">

        <!--  Catalogo-->
        <div class="tab-pane fade active show" id="catalogo" role="tabpanel" aria-labelledby="catalogo-tab">
          <div class="row">
            <div class="col-6 d-flex align-items-center justify-content-center btn-group" role="group">
              <a href="{{ route('nuevo.partida', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-lg btn-danger icon-left" title="Nueva Partida"><i class="fas fa-plus"></i> NUEVO ELEMENTO</a> 
              <a href="{{ route('import.form', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-lg btn-info icon-left" title="Importar Catalogo">IMPORTAR CATALOGO</a>
              @if ($partidas->count() > 0) 
              <!--<a href="{{ route('import.form', ['id_proyecto' => $id_proyecto]) }}" class="btn disabled btn-info icon-left ml-3" title="Importar Catalogo">IMPORTAR CATALOGO</a>-->
              @else 
              @endif
            </div>
            <div class="col-6 justify-content-end">
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
                  <th rowspan="2" class="text-center col-concepto">CONCEPTO</th>
                  <th rowspan="2" class="text-center col-unidad">UNIDAD</th>
                  <th rowspan="2" class="text-center col-cantidad">CANTIDAD</th>
                  <th colspan="2" class="text-center">{{$proyecto->constructora_proyecto}}</th>
                  <th colspan="2" class="text-center">CONTRATISTA</th>
                  <th></th> 
                </tr>
                <tr>
                  <th class="text-center col-importe">PU</th>
                  <th class="text-center col-importe">TOTAL</th>
                  <th class="text-center col-importe">PU</th>
                  <th class="text-center col-importe">TOTAL</th>
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
                      {{ substr($concepto,0,60) }}...
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
                    {{ number_format($partida->cantidad_partida,2) }}
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
                    @auth
                      @if (Auth::user()->isAdmin())
                      <div class="btn-group mb-1" role="group" aria-label="Basic example">
                        <a class="btn btn-sm btn-info icon-left" href="{{ route('editar.partida', ['id_partida' => $partida->id_partida]) }}" title="Editar Partida"><i class="fas fa-pen"></i></a>  
                        <!--<button type="button" class="btn btn-danger icon-left view-details-btn"
                                data-toggle="modal" data-target="#eliminarPartidaModal"
                                data-id="{{ $partida->id_partida }}"
                                title="Eliminar">
                            <i class="fas fa-trash"></i> 
                        </button>-->
                        <button class="btn btn-sm btn-danger"
                                data-confirm="¿Realmente deseas eliminar la Partida No: {{ $partida->no_partida }}?"
                                data-confirm-yes="document.getElementById('delete-form-{{ $partida->id_partida }}').submit();"
                                title="Eliminar Partida">
                            <i class="fas fa-trash"></i>
                        </button>

                        <form id="delete-form-{{ $partida->id_partida }}"
                              action="{{ route('partidas.destroy', $partida->id_partida) }}"
                              method="POST"
                              style="display: none;">
                            @csrf
                            @method('DELETE') 
                        </form>
                      </div>
                      @endif
                    @endauth
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
          <div class="row">
            <div class="col-6 d-flex align-items-center justify-content-center btn-group" role="group">
              <a href="{{ route('nuevo.extra', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-danger btn-lg icon-left" title="Nuevo Extraordinario"><i class="fas fa-plus"></i> NUEVO ELEMENTO</a> 
              <a href="{{ route('import.form.extra', ['id_proyecto' => $id_proyecto]) }}" class="btn btn-icon btn-lg icon-left btn-dark"  title="Importar Extraordinarios">IMPORTAR EXTRAS</a>
            </div>
            <div class="col-6 justify-content-end">
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
                      {{ substr($conceptoExtra,0,60) }}...
                    </div>
                  </td>
                  <td class="text-center">
                    {{ $extra->unidad_extra }}
                  </td>
                  <td class="text-right">
                    {{ number_format($extra->cantidad_extra,2) }}
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
                    @auth
                      @if (Auth::user()->isAdmin())
                      <div class="btn-group mb-1" role="group" aria-label="Basic example">
                        <a class="btn btn-sm btn-info icon-left" href="{{ route('editar.extra', ['id_extra' => $extra->id_extra]) }}" title="Editar Extraordinario"><i class="fas fa-pen"></i></a> 
                        <button class="btn btn-sm btn-danger"
                                data-confirm="¿Realmente deseas eliminar el Extraordinario No: {{ $extra->no_extra }}?"
                                data-confirm-yes="document.getElementById('delete-form-{{ $extra->id_extra }}-extra').submit();"
                                title="Eliminar Extraordinario">
                            <i class="fas fa-trash"></i>
                        </button>

                        <form id="delete-form-{{ $extra->id_extra }}-extra"
                              action="{{ route('extra.destroy', $extra->id_extra) }}"
                              method="POST"
                              style="display: none;">
                            @csrf
                            @method('DELETE') 
                        </form>
                      </div>
                      @endif
                    @endauth
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
                                {{ substr($concepto,0,60) }}...
                                </div>
                              </td>
                              <td>{{ $item->unidad_referencia }}</td>
                              <td class="text-right">{{ number_format($item->cantidad_referencia,2) }}</td>
                              <td>$ {{ number_format($item->precio_unitario_base, 2) }}</td>
                              <td>$ {{ number_format($item->cantidad_referencia*$item->precio_unitario_base, 2) }}</td>
                              <td class="text-right">{{ number_format($item->cantidad_acumulada,2) }}</td>
                              <td>$ {{ number_format($item->cantidad_acumulada*$item->precio_unitario_base,2) }}</td>
                              <td class="text-right col-pu">
                                @if(( $item->cantidad_referencia - $item->cantidad_acumulada) < 0 )
                                <span style="color: red">
                                @else
                                  <span>
                                @endif
                                {{ number_format($item->cantidad_referencia - $item->cantidad_acumulada,2)  }}
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
              <p>No se encontraron órdenes de compra para este proyecto.</p>
          @else
            @php
            $superTotal=0;
            @endphp
            @foreach ($totalContratistas as $contratista)
              @php
              $totalAmortizacion=0;
              $totalAPagar=0;
              $detallesContratista=$todosLosDetallesDeOrdenes->where('id_contratista',$contratista->id_contratista)->sortBy('id_orden');  
              $idsDeOrdenUnicos =$detallesContratista->pluck('id_orden')->unique();
              $sumaTotalContratista=0;
              @endphp
              <div class="col-12 contratista-tab-pane tab-pane fade show" id="contratista-{{$contratista->id_contratista}}" role="tabpanel" aria-labelledby="contratista{{$contratista->id_contratista}}-tab">
                <!--<div class="col-12 col-sm-12 col-md-4">
                  <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active show" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="true">Home</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                    </li>
                  </ul>
                </div>-->
                <div id="accordion">
                  <div class="accordion">
                    <!--<div class="col-12 col-sm-12 col-md-4">-->
                    <div class="accordion-header bg-dark" role="button" data-toggle="collapse" data-target="#panel-datos-{{$contratista->id_contratista}}" aria-expanded="true">
                      <h4>DATOS</h4>
                    </div>
                    <div class="accordion-body collapse active show" id="panel-datos-{{$contratista->id_contratista}}" data-parent="#accordion" style="">
                    <!--<div class="tab-content no-padding" id="myTab2Content">-->
                    <!--<div class="tab-pane fade active show" id="home4" role="tabpanel" aria-labelledby="home-tab4">-->
                      <table class="table table-striped table-bordered">
                        <tr>
                          <td class="w10"><strong>Residente:</strong></td>
                          <td colspan="3">
                            @foreach($proyecto->usuarios as $user)
                                {{ $user->name }} ({{ $user->email }})
                            @endforeach
                          </td>
                        </tr>
                        <tr>
                          <td class="w10"><strong>Contratista:</strong></td>
                          <td colspan="3">{{ $contratista->nombre_contratista}}</td>
                        </tr>
                        <tr>
                          <td><strong>Dirección:</strong></td>
                          <td colspan="3">{{ $contratista->direccion_contratista}}</td>
                        </tr>
                        <tr>
                          <td><strong>Banco:</strong></td>
                          <td>{{ $contratista->banco_contratista}}</td>
                          <td><strong>CLABE:</strong></td>
                          <td>{{ $contratista->clabe_contratista}}</td>
                        </tr>
                        <tr>
                          <td><strong>Cuenta:</strong></td>
                          <td>{{ $contratista->cuenta_contratista}}</td>
                          <td><strong>Tarjeta:</strong></td>
                          <td>{{ $contratista->tarjeta_contratista}}</td>
                        </tr>
                        <tr>
                          <th>
                            ANTICIPO:
                          </th>
                          <td>
                            @if ($contratista->anticipos->isNotEmpty())
                                @php
                                    $anticipo = $contratista->anticipos->first();
                                @endphp
                                <p>
                                    <strong>{{ $anticipo->porcentaje }}%</strong>
                                </p>
                            @else
                                {{-- 3. Si la colección está vacía, se muestra este mensaje --}}
                                <p>No se ha registrado un anticipo para este contratista en este proyecto.</p>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" 
                                        data-target="#anticipoModal"
                                        data-id-contratista="{{ $contratista->id_contratista }}"
                                        data-nombre-contratista="{{ $contratista->nombre_contratista }}">
                                    <i class="fas fa-plus-circle"></i> AGREGAR ANTICIPO
                                </button>
                            @endif
                          </td>
                        </tr>
                      </table>
                    </div>
                    @php
                    $sublistadoContratista = $sublistadoAcumulado->filter(function ($item) use ($contratista) {
                        // Asegúrate de que tu consulta de DB::raw incluya el 'sc.contratista_id'
                        // para que puedas filtrar por él.
                        return $item->id_contratista === $contratista->id_contratista;
                    }); 
                    @endphp
                    <div class="accordion-header bg-dark" role="button" data-toggle="collapse" data-target="#panel-catalogo-{{$contratista->id_contratista}}" aria-expanded="true">
                      <h4>CATÁLOGO</h4>
                    </div>
                    <div class="accordion-body collapse" id="panel-catalogo-{{$contratista->id_contratista}}" data-parent="#accordion" style="">
                    <!--<div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">-->
                      @php
                        $sumaSublistadoPu=0;
                        $sumaSublistadoPuContratista=0;
                        $sumaSublistadoTotal=0;
                        $sumaSublistadoTotalContratista=0;
                        $acumuladoOrdenDetalleContratista=0;
                      @endphp
                      @if($sublistadoContratista->isEmpty())
                          <p>Este contratista no tiene elementos en su sublistado.</p>
                      @else
                      <table class="table contratistas table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>CONCEPTO</th>
                            <th>UNIDAD</th>
                            <th>CANTIDAD</th>
                            <th>PU</th>
                            <th>PU CONTRATISTA</th>
                            <th>TOTAL</th>
                            <th>TOTAL CONTRATISTA</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($sublistadoContratista as $sublistado)
                            <tr>
                              <td>{{$sublistado->no_referencia}}</td>
                              <td>
                                <div data-toggle="tooltip" title="{{ $concepto=$item->concepto_referencia}}">
                                  {{substr($sublistado->concepto_referencia,0,60)}}</td>
                                </div>
                              <td>{{$sublistado->unidad_referencia}}</td>
                              <td>{{number_format($sublistado->cantidad_referencia,2)}}</td>
                              <td>
                                @php
                                $sumaSublistadoPu+=$sublistado->pu_base;
                                @endphp
                                $ {{number_format($sublistado->pu_base,2)}}</td>
                              <td>
                                @php
                                $sumaSublistadoPuContratista+=$sublistado->pu_contratista_base;
                                @endphp
                                $ {{number_format($sublistado->pu_contratista_base,2)}}</td>
                              <td>
                                @php
                                $sumaSublistadoTotal+=$sublistado->cantidad_referencia*$sublistado->pu_base;
                                @endphp
                                $ {{number_format($sublistado->cantidad_referencia*$sublistado->pu_base,2)}}
                              </td>
                              <td>
                                @php
                                $sumaSublistadoTotalContratista+=$sublistado->cantidad_referencia*$sublistado->pu_contratista_base;
                                @endphp
                                $ {{number_format($sublistado->cantidad_referencia*$sublistado->pu_contratista_base,2)}}
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5"></td>
                            <th>SUBTOTAL</th>
                            <td>$ {{number_format($sumaSublistadoTotal,2)}}</td>
                            <td>$ {{number_format($sumaSublistadoTotalContratista,2)}}</td>
                          </tr>
                          <tr>
                            <td colspan="5"></td>
                            <th>IVA</th>
                            <td>$ {{number_format($sumaSublistadoTotal*0.16,2)}}</td>
                            <td>$ {{number_format($sumaSublistadoTotalContratista*0.16,2)}}</td>
                          </tr>
                          <tr>
                            <td colspan="5"></td>
                            <th>TOTAL</th>
                            <td>$ {{number_format($sumaSublistadoTotal*1.16,2)}}</td>
                            <td>$ {{number_format($sumaSublistadoTotalContratista*1.16,2)}}</td>
                          </tr>
                        </tfoot>
                      </table>
                      @endif
                    </div>
                    <div class="accordion-header bg-dark" role="button" data-toggle="collapse" data-target="#panel-ordenes-{{$contratista->id_contratista}}" aria-expanded="true">
                      <h4>ORDENES</h4>
                    </div>
                    <div class="accordion-body collapse" id="panel-ordenes-{{$contratista->id_contratista}}" data-parent="#accordion" style="">
                      <!--<div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">-->
                      <table class="table contratistas table-bordered">
                        <thead>
                          <tr>
                            <th class="col-orden text-center">ORDEN</th>
                            <th class="text-center">FECHA</th>
                            <!--<th class="col-total text-center">SUBTOTAL</th>
                            <th class="text-center">IVA</th>-->
                            <th class="text-center">TOTAL</th>
                            <th class="text-center">AMORTIZACION</th>
                            <th class="text-center">A PAGAR</th>
                            <th class="text-center">ACCIONES</th>
                          </tr>
                        </thead>
                        <tbody>
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
                                                {{ substr($concepto,0,60) }}...
                                              </div>
                                          @elseif ($detalle->id_extra)
                                              <div data-toggle="tooltip" title="{{ $concepto=$detalle->concepto_extra}}">
                                                {{ substr($concepto,0,60) }}...
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
                              {{ \Carbon\Carbon::parse($ordenEspecifico->fecha_orden)->format('d/m/Y')}}
                            </td>
                            <!--<td class="text-right">$ {{number_format($acumuladoOrdenDetalleContratista,2)}}</td>
                            <td class="text-right">$ {{number_format($acumuladoOrdenDetalleContratista*0.16,2)}}</td>-->
                            @php
                            $superTotal+=$acumuladoOrdenDetalleContratista;
                            $sumaTotalContratista+=$acumuladoOrdenDetalleContratista;
                            @endphp
                            <td class="text-right">$ {{number_format($acumuladoOrdenDetalleContratista*1.16,2)}}</td>
                            @if($contratista->anticipos->isNotEmpty())
                            @php
                            $totalAmortizacion+=($acumuladoOrdenDetalleContratista*1.16)*($anticipo->porcentaje/100);
                            @endphp
                            <td class="text-right">$ {{number_format(($acumuladoOrdenDetalleContratista*1.16)*($anticipo->porcentaje/100),2)}}</td>
                            @php
                            $totalAPagar+=($acumuladoOrdenDetalleContratista*1.16)-($acumuladoOrdenDetalleContratista*1.16)*($anticipo->porcentaje/100);
                            @endphp
                            <td class="text-right">$ {{number_format(($acumuladoOrdenDetalleContratista*1.16)-($acumuladoOrdenDetalleContratista*1.16)*($anticipo->porcentaje/100),2)}}</td>
                            @else
                            <td></td>
                            <td></td>
                            <td></td>
                            @endif
                            <td>
                              <button type="button" class="btn btn-sm btn-info view-details-btn"
                                      data-toggle="modal" data-target="#ocDetailsModal"
                                      data-id="{{ $idDeOrden }}"
                                      title="Ver Detalles de la Orden">
                                  <i class="fas fa-eye"></i> DETALLES
                              </button>
                              <a href="{{ route('ordenes.pdf', $idDeOrden) }}" class="btn btn-danger btn-sm">
                                  <i class="fas fa-file-pdf"></i> PDF
                              </a>
                            </td>
                          </tr>
                          @endforeach
                          <tr>
                            <th colspan="2"></th>
                            <th class="text-right">$ {{ number_format(($sumaTotalContratista)*1.16,2) }}</th>
                            <th class="text-right">$ {{ number_format(($totalAmortizacion), 2) }}</th>
                            <th class="text-right">$ {{ number_format(($totalAPagar), 2) }}</th>
                          </tr>
                          <tr>
                            <th colspan="5"></th>
                          </tr>
                          <tr>
                            <th colspan="3"></th>
                            <th>IMPORTE DEL CONTRATO</th>
                            <!--<th class="text-right">$ {{ number_format(($totalContratistaImporte*1.16), 2) }}</th>-->
                            <th class="text-right">$ {{ number_format(($sumaSublistadoTotalContratista*1.16), 2) }}</th>
                          </tr>
                          <tr>
                            <th colspan="3"></th>
                            @if($contratista->anticipos->isEmpty())
                            <th>No hay anticipo</th>
                            @else
                            <th>ANTICIPO | {{ $anticipo->porcentaje  }}%</th>
                            <th class="text-right">$ {{ number_format(($sumaSublistadoTotalContratista*1.16)*($anticipo->porcentaje/100),2) }}</th>
                            @endif
                          </tr>
                          <tr>
                            <th colspan="3"></th>
                            <th>ACUMULADO</th>
                            <!--<th class="text-right">$ {{ number_format($superTotal,2) }}</th>
                            <th class="text-right">$ {{ number_format($superTotal*0.16,2) }}</th>-->
                            <th class="text-right">$ {{ number_format($acumuladoOrdenDetalleContratista*1.16,2) }}</th>
                          </tr>
                          <tr>
                            <th colspan="3"></th>
                            <th>SALDO</th>
                            <!--<th class="text-right">$ {{ number_format($superTotal,2) }}</th>
                            <th class="text-right">$ {{ number_format($superTotal*0.16,2) }}</th>-->
                            <th class="text-right">$ {{ number_format(($sumaSublistadoTotalContratista*1.16)-($acumuladoOrdenDetalleContratista*1.16),2) }}</th>
                          </tr>
                          <tr>
                            <th colspan="3"></th>
                            @if($contratista->anticipos->isEmpty())
                            <th>No hay anticipo</th>
                            @else
                            <th>POR AMORTIZAR</th>
                            <!--<th class="text-right">$ {{ number_format($superTotal,2) }}</th>
                            <th class="text-right">$ {{ number_format($superTotal*0.16,2) }}</th>-->
                            <!--<th class="text-right">$ {{ number_format((($sumaSublistadoTotal*1.16)*($anticipo->porcentaje/100))-$totalAmortizacion,2) }}</th>-->
                            <th class="text-right">$ {{ number_format((($totalAmortizacion))-(($sumaSublistadoTotalContratista*1.16)*($anticipo->porcentaje/100)),2) }}</th>
                            @endif
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
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
                <h4 class="modal-title" id="ocDetailsModalLabel">{{$proyecto->constructora_proyecto}}</h4>
                <div>
                  <table>
                  </table>
                </div>
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

{{-- MODAL PARA ANTICIPO --}}
<div class="modal fade" id="anticipoModal" tabindex="-1" role="dialog" aria-labelledby="anticipoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="anticipoForm" method="POST" action="{{ route('anticipos.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="anticipoModalLabel">Agregar Anticipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_proyecto" value="{{ $proyecto->id_proyecto }}">
                    <input type="hidden" name="id_contratista" id="id_contratista_input">

                    <p>Agregar anticipo para el contratista: <strong id="nombre_contratista_display"></strong></p>
                    
                    <div class="form-group">
                        <label for="porcentaje">Porcentaje de Anticipo (%)</label>
                        <input type="number" name="porcentaje" id="porcentaje" class="form-control" step="0.01" min="0" max="100" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Anticipo</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- FIN DEL MODAL ANTICIPO --}}


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
    width: 30% !important;
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

  .w10{
    width: 10%;
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
            //modalTitle.text('Cargando Detalles de la Orden...'); // Título temporal

            // Realiza la llamada AJAX para obtener los detalles
            $.ajax({
                url: "{{ url('/ordenes') }}/" + ordenId + "/detalles-modal",
                method: 'GET',
                success: function(response) {
                    // Inyecta el HTML recibido en el cuerpo del modal
                    modalBody.html(response);
                    // Actualiza el título del modal (puedes ajustarlo si el parcial no devuelve el título específico)
                    //modalTitle.text('Detalles de la Orden de Compra'); // Se actualizará desde el parcial si el partial_modal.blade.php tiene el h4
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
            //$(this).find('.modal-title').text(); // Resetea el título
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selector = document.getElementById('contratistaSelector');
        const tabList = document.getElementById('myTab');

        // Función unificada para manejar la visibilidad de todos los contenidos
        function hideAllContent() {
            // Oculta todos los contenidos de las pestañas de Bootstrap
            document.querySelectorAll('.tab-pane').forEach(tab => {
                tab.classList.remove('show', 'active');
            });
        }

        // Función para mostrar solo el contenido de un contratista específico
        function showContratistaContent(contratistaId) {
            hideAllContent(); // Oculta todo primero
            
            const contentToShow = document.getElementById(`contratista-${contratistaId}`);
            if (contentToShow) {
                // Muestra la pestaña principal de contratistas
                $('#contratistas-tab').tab('show');
                // Y luego muestra el div del contratista seleccionado
                contentToShow.classList.add('show', 'active');
            }
        }
        
        // --- 1. Escuchar el evento de cambio del selector ---
        selector.addEventListener('change', function() {
            const selectedValue = this.value;
            // Asegúrate de que el valor no sea la opción por defecto (vacía)
            if (selectedValue) {
                showContratistaContent(selectedValue.split('-')[1]);
            }
        });

        // --- 2. Escuchar cuando una pestaña principal se activa ---
        if (tabList) {
            $(tabList).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                const activeTabId = e.target.getAttribute('id');
                
                // Si la pestaña activada NO es la de contratistas, resetea el select.
                if (activeTabId !== 'contratistas-tab') {
                    selector.value = ''; // Resetea el valor del select a la opción vacía
                }
            });
        }
        
        // --- 3. Inicialización: Muestra el contenido de la primera pestaña al cargar ---
       // const defaultTab = document.getElementById('catalogo-tab');
        //if (defaultTab) {
            //defaultTab.click();
        //}

        //cambiar de panel al mandarlo por url
        const urlParams = new URLSearchParams(window.location.search);
        const contratistaIdFromUrl = urlParams.get('id_contratista');

        if (contratistaIdFromUrl) {
            // Seleccionar el contratista en el dropdown
            selector.value = `contratista-${contratistaIdFromUrl}`;
            
            // Mostrar el contenido del contratista
            showContratistaContent(contratistaIdFromUrl);
        } else {
            // Si no hay ID en la URL, activa la pestaña por defecto
            const defaultTab = document.getElementById('catalogo-tab');
            if (defaultTab) {
                defaultTab.click();
            }
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selecciona la alerta de éxito si existe
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            // Oculta la alerta después de 4 segundos
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 4000); // 4000 milisegundos = 4 segundos
        }

        // Selecciona la alerta de peligro si existe
        const dangerAlert = document.getElementById('danger-alert');
        if (dangerAlert) {
            // Oculta la alerta después de 4 segundos
            setTimeout(() => {
                dangerAlert.style.display = 'none';
            }, 4000); // 4000 milisegundos = 4 segundos
        }
    });
</script>
<script>
    $('#anticipoModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); // Botón que abrió el modal
        const idContratista = button.data('id-contratista');
        const nombreContratista = button.data('nombre-contratista');

        const modal = $(this);
        modal.find('.modal-title').text('Agregar Anticipo para ' + nombreContratista);
        modal.find('#id_contratista_input').val(idContratista);
        modal.find('#nombre_contratista_display').text(nombreContratista);
    });
</script>
@endsection