<div class="modal fade" id="modal_create_brand" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success d-block">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title text-uppercase text-center">Crear marca <span class="mdi mdi-alpha-r-circle-outline"></span></h5>
            </div>
            <form id="create-brand-form" name="create-brand-form" action="{{route('marca.store')}}" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="form-fields-brand">
                                <label for="nombre-marca">Nombre de la marca</label>
                                <input type="text" class="form-control text-uppercase" id="nombre-marca" name="nombre" aria-describedby="nombre" placeholder="Ingrese el nombre de la marca" required>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <div id="spinner-brand" class="spinner-border d-none" role="status" >
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="save-brand">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>