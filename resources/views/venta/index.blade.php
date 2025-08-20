@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between bd-highlight mb-3">
            <div class="d-flex justify-content-start bd-highlight">
                <div class="p-4 bg-light">
                    <h4>REGISTRO DE VENTAS</h4>
                </div>
            </div>
            <div class="d-flex justify-content-end bd-highlight">
                <div class="pr-3 pt-3" title="Registrar venta" data-toggle="tooltip">
                    <a href="{{route('venta.create')}}" class="text-body">
                        <span class="mdi mdi-car-wash mdi-36px"></span>
                    </a>
                </div>
                <!--<div class="pr-3 pt-3" title="Registrar venta de la tienda" data-toggle="tooltip">
                    <a href="{{route('venta.create-market')}}" class="text-body">
                        <span class="mdi mdi-shopping mdi-36px"></span>
                    </a>
                </div>-->
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-borderless shadow-sm rounded" id="table-sell">
                <thead class="bg-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Placa</th>
                        <th># Teléfono</th>
                        <th>Tipo vehículo</th>
                        <th>Atendido por</th>
                        <th>Valor Total</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)

                    <tr>
                        <td>{{date('Y-m-d h:i',strtotime($venta->fecha) )}}</td>
                        <th class="text-primary">{{$venta->cliente->nombre}}</th>
                        <th>
                            @if($venta->placa)
                                <div class="bg-warning py-2 px-1 text-center border border-dark rounded">
                                    {{$venta->placa}}
                                </div>
                            @else
                                Sin registro
                            @endif
                        </th>
                        <td>
                            @if($venta->cliente->telefono)
                                {{$venta->cliente->telefono}}
                            @else
                                Sin registro
                            @endif
                        </td>
                        <td>
                            @if($venta->detalle_paquete != null)
                                {{$venta->detalle_paquete->tipo_vehiculo->descripcion}}
                            @else
                                No aplica
                            @endif
                        </td>
                        <td>
                            @if($venta->user->identificacion=="000")
                            <label class="badge  badge-xs text-black badge-warning">{{$venta->user->name}}</label>
                            @else
                            {{$venta->user->name}}
                            @endif
                        </td>
                        <th class="text-danger">$ {{ number_format($venta->total_venta,0,',','.')}}</th>
                        <td class="text-center align-middle">
                            @if($venta->estado=='pendiente')
                                <span title="Pendiente" class="estado-icon bg-warning-soft rounded-circle p-2">
                                    <i class="mdi mdi-timer-sand text-warning mdi-24px"></i>
                                </span>
                            @elseif($venta->estado=='en_proceso')
                                <span title="En proceso" class="estado-icon bg-info-soft rounded-circle p-2">
                                    <i class="mdi mdi-car-wash text-info mdi-24px"></i>
                                </span>
                            @elseif($venta->estado=='finalizado')
                                <span title="Finalizado" class="estado-icon bg-success-soft rounded-circle p-2">
                                    <i class="mdi mdi-check-circle-outline text-success mdi-24px"></i>
                                </span>
                            @elseif($venta->estado=='cancelado')
                                <span title="Cancelado" class="estado-icon bg-danger-soft rounded-circle p-2">
                                    <i class="mdi mdi-close-circle-outline text-danger mdi-24px"></i>
                                </span>
                            @else
                                <span title="Otro" class="estado-icon bg-secondary-soft rounded-circle p-2">
                                    <i class="mdi mdi-help-circle-outline text-secondary mdi-24px"></i>
                                </span>
                            @endif
                        </td>
                        <td>
                        @if($venta->estado=='en_proceso')
                             <a class=" btn-finalizar-venta" 
                                title="Finalizar Venta"   data-toggle="tooltip"
                                data-id="{{ $venta->id }}" 
                                data-medio_pago="{{ $venta->medio_pago ?? '' }}"
                                data-toggle="modal" 
                                data-target="#modal_finalizar_venta">
                                <i class="mdi text-success mdi mdi-cash-multiple mdi-24px"></i>
                            </a>
                        @endif
                        @if($venta->estado_venta->id<>2 &&  $venta->estado_venta->id<>3 && $venta->estado<>'finalizado')
                            <a id="btn_show_change_user" data-venta="{{ $venta->id }}" data-id="{{ $venta->user->id }}" title="Cambio de Prestador" data-toggle="modal" data-target="#modal_edit_user_service"    data-toggle="tooltip">
                                <i class="mdi mdi-account-convert text-primary mdi-24px"></i>
                            </a>
                            <a href="{{route('venta.edit',[$venta->id])}}" data-venta="{{ $venta->id }}" data-id="{{ $venta->user->id }}" title="Editar Venta"   data-toggle="tooltip">
                                <i class="mdi mdi-pencil-box-outline text-primary mdi-24px"></i>
                            </a>
                        @endif                           
                            <a href="{{route('venta.show',[$venta->id])}}" title="Ver detalle" data-toggle="tooltip">
                                <i class="mdi mdi-point-of-sale text-warning mdi-24px"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('venta.mdl_changeUser')
    @include('venta.mdl_finalizar_venta')
    @if(session('success'))
        <input type="hidden" id="succes_message" value="{{session('success')}}">
    @endif

    @if(session('fail'))
        <input type="hidden" id="fail_message" value="{{session('fail')}}">
    @endif
</div>




@endsection
@push('styles')
<style>
    .bg-warning-soft { background: #fff8e1; }
    .bg-info-soft { background: #e3f2fd; }
    .bg-success-soft { background: #e8f5e9; }
    .bg-danger-soft { background: #ffebee; }
    .bg-secondary-soft { background: #ececec; }
    .estado-icon { display: inline-block; min-width: 40px; min-height: 40px; text-align: center; vertical-align: middle; }
    .table th, .table td { vertical-align: middle !important; }
    .table thead th { border-bottom: 2px solid #eaeaea; }
    .table-hover tbody tr:hover { background: #f6f6f6; }
    .rounded { border-radius: 12px !important; }
    .shadow-sm { box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
</style>

@endpush
@push('custom-scripts')
    {!! Html::script('lib/sell.js') !!}
@endpush