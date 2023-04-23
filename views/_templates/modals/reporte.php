<!--Codigo ventana nuevo rol-->
<div class="modal fade" id="usuario">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titleModal">Editar información de usuario</h4>
      </div>
      <div class="modal-body">
        <form id="formUser" name="edit-user" autocomplete="off">
            <div class="row form-modal">
                <div class="col-md-4">
                    <input type="hidden" id="idUser" name="idUser" value="">
                    <label for="nombre" class="control-label">Nombre</label>
                    <span class="asteriscoData form-text">*</span>
                    <input type="text" class="form-control form-control-error valid validTxt" placeholder="Nombre" name="nombre" id="tNombre">
                </div>

                <div class="col-md-4">
                    <label for="apellidoP" class="control-label">Apellido Paterno</label>
                    <span class="asteriscoData form-text">*</span>
                    <input type="text" class="form-control valid validTxt" name="apellidoP" id="tApe_p">
                </div>

                <div class="col-md-4">
                    <label for="apellidoM" class="control-label">Apellido Materno</label>
                    <span class="asteriscoData form-text">*</span>
                    <input type="text" class="form-control valid validTxt" name="apellidoM" id="tApe_m">
                </div>
                
            </div> <!-- end row-->

            <div class="row form-modal">
                <div class="col-md-6">
                    <label for="unidad" class="control-label">Unidad</label>
                    <span class="asteriscoData form-text">*</span>
                    <select id="unidadS" data-live-search="true" class="form-control input-format" name="unidad">
                                
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="cargo" class="control-label">Cargo</label>
                    <span class="asteriscoData form-text">*</span>
                    <select id="cargoS" data-live-search="true" class="form-control input-format" name="cargo">

                    </select>
                </div>
                
            </div> <!-- end row-->

            <div class="row form-modal">
                <div class="col-md-6">
                    <label for="rol" class="control-label">Rol</label>
                    <span class="asteriscoData form-text">*</span>
                    <select id="rolS" class="form-control input-format selectpicker" name="rol">
                                
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="titulo" class="control-label">Titulo</label>
                    <span class="asteriscoData form-text">*</span>
                    <select id="tituloS" class="form-control input-format selectpicker" name="titulo">
                                
                    </select>
                </div>
                
            </div> <!-- end row-->
          
          
            <div class="row form-modal">
                <div class="col-md-6">
                    <label for="correo" class="control-label">Correo Electronico</label>
                    <span class="asteriscoData form-text">*</span>
                    <input type="email" class="form-control valid validMail" name="mail" id="tMail">
                </div>
            </div><!-- end row-->
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button>
        <button class="btn btn-primary" id="actionUser"><span class="glyphicon glyphicon-ok-sign"></span> <span id="txtBtn"></span></button>
        
      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->