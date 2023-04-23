
        <?php include_once (CAB); ?>
        <div>
            <div class="col-md-12 banner top-buffer">
                <div class="container">
                    <i><label for="user" class="f-user">
                        <span class="glyphicon glyphicon-file"></span>
                        <?php echo $data['page_name']; ?>
                    </label></i>
                </div>      
            </div>
        </div>

        <main class="container ">
            <form id="formSOFI" name="new-documento" autocomplete="off">
            <div class="row ">
                <div class="col-md-12">               
                    <!--- Columna panel de creación -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <h4><span class="icon-infocircle" aria-hidden="true"></span> Información del oficio</h4>                       
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group op-menu">
                                <div id="divId"><!-- Aqui se carga el id del ultimo oficio reg!--></div>
                                    <a data-toggle="modal" data-target="#SofiDestinatario" title="AGREGAR DESTINATARIO" role="button" class="btn-link bAddDestinatario" ><span class="glyphicon glyphicon-plus"></span> Agregar Destinatario</a>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group op-menu">
                                    <a data-toggle="modal" data-target="#SofiRemitente" title="AGREGAR REMITENTE" role="button" class="btn-link bAddRemitente" ><span class="glyphicon glyphicon-plus"></span> Agregar Remitente</a>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group op-menu">
                                    <a data-toggle="modal" data-target="#SofiCargo" title="AGREGAR CARGO" role="button" class="btn-link bAddCargo" ><span class="glyphicon glyphicon-plus"></span> Agregar Cargo</a>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group op-menu">
                                    <a data-toggle="modal" data-target="#SofiEmpresa" title="AGREGAR EMPRESA" role="button" class="btn-link bAddEmpresa" ><span class="glyphicon glyphicon-plus"></span> Agregar Empresa</a>
                                </div>
                            </div>


                        </div><!-- end row-->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="destinatario" class="control-label">Nombre Destinatario
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="destinatario" type="text" class="form-control" name="destinatario" placeholder="Buscar...">
                                    <!--En este div de muestran las destinatarios de la tabla receptores en tiempo real-->
                                    <div id="suggestions"></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="cargoDest" class="control-label">Cargo Destinatario
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="cargoDest" type="text" class="form-control" name="cargoDest" placeholder="Buscar...">
                                    <!--En este div de muestran las destinatarios de la tabla receptores en tiempo real-->
                                    <div id="suggestionsCD"></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="empresaDest" class="control-label">Empresa/Unidad Destinatario
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input type="text" class="form-control"name="empDest" id="empDest" placeholder="Buscar...">
                                    <!--En este div de muestran los destinatarios de la tabla destinatrios- en tiempo real-->
                                    <div id="suggestionsED"></div>
                                </div>
                            </div>

                        </div><!-- end row-->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="remitente" class="control-label">Nombre Remitente
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="remitente" type="text" class="form-control" name="remitente" placeholder="Buscar...">
                                    <!--En este div de muestran las destinatarios de la tabla receptores en tiempo real-->
                                    <div id="suggestionsR"></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="cargoRem" class="control-label">Cargo Remitente
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input type="text" class="form-control"name="cargoRem" id="cargoRem" placeholder="Buscar...">
                                    <!--En este div de muestran los destinatarios de la tabla destinatrios- en tiempo real-->
                                    <div id="suggestionsCR"></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="empresaRem" class="control-label">Empresa/Unidad Remitente
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input type="text" class="form-control"name="empRem" id="empRem" placeholder="Buscar...">
                                    <!--En este div de muestran los destinatarios de la tabla destinatrios- en tiempo real-->
                                    <div id="suggestionsER"></div>
                                </div>
                            </div>

                        </div><!-- end row-->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                <label for="calendar" class="control-label">Fecha de Elaboración:
                                    <span class="asteriscoData form-text">*</span>
                                </label>
                                <input id="fechaElaborado" type="date" class="form-control" name="fechaElaboracion">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                
                                    <label for="calendar" class="control-label">Fecha de Recepción
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="fechaRecibidoSICT" type="date" class="form-control" name="fechaRecepcion">
                                </div>
                            </div>

                            <div class="col-md-4">
                            <label for="asunto" class="control-label">Asunto
                                <span class="asteriscoData form-text">*</span>
                            </label>
                            <input type="text" id="asunto" palceholder="asunto" class="form-control" name="asunto">
                            </div>

                        </div><!-- end row-->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group op-menu">
                                    <label for="archivo" class="control-label">Subir archivo
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                 
                                    <input  type="file" class="form-control" name="archivoOficio[]" multiple>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <label for="asunto" class="control-label">Número de oficio
                                <span class="asteriscoData form-text">*</span>
                            </label>
                            <input type="text" id="numero" palceholder="asunto" class="form-control" name="numero">
                            </div>

                        </div><!-- end row-->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group op-menu">
                                    <label for="descripcion" class="control-label">Observación
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <textarea id="descripcion" class="form-control" rows="3"name="descripcion" Value=""></textarea>
                                </div>
                            </div>                           

                        </div><!-- end row-->
                    </div><!--fin md-8-->
                </div> <!--- fin md-12-->

            </div><!-- end row principal-->
            <!--div guardar minuta-->
            <div class="col-md-12 top-buffer text-center">
                <button class="btn btn-primary active" type="submit"><span class="glyphicon glyphicon-cloud-upload"></span> Registrar Oficio</button>
            </div>
        </form>   
        </main><!--end Main Container-->
        <div class="bottom-buffer"></div>
      <!-- SECCIÓN DE VENTANAS MODALES-->
  <?php 
      getModal('SofiDestinatario', $data); 
      getModal('SofiRemitente', $data); 
      getModal('SofiCargo', $data); 
      getModal('SofiEmpresa', $data); 
?>  
    <?php include_once (FOOT); ?>