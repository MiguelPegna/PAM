<?php include_once (CAB); ?>
<!-- div que recibe el contenido de la peticon-->
        <div id="contentAjax"></div>
        <div>
            <div class="col-md-12 banner">
                <div class="container">
                    <i><label for="user" class="f-user">
                        <span class="glyphicon glyphicon-star"></span>
                        <?php echo $data['page_name']; ?>
                    </label></i>
                </div>      
            </div>
        </div>
        
        <main class="container top-buffer">
            <div class="row top-buffer ">
                <div class="col-md-12 espacio1">
                  <a data-toggle="modal" data-target="#rol" title="AGREGAR NUEVO ROL" role="button" class="btn btn-default" id="modalRol" onclick="changeModal();"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Rol</a>
                </div>

                <!--Codigo tabla de roles-->

                  <table class="table table-responsive display" id="table-roles">
	                  <thead>
	                  	<tr>
	                  		<th class="col-md-1">ID</th>
	                  		<th class="col-md-3">Nombre Rol</th>
	                  		<th class="col-md-1">Num. Usuarios</th>
	                  		<th class="col-md-1">Estado</th>
                        <th class="col-md-4">Acciones</th>
	                  	</tr>
	                  </thead>
                    <tbody>

                    </tbody>
                  </table>
                                 
            </div> <!--- fin row --> 

            <div class="bottom-buffer"></div>
        </main><!--- fin container -->

        
  <!-- SECCIÓN DE VENTANAS MODALES-->
  <?php 
      getModal('rol', $data); 
      //getModal('rolPermisos', $data); 
?>

        <?php include_once (FOOT); ?>