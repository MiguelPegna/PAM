<!--Codigo ventana cerrar sesion-->
<div class="modal fade" id="logout">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Mensaje de Alerta</h4>
      </div>
      <div class="modal-body">
        <form role="form" id="form-num-of" name="form-num-of">
          <p>¿<?php echo $_SESSION['userData']['nombre'];?> quieres cerrar la sesión?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a href="helpers/logout.php" class="btn btn-primary" id="btn-addNumOf">Aceptar</a>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->