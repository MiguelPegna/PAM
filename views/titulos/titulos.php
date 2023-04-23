<?php include_once (CAB); ?>

        <div>
            <div class="col-md-12 banner">
                <div class="container">
                    <i><label for="user" class="f-user">
                        <span class="glyphicon glyphicon-education"></span>
                        <?php echo $data['page_name']; ?>
                    </label></i>
                </div>      
            </div>
        </div>
        
        <main class="container top-buffer">
            <div class="row top-buffer ">
                <div class="col-md-8 espacio1">
                  <a data-toggle="modal" data-target="#titulo" title="AGREGAR NUEVO TITULO" role="button" class="btn btn-default" id="modalTitulo" onclick="changeModal();"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Titulo</a>
                </div>

                <!--Codigo tabla de roles-->

                  <table class="table table-responsive display" id="table-titulos">
	                  <thead>
	                  	<tr>
	                  		<th class="col-md-1">ID</th>
	                  		<th class="col-md-3">Titulo</th>
	                  		<th class="col-md-1">abr.</th>
	                  		<th class="col-md-1">num</th>
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
      getModal('titulo', $data); 
      //getModal('rolPermisos', $data); 
?>
        <?php include_once (FOOT); ?>