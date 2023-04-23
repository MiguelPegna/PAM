<!--Codigo ventana inactivar rol-->
<div class="modal fade" id="drop-rol">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Inactivar Rol</h4>
      </div>
      <div class="modal-body">
        <form id="deleteRol" name="delete-rol">
          <p>
          <input type="hidden" id="idRol" name="idRol" value="">
            <label for="msg" class="control-label">¿Deseas desactivar este rol de usuario? <br/>
            Al hacer esto los usuarios con este rol pasaran a ser usuarios inactivos.</label>
          </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button>
        <button class="btn btn-primary" id="dropRol"><span class="glyphicon glyphicon-ok-sign"></span> Aceptar</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->