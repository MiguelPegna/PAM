<!--Codigo ventana nuevo rol-->
<div class="modal fade" id="SofiEmpresa">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titleModal">Agregar Nueva Empresa</h4>
      </div>
      <div class="modal-body">
        <form id="formEmpresa" name="new-empresa" autocomplete="off">
          <p>
            <input type="hidden" id="idEmpresa" name="idEmpresa" value="">
            <div class="formEmpresa">
              <label for="rol" class="control-label">Nombre de Empresa</label>
              <input type="text" class="form-control" placeholder="Nombre empresa" name="empresa" id="tEmpresa">
            </div>
          </p>
          
          <div class="opStatus">
            <label for="estado" class="control-label">Esta empresa pertenece a UTIC?</label><br/>
            <select class="form-control" id="listStatus" name="listStatus">
              <option value="1">SI</option>
              <option value="0">NO</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button>
        <button class="btn btn-primary" id="actionEmpresa"><span class="glyphicon glyphicon-ok-sign"></span> <span id="txtBtn">Guardar</span></button>
        
      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->