@extends('layout.master')
@section('content')
<div class="card shadow-lg border-0 mt-4" style="border-radius:18px;">
    <div class="card-header bg-primary text-white d-flex align-items-center" style="border-radius:18px 18px 0 0;">
    <img src="/icon.jpg" alt="Logo" style="height:40px;width:auto;margin-right:15px;border-radius:10px;">
    <h3 class="mb-0"><i class="mdi mdi-cart-plus"></i> Registrar Venta</h3>
</div>
    <form id="form_create_sell" action="{{route('venta.store')}}" method="POST" autocomplete="off">
        {{ csrf_field() }}

        @if (session('fail'))
            <div class="alert alert-warning mt-3">
                <ul><li>{{ session('fail') }}</li></ul>
            </div>
        @endif

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <label for="input_license_plate" class="font-weight-bold">Placa</label>
                    <input type="text" id="input_license_plate" name="placa" class="form-control text-uppercase" placeholder="PLACA" value="{{old('placa')}}">
                    @if ($errors->any() && $errors->first('placa'))
                        <span class="badge badge-danger">{{$errors->first('placa')}}</span>
                    @endif
                </div>
                <div class="col-md-3 mb-3">
                    <label class="font-weight-bold">Fecha</label>
                    <input type="text" class="form-control bg-light" value="{{ date('Y-m-d h:i A')}}" readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="input_name_customer" class="font-weight-bold">Cliente</label>
                    <input type="text" id="input_name_customer" name="nombre_cliente" class="form-control text-uppercase" placeholder="CLIENTE" value="{{old('nombre_cliente')}}" required>
                    @if ($errors->any() && $errors->first('nombre_cliente'))
                        <span class="badge badge-danger">{{$errors->first('nombre_cliente')}}</span>
                    @endif
                </div>
                <div class="col-md-3 mb-3">
                    <label for="input_phone_number" class="font-weight-bold">Teléfono</label>
                    <input type="number" id="input_phone_number" name="numero_telefono" class="form-control" placeholder="TELÉFONO" value="{{old('numero_telefono')}}" required>
                    @if ($errors->any() && $errors->first('numero_telefono'))
                        <span class="badge badge-danger">{{$errors->first('numero_telefono')}}</span>
                    @endif
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <label class="font-weight-bold">¿Quién presta el servicio?</label>
                    <select class="form-control select2" name="id_usuario" required>
                        @foreach($llegadas as $llegada)
                            <option value="{{ $llegada->empleado->id }}"
                                {{ ($lavadorTurno && $lavadorTurno->empleado->id == $llegada->empleado->id && $llegada->estado == 'activo') ? 'selected' : '' }}>
                                #{{ $llegada->orden }} - {{ $llegada->empleado->name }} ({{ ucfirst($llegada->estado) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="input_payment_method" class="font-weight-bold">Medio de Pago</label>
                    <select class="form-control select2" name="medio_pago" id="input_payment_method" required>
                        <option value="pendiente_pago" selected>Pendiente Pago</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="transferencia">Transferencia</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="input_discount" class="font-weight-bold">Descuento</label>
                    <div class="input-group">
                        <input type="number" min="0" step="1" id="input_discount" name="descuento" class="form-control" placeholder="Descuento en $">
                        <div class="input-group-append">
                            <span class="input-group-text bg-light"><i class="mdi mdi-tag"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="input_password_card" class="font-weight-bold">Clave</label>
                    <div class="input-group">
                        <input type="number" min="0" step="1" id="input_password_card" name="clave_vehiculo" class="form-control" placeholder="Clave">                        
                    </div>
                </div>
            </div>

            <div class="card mb-4" id="card-vehicle-type">
                <div class="card-header text-center bg-light font-weight-bold">
                    Seleccione el tipo de vehículo al que aplica el servicio
                </div>
                <div class="d-flex justify-content-center pt-4 flex-wrap">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        @foreach($tipos_vehiculo as $tipo_vehiculo)
                        <label class="btn btn-outline-primary m-1">
                            <input type="radio" name="id_tipo_vehiculo" class="radio-btn-vehicle-type" value="{{$tipo_vehiculo->id}}" data-url="{{route('paquete.packagesByVehicleType',[$tipo_vehiculo->id])}}">
                            <img src="{{asset($tipo_vehiculo->imagen)}}" class="rounded" alt="{{$tipo_vehiculo->descripcion}}" data-toggle="tooltip" title="{{$tipo_vehiculo->descripcion}}" height="150px" width="150px">
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mt-4 d-none" id="div-packages">
                <div class="card-header text-center bg-light font-weight-bold">
                    Seleccione el combo o servicio
                </div>
                <div class="d-flex justify-content-center pt-4">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons" style="overflow-x: auto" id="div-buttons-package"></div>
                </div>
            </div>

            <div class="pb-2 pt-5">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-centered text-center mb-0" id="table-products">
                        <thead>
                            <tr>
                                <th class="header-pay" colspan="4">Detalle venta <i class="mdi mdi-cart-plus"></i></th>
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
                                <td class="font-weight-bold text-right" colspan="3">
                                    Total:<input type="hidden" name="importe_total" id="importe_total" value="0">
                                </td>
                                <td class="font-weight-bold td_importe_total">
                                    $<strong id="text_importe_total">0</strong>
                                    <div id="descuento_aplicado" class="text-danger small font-weight-bold"></div>
                                    <div id="total_final" class="text-success h5"></div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-center">
                <button type="submit" id="btn_create_sell" class="btn btn-success btn-lg px-5">
                    <i class="mdi mdi-content-save-all"></i> Generar Venta
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('style')
<style>
.header-pay{
    background:#e3f2fd;
    border-radius:8px;
    font-weight:bold;
}
.card-header.bg-primary {
    background: linear-gradient(90deg, #007bff 60%, #00c6ff 100%) !important;
}
input[type="text"], input[type="number"], select.form-control {
    border-radius: 8px !important;
}
.btn-success {
    background: linear-gradient(90deg, #28a745 60%, #00c851 100%);
    border: none;
}
</style>
@endpush

@push('custom-scripts')
    {!! Html::script('js/validate.min.js') !!}
    {!! Html::script('js/validator.messages.js') !!}
    {!! Html::script('lib/sell.js?v.2') !!}
@endpush