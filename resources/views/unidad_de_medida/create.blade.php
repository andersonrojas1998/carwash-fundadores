<div class="modal fade" id="modal_create_unit_measurement" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success d-block">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title text-uppercase text-center">Crear unidad de medida <span class="mdi mdi-beaker-outline"></span></h5>
            </div>
            <form id="create-unit-measurement-form" action="{{ route('unidad-de-medida.store') }}">
                <div class="modal-body">
                    <div id="form-fields-unit-measurement" class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nombre-unidad-medida">Nombre</label>
                                <input type="text" class="form-control text-uppercase" id="nombre-unidad-medida" name="nombre" aria-describedby="nombre" placeholder="Ingrese el nombre" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="abreviatura-unidad-medida">Abreviatura</label>
                                <input type="text" class="form-control" id="abreviatura-unidad-medida" name="abreviatura" aria-describedby="abreviatura" placeholder="Ingrese la abreviatura" required>
                            </div>
                        </div>
                    </div>
                    <div id="spinner-unit-measurement" class="row text-center d-none">
                        <div class="col-lg-12">
                            <div class="spinner-border" role="status" >
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="save-unit-measurement">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>