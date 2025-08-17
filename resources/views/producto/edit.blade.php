<div class="modal fade" id="modal_edit_product" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success d-block">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title text-uppercase text-center text-light">Editar producto&nbsp;<span class="mdi mdi-package"></span></h5>
            </div>
            <form id="edit-product-form" action="{{ route('producto.update') }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <fieldset>
                    <div class="modal-body" style="background:white;">
    
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name_product_edit">Nombre/Referencia&nbsp;:</label>
                                <input type="text" id="name_product_edit" name="nombre" class="form-control text-uppercase" placeholder="Ingrese el nombre del producto" required>
                                <input type="hidden" id="id_producto" name="id">
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Tipo de producto&nbsp;:</label>
                                    <div class="input-group">
                                        <select class="select2-edit select-tipo-producto" id="select_tipo_producto_edit" name="id_tipo_producto" required style="width: 90%;">
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" title="Agregar tipo de producto" data-toggle="modal" data-target="#modal_create_product_type">
                                                <span class="mdi mdi-plus-circle-outline mdi-24px"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <small id="type_product_edit_help" class="form-text text-muted">Ejemplo: Filtro de aire, Filtro de aceite, etc.</small>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-center">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Marca&nbsp;:</label>
                                    <div class="input-group">
                                        <select class="select2-edit select-marca" id="select_marca_edit" name="id_marca" style="width:90%">
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" title="Agregar marca" data-toggle="modal" data-target="#modal_create_brand">
                                                <span class="mdi mdi-plus-circle-outline mdi-24px"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" id="select-brand-data-url" value="{{ route('marca.index') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-4">
                                <label class="control-label">Unidad de medida&nbsp;:</label>
                                <select class="select2-edit select-unidad-de-medida" id="select-unidad-de-medida-edit" name="id_unidad_medida" style="width:100%">
                                </select>
                                @if ($errors->any() && $errors->first('id_unidad_medida'))
                                    <span class="badge badge-pill badge-danger">{{$errors->first('id_unidad_medida')}}</span>
                                @endif
                                @if (old('id_unidad_medida'))
                                    <input type="hidden" id="old-select-unit-measurement" value="{{ old('id_unidad_medida') }}">
                                @endif
                                <input type="hidden" id="select-unit-measurement-data-url" value="{{ route('unidad-de-medida.index') }}">
                            </div>
                            <div class="col-lg-4">
                                <label class="control-label">Presentacion&nbsp;:</label>
                                <select class="select2-edit select-presentation" id="select-presentation-edit" name="id_presentacion" style="width:100%">
                                </select>
                                @if ($errors->any() && $errors->first('id_presentacion'))
                                    <span class="badge badge-pill badge-danger">{{$errors->first('id_presentacion')}}</span>
                                @endif
                                @if (old('id_presentacion'))
                                    <input type="hidden" id="old-select-presentation" value="{{ old('id_presentacion') }}">
                                @endif
                                <input type="hidden" id="select-presentation-data-url" value="{{ route('presentacion.index') }}">
                            </div>

                            <div class="col-lg-4">
                                <label class="control-label">Precio venta:</label>
                                <input  type="text" class="form-control" id="input-price-edit" name="precio_venta" style="width:100%">
                                
                                @if ($errors->any() && $errors->first('precio_venta'))
                                    <span class="badge badge-pill badge-danger">{{$errors->first('precio_venta')}}</span>
                                @endif
                                @if (old('precio_venta'))
                                    <input type="hidden" id="old-select-presentation" value="{{ old('precio_venta') }}">
                                @endif
                                <input type="hidden" id="select-presentation-data-url" value="{{ route('presentacion.index') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="update-product">Guardar</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>