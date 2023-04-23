<?php
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
//require_once 'dompdf/autoload.inc.php';
function base_url() {
	$base_url='http://localhost/PAM/';
	//$base_url='http://10.33.142.92';
	return $base_url;
}

require 'vendor/autoload.php';
include_once 'DB_conection.php';
	//recibimos el id del reporte
    $id= $_GET['idRep'];
    //$id= 1;
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

    /*LOGO IZQ*/ 
    $queryLogIzq ="SELECT logo_url FROM logos WHERE logo_para=2 AND logo_estado=1 ORDER BY logo_para ASC;";
    $logosIzq = $DB_conection->query($queryLogIzq);
    $logoIzq = $logosIzq->fetch_assoc();

    $server = $_SERVER['SERVER_NAME'];
    $urlLogoIzq= str_replace('..', $server, $logoIzq['logo_url']);

    /*LOGO DER*/ 
    $queryLogDer ="SELECT logo_url FROM logos WHERE logo_para=3 AND logo_estado=1 ORDER BY logo_para ASC;";
    $logosDer = $DB_conection->query($queryLogDer);
    $logoDer = $logosDer->fetch_assoc();
    $urlLogoDer= str_replace('..', $server, $logoDer['logo_url']);

    /*Pie de PAg*/ 
    $queryPie ="SELECT logo_url, logo_para FROM logos WHERE logo_para=4 AND logo_estado=1 ORDER BY logo_para ASC;";
    $piesPag = $DB_conection->query($queryPie);
    $piePag = $piesPag->fetch_assoc();

    $urlPiePag= str_replace('..', $server, $piePag['logo_url']);

    /*Evidencias*/
    $queryEv ="SELECT evidencia_origen as origen, DATE_FORMAT(evidencia_fecha, '%d/%m/%Y') as fecha, evidencia_razon as razon, evidencia_destino as destino FROM evidencias WHERE evidencia_reporte=$id;";
    $evidencias = $DB_conection->query($queryEv);
    $evidencia = $evidencias->fetch_assoc();

    $totalEvidencias='';
    foreach ($evidencias as $evidencia){
        $totalEvidencias.= '<tr>
            <td class="text-center tab-reporteEv mb">
                <b>Origen</b>
            </td>
    
            <td class="text-center tab-reporteEv mb">
                <b>Fecha</b>
            </td>
        
            <td class="text-center tab-reporteEv mb">
                <b>Razón</b>
            </td>
        
            <td class="text-center tab-reporteEv mb">
                <b>Destino</b>
            </td>
        </tr> 
        <tr id="info-reporte">
            <td class="cell-reporte text-center mb">
                '.$evidencia["origen"].'
            </td>
            <td class="cell-reporte text-center mb">
                '.$evidencia['fecha'].'
            </td>
            <td class="cell-reporte text-center mb">
                '.$evidencia['razon'].'
            </td>
            <td class="cell-reporte text-center mb">
                '.$evidencia['destino'].'
            </td>
        </tr>';                                           
    }

    use Dompdf\Dompdf;
	use Dompdf\Options;
    $rootFrame= 'http://'.$_SERVER['SERVER_NAME'].'/PAM/frame/css/main.css';
    $rootStyle= 'http://'.$_SERVER['SERVER_NAME'].'/PAM/resources/css/styles.css';
    $html ='HTML
    <!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="'.$rootFrame.'" rel="stylesheet">
    <link href="'.$rootStyle.'" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />
    <style>
    @page {
        margin: 2px 30px;
    }
    header {
        position: fixed;
        top: 10px;
        left: 0px;
        right: 0px;
        color: white;
        text-align: center;
    }

    footer {
        position: fixed; 
        bottom: 80px; 
        left: 0px; 
        right: 0px;
        height: 50px;

    }

    .m {
        font-family: "Montserrat, sans-serif";
        font-weight: normal;
        font-size: 13px;
    }

    .mb {
        font-family: "Montserrat, sans-serif";
        font-weight: 700;
        font-size: 13px;
    }
    .pp-ground{
        background: transparent url(\'http://'.$urlPiePag.'\');
    }
    .mpp {
        font-family: "Montserrat, sans-serif";
        font-weight: normal;
        font-size: 13px;
    }
    .sp{
        margin-bottom: 0px;
        padding-bottom: 0px;
    }
    .tdp1{
        width: 80%;
    }
    .tdp2{
        width: 20%;
    }


    </style>
    </head>
    <body>
    
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
                    <img src="http://'.$urlLogoIzq.'" whidth="30" height="30">
                </td>

				<td class="text-center mb" colspan="2">
                    SECRETARÍA DE INFRAESTRUCTURA COMUNICACIONES Y TRANSPORTES<br>
                    Unidad de Administración y Finanzas<br>
                    Unidad de Tecnologías de Información y Comunicaciones
                </td>
				<td class="text-center mb" rowspan="2">
                    <img src="http://'.$urlLogoDer.'" whidth="50" height="80">
                </td>
			</tr>
                
			<tr>
				<td class="text-center m" colspan="2">
                    Formato de entrega de Evidencias <br>
                    Cadena de Custodia
                </td>  
			</tr>
		</tbody>
        </table><br>

        <table class="reporte">
            <thead>
            </thead>
            <tbody>
                 <tr>
                    <td class="text-center tab-reporteEv mb">
                        Fecha
                    </td>

                    <td class="text-center tab-reporteEv mb">
                        Tipo de Incidente
                    </td>

                    <td class="text-center tab-reporteEv mb">
                        Caso
                    </td>
                </tr>
                
                <tr id="info-reporte">
                    <td class="cell-reporte text-center mb">
                        '.$reporte['fechaInc'].'
                    </td>

                    <td class="cell-reporte text-center mb">
                        '.$reporte['incidente'].'
                    </td>

                    <td class="cell-reporte text-center mb">
                        '.$reporte['caso'].'
                    </td>
                </tr>
                    
                <tr>
                    <td class="text-center tab-reporteEv mb">
                        Requiere Consentimiento
                    </td>

                    <td  class="text-center tab-reporteEv mb">
                        Firma de Consentimiento
                    </td>

                    <td class="text-center tab-reporteEv mb">
                        Etiqueta
                    </td>
                </tr>
                
                <tr id="info-reporte">
                    <td  class="cell-reporte text-center mb">
                    '.$consentimiento.'
                    </td>

                    <td width="50" height="40" class="cell-reporte text-center">
                        
                    </td>

                    <td class="cell-reporte text-center mb">
                        '.$reporte['etiqueta'].'
                    </td>

                </tr>

                <tr>
                    <td class="text-center tab-reporteEv mb">
                        Modelo
                    </td>

                    <td class="text-center tab-reporteEv mb">
                        Fabricante
                    </td>

                    <td class="text-center tab-reporteEv mb">
                        Número de Serie
                    </td>
                </tr> 
          
                <tr id="info-reporte">
                    <td class="cell-reporte text-center mb">
                        '.$reporte['modelo'].'
                    </td>
                    <td class="cell-reporte text-center mb">
                        '.$reporte['fabricante'].'
                    </td>
                    <td class="cell-reporte text-center mb">
                        '.$reporte['numSerie'].'
                    </td>
                </tr>
            </tbody>
        </table> 

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center tab-reporteEv mb">
                        Descripción
                       
                    </td>
                </tr>
                <tr>
                    <td class="cell-reporte text-left m">
                    &nbsp;'.nl2br($reporte['descripcion']).'
                    </td>
                </tr> 
            </tbody>
        </table> 

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                <tr>
                  <td class="text-center tab-reporteEv mb">
                        Persona que recibe la Evidencia 
                  </td> 

                  <td class="text-center tab-reporteEv mb">
                        Firma
                  </td> 
                </tr>

        
                <tr id="info-reporte">
                    <td class="cell-reporte text-center mb">
                        '.$reporte['receptor'].'
                    </td>
                    <td width="50" height="40" class="cell-reporte text-center">
                        
                    </td>
                   
                </tr>
            </tbody>
        </table>

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
            <tr>
                    <td class="text-center tab-reporteEv mb">
                        Cadena de Custodia
                       
                    </td>
                </tr>
            </tbody>
        </table>


        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                '.$totalEvidencias.'
            </tbody>
        </table>

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                
                 <tr>
                    <td class="text-center tab-reporteEv mb">
                        Disposicion Final de la Evidencia
                    </td>

                    <td class="text-center tab-reporteEv mb">
                        Fecha
                    </td>
                </tr>

                <tr id="info-reporte">
                    <td width="50" height="25" class="cell-reporte text-center mb">
                        '.$reporte['disposicion'].'
                    </td>
                    <td class="cell-reporte text-center mb">
                        '.$reporte['fechaFinal'].'
                    </td>  
                </tr>
               
            </tbody>
        </table>

        <footer>
        <table class="reporte">
            <thead>
            </thead>
            <tbody>
                <tr>
                    <td class="separar"></td>
                </tr>
                 <tr>
                    <td class="col-md-12 pp-ground">
                        &nbsp;
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="reporte">
            <thead>
            </thead>
            <tbody>
                
                 <tr>
                    
                    <td class="text-left pie-pag mpp tdp1">
                        Avenida de los Insurgentes Sur 1089, Colonia Noche Buena, C. P. 03720<br/>
                        Alcadía Benito Juárez, CDMX
                    </td>

                    <td class="text-right pie-pag mpp tdp2">
                        Tel: 01(55)5723 9300<br/>
                        www.gob.mx/sct
                    </td>
                </tr>
            </tbody>
        </table>
        </footer>
        
    </body>
    </html>
    ';
//direccion de la pagina donde estara el template del pdf
//$html=file_get_contents_curl(base_url()."reportePdf?id=".$idRep);

$temp = sys_get_temp_dir();
$dompdf = new Dompdf([
	'logOutputFile' => '',
	'isRemoteEnable' => true,
	'fontDir' =>$temp,
	'fontCache' =>$temp,
	'tempDir' =>$temp,
	'chroot' =>$temp,
]);
$options = $dompdf->getOptions();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Courier');
$dompdf->setOptions($options);
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('letter');
//$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$tmp = sys_get_temp_dir();

    $dompdf = new Dompdf([
        'logOutputFile' => '',
        // authorize DomPdf to download fonts and other Internet assets
        'isRemoteEnabled' => true,
        // all directories must exist and not end with /
        'fontDir' => $tmp,
        'fontCache' => $tmp,
        'tempDir' => $tmp,
        'chroot' => $tmp,
    ]);

    $dompdf->loadHtml($html); //load an html

    $dompdf->render();

    $dompdf->stream('reporte.pdf', [
        'compress' => true,
        'Attachment' => true,
    ]);