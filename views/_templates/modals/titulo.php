<!--Codigo ventana nuevo rol-->
<div class="modal fade" id="titulo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titleModal">Agregar Nuevo Titulo Académico</h4>
      </div>
      <div class="modal-body">
        <form id="formTitulo" name="new-titulo" autocomplete="off">
          <p>
            <input type="hidden" id="idTitulo" name="idTitulo" value="">
            <div class="formTitulo">
              <label for="rol" class="control-label">Titulo Académico</label>
              <input type="text" class="form-control" placeholder="Nombre Titulo" name="titulo" id="tTitulo">
            </div>
          </p>
          
          <div class="abrT">
            <label for="rol" class="control-label">Abreviatura del titulo</label>
              <input type="text" class="form-control" placeholder="Abreviatura" name="abr" id="tAbr">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button>
        <button class="btn btn-primary" id="actionTitulo"><span class="glyphicon glyphicon-ok-sign"></span> <span id="txtBtn">Guardar</span></button>
        
      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->