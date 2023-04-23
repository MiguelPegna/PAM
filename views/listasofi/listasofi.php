<?php include_once (CAB); ?>
<!-- div que recibe el contenido de la peticon-->
        <div>
            <div class="col-md-12 banner">
                <div class="container">
                    <i><label for="user" class="f-user">
                        <span class="glyphicon glyphicon-file"></span>
                        <?php echo $data['page_name']; ?>
                    </label></i>
                </div>      
            </div>
        </div>
        
        <main class="container top-buffer">
            <div class="row top-buffer ">
                <div class="col-md-2 espacio1">
                  <a href="sofi" title="SUBIR NUEVO OFICIO"  class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span> Subir Oficio</a>
                </div>
                <div class="col-md-2 espacio1">
                  <a href="<?php base_url();?>libraries/phpExcel/libro.php" title="DESCARGAR EXCEL"  class="btn btn-default"><img src="<?php assets();?>resources/img/icons/xlsx.png" width="25" heigth="25"> Descargar Excel</a>
                </div>
                <div class="col-md-2 espacio1">
                  <a href="resources/oficios.php" title="DESCARGAR OFICIOS"  class="btn btn-default"><span class="glyphicon glyphicon-download"></span> Descargar Oficios</a>
                </div>

                <!--Codigo tabla de roles-->

                  <table class="table table-responsive display" id="table-oficios">
	                <thead>
	                  	<tr>
	                  		<th class="col-md-2">Num. Oficio</th>
	                  		<th class="col-md-2">Fecha Elab.</th>
	                  		<th class="col-md-2">Asunto</th>
	                  		<th class="col-md-2">Destinatario</th>
	                  		<th class="col-md-2">Unidad o Empresa</th>
                            <th class="col-md-2">Oficios</th>
	                  	</tr>
	                </thead>
                    <?php
                        //esta no era la mejor manera de hacerlo de acuerdo a la metodologia de desarrollo MVC pero fue las mas funcional y compatible
                        //para el correcto funcionamnto del dataTables
                        include_once 'helpers/DB_conection.php';
                        #consulta multitabla con inner join para mostrar los oficios subidos
                        $query4= "SELECT o.ofi_numero as numOficio, DATE_FORMAT(o.ofi_fechaE,'%d/%m/%Y') as fechaElab, o.ofi_asunto as asunto, 
                        ed.ente_nom as destinatario, ee.ente_nom as empresaD, o.ofi_url as urlOfi
                        FROM oficios as o 
                        INNER JOIN entes as ed ON o.ofi_destinatario = ed.ente_id
                        INNER JOIN entes as ee ON o.ofi_unidadDest = ee.ente_id;";
                        $oficios = $DB_conection->query($query4);
                        //echo "se abre la conexióna la BD";   
                        if($oficios->num_rows > 0){
                            while($oficio =$oficios->fetch_assoc()){
                    ?>  
                        <tr> 
                            <td><?php echo $oficio['numOficio'];?></td>
                            <td>
                                <?php echo $oficio['fechaElab']; ?>     
                            </td>
                            <td>
                                <?php echo $oficio['asunto']; ?> </p>
                            </td>
                            <td><?php echo ucwords(strtolower($oficio['destinatario']));?></td>
                            <td><?php echo ucwords(strtolower($oficio['empresaD']));?></td>
                            <td>
                                <?php
                                    $mUrl = substr($oficio['urlOfi'], 1);
                                    $arrUrl = explode(',', $mUrl);
                                    foreach ($arrUrl as $anexoFile){
                                        $ext= pathinfo($anexoFile, PATHINFO_EXTENSION);
                                ?>
                                    <a href="<?php echo $anexoFile; ?>"  target="_blank"><img src="../PAM/resources/img/icons/<?php echo $ext.'.png';?>" width="40" height="40"></a><br/>
                                <?php } ?>
                            </td> 
           
                        </tr>
                        <?php 
                        }
                        } else{
	                    	//echo "No se encontraron resultados";
	                    }
                        ?>

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