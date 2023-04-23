<!--Codigo ventana nuevo rol-->
<div class="modal fade" id="SofiDestinatario">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titleModal">Agregar Nuevo Destinatario</h4>
      </div>
      <div class="modal-body">
        <form id="formDestinatario" name="new-destinatario" autocomplete="off">
          <p>
            <div class="formDestinatario">
              <label for="nombre" class="control-label">Nombre completo del Destinatario</label>
              <input type="text" class="form-control" placeholder="Nombre destinatario" name="nDestinatario" id="nDestinatario">
            </div>
          </p>
          
          <div class="opStatus form-group">
            <label for="estado" class="control-label ">Pertenece a UTIC?</label><br/>
            <select class="form-control" id="listStatus" name="listStatus">
              <option value="1">SI</option>
              <option value="0">NO</option>
            </select>
          </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button>
        <button class="btn btn-primary" id="actionDestinatario"><span class="glyphicon glyphicon-ok-sign"></span> <span id="txtBtn">Guardar</span></button>
        
      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->