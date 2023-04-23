<?php
    class Reportes extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function reportes ($params){
            $data['page_id'] = 'p_reportes';
            $data['page_title'] = '.:Crear Reporte de Evidencia:.';
            $data['page_tag'] = 'reportes';
            $data['page_name'] = 'Formato de Entrega de Evidencias';
            $data['page_scripts']='<script src="'.assets().'js/reportes.js"></script><script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>'; 
            $this->views->getView($this, 'reportes', $data);
        }

        //obtener el ultimo id del reporte
        public function getIdReporte(){
			$idRep ='';
            $arrData= $this->model->selectIdReporte();
            if(count($arrData) > 0){
                    $idRep .='<input type="hidden" id="idRep" name="idRep" value="'.$arrData['id']+1 .'"/>';
            }
            echo $idRep;
            die();
        }

        //obtener personas receptoras por select
        public function getSelectReceptores(){
            $options ='';
            $arrData= $this->model->selectReceptoresC();
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    $options .='<option value="'.$arrData[$i]['receptor_id'] .'">'.$arrData[$i]['receptor_nom']. '</option> ';
                }
            }
            echo $options;
            die();
        }
        /*
        public function getPersona(){
            //if ($destinatarios->num_rows > 0) {
            //    while ($destinatario = $destinatarios->fetch_assoc())
            $persona = $_POST['persona'];
            var_dump($persona);
            $options ='';
            $arrData= $this->model->selectReceptoresInput($persona);
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    $options .='<div>
                                    <a class="suggest-element " data="'.$arrData['receptor'].'" id="'.$arrData['id'].'">'.$arrData['receptor'].'</a>
                                </div>
                                <input type="hidden" id="idRecep" name="idRecep" value="'.$arrData['id'].'">
                            ';
                }
            }
            else{
                $options.='<div><a class="suggest-element">No hay resultados similares a tu busqueda</div>';
            }
            echo $options;
            die();
        }*/

        public function getPersona(){
            require_once 'helpers/DB_conection.php';
            $html = '';
            $persona = $_POST['persona'];
    
            $queryPers=('SELECT receptor_id as id, receptor_nom as receptor FROM receptores WHERE receptor_nom LIKE "%'.strip_tags($persona).'%" AND receptor_estado=1 ORDER BY receptor_nom DESC LIMIT 0,15');
            $personas = $DB_conection->query($queryPers);
            if ($personas->num_rows > 0) {
                while ($persona = $personas->fetch_assoc()) {                
                    $html.='
                    <div>
                        <a class="suggest-element input-search" data="'.$persona['receptor'].'" id="'.$persona['id'].'">'.$persona['receptor'].'</a>
                    </div>
                        <input type="hidden" id="idRecep" name="idRecep" value="'.$persona['id'].'">
                    ';
                }
            }
            else{
                $html.='<div><a class="suggest-element input-search">No hay resultados similares a tu busqueda</div>';
            }
            echo $html;
            die();          
        }

        public function setReporte(){
            //dep($_POST);
            
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['titulo']) ||empty($_POST['fechaInc']) || empty($_POST['incidente']) || empty($_POST['caso']) || empty($_POST['etiqueta']) || empty($_POST['modelo']) || empty($_POST['fabricante']) || empty($_POST['numSerie']) || empty($_POST['persona']) || empty($_POST['descripcion']) ||empty($_POST['origen']) || empty($_POST['fechaCad']) || empty($_POST['razon']) ||empty($_POST['destino']) || empty($_POST['disposicion'])||empty($_POST['fechaFinal']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $strTitulo =  $_POST['titulo'];
                    $strFechaInc =  $_POST['fechaInc'];
                    $strIncidente = $_POST['incidente'];
                    $strCaso = $_POST['caso'];
                    $intConsentimiento = $_POST['consentimiento'];
                    $strEtiqueta =  $_POST['etiqueta'];
                    $strModelo = $_POST['modelo'];
                    $strFabricante = $_POST['fabricante'];
                    $strNumSerie = $_POST['numSerie'];
                    $intIdPersona = intval($_POST['idRecep']);
                    $strDescripcion = $_POST['descripcion'];
                    $strOrigen = $_POST['origen'];
                    $strFechaCad = $_POST['fechaCad'];
                    $strRazon = $_POST['razon'];
                    $strDestino = $_POST['destino'];
                    $strDisposicion = $_POST['disposicion'];
                    $strFechaF = $_POST['fechaFinal'];
                    $intIdReporte = intval($_POST['idRep']);
                    $_SESSION['userData']['user_id'];
                    $_FILES['prueba'];

                    //Subir la prueba al servidor
                    //restringimos que tipo de documentos se pueden subir
                    $extension = array('', 'image/png', 'image/jpeg','application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation');
                    //convertir bytes a Unidades de almacenamiento de archivo
                    $TB = pow(1024, 4);  // = 1TB en bytes
                    $GB = pow(1024, 3);  // = 1GB en bytes
                    $MB = pow(1024, 2);  // = 1MB en bytes
                    //ponemos el limite máximo que debe pesar cada archivo en MB
                    $docSize= $MB * 5;
                    $p=1;
                    foreach ($_FILES['prueba']['tmp_name'] as $key => $value){
                        if($_FILES['prueba']['size'][$key] > $docSize){
                            $arrResponse = array('status' => false, 'msg' => 'La prueba no puede pesar más de 5MB ●︿●');
                            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                            exit();
                        }
                        else if(!in_array($_FILES['prueba']['type'][$key],  $extension)){
                            $arrResponse = array('status' => false, 'msg' => 'Extensión no valida: Solo se aceptan archivos de Word, Excel, Power Point o PDF'); 
                            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                            exit(); 
                        }
                    }//end foreach

                    $request_rep = $this->model->insertReporte($strTitulo, $strFechaInc, $strIncidente, $strCaso, $intConsentimiento, $strEtiqueta, $strModelo, $strFabricante, $strNumSerie, $intIdPersona, $strDescripcion, $strDisposicion, $strFechaF, $_SESSION['userData']['user_id'], $intIdReporte);
                    $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                    $accion= 30; //Crear reporte;
                    
                    for($i=0; $i<sizeof($strOrigen); $i++){                      
                        //volvemos a recorrer el $_files ahora para guardar el oficio
                        foreach ($_FILES['prueba']['tmp_name'] as $key => $value){
                            if(in_array($_FILES['prueba']['type'][$key], $extension)){  
                                $root='../PAM/resources/';                    //regresamos al directorio raiz
                                $pruebasDir=$root.'pruebas';    //Creamos la carpeta pruebas en la carpeta raiz si no existe
                                if(!is_dir($pruebasDir)){
                                    mkdir($pruebasDir);
                                }
                                $idDir=$pruebasDir.'/Reporte_00'.$intIdReporte.'/';     //Creamos la carpeta del reporte para sus pruebas
                                if(!is_dir($idDir)){
                                    mkdir($idDir);
                                }
                                 //Extraemos la extension d
                                 $ext = pathinfo($_FILES['prueba']['name'][$key], PATHINFO_EXTENSION);
                                 $urlDoc =$idDir.'Rep_00'.$intIdReporte.'_prueba_'.$p++. '.'.$ext;
                                // $urlDB = $urlDoc;
                                 //echo $urlDB;
                                 $request_ev = $this->model->insertEvidencia($strOrigen[$i], $strFechaCad[$i], $strRazon[$i], $strDestino[$i], $intIdReporte, $urlDoc);
                                 $accion= 35;  //crearCadena de Evidencia        
                                 $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                                if($request_ev >0){
                                     if(!file_exists($urlDoc)){
                                     $pruebaUrl=@move_uploaded_file($_FILES['prueba']['tmp_name'][$key], $urlDoc);                                     
                                    }
                                }    
                            }
                        } //fin Foreach
                    } //end for
 
                    //mandamos respuesta 
                    if($request_rep >0){
                        $arrResponse = array('status' => true, 'msg' => 'El reporte y las cadenas de custodía se han agregado correctamente (◕‿◕)');
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        //subir las cadenas de evidencia con sus respectivas pruebas
                    }
                    else if($request_rep == 0){
                        $arrResponse = array('status' => false, 'msg' => 'No se pudo crear el reporte (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible agregar información a la DB ┌∩┐(◣_◢)┌∩┐');
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end function

        public function setReceptor(){
            //dep($_POST);
            
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['nPersona']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                else if(strlen(trim($_POST['nPersona'])) <8 ){   
                    $arrResponse= array('status' => false, 'msg' => 'Introduce el nombre completo del invitado >:{ ');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $strNombre =  ucwords(strtolower(strClean($_POST['nPersona'])));
                    $intTipo = intval($_POST['listStatus']);

                    //se manda la peticion al metodo insert que revisara si el email ya esta registrado en la DB             
                    $request_per = $this->model->insertPersona($strNombre, $intTipo, $_SESSION['userData']['user_id']);
                    $accion= 39; //Registrar persona;
                    $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                    
                    //mandamos respuesta 
                    if($request_per >0){
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        $arrResponse = array('status' => true, 'msg' => 'La persona que recibira la evidencia se ha agregado correctamente (◕‿◕)');
                    }
                    else if($request_per == 0){
                        $arrResponse = array('status' => false, 'msg' => 'El nombre de la persona ya se encuentra registrado (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible agregar información a la DB ┌∩┐(◣_◢)┌∩┐');
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end function

    } //end class
?>