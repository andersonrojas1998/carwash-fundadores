<div class="modal fade" id="modal_create_package" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success d-block">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title text-uppercase text-center">Crear combo <span class="mdi mdi-alpha-r-circle-outline"></span></h5>
            </div>
            <form id="create-package-form" action="{{route('paquete.store')}}" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="form-fields-package">
                                <label for="nombre-paquete">Nombre del combo</label>
                                <input type="text" class="form-control text-uppercase" id="nombre-paquete" name="nombre" aria-describedby="nombre" placeholder="Ingrese el nombre del combo" required>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <div id="spinner-package" class="spinner-border d-none" role="status" >
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="save-package">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>