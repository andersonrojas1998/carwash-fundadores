<div class="modal fade" id="modal_create_product_type" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success d-block">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title text-uppercase text-center">Crear tipo de producto&nbsp;<span class="mdi mdi-arrow-left-right-bold"></span></h5>
            </div>
            <form id="create-product-type-form" action="{{route('tipo-producto.store')}}">
                <div class="modal-body">
                    <div class="form-group" id="form-fields-product-type">
                        <label for="descripcion-tipo-producto">Descripci&oacute;n</label>
                        <input type="text" class="form-control text-uppercase" id="descripcion-tipo-producto" name="descripcion" aria-describedby="descripcion" placeholder="Ingrese la descripci&oacute;n" required>
                    </div>
                    <div class="text-center">
                        <div id="spinner-product-type" class="spinner-border d-none" role="status" >
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="save-product-type">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>