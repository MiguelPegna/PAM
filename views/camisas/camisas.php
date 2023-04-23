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
                  <a data-toggle="modal" data-target="#cargo" title="AGREGAR NUEVO CARGO" role="button" class="btn btn-default" id="modalCargo" onclick="changeModal();"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Cargo</a>
                </div>

                <!--Codigo tabla de roles-->

                  hola
                                 
            </div> <!--- fin row --> 

            <div class="bottom-buffer"></div>
        </main><!--- fin container -->

        
  <!-- SECCIÓN DE VENTANAS MODALES-->
  <?php 
      getModal('cargo', $data); 
      //getModal('rolPermisos', $data); 
?>
        <?php include_once (FOOT); ?>