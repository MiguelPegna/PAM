<!--Codigo ventana nuevo rol-->
<div class="modal fade" id="invitado">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titleModal">Agregar Nuevo Participante</h4>
      </div>
      <div class="modal-body">
        <form id="formInvitado" name="new-invitado" autocomplete="off">
          <p>
            <div class="formInvitado">
              <label for="nombre" class="control-label">Nombre completo del participante</label>
              <input type="text" class="form-control" placeholder="Nombre participante" name="nombre" id="tNombre">
            </div>
          </p>
          
          <div class="opStatus col-md-6">
            <label for="estado" class="control-label ">Pertenece a UTIC?</label><br/>
            <select class="form-control" id="listStatus" name="listStatus">
              <option value="1">SI</option>
              <option value="0">NO</option>
            </select>
          </div>

            <div class="col-md-6">
              <label for="titulo" class="control-label">Titulo Profesional</label>
              <select class="form-control" id="tituloS" name="titulo">

              </select>
          </div>

          <div class="formInvitado">
              <label for="mail" class="control-label">Correo Electronico</label>
              <input type="text" class="form-control" placeholder="@" name="email" id="tMail">
            </div>
          </p>
          
            <div class="formInvitado">
              <label for="cargo" class="control-label">Cargo</label>
              <!--carga de select con las unidades-->
              <select id="cargoI" class="form-control input-format" data-live-search="true" name="cargoI">
                                        
              </select>
            </div>
          </p>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button>
        <button class="btn btn-primary" id="actionInvitado"><span class="glyphicon glyphicon-ok-sign"></span> <span id="txtBtn">Guardar</span></button>
        
      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->