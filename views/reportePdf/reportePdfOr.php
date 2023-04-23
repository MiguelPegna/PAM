<?php
    include_once 'helpers/DB_conection.php';

    $id= $_GET['id'];
    //$id= 3;
    /*MINUTAS*/
    $queryRep="SELECT rep.reporte_id, rep.reporte_titulo as titulo, DATE_FORMAT(`reporte_fecha_incidente`,'%d/%m/%Y') as fechaInc, rep.reporte_incidente as incidente, rep.reporte_caso as caso, rep.reporte_consentimiento as consentimiento, rep.reporte_etiqueta as etiqueta, rep.reporte_modelo as modelo, rep.reporte_fabricante as fabricante, rep.reporte_num_serie as numSerie, rep.reporte_descripcion as descripcion, rep.reporte_disp_final as disposicion, DATE_FORMAT(`reporte_fecha_final`,'%d/%m/%Y') as fechaFinal,
    recep.receptor_nom as receptor FROM reportes as rep
    INNER JOIN receptores as recep ON rep.reporte_persona= recep.receptor_id WHERE rep.reporte_id=$id";
    $reportes = $DB_conection->query($queryRep);
    $reporte = $reportes->fetch_assoc();

    /*Acuerdos*/
    $queryEv ="SELECT evidencia_origen as origen, DATE_FORMAT(evidencia_fecha, '%d/%m/%Y') as fecha, evidencia_razon as razon, evidencia_destino as destino FROM evidencias WHERE evidencia_reporte=$id;";
    $evidencias = $DB_conection->query($queryEv);

/*MINUTAS
SELECT m.minuta_id, m.minuta_titulo, m.minuta_desarrollo, m.minuta_lugar, DATE_FORMAT(`minuta_fecha`,'%d/%m/%Y') as Fecha , minuta_hora, minuta_hora_cierre,
c.cargo_nom FROM minutas as m
INNER JOIN cargos as c ON m.minuta_unidad_admin= c.cargo_id WHERE m.minuta_id=4;

*/

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
        <table>
            <thead>
            </thead>
            <tbody>
                <tr>
                    <td class="logo">
                        <img src="<?php echo assets_full(); ?>logos/logo-full-sict.png">
                    </td>
                </tr>

                <tr>
                    <td class="text-center">
                        <b>Unidad de Administración y Finanzas</b>
                    </td>
                </tr>

                <tr>
                    <td class="text-center">
                        <b>Unidad de Tecnologías de Información y Comunicaciones</b>
                    </td>
                </tr>
                
                <tr>
                    <td class="text-center">
                        <b><?php echo $minuta['unidad']?></b>
                    </td>
                </tr>

                <tr>
                    <td class="separar">
                    </td>
                </tr>

                <tr>
                    <td class="text-center">
                        <b><?php echo $minuta['titulo']?></b>
                    </td>
                </tr>
            </tbody>
        </table>

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                 <tr>
                    <td class="text-center tab-reporte">
                        <b>Fecha</b>
                    </td>

                    <td class="text-center tab-reporte">
                        <b>Hora apertura / Hora cierre</b>
                    </td>

                    <td class="text-center tab-reporte">
                        <b>Lugar</b>
                    </td>
                </tr>
        
                <tr id="info-minuta">
                    <td class="cell-reporte text-center">
                        <b><?php echo $minuta['fecha']?></b>
                    </td>
                    <td class="cell-reporte text-center">
                        <b><?php echo $minuta['hora']?> / <?php echo $minuta['hora_cierre']?></b>
                    </td>
                    <td class="cell-reporte text-center">
                        <b><?php echo $minuta['lugar']?></b>
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
                    <td class="text-center">
                        <b>Desarrollo de la sesión</b>
                    </td>
                </tr>
        
                <tr id="info-desarrollo">
                    <td class="text-left">
                    <?php echo $minuta['desarrollo']?>
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
                    <td class="text-center tab-reporte">
                        <b>Acuerdos y compromisos</b>
                    </td>
                </tr>
            </tbody>
        </table>

        <table  class="reporte">
            <thead>
            </thead>
            <tbody>
                <?php 
                    foreach ($acuerdos as $acuerdo){ ?>
                        <tr id="info-acuerdos">
                    
                            <td class="cell-reporte text-left">
                                <b><?php echo $acuerdo['titulo']?></b>
                            </td>
                            <td class="cell-reporte text-center">
                                <b><?php echo $acuerdo['nombre']?></b>
                            </td>
                            <td class="cell-reporte text-center">
                                <b><?php echo $acuerdo['fecha']?></b>
                            </td>
                        </tr>   
                    <?php } ?>
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
                    <td class="text-center tab-reporte">
                        <b>Unidad de Tecnologías de Información y Comunicaciones</b>
                    </td>
                </tr>
                <?php
                        $arrPart = explode(',', $minuta['participantes']);
                        //echo $arrUrl[0];
                        foreach ($arrPart as $participante){
                            $serv='query'.$participante;
                            $serv="SELECT p.participante_nom as nombre, c.cargo_nom as cargo, t.titulo_abr as titulo
                            FROM participantes as p
                            INNER JOIN titulos as t ON p.participante_titulo = titulo_id
                            INNER JOIN cargos as c ON p.participante_cargo= cargo_id
                            WHERE participante_id=$participante";
                            $info = $DB_conection->query($serv);
                            $user = $info->fetch_assoc();
                            $printR= "<b>". $user['titulo']. " ".  $user['nombre']. "</b><br/>".$user['cargo'];                                                 
                ?>
                <tr>
                    <td class="cell-reporte text-left">
                        <?php echo $printR; ?>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td class="separar"></td>
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
                    <td class="col-md-12 pie-pag-logo">
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