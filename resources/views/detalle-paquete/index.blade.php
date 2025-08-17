@push('style')
<style type="text/css">
    @font-face {
        font-family: 'ShrikhandRegular';
        src: url({{asset("/fonts/ShrikhandRegular.ttf")}});
    }
</style>
@endpush
@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between bd-highlight mb-3">
            <div class="d-flex justify-content-start bd-highlight">
                <div class="m-auto bg-light">
                    <!-- <h4>COMBOS /<br>SERVICIOS</h4> -->
                </div>
            </div>
            <div class="d-flex justify-content-center bd-highlight">
            <h2 class="m-0 text-danger text-center" style="font-family: ShrikhandRegular;text-shadow: 2px 0 #000, -2px 0 #000, 0 2px #000, 0 -2px #000, 1px 1px #000, -1px -1px #000, 1px -1px #000, -1px 1px #000;">TRABAJAMOS CON ESFUERZO,<br>ESPUMA Y CORAZ&Oacute;N.</h2>
            </div>
            <div class="d-flex justify-content-end bd-highlight">
                <div class="pr-3 pt-3" title="Crear combo o servicio" data-toggle="tooltip">
                    <a href="{{route('detalle-paquete.create')}}" class="text-body">
                        <span class="mdi mdi-plus-circle-outline mdi-36px"></span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Listar paquetes para carro -->
        @if(count($paquetes_carro) != 0)
            <div class="card">
                <div class="card-header border-0 py-5" style="background-image: url(/images/carwash.jpg); background-size: contain; background-repeat: no-repeat; background-position: center;"></div>
                <div class="card-body pt-0" style="background-image: url(/images/bubbles.png); background-size: cover;">
                    <div class="card-deck m-3">
        @endif
        @foreach($paquetes_carro as $key => $paquete)
            @php
            $detalles_paquete = $paquete->detalle_paquete->where('tipo_vehiculo.nomenclatura', 'C');
            @endphp
            <div class="card border border-dark text-center text-light text-uppercase mx-auto" style="border-radius: 1em; overflow:hidden; max-width:205.938px;">
                <div class="card-header px-2 py-0" style="background-color: black;">
                    <h1 class="m-0"><strong>{{$paquete->nombre}}</strong></h1>
                </div>
                <div class="card-body px-2 py-3" style="background: linear-gradient({{explode(',', $paquete->color)[0]}}, #a8a4a4); color: {{explode(',', $paquete->color)[1]}};">
                    @foreach($detalles_paquete as $detalle_paquete)
                        <h2 class="m-0"><strong>{{$detalle_paquete->tipo_vehiculo->descripcion}}</strong></h2>
                        <h2 class="m-0"><strong>$ {{$detalle_paquete->precio_venta}}</strong></h2>
                        <hr class="my-1">
                    @endforeach
                    <strong class="card-title text-light" style="text-shadow: 2px 0 #000, -2px 0 #000, 0 2px #000, 0 -2px #000, 1px 1px #000, -1px -1px #000, 1px -1px #000, -1px 1px #000;">
                        @php $servicios_paquete = $detalles_paquete->first()->servicio_paquete; @endphp
                        @foreach($servicios_paquete as $key => $servicio_paquete)
                            {{$servicio_paquete->servicio->nombre}}
                            @if(isset($servicios_paquete[$key+1]))
                                &nbsp;-&nbsp;
                            @endif
                        @endforeach
                    </strong>
                </div>
                <div class="card-footer" style="background: linear-gradient(#a8a4a4, {{explode(',', $paquete->color)[0]}});">
                    @if($detalles_paquete->count() == 1)
                        <a href="{{route('detalle-paquete.edit', [$detalles_paquete->first()->id])}}" class="btn btn-primary rounded btn-block" >
                            <strong>Editar <i class="mdi mdi-pencil-box-outline"></i></strong></a>
                    @else
                        <button type="button" class="btn btn-primary rounded btn-block" data-toggle="modal" data-target="#modal_choose_vehicle_type_{{$paquete->id}}">
                            <strong>Editar <i class="mdi mdi-pencil-box-outline"></i></strong></button>

                        <div class="modal fade" id="modal_choose_vehicle_type_{{$paquete->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-success d-block">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title text-uppercase text-center"><strong>{{$paquete->nombre}}</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <h3 style="color: black;"><strong>¿Cu&aacute;l desea editar?</strong></h3>
                                        @foreach($detalles_paquete as $detalle_paquete)
                                            <a href="{{route('detalle-paquete.edit', [$detalle_paquete->id])}}" class="btn btn-outline-primary btn-lg rounded" title="Editar {{$detalle_paquete->tipo_vehiculo->descripcion}}" data-toggle="tooltip">
                                                <img class="w-50" src="{{$detalle_paquete->tipo_vehiculo->imagen}}" alt="{{$detalle_paquete->tipo_vehiculo->descripcion}}"></a>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        @if(count($paquetes_carro) != 0)
            </div>
        </div>
        </div>
        @endif
        <!-- Fin listar paquetes para carro -->
        
        <!-- Listar paquetes para moto -->
        @if(count($paquetes_moto) != 0)
        <div class="card mt-5" >
            <div class="card-header border-0 py-5" style="background-image: url(/images/motowash.jpg); background-size: contain; background-repeat: no-repeat; background-position: center;"></div>
            <div class="card-body" style="background-image: url(/images/bubbles.png); background-size: cover;">
                <div class="card-deck m-3">
        @endif
        @foreach($paquetes_moto as $paquete)
            <div class="card border border-dark text-center text-light text-uppercase mx-auto" style="border-radius: 1em; overflow:hidden; max-width:205.938px;">
                <div class="card-header px-2" style="background-color: black;">
                    <h1 class="m-0"><strong>{{$paquete->nombre}}</strong></h1>
                </div>
                <div class="card-body px-2 py-3" style="background: linear-gradient({{explode(',', $paquete->color)[0]}}, #a8a4a4); color:{{explode(',', $paquete->color)[1]}}">
                    @foreach($paquete->detalle_paquete->where('tipo_vehiculo.nomenclatura', 'M') as $detalle_paquete)
                        <h2 class="m-0"><strong>{{$detalle_paquete->tipo_vehiculo->descripcion}}</strong></h2>
                        <h2 class="m-0"><strong>$ {{$detalle_paquete->precio_venta}}</strong></h2>
                    @endforeach
                    <hr class="my-1">
                    <strong class="card-title text-light" style="text-shadow: 2px 0 #000, -2px 0 #000, 0 2px #000, 0 -2px #000, 1px 1px #000, -1px -1px #000, 1px -1px #000, -1px 1px #000;">
                        @php $servicios_paquete = $paquete->detalle_paquete->where('tipo_vehiculo.nomenclatura', 'M')->first()->servicio_paquete; @endphp
                        @foreach($servicios_paquete as $key => $servicio_paquete)
                            {{$servicio_paquete->servicio->nombre}}
                            @if(isset($servicios_paquete[$key+1]))
                                &nbsp;-&nbsp;
                            @endif
                        @endforeach
                    </strong>
                </div>
                <div class="card-footer" style="background: linear-gradient(#a8a4a4, {{explode(',', $paquete->color)[0]}});">
                    <a href="{{route('detalle-paquete.edit', [$paquete->detalle_paquete->where('tipo_vehiculo.nomenclatura', 'M')->first()->id])}}" class="btn btn-primary rounded btn-block"><strong>Editar <i class="mdi mdi-pencil-box-outline"></i></strong></a>
                </div>
            </div>
        @endforeach

        @if(count($paquetes_moto) != 0)
                </div>
            </div>
        </div>
        @endif
        
    <!-- Fin listar paquetes para moto -->

    <!-- Botones de paginado-->
    <div class="d-flex justify-content-center mt-5">
        @if($paquetes_carro->count() >= $paquetes_moto->count())
            {!!$paquetes_carro->links()!!}
        @elseif($paquetes_moto->count() >= 0)
            {!!$paquetes_moto->links()!!}
        @endif
    </div>
    <!-- Fin botones de paginado-->
    </div>
    @if(session('success'))
    <input type="hidden" id="succes_message" value="{{session('success')}}">
    @endif

    @if(session('fail'))
    <input type="hidden" id="fail_message" value="{{session('fail')}}">
    @endif
</div>
@endsection
@push('custom-scripts')
    {!! Html::script('js/validate.min.js') !!}
    {!! Html::script('js/validator.messages.js') !!}
    {!! Html::script('lib/package.js') !!}
@endpush