<!--Codigo ventana inactivar rol-->
<!-- CSS only -->
<link href="<?php echo assets();?>css/extras/check-toogle.css" rel="stylesheet">
<script src="<?php echo assets();?>js/plugins/popper.min.js"></script>
<div class="modal fade" id="rolPermisos"> 
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Permisos de Rol de Usuario</h4>
      </div>
      <div class="modal-body">
        <?php //dep($data);?>
        <div class="col-md-12">
          <form action="" id="permisoFormRol" name="permiso-rol">
            <!--Obtiene el id del rol para poder mostrar los permisos del rol-->
            <input type="hidden" id="idrol" name="idRol" value="<?= $data['idRol']; ?>" required="">
          
          
          <div class="container-fluid">
            <table class="table">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Módulo</th>
                  <th>Ver</th>
                  <th>Crear</th>
                  <th>Modif.</th>
                  <th>Borrar</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $no=1;
                $modulos = $data['modulos'];
                for($i=0; $i < count($modulos); $i++){
                  $permisos = $modulos[$i]['permisos'];
                  $lCheck = $permisos['leer'] == 1 ? "checked" : "";
                  $cCheck = $permisos['crear'] == 1 ? "checked" : "";
                  $mCheck = $permisos['modif'] == 1 ? "checked" : "";
                  $bCheck = $permisos['borrar'] == 1 ? "checked" : "";
                  $idmod = $modulos[$i]['mod_id'];
                ?>
                <tr>
                  <td>
                    <?php echo $no; ?>
                    <input type="hidden" name="modulos[<?php echo $i; ?>][mod_id]" value="<?php echo $idmod; ?>" required="">
          
                  </td>
                  <td>
                    <?php echo $modulos[$i]['mod_nombre']; ?>
                  </td>
                  <td>
                    <div class="toggle-flip">
                      <label>
                        <input type="checkbox" name="modulos[<?php echo $i; ?>][leer]" <?php echo $lCheck; ?> ><span class="flip-indecator" data-toggle-on="SI" data-toggle-off="NO"></span>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="toggle-flip">
                      <label>
                        <input type="checkbox" name="modulos[<?php echo $i; ?>][crear]" <?php echo $cCheck; ?> ><span class="flip-indecator" data-toggle-on="SI" data-toggle-off="NO"></span>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="toggle-flip">
                      <label>
                        <input type="checkbox" name="modulos[<?php echo $i; ?>][modif]" <?php echo $mCheck; ?> ><span class="flip-indecator" data-toggle-on="SI" data-toggle-off="NO"></span>
                      </label>
                    </div>
                  </td>
                  <td>  
                    <div class="toggle-flip">
                      <label>
                        <input type="checkbox" name="modulos[<?php echo $i; ?>][borrar]" <?php echo $bCheck; ?> ><span class="flip-indecator" data-toggle-on="SI" data-toggle-off="NO"></span>
                      </label>
                    </div>
                  </td>
                </tr>
                <?php 
                  $no++;
                  }
                ?>
              </tbody>
            </table>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button>
            <button type="submit" class="btn btn-primary" id="updateKeys"><span class="glyphicon glyphicon-floppy-saved"></span> <span id="txtBtn">Guardar</span></button>
          </form>
          </div>
        </div>
      </div>

      <div class="modal-footer">
         <!-- scripts toogle-checkbox-->  
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

