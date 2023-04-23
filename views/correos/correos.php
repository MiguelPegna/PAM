<?php include_once (CAB); ?>
<!-- div que recibe el contenido de la peticon-->
        <div id="contentAjax"></div>
        <div>
            <div class="col-md-12 banner">
                <div class="container">
                    <i><label for="user" class="f-user">
                        <span class="glyphicon glyphicon-tower"></span>
                        <?php echo $data['page_name']; ?>
                    </label></i>
                </div>      
            </div>
        </div>
        
        <main class="container top-buffer">
            <div class="row top-buffer ">
                <div class="col-md-12 espacio1">
                    <form id="formCorreos" name="new-correo" autocomplete="off">
                </div>

                <div class="row">
                        <div class="col-md-4">
                            <div class="form-group op-menu">
                                <label for="calendar" class="control-label">Fecha
                                    <span class="asteriscoData form-text">*</span>
                                </label>
                                <input id="t1" type="text" class="form-control" value="1" name="correo[]">
                                <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                    Este campo es obligatorio
                                </small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group op-menu">
                                <label for="calendar" class="control-label">Hora
                                    <span class="asteriscoData form-text">*</span>
                                </label>
                                <input id="t2" type="text" class="form-control" value="2" name="correo[]">
                                <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                    Este campo es obligatorio
                                </small>
                            </div>
                        </div>

                        <button class="btn btn-primary">Probar</button>
                </form>
                <!--Codigo tabla de roles-->

                  
                                 
            </div> <!--- fin row --> 

            <div class="bottom-buffer"></div>
        </main><!--- fin container -->

        
  <!-- SECCIÓN DE VENTANAS MODALES-->
  <?php 
      getModal('cargo', $data); 
      //getModal('rolPermisos', $data); 
?>
        <?php include_once (FOOT); ?>