<?php include_once (CAB); ?>
<!--?php
    este sirve para restringir elementos visibles
   if(!empty($_SESSION['permisos'][1]['leer'])){}
?>-->
<!-- div que recibe el contenido de la peticon-->
        <div>
            <div class="col-md-12 banner">
                <div class="container">
                    <i><label for="user" class="f-user">
                        <span class="glyphicon glyphicon-user"></span>
                        <?php echo $data['page_name']; ?>
                    </label></i>
                </div>      
            </div>
        </div>
        <!--?php
            Este sirve para restringir vistas
            if(empty($_SESSION['permisosMod']['leer'])){
                <div>Acceso restringido</div>
            }
        ?>-->
        <main class="container top-buffer">
            <div class="row top-buffer ">
                <div class="col-md-12 espacio1">
                  <a href="registro" title="REGISTRAR NUEVO USUARIO"  class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Usuario</a>
                </div>

                <!--Codigo tabla de roles-->

                  <table class="table table-responsive display" id="table-usuarios">
	                  <thead>
	                  	<tr>
	                  		<th class="col-md-1">ID</th>
	                  		<th class="col-md-3">Info Usuario</th>
	                  		<th class="col-md-5">Info SICT</th>
	                  		<th class="col-md-1">Estado</th>
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
      getModal('usuario', $data); 
      //getModal('rolPermisos', $data); 
?>
        <?php include_once (FOOT); ?>