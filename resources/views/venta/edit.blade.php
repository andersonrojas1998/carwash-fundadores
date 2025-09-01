@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-header"><h3>Editar Venta  - {{ $venta->id }}</h3></div>
    <form id="form_create_sell_edit" action="{{route('venta.update')}}" method="POST">
        <input type="hidden" name="id_venta" value="{{ $venta->id }}">
        {{ csrf_field() }}

        @if (session('fail'))
            <div class="alert alert-warning">
               <ul><li>{{ session('fail') }}</li></ul> 
            </div>
        @endif



        <fieldset>
            <div class="card-body">
                <div class="d-flex justify-content-around mb-3">
                    <div class="col-lg-4">
                        <label for="input_name_customer">Cliente&nbsp;:</label>
                        <input type="text" disabled id="input_name_customer" name="nombre_cliente" class="form-control text-uppercase" placeholder="Cliente" value="{{ $venta->cliente->nombre }}" >
                        
                    </div>

                    <div class="col-lg-4">
                        <div class="row pl-2">
                            <label>Fecha&nbsp;:</label>
                        </div>
                        <div class="row pl-3">
                            <label>{{ $venta->fecha}}</label>
                        </div>
                    </div>
                    
                </div>

                <div class="d-flex justify-content-around mb-3 pb-3">
                    <div class="col-lg-4">
                        <label for="input_license_plate" class="control-label">Placa&nbsp;:</label>
                        <input type="text" disabled id="input_license_plate" name="placa" class="form-control text-uppercase" placeholder="Placa" value="{{$venta->placa}}">
                        
                    </div>
                    <div class="col-lg-4">
                        <label for="input_phone_number" class="control-label">Telefono&nbsp;:</label>
                        <input type="number" disabled id="input_phone_number" name="numero_telefono" class="form-control text-uppercase" placeholder="Telefono del cliente" value="{{ $venta->cliente->telefono }}" >                       
                    </div>
                </div>

                <div class="d-flex justify-content-around mb-3 pb-3">
                   
                    
                </div>

                <div class="card" id="card-vehicle-type">
                    <div class="card-header text-center">
                        Seleccione el tipo de vehiculo al que aplica el servicio
                    </div>
                    <div>
                        <div class="d-flex justify-content-center pt-4">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                @foreach($tipos_vehiculo as $tipo_vehiculo)
                                <label class="btn btn-outline-primary   {{ ($venta->detalle_paquete->id_tipo_vehiculo ==  $tipo_vehiculo->id ) ? 'active':'' }}  ">
                                    <input type="radio"   name="id_tipo_vehiculo" class="radio-btn-vehicle-type  edit-sell" value="{{$tipo_vehiculo->id}}"   data-url="{{route('paquete.packagesByVehicleType',[$tipo_vehiculo->id]) }}"    data-url-old="{{route('paquete.packagesByVehicleType',[$venta->detalle_paquete->id_tipo_vehiculo])}}"  data-pack="{{ $venta->detalle_paquete->id_paquete}}"  {{ ($venta->detalle_paquete->id_tipo_vehiculo ==  $tipo_vehiculo->id ) ? 'checked':'' }}> 
                                    <img src="{{asset($tipo_vehiculo->imagen)}}" class="rounded" alt="{{$tipo_vehiculo->descripcion}}" data-toggle="tooltip" title="{{$tipo_vehiculo->descripcion}}" height="90px" width="140px">
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4 d-none" id="div-packages">
                    <div class="card-header text-center">
                        Seleccione el combo o servicio
                    </div>
                    <div>
                        <div class="d-flex justify-content-center pt-4">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons" style="overflow-x: scroll" id="div-buttons-package">
                            </div>
                        </div>
                    </div>
                </div>
              <!--  <div class="card mt-4" id="card-products">
                    <div class="card-header text-center">
                        Agregar productos a la venta
                    </div>
                    <div>
                        <div class="d-flex justify-content-center pt-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Producto&nbsp;:</label>
                                    <select class="select2" id="select-product" style="width:100%;">
                                    
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around pt-3">
                            <div class="col-lg-4">
                                <div>
                                    <label class="control-label">Disponible&nbsp;:</label>
                                    <input type="number" class="form-control" id="input-quantity-available-product" placeholder="Disponible" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label class="control-label">Cantidad&nbsp;:</label>
                                    <input type="number" class="form-control" id="input-quantity-product" placeholder="Cantidad">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center pt-4">
                            <button type="button" class="btn btn-primary" id="btn-add-products" title="Agregar" data-toggle="tooltip">Agregar&nbsp;<i class="mdi mdi-plus-circle-outline mdi-18px"></i></button>
                        </div>
                    </div>
                </div>-->
                <div class="pb-2 pt-5">
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-centered text-center mb-0" id="table-products">
                            <thead>
                                <tr>
                                    <th  class="header-pay" colspan="4">Detalle venta   <i class="mdi  mdi-cart-plus" ></i></th>
                                </tr>
                                <tr>
                                    <th>Productos/Servicios</th>
                                    <th>Precio unitario</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="tr-package"></tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="font-weight-bold text-right" colspan="3">Total:<input type="hidden" name="importe_total" id="importe_total" value="0"></td>
                                    <td class="font-weight-bold td_importe_total">$<strong id="text_importe_total">0</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    <button type="submit" id="btn_create_sell_edit" class="btn btn-success btn-w-all">Generar Venta <i  class="mdi mdi-content-save-all mdi-18px"></i></button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
@endsection
@push('style')    
<style>
.header-pay{
    background:#c9ddeb73;
    -webkit-text-stroke:thin;
    border-radius:8px;
}
</style>
@endpush
@push('custom-scripts')
    {!! Html::script('js/validate.min.js') !!}
    {!! Html::script('js/validator.messages.js') !!}
    {!! Html::script('lib/sell.js?v.2') !!}
@endpush