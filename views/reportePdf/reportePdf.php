<?php
    include_once 'helpers/DB_conection.php';

    $id= $_GET['id'];
    //$id= 3;
    /*Reportes*/
    $queryRep="SELECT rep.reporte_id, rep.reporte_titulo as titulo, DATE_FORMAT(`reporte_fecha_incidente`,'%d/%m/%Y') as fechaInc, rep.reporte_incidente as incidente, rep.reporte_caso as caso, rep.reporte_consentimiento as consentimiento, rep.reporte_etiqueta as etiqueta, rep.reporte_modelo as modelo, rep.reporte_fabricante as fabricante, rep.reporte_num_serie as numSerie, rep.reporte_descripcion as descripcion, rep.reporte_disp_final as disposicion, DATE_FORMAT(`reporte_fecha_final`,'%d/%m/%Y') as fechaFinal,
    recep.receptor_nom as receptor FROM reportes as rep
    INNER JOIN receptores as recep ON rep.reporte_persona= recep.receptor_id WHERE rep.reporte_id=$id";
    $reportes = $DB_conection->query($queryRep);
    $reporte = $reportes->fetch_assoc();

    if($reporte['consentimiento']==1){
        $consentimiento='SI';
    }
    else if ($reporte['consentimiento']==0){
        $consentimiento='NO';
    }

    /*Evidencia*/
    $queryEv ="SELECT evidencia_origen as origen, DATE_FORMAT(evidencia_fecha, '%d/%m/%Y') as fecha, evidencia_razon as razon, evidencia_destino as destino FROM evidencias WHERE evidencia_reporte=$id;";
    $evidencias = $DB_conection->query($queryEv);
    $evidencia = $evidencias->fetch_assoc();

    /*LOGO IZQ*/ 
    $queryLogIzq ="SELECT logo_url FROM logos WHERE logo_para=2 AND logo_estado=1 ORDER BY logo_para ASC;";
    $logosIzq = $DB_conection->query($queryLogIzq);
    $logoIzq = $logosIzq->fetch_assoc();

    /*LOGO DER*/ 
    $queryLogDer ="SELECT logo_url FROM logos WHERE logo_para=3 AND logo_estado=1 ORDER BY logo_para ASC;";
    $logosDer = $DB_conection->query($queryLogDer);
    $logoDer = $logosDer->fetch_assoc();

    /*Pie de PAg*/ 
    $queryPie ="SELECT logo_url, logo_para FROM logos WHERE logo_para=4 AND logo_estado=1 ORDER BY logo_para ASC;";
    $piesPag = $DB_conection->query($queryPie);
    $piePag = $piesPag->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['page_title']; ?></title>
        <!-- CSS --
        <link href="https://framework-gb.cdn.gob.mx/applications/cms/favicon.png" rel="shortcut icon">
        <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
        <link href="http://localhost/PAM/resources/css/styles.css" rel="stylesheet">
        -->
        <link href="<?php echo assets_full(); ?>img/icons/favicon.png" rel="shortcut icon">
        <link href="<?php echo frame_full(); ?>css/main.css" rel="stylesheet">
        <link href="<?php echo assets_full(); ?>css/styles.css" rel="stylesheet">

</head>
<body>       
    <main class="container">
    <table border="1" style="width:100%">
        <colgroup>
			<col style="width: 33%"/>
			<col style="width: 33%"/>
			<col style="width: 33%"/>
			
		</colgroup>
			<thead>
            </thead>
            <tbody>
				<tr>
					<td class="text-center" rowspan="2">
                        <?php 
                            $server = $_SERVER['SERVER_NAME'];
                            $urlLogoIzq= str_replace('..', $server, $logoIzq['logo_url']);?>
                        <img src="http://<?php echo $urlLogoIzq; ?>" whidth="30" height="30">
                    </td>

					<td class="text-center" colspan="2">
                        <b><?php echo strtoupper('Secretaria de Infraestructura Comunicaciones y Transportes');?><br>
                        Unidad de Administración y Finanzas</b><br>
                        Unidad de Tecnologías de Información y Comunicaciones
                    </td>

				    <td class="text-center" rowspan="2">
                        <?php 
                            $urlLogoDer= str_replace('..', $server, $logoDer['logo_url']);?>
                        <img src="http://<?php echo $urlLogoDer; ?>" whidth="50" height="90">
                    </td>
				</tr>
                
				<tr>
					<td class="text-center" colspan="2">
                        Formato de entrega de Evidencias <br>
                        Cadena de Custodia
                    </td>  
				</tr>
			</tbody>
       
        </table>
<br>

        <table class="reporte">
            <thead>
            </thead>
            <tbody>
                 <tr>
                    <td class="text-center tab-reporteEv">
                        <b>Fecha</b>
                    </td>

                    <td class="text-center tab-reporteEv">
                        <b>Tipo de Incidente</b>
                    </td>

                    <td class="text-center tab-reporteEv">
                        <b>Caso</b>
                    </td>
                </tr>
                
                <tr id="info-reporte">
                    <td class="cell-reporte text-center">
                        <b><?php echo $reporte['fechaInc'];?></b>
                    </td>

                    <td class="cell-reporte text-center">
                        <b><?php echo $reporte['incidente'];?></b>
                    </td>

                    <td class="cell-reporte text-center">
                        <b><?php  echo $reporte['caso']?></b>
                    </td>
                </tr>
                    
                <tr>
                    <td class="text-center tab-reporteEv">
                        <b>Requiere Consentimiento</b>
                    </td>

                    <td  class="text-center tab-reporteEv">
                        <b>Firma de Consentimiento</b>
                    </td>

                    <td class="text-center tab-reporteEv">
                        <b>Etiqueta</b>
                    </td>
                </tr>
                
                <tr id="info-reporte">
                    <td  class="cell-reporte text-center">
                        <b>
                            <?php
                                if($reporte['consentimiento']==1){
                                    $consentimiento='SI';
                                }
                                else if ($reporte['consentimiento']==0){
                                    $consentimiento='NO';
                                }
                                echo $consentimiento;
                            ?>
                        </b>
                    </td>

                    <td width="50" height="60" class="cell-reporte text-center">
                        <b></b>
                    </td>

                    <td class="cell-reporte text-center">
                        <b><?php echo $reporte['etiqueta'] ?></b>
                    </td>

                </tr>

                <tr>
                    <td class="text-center tab-reporteEv">
                        <b>Modelo</b>
                    </td>

                    <td class="text-center tab-reporteEv">
                        <b>Fabricante</b>
                    </td>

                    <td class="text-center tab-reporteEv">
                        <b>Número de Serie</b>
                    </td>
                </tr> 
          
                <tr id="info-reporte">
                    <td class="cell-reporte text-center">
                        <b><?php echo $reporte['modelo'];?></b>
                    </td>
                    <td class="cell-reporte text-center">
                        <b><?php echo $reporte['fabricante'];?></b>
                    </td>
                    <td class="cell-reporte text-center">
                        <b><?php echo $reporte['numSerie'];?></b>
                    </td>
                </tr>
            </tbody>
        </table> 

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center tab-reporteEv">
                        <b>Descripción</b>
                       
                    </td>
                </tr>
                <tr>
                    <td class="cell-reporte text-left">
                    &nbsp;<?php echo nl2br($reporte['descripcion']); ?>
                    </td>
                </tr> 
            </tbody>
        </table> 

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                <tr>
                  <td class="text-center tab-reporteEv">
                        <b>Persona que recibe la Evidencia </b>
                  </td> 

                  <td class="text-center tab-reporteEv">
                        <b>Firma</b>
                  </td> 
                </tr>

        
                <tr id="info-reporte">
                    <td class="cell-reporte text-center">
                        <b><?php echo $reporte['receptor']; ?></b>
                    </td>
                    <td width="50" height="60" class="cell-reporte text-center">
                        <b></b>
                    </td>
                   
                </tr>
            </tbody>
        </table>

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
            <tr>
                    <td class="text-center tab-reporteEv">
                        <b>Cadena de Custodia</b>
                       
                    </td>
                </tr>
            </tbody>
        </table>


        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
            <?php
                $printR='';
                foreach ($evidencias as $evidencia){
                    $printR.= '<tr>
                        <td class="text-center tab-reporteEv">
                            <b>Origen</b>
                        </td>
                
                        <td class="text-center tab-reporteEv">
                            <b>Fecha</b>
                        </td>
                    
                        <td class="text-center tab-reporteEv">
                            <b>Razón</b>
                        </td>
                    
                        <td class="text-center tab-reporteEv">
                            <b>Destino</b>
                        </td>
                    </tr> 

                    <tr id="info-reporte">
                        <td class="cell-reporte text-center">
                            <b>'.$evidencia["origen"].'</b>
                        </td>
                        <td class="cell-reporte text-center">
                            <b>'.$evidencia['fecha'].'</b>
                        </td>
                        <td class="cell-reporte text-center">
                            <b>'.$evidencia['razon'].'</b>
                        </td>
                        <td class="cell-reporte text-center">
                            <b>'.$evidencia['destino'].'</b>
                        </td>
                    </tr>';                                           
                }
                echo $printR;
          ?>
            </tbody>
        </table>

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                
                 <tr>
                    <td class="text-center tab-reporteEv">
                        <b>Disposicion Final de la Evidencia</b>
                    </td>

                    <td class="text-center tab-reporteEv">
                        <b>Fecha</b>
                    </td>
                </tr>

                <tr id="info-reporte">
                    <td width="50" height="40" class="cell-reporte text-center">
                        <b><?php echo $reporte['disposicion'] ?></b>
                    </td>
                    <td class="cell-reporte text-center">
                        <b><?php echo $reporte['fechaFinal'] ?></b>
                    </td>  
                </tr>
               
            </tbody>
        </table>

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                <tr>
                    <td class="separar"></td>
                </tr>
                <tr>
                    <?php 
                        $urlPiePag= str_replace('..', $server, $piePag['logo_url']);?>
                    <td class="col-md-12" style="background: transparent url('<?php echo 'http://'.$urlPiePag; ?>')">
                        &nbsp;
                    </td>
                </tr>
            </tbody>
        </table>

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                <tr>
                    <td class="separar"></td>
                </tr>
                 <tr>
                    <td class="text-left pie-pag">
                        Avenida de los Insurgentes Sur 1089, Colonia Noche Buena, C. P. 03720<br/>
                        Alcadía Benito Juárez, CDMX
                    </td>

                    <td class="text-right pie-pag">
                        Tel: 01(55)5723 9300<br/>
                        www.gob.mx/sct
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
        
</body>
</html>