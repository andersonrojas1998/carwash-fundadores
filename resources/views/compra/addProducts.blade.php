<div class="container-fluid mx-1">
    <div class="card">
        <div class="card-header header-pay text-center header-pay">Agregar productos   <i class="mdi  mdi-cart-plus"></i></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-add-products">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <!-- <th class="d-none">Precio de venta</th> -->
                            <th>Precio de compra</th>
                        </tr>
                        <tr>
                            <td class="w-25 p-1">
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="select2 select-product-compra select_add_products" data-url-quantity="{{route('producto.index')}}" style="width: 100%"></select>
                                    </div>
                                </div>
                            </td>
                            <td class="p-1">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-quantity input_add_products">
                                    </div>
                                </div>
                            </td>
                            <!--  -->
                            <!--<td class="p-1 d-none">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-sell-price input_add_products">
                                    </div>
                                </div>
                            </td>  -->
                            <!--  -->



                            <td class="p-1">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-buy-price input_add_products">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-icons btn-rounded btn-success btn_add_product" title="Agregar" data-toggle="tooltip"><i class="mdi mdi-plus-circle-outline mdi-18px"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <!-- <th class="d-none">Precio de venta</th> -->
                            <th>Precio de compra</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($compra))
                            @foreach($compra->detalle_compra_productos as $detalle_compra_producto)
                                <tr>
                                    <td>
                                        {{$detalle_compra_producto->producto->nombre . ' (' . $detalle_compra_producto->producto->tipo_producto->descripcion . ')'}}
                                        <input type="hidden" class="id_producto_table" name="id_producto[]" value="{{$detalle_compra_producto->producto->id}}">
                                        <input type="hidden" name="id_detalle_compra_producto[]" value="{{$detalle_compra_producto->id_detalle_compra}}">
                                    </td>
                                    <td class="td_quantity">
                                        {{$detalle_compra_producto->cantidad}}
                                        <input type="hidden" name="cantidad[]"  class="cantidad_producto_table" value="{{$detalle_compra_producto->cantidad}}">
                                    </td>
                                    <!--<td class="td_sell_price d-none">
                                        {{$detalle_compra_producto->precio_venta}}
                                        <input type="hidden" name="precio_venta[]" value="{{$detalle_compra_producto->precio_venta}}">
                                    </td>-->
                                    <td class="td_buy_price">
                                        {{$detalle_compra_producto->precio_compra}}
                                        <input type="hidden" class="precio_compra_producto_table" name="precio_compra[]" value="{{$detalle_compra_producto->precio_compra}}">
                                    </td>
                                    <td>
                                        <a class="btn_edit_product_values" data-toggle="tooltip" title="Editar">
                                            <i class="mdi mdi-pencil-box-outline text-primary mdi-18px"></i>
                                        </a>
                                        <a class="btn_save_edit_product_values" data-toggle="tooltip" title="Guardar">
                                            <i class="mdi mdi-checkbox-marked-outline text-success mdi-18px"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="font-weight-bold text-right" colspan="3">Total:<input type="hidden" name="importe_total" class="importe_total form_add_products" value="@if(isset($compra)) {{$compra->importe_total}} @else 0 @endif"></td>
                            <td class="font-weight-bold td_importe_total">$<strong class="text_importe_total">@if(isset($compra)) {{$compra->importe_total}} @else 0 @endif</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="select-product-data-url" value="{{ route('producto.data',[-1])}}">