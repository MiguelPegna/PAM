<!--Codigo ventana nuevo rol-->
<div class="modal fade" id="rol">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titleModal">Agregar Nuevo Rol</h4>
      </div>
      <div class="modal-body">
        <form id="formRol" name="new-rol" autocomplete="off">
          <p>
            <input type="hidden" id="idRol" name="idRol" value="">
            <div class="formRol">
              <label for="rol" class="control-label">Nombre de Rol</label>
              <input type="text" class="form-control" placeholder="Nombre Rol" name="rol" id="tRol">
            </div>
          </p>
          <!--Este bloque no sera visible para la opcion de crear rol-->
          <div class="opStatus">
            <label for="estado" class="control-label">Estado de Rol </label><br/>
            <select class="form-control" id="listStatus" name="listStatus">
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button>
        <button class="btn btn-primary" id="actionRol"><span class="glyphicon glyphicon-ok-sign"></span> <span id="txtBtn">Guardar</span></button>
        
      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->