<?php
    require 'vendor/autoload.php';
    require 'DB_conection.php';
    //Direcion para descargar libro http://localhost/PAM/libraries/phpExcel/libro.php
                       
    use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

    //consulta para exportar la informacion de la DB a excel
    $sql="SELECT o.ofi_numero as numOficio, DATE_FORMAT(o.ofi_fechaE,'%d/%m/%Y') as fechaElab, o.ofi_asunto as asunto, 
    ed.ente_nom as destinatario, ee.ente_nom as empresaD, cd.cargo_nom as cargoD,
    er.ente_nom as remitente, erem.ente_nom as empresaR, cr.cargo_nom as cargoR ,o.ofi_url as urlOfi
    FROM oficios as o 
    INNER JOIN entes as ed ON o.ofi_destinatario = ed.ente_id
    INNER JOIN entes as ee ON o.ofi_unidadDest = ee.ente_id
    INNER JOIN cargos as cd ON o.ofi_cargoDest = cd.cargo_id
    INNER JOIN entes as er ON o.ofi_remitente = er.ente_id
    INNER JOIN entes as erem ON o.ofi_unidadRem = erem.ente_id
    INNER JOIN cargos as cr ON o.ofi_cargoRem = cr.cargo_id;";
    $resultado = $DB_conection->query($sql);



    $objExcel = new Spreadsheet();
    $objExcel->getProperties()
    ->setCreator("UTIC")
    ->setTitle('Tabla de Oficios Subidos')
    ->setDescription('Consulta de oficios')
    ->setKeywords('SOFI Oficios Excel UTIC')
    ->setCategory('Oficios');

    //Pestaña Activa del libro de excel
    $objExcel->setActiveSheetIndex(0);
    $hojaActiva =$objExcel->getActiveSheet();

    //Seleccionar fuente predeterminada
    $objExcel->getDefaultStyle()->getFont()->setName('Montserrat');
    $objExcel->getDefaultStyle()->getFont()->setSize(8);

    //Modificar el Ancho de las columnas
    $hojaActiva->getColumnDimension('A')->setWidth(18);
    $hojaActiva->getColumnDimension('B')->setWidth(15);
    $hojaActiva->getColumnDimension('C')->setWidth(18);
    $hojaActiva->getColumnDimension('D')->setWidth(18);
    $hojaActiva->getColumnDimension('E')->setWidth(40);
    $hojaActiva->getColumnDimension('F')->setWidth(18);
    $hojaActiva->getColumnDimension('G')->setWidth(18);
    $hojaActiva->getColumnDimension('H')->setWidth(40);
    $hojaActiva->getColumnDimension('I')->setWidth(20);
    $hojaActiva->getColumnDimension('J')->setWidth(60);

    //insertar informacion a las celdas
    $hojaActiva->setCellValue('A1', 'Num. de Oficio');
    $hojaActiva->setCellValue('B1', 'Fecha Elab.');
    $hojaActiva->setCellValue('C1', 'Asunto');
    $hojaActiva->setCellValue('D1', 'Destinatario');
    $hojaActiva->setCellValue('E1', 'Cargo Dest.');
    $hojaActiva->setCellValue('F1', 'Empresa Dest.');
    $hojaActiva->setCellValue('G1', 'Remitente');
    $hojaActiva->setCellValue('H1', 'Cargo Rem.');
    $hojaActiva->setCellValue('I1', 'Empresa Rem.');
    $hojaActiva->setCellValue('J1', 'Oficios');
    $fila =2;

    //Recorrer los registros de la DB
    while($rows = $resultado->fetch_assoc()) {
        $hojaActiva->setCellValue('A'.$fila, $rows['numOficio']);
        $hojaActiva->setCellValue('B'.$fila, $rows['fechaElab']);
        $hojaActiva->setCellValue('C'.$fila, $rows['asunto']);
        $hojaActiva->setCellValue('D'.$fila, $rows['destinatario']);
        $hojaActiva->setCellValue('E'.$fila, $rows['cargoD']);
        $hojaActiva->setCellValue('F'.$fila, $rows['empresaD']);
        $hojaActiva->setCellValue('G'.$fila, $rows['remitente']);
        $hojaActiva->setCellValue('H'.$fila, $rows['cargoR']);
        $hojaActiva->setCellValue('I'.$fila, $rows['empresaR']);

            $arrUrl = str_replace(',resources', 'OficiosUtic',$rows['urlOfi'].' || ');                             
        $hojaActiva->setCellValue('J'.$fila, $arrUrl);
        
        $fila++;
    }


    //header('Content-Type: application/vnd.ms-excel'); //versiones anteriores
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="TablaOficios.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = IOFactory::createWriter($objExcel, 'Xlsx');
    $objWriter->save('php://output');
    exit;


?>