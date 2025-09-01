@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-header"><h3>Registrar Venta Tienda</h3></div>
    <form id="form_create_sell" action="{{route('venta.store')}}" method="POST">
        {{ csrf_field() }}
        <fieldset>
            <div class="card-body">
                <div class="d-flex justify-content-around mb-3 pb-3">
                    <div class="col-lg-4">
                        <label>¿Qui&eacute;n presta el servicio?&nbsp;:</label>
                        <select class="select2" name="id_usuario" style="width: 100%">
                            @foreach($usuarios as $usuario)
                            <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card mt-4" id="card-products">
                    <div class="card-header text-center">
                        Agregar productos a la venta
                    </div>
                    <div>
                        <div class="d-flex justify-content-center pt-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Producto&nbsp;:</label>
                                    <select class="select2" id="select-product" style="width:100%;">
                                        @if(count($productos) != 0)
                                        <option value="">Seleccione el producto...</option>
                                        @foreach($productos as $producto)
                                            <option value="{{$producto->id_detalle_compra}}" data-price="{{$producto->precio_venta}}" data-buy-price="{{$producto->precio_compra}}" data-quantity="{{$producto->cantidad_disponible}}" data-text="{{$producto->producto->nombre.' - '.$producto->producto->presentacion->nombre}}">{{$producto->producto->nombre.' - '.$producto->producto->presentacion->nombre.' - $ '.$producto->precio_venta}}</option>
                                        @endforeach
                                    @else
                                    <option value="">Existencias agotadas</option>
                                    @endif
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
                            <button type="button" class="btn btn-success" id="btn-add-products" title="Agregar" data-toggle="tooltip">Agregar&nbsp;<i class="mdi mdi-plus-circle-outline mdi-18px"></i></button>
                        </div>
                    </div>
                </div>
                <div class="pb-2 pt-5">
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-centered text-center mb-0" id="table-products">
                            <thead>
                                <tr>
                                    <th class="header-pay" colspan="4">Detalle venta</th>
                                </tr>
                                <tr>
                                    <th>Productos</th>
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
                <div class="d-flex justify-content-end">
                    <button type="submit" id="btn_create_sell" class="btn btn-success">Generar Venta  <i  class="mdi mdi-content-save-all"></i> </button>
                </div>
            </div>
        </fieldset>
        <input type="hidden" name="nombre_cliente" value="No aplica">
        <input type="hidden" name="id_estado_venta" value="3">
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