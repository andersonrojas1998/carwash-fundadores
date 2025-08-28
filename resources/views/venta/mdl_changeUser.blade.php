<div class="modal fade" id="modal_edit_user_service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary d-block">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title text-uppercase text-center text-light" >Cambiar Prestador De Servicio<span class="mdi mdi-package"></span></h5>
            </div>
           
                {{ csrf_field() }}
                <fieldset>
                    <div class="modal-body" style="background:white;">
    
                        <div class="row">
                        <div class="col-lg-8">
                            <input type="hidden" id="id_venta">
                        <label for="">
                            Atendido Por : 
                        </label>
                        <select id="user_service" class="select2" style="width: 100%">
                            @foreach($llegadas as $llegada)
                                <option value="{{ $llegada->empleado->id }}"
                                    {{ $llegada->estado == 'activo' ? 'selected' : '' }}>
                                    {{ $llegada->empleado->name }} ({{ ucfirst($llegada->estado) }})
                                </option>
                            @endforeach
                        </select>
                        </div>
                        </div>
                        <br>                                                   
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button  class="btn btn-success btn_user_service">Guardar</button>
                    </div>
                </fieldset>
           
        </div>
    </div>
</div>