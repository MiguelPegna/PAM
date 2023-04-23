
        <?php 
            $idReporte= intval(strClean($_GET['id']));
            include_once (CAB); 
        ?>
        <div>
            <div class="col-md-12 banner top-buffer">
                <div class="container">
                    <i><label for="user" class="f-user">
                        <span class="glyphicon glyphicon-book"></span>
                        <?php echo $data['page_name']; ?>
                    </label></i>
                </div>      
            </div>
        </div>

        <main class="container ">
            <form id="formReporte" name="new-reporte" autocomplete="off">
                <input type="hidden" id="idReporte" name="idReporte" value="<?php echo $idReporte ?>">
            <div class="row ">
                <div class="col-md-12">               
                    <!--- Columna panel de creación -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <h4><span class="icon-infocircle" aria-hidden="true"></span> Información del reporte</h4>                       
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group op-menu">
                                    <label for="titulo" class="control-label">Titulo
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="titulo" type="text" class="form-control" name="titulo" value="<?php echo $arrData['titulo']; ?>">
                                    <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                        Este campo es obligatorio
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group op-menu">
                                    <label for="calendar" class="control-label">Fecha
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="fechaInc" type="date" class="form-control" name="fechaInc">
                                    <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                        Este campo es obligatorio
                                    </small>
                                </div>
                            </div>


                        </div><!-- end row-->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="calendar" class="control-label">Tipo de Incidente
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="incidente" type="text" class="form-control" name="incidente">
                                    <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                        Este campo es obligatorio
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="calendar" class="control-label">Caso
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="caso" type="text" class="form-control" name="caso">
                                    <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                        Este campo es obligatorio
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="calendar" class="control-label">Requiere consentimiento
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <select id="consentimiento" name="consentimiento" class="form-control">
                                        <option value="1">SI</option>
                                        <option value="0">NO</option>
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
                                    <label for="etiqueta" class="control-label">Etiqueta
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="etiqueta" type="text" class="form-control" name="etiqueta">
                                    <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                        Este campo es obligatorio
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="modelo" class="control-label">Modelo
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="modelo" type="text" class="form-control" name="modelo">
                                    <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                        Este campo es obligatorio
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="fabricante" class="control-label">Fabricante
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="fabricante" type="text" class="form-control" name="fabricante">
                                    <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                        Este campo es obligatorio
                                    </small>
                                </div>
                            </div>

                        </div><!-- end row-->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="numSerie" class="control-label">Número de serie
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="numSerie" type="text" class="form-control" name="numSerie">
                                    <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                        Este campo es obligatorio
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group op-menu">
                                    <label for="persona" class="control-label">Persona que recibe la evidencia
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <input id="persona" type="text" class="form-control" name="persona" placeholder="Buscar...">
                                    <!--En este div de muestran las personas de la tabla receptores en tiempo real-->
                                    <div id="suggestions"><input type="hidden" id="idRecep" name="idRecep" rl="Jijiji"></div>
                                    <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                        Este campo es obligatorio
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group op-menu acomodo">
                                    <a data-toggle="modal" data-target="#newPersona" title="AGREGAR PERSONA" role="button" class="btn-link bAddInvitado" ><span class="glyphicon glyphicon-plus"></span> Agregar Nueva Persona</a>
                                </div>
                                <div id="divId"></div>
                            </div>

                        </div><!-- end row-->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group op-menu">
                                    <label for="descripcion" class="control-label">Descripción
                                        <span class="asteriscoData form-text">*</span>
                                    </label>
                                    <textarea id="descripcion" class="form-control" rows="3"name="descripcion" Value=""></textarea>
                                </div>
                            </div>                           

                        </div><!-- end row-->
                    </div><!--fin md-8-->
                </div> <!--- fin md-12-->

                <!--div control de las cadenas de evidencia-->
                <div class="col-md-12">
                    <h4><span class="glyphicon glyphicon-link"></span> Cadena de Custodia</h4> 
                    <!--div control de los evidencias-->
                    <div class="col-md-12 espacio1">
                        <a title="AGREGAR CADENA" id="agregar" onClick="addRow('cadenasTable')" class="cursor"><span class="glyphicon glyphicon-plus"></span> Agregar Nueva Cadena de Custodia</a>
                    </div>
                            
                    <!--divs evidencias-->
                     <table id="cadenasTable" >
		                <thead>
		                    <tr>
		                    	<th><div class="text-center"><span class="glyphicon glyphicon-remove text-danger cursor" title="REMOVER CADENA SELECCIONADA" onClick="deleteRow('cadenasTable')"></span></div></th>
		                    	<th class="col-md-3">
		                    		<label for="origen" class="control-label">Origen
                                      <span class="asteriscoData form-text">*</span>
                                	</label>
		                    	</th>
		                    	<th class="col-md-3">
		                    		<label for="fechaCad" class="control-label">Fecha
                                      <span class="asteriscoData form-text">*</span>
                                	</label>
		                    	</th>
		                    	<th class="col-md-3">
		                    		<label for="razon" class="control-label">Razón
                                      <span class="asteriscoData form-text">*</span>
                                	</label>
		                    	</th>
		                    	<th class="col-md-3">
		                    		<label for="destino" class="control-label">Destino
                                		<span class="asteriscoData form-text">*</span>
                                	</label>
		                    	</th>
 		                    </tr>
		                </thead>
		                <tbody id="td-content">
                            
 	                    </tbody>
                    </table>

                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group op-menu">
                            <label for="calendar" class="control-label">Disposición Final de la evidencia
                                <span class="asteriscoData form-text">*</span>
                            </label>
                            <input id="disposicion" type="text" class="form-control" name="disposicion">
                            <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                Este campo es obligatorio
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group op-menu">
                            <label for="calendar" class="control-label">Fecha
                                <span class="asteriscoData form-text">*</span>
                            </label>
                            <input id="fechaFinal" type="date" class="form-control" name="fechaFinal">
                            <small class="smallDatos form-text form-text-error hide" aria-live="polite">
                                Este campo es obligatorio
                            </small>
                        </div>
                    </div>           
                </div><!-- end row-->


                </div><!--div acuerdos-->

            </div><!-- end row principal-->
            <!--div guardar minuta-->
            <div class="col-md-12 top-buffer text-center">
                <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Actualizar Reporte</button>
            </div>
        </form>   
        </main><!--end Main Container-->
        <div class="bottom-buffer"></div>
      <!-- SECCIÓN DE VENTANAS MODALES-->
  <?php 
      getModal('newPersona', $data); 
      //getModal('rolPermisos', $data); 
?>  
    <?php include_once (FOOT); ?>