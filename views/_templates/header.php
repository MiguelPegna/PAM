<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $data['page_title']; ?></title>
        <!-- CSS -->
        <link href="frame/images/favicon.png" rel="shortcut icon">
        <!--<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet"> -->
        <link href="frame/css/main.css" rel="stylesheet">
        
        <link href="<?php echo assets(); ?>css/extras/datatables.min.css" rel="stylesheet">
        <script src="<?php echo assets(); ?>js/plugins/jquery-3.6.0.min.js"> </script>
        <?php
          if($data['page_id'] == 'p_registro' || $data['page_id'] == 'p_usuarios' || $data['page_id'] =='p_minutas' ||$data['page_id']=='p_primero'){
            echo '<link href="'.assets().'css/extras/bootstrap-select.min.css" rel="stylesheet">'; 
        }?>
              
        <link href="<?php echo assets(); ?>css/styles.css" rel="stylesheet">
        
    </head> 
    <body>
     
    <!-- Contenido -->

    <main class="page">
      <nav class="navbar navbar-inverse sub-navbar navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#subenlaces">
              <span class="sr-only">Interruptor de Navegación</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="portal"><span class="icon-home" aria-hidden="true"></span> PLATAFORMA DE ACUERDOS Y MINUTAS </a>
          </div>

          <div class="collapse navbar-collapse" id="subenlaces">
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Usuarios <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                <li><a href="registro">Registrar Usuario</a></li>
                  <li><a href="usuarios">Lista de Usuarios</a></li>
                  <li class="divider"></li>
                  <li><a href="usuarios_inactivos">Usuarios Inactivos</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Minutas <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                <li><a href="minutas">Crear Minuta</a></li>
                  <li><a href="listamin">Lista de Minutas</a></li>
                  <li class="divider"></li>
                  <li><a href="acuerdos.php">Lista de Acuerdos</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                <li><a href="reportes">Crear Reporte</a></li>
                  <li><a href="listarep">Lista de Reportes</a></li>
                  
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Oficios <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                <li><a href="sofi">Subir oficio</a></li>
                  <li><a href="oficios.php">Lista de Oficios</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Listas <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                <li><a href="roles">Lista de Roles</a></li>
                  <li><a href="cargos">Lista de Cargos</a></li>
                  <li><a href="titulos">Lista de Titulos</a></li>
                </ul>
              </li>

        <li>
          <a data-toggle="modal" data-target="#logout" title="Cerrar Sesión" role="button" >Cerrar Sesion <span class="glyphicon glyphicon-log-out"></span></a>
          <!--<a href="includes/logout.php" title="Cerrar Sesión" role="button" >Cerrar Sesion </a>-->
        </li>
      </ul>
    </div>
  </div>
</nav>
</div>


<!--Codigo ventana cerrar sesion-->
<?php 
  getModal('logout', $data); 
?>
<!--   <h3>Registrar nuevo usuario</h3> -->
  