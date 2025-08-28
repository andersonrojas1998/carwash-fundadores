
<div class="modal fade" id="modal_finalizar_venta" tabindex="-1" role="dialog" aria-labelledby="finalizarVentaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form_finalizar_venta">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title">Finalizar Venta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="finalizar_id_venta" name="id_venta">
            <div class="form-group">
                <label for="finalizar_medio_pago">Método de Pago</label>
                <select id="finalizar_medio_pago" name="medio_pago" class="form-control select2" style="width:100%" required>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Transferencia">Transferencia</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Actualizar y Finalizar</button>
        </div>
      </div>
    </form>
  </div>
</div>