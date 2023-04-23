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
//recibimos el id de la minuta
$id= $_GET['idMin'];
/*MINUTAS*/
$queryMin="SELECT m.minuta_id, m.minuta_titulo as titulo, m.minuta_desarrollo as desarrollo, m.minuta_lugar as lugar, DATE_FORMAT(`minuta_fecha`,'%d/%m/%Y') as fecha , m.minuta_hora as hora, m.minuta_hora_cierre as hora_cierre, m.minuta_participantes as participantes,
c.cargo_nom as unidad FROM minutas as m
INNER JOIN cargos as c ON m.minuta_unidad_admin= c.cargo_id WHERE m.minuta_id=$id";
$minutas = $DB_conection->query($queryMin);
$minuta = $minutas->fetch_assoc();

/*Acuerdos*/
$queryAc ="SELECT a.acuerdo_id, a.acuerdo_titulo as titulo, DATE_FORMAT(a.acuerdo_fecha_entrega, '%d/%m/%Y') as fecha,
p.participante_nom as nombre FROM acuerdos as a 
INNER JOIN participantes as p ON a.acuerdo_responsable= p.participante_id
WHERE acuerdo_minuta=$id;";

$acuerdos = $DB_conection->query($queryAc);

/*LOGOS*/ 
$queryLog ="SELECT logo_url, logo_para FROM logos WHERE logo_para=1 AND logo_estado=1 ORDER BY logo_para ASC;";
$logos = $DB_conection->query($queryLog);
$logo = $logos->fetch_assoc();

/*Pie de PAg*/ 
$queryPie ="SELECT logo_url, logo_para FROM logos WHERE logo_para=4 AND logo_estado=1 ORDER BY logo_para ASC;";
$piesPag = $DB_conection->query($queryPie);
$piePag = $piesPag->fetch_assoc();

$server = $_SERVER['SERVER_NAME'];
$urlLogo= str_replace('..', $server, $logo['logo_url']);

$totalAcuerdos='';
foreach ($acuerdos as $acuerdo){
	$totalAcuerdos.='
	<tr id="info-acuerdos">

		<td class="cell-reporte text-left mb">
			&nbsp;'.$acuerdo['titulo'].'
		</td>
		<td class="cell-reporte text-center mb">
			&nbsp;'.$acuerdo['nombre'].'
		</td>
		<td class="cell-reporte text-center mb">
			&nbsp;'.$acuerdo['fecha'].'
		</td>
	</tr>'; 
} 

$arrPart = explode(',', $minuta['participantes']);
$printR='';
foreach ($arrPart as $participante){
	$serv='query'.$participante;
	$serv="SELECT p.participante_nom as nombre, c.cargo_nom as cargo, t.titulo_abr as titulo
	FROM participantes as p
	INNER JOIN titulos as t ON p.participante_titulo = titulo_id
	INNER JOIN cargos as c ON p.participante_cargo= cargo_id
	WHERE participante_id=$participante";
	$info = $DB_conection->query($serv);
	$user = $info->fetch_assoc();
	$printR.= '
		<tr>
			<td class="cell-reporte text-left">
				<span class="mb sp">&nbsp;'. $user['titulo']. ' '.  $user['nombre']. '</span><br/>
				<span class="m sp">&nbsp;'.$user['cargo'].
			'</span></td>
		</tr>';
}

$urlPiePag= str_replace('..', $server, $piePag['logo_url']);


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
        margin: 5px 30px;
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
    .info{
        position: relative;
        top: 70px;
        margin-bottom: 75px;
        text-align: center;
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
        marging: 0px;
        padding: 0px;
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
    <header>
        <table>
            <thead>
            </thead>
            <tbody>
                <tr>
                    <td class="logo">
                        <img src="http://'.$urlLogo.'">
                    </td>
                </tr>
            </tbody>
        </table>
        </header>

        <table class="reporte info">
            <thead>
            </thead>
            <tbody>
                
                <tr>
                    <td class="text-center mb">
                        Unidad de Administración y Finanzas
                    </td>
                </tr>

                <tr>
                    <td class="text-center mb">
                        <b>Unidad de Tecnologías de Información y Comunicaciones</b>
                    </td>
                </tr>

                <tr>
                    <td class="text-center mb">
                        <b>'.$minuta['unidad'].'</b>
                    </td>
                </tr>

                <tr>
                    <td class="separar">
                    </td>
                </tr>

                <tr>
                    <td class="text-center mb">
                        <b>'.$minuta['titulo'].'</b>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="reporte">
            <thead>
            </thead>
            <tbody>
                 <tr>
                    <td class="text-center tab-reporte mb">
                        &nbsp;Fecha
                    </td>

                    <td class="text-center tab-reporte mb">
                        &nbsp;Hora apertura / Hora cierre
                    </td>

                    <td class="text-center tab-reporte mb">
                        &nbsp;Lugar
                    </td>
                </tr>
        
                <tr id="info-minuta">
                    <td class="cell-reporte text-center mb">
                        &nbsp;'.$minuta['fecha'].'
                    </td>
                    <td class="cell-reporte text-center mb">
                        &nbsp;'.$minuta['hora'].' / '.$minuta['hora_cierre'].'
                    </td>
                    <td class="cell-reporte text-center mb">
                        &nbsp;'.$minuta['lugar'].'
                    </td>
                </tr>
            </tbody>
        </table>

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                 <tr>
                    <td class="separar">
                    </td>
                </tr>

                <tr>
                    <td class="text-center mb">
                        Desarrollo de la sesión
                    </td>
                </tr>
        
                <tr id="info-desarrollo">
                    <td class="text-left m">
                    &nbsp;'.nl2br($minuta['desarrollo']).'
                    </td>
                </tr>

                <tr>
                    <td class="separar">        
                    </td>
                </tr>
            </tbody>
        </table>

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                 <tr>
                    <td class="text-center tab-reporte mb">
                        &nbsp;Acuerdos y compromisos
                    </td>
                </tr>
            </tbody>
        </table>

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                '.$totalAcuerdos.'
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
                    <td class="text-center tab-reporte mb">
                        &nbsp;Unidad de Tecnologías de Información y Comunicaciones
                    </td>
                </tr>
                    
                    '.$printR.'
                    
                <tr>
                    <td class="separar"></td>
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
//$html=file_get_contents_curl(base_url()."minutaPdf?id=".$idMin);


//$dompdf = new Dompdf();
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
$dompdf->setOptions($options);
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
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

    $dompdf->stream('minuta.pdf', [
        'compress' => true,
        'Attachment' => true,
    ]);