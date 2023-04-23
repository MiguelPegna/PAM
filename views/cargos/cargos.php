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

                  <table class="table table-responsive display" id="table-cargos">
	                  <thead>
	                  	<tr>
	                  		<th class="col-md-1">ID</th>
	                  		<th class="col-md-6">Cargo</th>
	                  		<th class="col-md-1">Num. Usuarios</th>
	                  		<th class="col-md-1">Tipo de Cargo</th>
                        <th class="col-md-2">Acciones</th>
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
      getModal('cargo', $data); 
      //getModal('rolPermisos', $data); 
?>
        <?php include_once (FOOT); ?>