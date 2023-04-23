
        
        <?php include_once (CAB); ?>
        <div>
            <div class="col-md-12 banner top-buffer">
                <div class="container">
                    <i><label for="user" class="f-user">
                        <span class="glyphicon glyphicon-picture"></span>
                        <?php echo $data['page_name']; ?>
                    </label></i>
                </div>      
            </div>
        </div>

        <main class="container ">
            <form id="formLogo" name="formLogo" autocomplete="off">
            <div class="row ">
                <div class="col-md-12">
                    <div class="form-group">
                        <h4><span class="glyphicon glyphicon-cog"></span> Seleccionar logo</h4>                       
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group op-menu">
                                <a data-toggle="modal" data-target="#logoMinuta" role="button" class="btn btn-default active"><span class="glyphicon glyphicon-tasks"></span> Logos para Minuta</a>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group op-menu">
                                <a data-toggle="modal" data-target="#logoReporte" role="button" class="btn btn-default active"><span class="glyphicon glyphicon-book"></span> Logos para Reportes</a>
                            </div>
                        </div>
                    </div
                    <!--- Columna panel de creación -->
                    <div class="form-group">
                        <h4><span class="glyphicon glyphicon-upload"></span> Subir nuevo logo</h4>                       
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group op-menu">
                                <label for="calendar" class="control-label">Nombre del logo
                                    <span class="asteriscoData form-text">*</span>
                                </label>
                                <input type="text" id="nombreLogo" class="form-control" name="nombreLogo">
                                <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                    Este campo es obligatorio
                                </small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group op-menu">
                                <label for="calendar" class="control-label">Año de uso
                                    <span class="asteriscoData form-text">*</span>
                                </label>
                                <select id="anho" class="form-control" name="anho">
                                    <option value="" selected disabled hidden>Selecciona Año</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                </select>
                                <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                    Este campo es obligatorio
                                </small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group op-menu">
                                <label for="calendar" class="control-label">Logo para
                                    <span class="asteriscoData form-text">*</span>
                                </label>
                                <select id="usoPara" class="form-control" name="usoPara">
                                    <option value="" selected disabled hidden>Selecciona Uso</option>
                                    <option value="1">Minuta</option>
                                    <option value="2">Reporte lado Izq.</option>
                                    <option value="2">Reporte lado Der.</option>
                                    <option value="3">Pie de Página</option>
                                </select>
                                <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                    Este campo es obligatorio
                                </small>
                            </div>
                        </div>

                    </div><!-- end row-->

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group op-menu">
                                <label for="calendar" class="control-label">Subir archivo
                                    <span class="asteriscoData form-text">*</span>
                                </label>
                                <input id="logo" type="file" class="form-control" name="logo">
                                <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                    Este campo es obligatorio
                                </small>
                            </div>
                        </div> 
                                                 
                    </div><!-- end row-->
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group op-menu">
                                <label for="calendar" class="control-label">Vista Previa
                                </label>
                                <output id="preview"></output>
                            </div>
                        </div> 
                                                 
                    </div><!-- end row-->
                </div> <!--- fin md-12-->

            </div><!-- end row principal-->
            <!--div guardar minuta-->
            <div class="col-md-12 top-buffer text-center">
                <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-cloud-upload"></span> Subir Logo</button>
            </div>
        </form>   
        </main><!--end Main Container-->
        <div class="bottom-buffer"></div>
        <?php 
            getModal('logoMinuta', $data);
            getModal('logoReporte', $data);
 
        ?>

    <?php include_once (FOOT); ?>