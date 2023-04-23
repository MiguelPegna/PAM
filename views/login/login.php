<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $data['page_title']; ?></title>
        <!-- CSS -->
        <link href="frame/img/icons/favicon.png" rel="shortcut icon">
        <!--<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet"> -->
        <link href="frame/css/main.css" rel="stylesheet">
        
        <link href="<?php echo assets(); ?>css/extras/datatables.min.css" rel="stylesheet">
        <script src="<?php echo assets(); ?>js/plugins/jquery-3.6.0.min.js"> </script>
        <script type="text/javascript" src="<?php echo assets(); ?>js/validaForm.js"></script>
        <script src="<?php echo assets(); ?>js/login.js"> </script>
              
        <link href="<?php echo assets(); ?>css/styles.css" rel="stylesheet">
        
    </head> 
    <body>
        <div class="container top-buffer">
 
            <!-- Contenido -->
            <main>
                <form class="form-horizontal" role="form" action="" method="post" name="loginForm" id="loginForm">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4"> 
                                <h3> &raquo; Iniciar Sesión </h3>
                                <hr class="red">   
                                <label class="control-label" for="email"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Correo Electronico</label>
                                <input class="form-control" id="email" type="text" name="usuario">
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                        <br/>

                        <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <label class="control-label" for="pass"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Contraseña</label>
                                <input class="form-control ver01" id="pass" type="password" name="password">
                            </div>
                            <div class="col-sm-1">
                                <br/><h4><a href="javascript:verPass01();"><label><span id="ojo" class="glyphicon glyphicon-eye-open eye" aria-hidden="true" title="VER CONTRASEÑA"></span></label></a></h4>
                            </div>
                        </div><br/>

                        <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <a href="recuperar" class="pull-right"><span class="glyphicon glyphicon-question-sign"></span> Olvide mi Contraseña</a>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>

                        <br/>

                        <div class="row">
                            <div class="col-sm-5"></div>
                            <div class="col-sm-3">
                                
                                <button class="btn btn-primary pull-left" type="submit"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;INICIAR SESIÓN</button><br/>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>

                    </div>                                        
                </form>
            </main>
        </div>
        <div class="bottom-buffer"></div>
        <!-- JS -->
        <script>
            const base_url= "<?php echo base_url(); ?>";
        </script>
           <!-- Contenido   <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>  -->
    <script src="<?php echo assets(); ?>js/plugins/gobmx.js"></script>

    <!-- SCRIPTS -->
    <!--  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="<?php echo assets(); ?>js/plugins/sweetalert2@11.js"></script>
    <!-- cargar scripts correspondientes a cada vista-->
        
    </body>
</html>