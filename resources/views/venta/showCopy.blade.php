@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-header pt-5 pl-5" style="
        background-image: url('/images/top_left_corner.png');
        background-repeat: no-repeat;
        background-size: 20%;
    ">
        <div class="d-flex justify-content-between mb-3">
            <div class="col-4">
                <h1 class="mt-3 ml-3"><strong>Factura</strong></h1>
                <div class="d-block">
                    <strong class="ml-3"># de orden&nbsp;:&nbsp;</strong><label>{{$venta->id}}</label>
                </div>
                <strong class="ml-3">Fecha&nbsp;:&nbsp;</strong><label>{{$venta->fecha}}</label>
            </div>
            <div class="col-4 text-center">
                <h5><strong>Lavado y Mantenimiento de<br>Vehiculos Automotores</strong></h5>
                <h5><strong>JORGE ANDR&Eacute;S D&Iacute;AZ CRUZ</strong></h5>
                <h6>Nit. 1.144.189.073-3</h6>
                <h6>No Responsable del IVA</h6>
            </div>
            <div class="col-3" style="
                background-image: url('/icon.jpg');
                background-repeat: no-repeat;
                background-size: 54%;
                background-position: center;"></div>
        </div>
        <div class="col-12 text-center">
            <h5><strong>Manzana 10 Lote 77 Etapa III Poblado Campestre - Candelar&iacute;a - Valle</strong></h5>
            <h5><strong>Cel: 311 426 4334 - 316 625 6386 / juanchoscarwash2017@hotmail.com</strong></h5>
        </div>
    </div>
    
            <div class="card-body pb-5" style="
            background-image: url('/images/bottom_right_corner.png');
            background-repeat: no-repeat;
            background-position: bottom right;
            background-size: 20%;
        ">
                <div class="d-flex justify-content-around mb-3">
                    <div class="col-lg-4">
                        <h4 class="mb-3"><strong>Comprador&nbsp;:</strong></h4>
                        <label class="d-block">{{$venta->nombre_cliente}}</label>
                        @if($venta->placa)
                            <label class="d-block"><strong>Placa&nbsp;:&nbsp;</strong>{{$venta->placa}}</label>
                        @endif
                        @if($venta->numero_telefono)
                            <label class="d-block"><strong>Tel&nbsp;:&nbsp;</strong>{{$venta->numero_telefono}}</label>
                        @endif
                        @if($venta->detalle_paquete != null)
                            <label class="d-block">
                                <strong>Tipo vehiculo&nbsp;:&nbsp;</strong>
                                {{$venta->detalle_paquete->tipo_vehiculo->descripcion}}</label>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <h4 class="mb-3"><strong>Atendido por&nbsp;:</strong></h4>
                        <label>{{$venta->user->name}}</label>
                        <h4 class="mt-3"><strong>Estado&nbsp;:</strong></h4>
                        <label>{{$venta->estado_venta->nombre}}</label>
                    </div>
                </div>

                <div class="mb-3 pt-2 px-5">
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-centered text-center mb-0" id="table-products">
                            <thead>
                                <tr>
                                    <th style="background-color: black !important; color: white !important;">Productos/Servicios</th>
                                    <th style="background-color: black !important; color: white !important;">Precio unitario</th>
                                    <th style="background-color: black !important; color: white !important;">Cantidad</th>
                                    <th style="background-color: black !important; color: white !important;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @if($venta->detalle_paquete)
                                    @php
                                    $total += $venta->detalle_paquete->precio_venta;
                                    @endphp
                                    <tr>
                                        <td>{{$venta->detalle_paquete->paquete->nombre.' - '.$venta->detalle_paquete->tipo_vehiculo->descripcion}}</td>
                                        <td>{{$venta->detalle_paquete->precio_venta}}</td>
                                        <td>1</td>
                                        <td>{{$venta->detalle_paquete->precio_venta}}</td>
                                    </tr>
                                @endif
                                @foreach($venta->detalle_venta_productos as $detalle_venta_producto)
                                    @php
                                    $total += $detalle_venta_producto->precio_venta * $detalle_venta_producto->cantidad;
                                    @endphp
                                    <tr>
                                        <td>{{$detalle_venta_producto->detalle_compra_productos->producto->nombre.' - '.$detalle_venta_producto->detalle_compra_productos->producto->presentacion->nombre}}</td>
                                        <td>{{$detalle_venta_producto->precio_venta}}</td>
                                        <td>{{$detalle_venta_producto->cantidad}}</td>
                                        <td>{{$detalle_venta_producto->precio_venta * $detalle_venta_producto->cantidad}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="font-weight-bold text-right" colspan="3">Total:</td>
                                    <td class="font-weight-bold td_importe_total">$<strong id="text_importe_total">{{$total}}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
            </div>

            <div class="card-footer">
            <div class="row justify-content-end">
                    <button class="btn btn-success d-print-none" ><i class="mdi  mdi-whatsapp  text-white " onclick="window.print()"></i>  w print-</button> &nbsp;
                    <!-- <button class="btn btn-success d-print-none" ><i class="mdi  mdi-whatsapp  text-white " onclick="printIframe()"></i>  w print-iframe</button> &nbsp; -->
                    <button class="btn  btn-primary d-print-none btn_generateTicket btn-w-all"  data-id="{{$venta->id}}" > <i class="mdi  mdi-cloud-print text-white "></i>  Imprimir</button>
            </div>
            </div>
           
            
</div>

<!-- <iframe id="theFrame"  name="theFrame"   frameborder="0" scrolling="no" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="800" height="600"></iframe> -->

<!-- <iframe src="https://docs.google.com/viewer?url=http://infolab.stanford.edu/pub/papers/google.pdf&embedded=true" style="width:100%; height:650px;" frameborder="0"></iframe> -->


<!-- <object data="http://infolab.stanford.edu/pub/papers/google.pdf" type="application/pdf" frameborder="0" width="100%" height="600px" style="padding: 20px;"> -->
    <!-- <embed  id="theFrame"  name="theFrame"  width="100%" height="600px"/>  -->
<!-- </object> -->

<!-- <object  id="theFrame"  type="application/pdf" name="theFrame"   width="100%" height="800px"></object> -->


@if(session('success'))
<input type="hidden" id="succes_message" value="{{session('success')}}">
@endif
@endsection
@push('custom-scripts')
    {!! Html::script('js/validate.min.js') !!}
    {!! Html::script('js/validator.messages.js') !!}
    {!! Html::script('lib/sell.js?v.1') !!}
@endpush