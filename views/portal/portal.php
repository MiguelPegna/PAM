        <?php include_once (CAB); ?>
        
        <div>
            <div class="col-md-12 banner">
                <div class="container">
                    <label for="user" class="f-user"><?php  echo $_SESSION['userData']['nombre']. ' '. $_SESSION['userData']['apellidoP']. ' '. $_SESSION['userData']['apellidoM'];?></label><br/>
                    <label for="cargo" class="f-cargo"><?php  echo $_SESSION['userData']['cargo'];?> / </label>  
                    <label for="rol" class="f-rol"><?php  echo $_SESSION['userData']['rol'];?></label></br>
                </div>      
            </div>
        </div>

        <main class="container top-buffer">
            <div class="row top-buffer">
                <div class="col-md-12 espacio1">
                    <!--- Columna panel de creación -->
                    <div class="col-md-4">
                        <div class="form-group a-menu">
                            <h3> &raquo; <span class="glyphicon glyphicon-list-alt"></span> Panel de Creación</a></h3>
                            
                        </div>

                        <div class="form-group op-menu">
                            <a href="registro"><h3><span class="glyphicon glyphicon-user"></span> Registrar Usuario</a></h3>
                        </div>

                        <div class="form-group op-menu">
                            <a href="minutas"><h3><span class="glyphicon glyphicon-tasks"></span> Crear Minuta</a></h3>
                        </div>

                        <div class="form-group op-menu">
                            <a href="reportes"><h3><span class="glyphicon glyphicon-book"></span> Crear Reporte</a></h3>
                        </div>

                        <div class="form-group op-menu">
                            <a href="sofi"><h3><span class="glyphicon glyphicon-file"></span> Subir Oficio</a></h3>
                        </div>

                        <div class="form-group op-menu">
                            <a href="cargos"><h3><span class="glyphicon glyphicon-tower"></span> Crear Cargo</a></h3>
                         </div>

                         <div class="form-group op-menu">
                            <a href="roles"><h3><span class="glyphicon glyphicon-star"></span> Crear Rol</a></h3>
                        </div>

                        <div class="form-group op-menu">
                            <a href="titulos"><h3><span class="glyphicon glyphicon-education"></span> Crear Título</a></h3>
                        </div>

                        <div class="form-group op-menu">
                            <a href="logos"><h3><span class="glyphicon glyphicon-picture"></span> Modificar Logos</a></h3>
                        </div>
                    </div>

                    <!--- Columna panel de edición -->
                    <div class="col-md-4">
                        <div class="form-group a-menu">
                        <h3> &raquo; <span class="glyphicon glyphicon-edit"></span> Panel de Edición</h3>

                        </div>

                        <div class="form-group op-menu">
                            <a href="usuarios"><h3><span class="glyphicon glyphicon-user"></span> Lista de Usuarios</a></h3>
                        </div>

                        <div class="form-group op-menu">
                            <a href="listamin"><h3><span class="glyphicon glyphicon-tasks"></span> Lista de Minutas</a></h3>
                        </div>

                        <div class="form-group op-menu">
                            <a href="listarep"><h3><span class="glyphicon glyphicon-book"></span> Lista de Reportes</a></h3>
                        </div>

                        <div class="form-group op-menu">
                            <a href="listaSofi"><h3><span class="glyphicon glyphicon-file"></span> Lista de Oficios</a></h3>
                        </div>

                        <div class="form-group op-menu">
                            <a href="acuerdos"><h3><span class="glyphicon glyphicon-transfer"></span> Lista de Acuerdos</a></h3>
                        </div>
                    </div>

                    <!--- Columna panel de control -->
                    <div class="col-md-4">
                        <div class="form-group a-menu">
                            <h3> &raquo; <span class="glyphicon glyphicon-info-sign"></span> Panel de Control</a></h3>
                        </div>

                            <div class="form-group op-menu">
                                <a href="#"><h3><span class="glyphicon glyphicon-time"></span> Historial de Acciones</a></h3>
                            </div>

                            <div class="form-group op-menu">
                                <a href="#"><h3><span class="glyphicon glyphicon-stats"></span> Estadísticas</a></h3>
                            </div>   
                        </div>

                        <!--- Columna panel personal -->
                        <div class="col-md-4">
                        <div class="form-group a-menu">
                            <h3> &raquo; <span class="glyphicon glyphicon-bookmark"></span> Panel Personal</a></h3>
                        </div>

                            <div class="form-group op-menu">
                                <a href="#"><h3><span class="glyphicon glyphicon-tasks"></span> Mis Minutas</a></h3>
                            </div>

                            <div class="form-group op-menu">
                                <a href="#"><h3><span class="glyphicon glyphicon-book"></span> Mis Reportes</a></h3>
                            </div>

                            <div class="form-group op-menu">
                                <a href="#"><h3><span class="glyphicon glyphicon-transfer"></span> Mis Acuerdos</a></h3>
                            </div>

                            <div class="form-group op-menu">
                                <a href="#"><h3><span class="glyphicon glyphicon-cog"></span> Configuación </a></h3>
                            </div>
                    </div>

                </div> <!--- fin row-->
            </div>  <!--- fin container -->
            <div class="bottom-buffer"></div>
        </main>
        <?php include_once (FOOT); ?>