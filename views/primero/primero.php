
        <?php include_once (CAB); ?>
        <div>
            <div class="col-md-12 banner bottom-buffer">
                <div class="container">
                    <i><label for="user" class="f-user">
                        <span class="glyphicon glyphicon-list-alt"></span>
                        <?php echo $data['page_name']; ?>
                    </label></i>
                </div>      
            </div>
        </div>

        <main class="container">
            <form id="formRegistro" name="new-registro" autocomplete="off">
                <div class="row top-buffer bottom-buffer">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre" class="control-label">Nombre</label>
                            <span class="asteriscoData form-text">*</span>
                            <input id="nombre" type="text" class="form-control input-format" name="nom">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ap_p" class="control-label">Apellido Paterno</label>
                            <span class="asteriscoData form-text">*</span>
                            <input id="apP" type="text" class="form-control input-format" name="ape_p">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ap_m" class="control-label">Apellido Materno</label>
                            <span class="asteriscoData form-text">*</span>
                            <input id="apM" type="text" class="form-control input-format" name="ape_m">
                        </div>
                    </div>
                </div>

                <div class="row top-buffer bottom-buffer">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="unidad" class="control-label">Unidad</label>
                            <span class="asteriscoData form-text">*</span>
                            <select id="unidadS" data-live-search="true" class="form-control input-format" name="unidad">
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cargo" class="control-label">Cargo</label>
                            <span class="asteriscoData form-text">*</span>
                            <select id="cargoS" data-live-search="true" class="form-control input-format" name="cargo">
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="rol" class="control-label">Rol</label>
                            <span class="asteriscoData form-text">*</span>
                            <select id="rolS" class="form-control input-format selectpicker" name="rol">
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="titulo" class="control-label">Titulo</label>
                            <span class="asteriscoData form-text">*</span>
                            <select id="tituloS" class="form-control input-format selectpicker" name="titulo">
                                
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row top-buffer bottom-buffer">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email" class="control-label">Correo Electronico</label>
                            <span class="asteriscoData form-text">*</span>
                            <input id="email" type="text" class="form-control input-format" name="email" placeholder="@">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ap_p" class="control-label">Contraseña</label>
                            <span class="asteriscoData form-text">*</span>
                            <span class="glyphicon glyphicon-eye-open pull-right"></span>
                            <input id="pass01" type="password" class="form-control input-format" name="pass1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ap_m" class="control-label">Repetir Contraseña</label>
                            <span class="asteriscoData form-text">*</span>
                            <span class="glyphicon glyphicon-eye-open eye pull-right"></span>
                            <input id="pass02" type="password" class="form-control input-format" name="pass2">
                        </div>
                    </div>
                </div>

                <div class="row top-buffer bottom-buffer">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Registrar Usuario</button>

                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        </div>
                    </div>
                </div>
            
        </main>
    <?php include_once (FOOT); ?>