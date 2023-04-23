<?php include_once (CAB); ?>
<!-- div que recibe el contenido de la peticon-->
        <div>
            <div class="col-md-12 banner">
                <div class="container">
                    <i><label for="user" class="f-user">
                        <span class="glyphicon glyphicon-book"></span>
                        <?php echo $data['page_name']; ?>
                    </label></i>
                </div>      
            </div>
        </div>
        
        <main class="container top-buffer">
            <div class="row top-buffer ">
                <div class="col-md-12 espacio1">
                  <a href="reportes" title="CREAR NUEVO REPORTE"  class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Reporte</a>
                </div>

                <!--Codigo tabla de roles-->

                  <table class="table table-responsive display" id="table-reportes">
	                  <thead>
	                  	<tr>
	                  		<th class="col-md-2">Titulo</th>
	                  		<th class="col-md-1">Fecha</th>
	                  		<th class="col-md-3">Receptor</th>
	                  		<th class="col-md-1">Estado</th>
                        <th class="col-md-3">Acciones</th>
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
      getModal('reporte', $data); 
      //getModal('rolPermisos', $data); 
?>
        <?php include_once (FOOT); ?>