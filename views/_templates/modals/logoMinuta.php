<!--Codigo ventana logo minuta-->
<div class="modal fade" id="logoMinuta">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="titleModal">Seleccionar logos para la minuta</h4>
        </div>
        <div class="modal-body">
            <form id="formLogoMinuta" name="logoMinuta" autocomplete="off">
            <div class="row">
                <div class="col-md-6">
                    <label for="titulo" class="control-label">Elegir Logo</label>
                    <select class="form-control" id="logoMin" name="logoMin">

                    </select>
                </div>

                <div class="col-md-6">
                    <label for="titulo" class="control-label">Elegir pie de pág.</label>
                    <select class="form-control" id="piePagMin" name="piePagMin">
                        
                    </select>
                </div>
            </div>

        </div>
        
      <div class="modal-footer">
        
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button>
        <button class="btn btn-primary" id="actionLogoRep"><span class="glyphicon glyphicon-ok"></span> Aceptar</button>
      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->