@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-header "><h3>Registrar Pago  <i class="mdi mdi-cash"></i></h3> </div>
    <form id=""    action="{{ route('pago.store')}}" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <fieldset>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="reg_op_compra"># de Factura&nbsp;:</label>
                        <input type="text" id="reg_op_compra" name="reg_op" class="form-control text-uppercase" placeholder="Ingrese el # de Factura de la compra" value="{{old('reg_op')}}" >
                        @if ($errors->any() && $errors->first('reg_op'))
                            <span class="badge badge-pill badge-danger">{{$errors->first('reg_op')}}</span>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <label for="fecha_emision_compra">Fecha&nbsp;de&nbsp;emisi&oacute;n&nbsp;: <span class="text-danger">*</span></label>
                        <input type="date" id="fecha_emision_compra" name="fecha_emision" class="form-control text-uppercase" placeholder="Ingrese la fecha de emision de la compra" value="{{old('fecha_emision')}}" required>
                        @if ($errors->any() && $errors->first('fecha_emision'))
                            <span class="badge badge-pill badge-danger">{{$errors->first('fecha_emision')}}</span>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <label for="compracol" class="control-label">Descripci&oacute;n&nbsp;: <span class="text-danger">*</span></label>
                        <input type="text" id="compracol" name="compracol" class="form-control text-uppercase" placeholder="Ingrese la Descripci&oacute;n de la compra" value="{{old('compracol')}}" required>
                        @if ($errors->any() && $errors->first('compracol'))
                            <span class="badge badge-pill badge-danger">{{$errors->first('compracol')}}</span>
                        @endif
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="no_comprobante_compra">No. Comprobante:</label>
                        <input type="text" id="no_comprobante_compra" name="no_comprobante" class="form-control text-uppercase" placeholder="Ingrese el No. comprobante de la compra" value="{{old('no_comprobante')}}" >
                        @if ($errors->any() && $errors->first('no_comprobante'))
                            <span class="badge badge-pill badge-danger">{{$errors->first('no_comprobante')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label for="descuentos_iva_compra">Descuento IVA:</label>
                        <input type="number" id="descuentos_iva_compra" name="descuentos_iva" class="form-control text-uppercase" placeholder="Ingrese el descuento IVA de la compra" value="{{old('descuentos_iva')}}" >
                        @if ($errors->any() && $errors->first('descuentos_iva'))
                            <span class="badge badge-pill badge-danger">{{$errors->first('descuentos_iva')}}</span>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <label for="importe_total">Total Pago: <span class="text-danger">*</span></label>
                        <input type="number" id="importe_total" name="importe_total" class="form-control text-uppercase" placeholder="Ingrese el Total pago" value="{{old('importe_total')}}" required>
                        @if ($errors->any() && $errors->first('importe_total'))
                            <span class="badge badge-pill badge-danger">{{$errors->first('importe_total')}}</span>
                        @endif
                    </div>
                </div>
                <br>
                
                <div class="container p-1">
                    <div class="card">
                        <div class="card-header text-center header-pay" >Proveedor   <i class="mdi mdi-account"></i></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="id_proveedor_compra">Nit:</label>
                                    <input type="text" id="id_proveedor_compra" name="id_proveedor" class="form-control text-uppercase" placeholder="Ingrese el nit" value="{{old('id_proveedor')}}" >
                                    @if ($errors->any() && $errors->first('fecha_emision'))
                                        <span class="badge badge-pill badge-danger">{{$errors->first('fecha_emision')}}</span>
                                    @endif
                                </div>
                                <div class="col-lg-3">
                                    <label for="id_proveedor_nombre">Nombre:</label>
                                    <input type="text" id="id_proveedor_nombre" name="id_proveedor_nombre" class="form-control text-uppercase" placeholder="Ingrese el nombre de la empresa" value="{{old('id_proveedor_nombre')}}">
                                    @if ($errors->any() && $errors->first('id_proveedor_nombre'))
                                        <span class="badge badge-pill badge-danger">{{$errors->first('id_proveedor_nombre')}}</span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label>Raz&oacute;n social:</label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input type="radio" name="razon_social_proveedor" id="razon_social_proveedor1" value="Natural" class="form-check-input"  @if (old('razon_social_proveedor') && old('razon_social_proveedor') == 'Natural') checked="true" @endif>
                                                <label for="razon_social_proveedor1">Natural</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input type="radio" name="razon_social_proveedor" id="razon_social_proveedor0" value="Jur&iacute;dica" class="form-check-input"  @if (old('razon_social_proveedor') && old('razon_social_proveedor') != 'Natural') checked="true" @endif>
                                                <label for="razon_social_proveedor0">Jur&iacute;dica</label>
                                            </div>
                                        </div>
                                        @if ($errors->any() && $errors->first('fecha_emision'))
                                            <span class="badge badge-pill badge-danger">{{$errors->first('fecha_emision')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit"  class="btn btn-success">Guardar <i class="mdi mdi-content-save"></i></button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
@endsection
@push('custom-scripts')
    {!! Html::script('js/validate.min.js') !!}
    {!! Html::script('js/validator.messages.js') !!}
    {!! Html::script('lib/buy.js') !!}
@endpush