<!-- CSS only -->

<input type="checkbox" checked data-toggle="toggle" data-onstyle="secondary" data-offstyle="success"><div class="container"><br/>
<label class="switch">
  <input type="checkbox">
  <span class="slider"></span>
</label><br><br>
</div>
<div class="modal fade" id="rol">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Agregar Nuevo Rol</h4>
      </div>
      <div class="modal-body">
        <form id="formRol" name="new-rol" autocomplete="off">
          <p>
            <label for="rol" class="control-label">Nombre de Rol </label>
            <input type="text" class="form-control" placeholder="Nombre Rol" name="rol" id="tRol">
          </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button>
        <button class="btn btn-primary" id="addRol"><span class="glyphicon glyphicon-ok-sign"></span> Guardar</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<p>
<div class="card mb-3" style="border:0;"  >
                      <div class="flip-card mb-3 ">
                        <div class="flip-card-inner"  >
                          <div class="flip-card-front"> 
                            <div class="view overlay">
                              <!--Clase del contenido de la card-->  
                              <!--<input type="checkbox" name="modulos[<= $i; >]['leer']"> -->
                              <div class="btn btn-primary active btn-sm">
                                <span class="glyphicon glyphicon-remove-sign"></span> NO
                              </div>
                              <a href="#">
                                <div class="mask rgba-white-slight"></div>
                              </a>
                            </div>
                          </div>

                          <div class="flip-card-back" >
                            <div class="view overlay">
                              <!--Clase del contenido de la card-->  
                              <div class="btn btn-default btn-success btn-sm">
                                <span class="glyphicon glyphicon-ok-sign"></span> SI
                              </div>
                              <a href="#">
                                <div class="mask rgba-white-slight"></div>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>  
                    </div>
                    <!--EndCARD-->

                    
			</div>
<!-- JavaScript Bundle with Popper -->
