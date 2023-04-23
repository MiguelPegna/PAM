<!--Codigo ventana logo minuta-->
<div class="modal fade" id="logoReporte">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="titleModal">Seleccionar logos para reportes</h4>
        </div>
        <div class="modal-body">
            <form id="formLogoReporte" name="logoMinuta" autocomplete="off">
            <div class="row">
                <div class="opStatus col-md-6">
                    <input type="hidden" id="idReporte" name="idReporte" value="">
                    <label for="logo-izq" class="control-label ">Logo lado izquierdo</label><br/>
                    <select class="form-control" id="logoRepIzq" name="logoRepIzq">

                    </select>
                </div>
    
                <div class="col-md-6">
                    <label for="logo-der" class="control-label">Logo lado derecho</label>
                    <select class="form-control" id="logoRepDer" name="logoRepDer">

                    </select>
                </div>
            </div>
            

            <div class="row">
                <div class="col-md-6">
                    <label for="pie-pag" class="control-label">Elegir pie de pág.</label>
                    <select class="form-control" id="piePagRep" name="piePagRep">

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