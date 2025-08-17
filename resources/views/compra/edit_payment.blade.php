@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-header"><h1>Editar pago</h1></div>
    <form id="edit-buy-form" action="{{ route('compra.update-payment') }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <fieldset>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="reg_op_compra_edit">Reg op&nbsp;:</label>
                        <input type="text" id="reg_op_compra_edit" name="reg_op" class="form-control text-uppercase" placeholder="Ingrese el Reg op de la compra" value="{{$compra->reg_op}}" required>
                        <input type="hidden" id="id_compra" name="id" value="{{$compra->id}}">
                    </div>

                    <div class="col-lg-4">
                        <label for="fecha_emision_compra_edit">Fecha&nbsp;de&nbsp;emisi&oacute;n&nbsp;:</label>
                        <input type="date" id="fecha_emision_compra_edit" name="fecha_emision" class="form-control text-uppercase" placeholder="Ingrese la fecha de emision de la compra" value="{{substr($compra->fecha_emision,0,10)}}" required>
                    </div>

                    <div class="col-lg-4">
                        <label for="compracol_edit" class="control-label">Compracol&nbsp;:</label>
                        <input type="text" id="compracol_edit" name="compracol" class="form-control text-uppercase" placeholder="Ingrese la compracol de la compra" value="{{$compra->compracol}}" required>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="no_comprobante_compra_edit">No. Comprobante:</label>
                        <input type="text" id="no_comprobante_compra_edit" name="no_comprobante" class="form-control text-uppercase" placeholder="Ingrese el No. comprobante de la compra" value="{{$compra->no_comprobante}}" required>
                    </div>
                    <div class="col-lg-4">
                        <label for="descuentos_iva_compra_edit">Descuento IVA:</label>
                        <input type="text" id="descuentos_iva_compra_edit" name="descuentos_iva" class="form-control text-uppercase" placeholder="Ingrese el descuento IVA de la compra" value="{{$compra->descuentos_iva}}" required>
                    </div>
                    <div class="col-lg-4">
                        <label for="importe_total_compra_edit">Total pago:</label>
                        <input type="text" id="importe_total_compra_edit" name="importe_total" class="form-control" value="{{$compra->importe_total}}" required>
                    </div>
                </div>
                <div class="container p-1">
                    <div class="card">
                        <div class="card-header">Proveedor</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="id_proveedor_compra">Nit:</label>
                                    <input type="text" id="id_proveedor_compra" name="id_proveedor" class="form-control text-uppercase" placeholder="Ingrese el nit" value="{{$compra->id_proveedor}}" required>
                                </div>
                                <div class="col-lg-3">
                                    <label for="id_proveedor_compra">Nombre:</label>
                                    <input type="text" id="id_proveedor_nombre" name="id_proveedor_nombre" class="form-control text-uppercase" placeholder="Ingrese el nombre de la empresa" value="{{$compra->id_proveedor_nombre}}" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="razon_social_proveedor_compra_edit">Raz&oacute;n social:</label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input type="radio" name="razon_social_proveedor" id="razon_social_proveedor_compra_edit1" value="Natural" class="form-check-input" required @if($compra->razon_social_proveedor == 'Natural') checked="true" @endif>
                                                <label for="razon_social_proveedor_compra_edit1">Natural</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input type="radio" name="razon_social_proveedor" id="razon_social_proveedor_compra_edit0" value="Jur&iacute;dica" class="form-check-input" required @if($compra->razon_social_proveedor != "Natural") checked="true" @endif>
                                                <label for="razon_social_proveedor_compra_edit0">Jur&iacute;dica</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" id="btn_save_edit_buy" class="btn btn-success">Guardar</button>
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