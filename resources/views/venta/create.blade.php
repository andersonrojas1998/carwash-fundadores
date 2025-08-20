@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-header"><h3>Registrar Venta</h3></div>
    <form id="form_create_sell" action="{{route('venta.store')}}" method="POST">
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
                        <label for="input_license_plate" class="control-label">Placa&nbsp;:</label>
                        <input type="text" id="input_license_plate" name="placa" class="form-control text-uppercase" placeholder="Placa" value="{{old('placa')}}">
                        @if ($errors->any() && $errors->first('placa'))
                            <span class="badge badge-pill badge-danger">{{$errors->first('placa')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="row pl-2">
                            <label>Fecha&nbsp;:</label>
                        </div>
                        <div class="row pl-3">
                            <label>{{ date('Y-m-d h:i A')}}</label>
                        </div>
                    </div>
                    
                </div>

                <div class="d-flex justify-content-around mb-3 pb-3">
                   
                    <div class="col-lg-4">
                        <label for="input_name_customer">Cliente&nbsp;:</label>
                        <input type="text" id="input_name_customer" name="nombre_cliente" class="form-control text-uppercase" placeholder="Cliente" value="{{old('nombre_cliente')}}" required>
                        @if ($errors->any() && $errors->first('nombre_cliente'))
                            <span class="badge badge-pill badge-danger">{{$errors->first('nombre_cliente')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label for="input_phone_number" class="control-label">Telefono&nbsp;:</label>
                        <input type="number" id="input_phone_number" name="numero_telefono" class="form-control text-uppercase" placeholder="Telefono del cliente" value="{{old('numero_telefono')}}" required>
                        @if ($errors->any() && $errors->first('numero_telefono'))
                            <span class="badge badge-pill badge-danger">{{$errors->first('numero_telefono')}}</span>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-around mb-3 pb-3">
                    <div class="col-lg-4">
                    <label>¿Quién presta el servicio?&nbsp;:</label>
                    <select class="select2" name="id_usuario" style="width: 100%">
                        @foreach($llegadas as $llegada)
                            <option value="{{ $llegada->empleado->id }}"
                                {{ ($lavadorTurno && $lavadorTurno->empleado->id == $llegada->empleado->id) ? 'selected' : '' }}>
                                {{ $llegada->empleado->name }} ({{ $llegada->estado }})
                            </option>
                        @endforeach
                    </select>
                </div>
                  <!--  <div class="col-lg-4">
                        <label for="type-sale">Tipo de venta</label>
                        <select class="custom-select" name="id_estado_venta" id="type-sale">
                            <option value="1">Servicio y productos</option>
                            <option value="3">Productos</option>
                        </select>
                    </div>-->

                    <div class="col-lg-4">
                        <label for="input_payment_method">Medio de Pago&nbsp;:</label>
                        <select class="select2" name="medio_pago" id="input_payment_method" style="width: 100%">
                            <option value="pendiente_pago" data-icon="mdi mdi-cash" selected>Pendiente Pago</option>
                            <option value="efectivo" data-icon="mdi mdi-cash">Efectivo</option>
                            <option value="transferencia" data-icon="mdi mdi-cellphone" >Transferencia</option>
                        </select>
                    </div>
                </div>

                
                

                <div class="card" id="card-vehicle-type">
                    <div class="card-header text-center">
                        Seleccione el tipo de vehiculo al que aplica el servicio
                    </div>
                    <div>
                        <div class="d-flex justify-content-center pt-4">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                @foreach($tipos_vehiculo as $tipo_vehiculo)
                                <label class="btn btn-outline-primary">
                                    <input type="radio" name="id_tipo_vehiculo" class="radio-btn-vehicle-type" value="{{$tipo_vehiculo->id}}" data-url="{{route('paquete.packagesByVehicleType',[$tipo_vehiculo->id])}}"> 
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
                                <div class= "form-group">
                                    <label>Producto&nbsp;:</label>
                                    <select class="select2" id="select-product" style="width:100%;">
                                       {{--  @if(count($productos) != 0)
                                        <option value="">Seleccione el producto...</option>
                                        @foreach($productos as $producto)
                                            
                                            <option value="{{$producto->id}}" data-price="{{$producto->precio_venta}}" data-buy-price="{{$producto->precio_venta}}" data-quantity="{{$producto->cant_disponible}}" data-text="{{$producto->producto.' - '.$producto->tipo_producto.' - '.$producto->presentacion.' - $ '.$producto->precio_venta}}" >{{$producto->producto.' - '.$producto->tipo_producto.' - '.$producto->presentacion}}</option>
                                        @endforeach --}}
                                  {{--    @else --}}
                                    <option value="">Existencias agotadas</option>
                                  {{--  @endif --}}
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
                    <button type="submit" id="btn_create_sell" class="btn btn-success btn-w-all">Generar Venta <i  class="mdi mdi-content-save-all mdi-18px"></i></button>
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
    {!! Html::script('lib/sell.js') !!}
@endpush