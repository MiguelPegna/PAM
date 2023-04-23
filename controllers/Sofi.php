<?php
    class Sofi extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function sofi ($params){
            $data['page_id'] = 'p_sofi';
            $data['page_title'] = '.:Subir Oficio:.';
            $data['page_tag'] = 'oficios';
            $data['page_name'] = 'SOFI';
            $data['page_scripts']='<script src="'.assets().'js/sofi.js"></script><script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>'; 
            $this->views->getView($this, 'sofi', $data);
        }

        //obtener el ultimo id del reporte
        public function getIdOficio(){
			$idOfi ='';
            $arrData= $this->model->selectIdOfi();
            if(count($arrData) > 0){
                $idOfi .='<input type="hidden" id="idOfi" name="idOfi" value="'.$arrData['id']+1 .'"/>';
            }
            echo $idOfi;
            die();
        }
        //agregar nuevo destinatario
        public function setDestinatario(){
            //dep($_POST);
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['nDestinatario']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                else if(strlen(trim($_POST['nDestinatario'])) <8 ){   
                    $arrResponse= array('status' => false, 'msg' => 'Introduce el nombre completo del destinatario >:{ ');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $strDestinatario =  ucwords(strtolower(strClean($_POST['nDestinatario'])));
                    $intTipo = intval($_POST['listStatus']);

                    //se manda la peticion al metodo insert que revisara si el email ya esta registrado en la DB             
                    $request_dest = $this->model->insertDestinatario($strDestinatario, $intTipo, $_SESSION['userData']['user_id']);
                    $accion= 42; //Registrar destinatario;
                    $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                    
                    //mandamos respuesta 
                    if($request_dest >0){
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        $arrResponse = array('status' => true, 'msg' => 'Destinatario agregado correctamente (◕‿◕)');
                    }
                    else if($request_dest == 0){
                        $arrResponse = array('status' => false, 'msg' => 'Este destinatario ya se encuentra registrado (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible agregar información a la DB ┌∩┐(◣_◢)┌∩┐');
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
    
        } //end function

        //agregar nuevo remitente
         public function setRemitente(){
            //dep($_POST);
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['nRemitente']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                else if(strlen(trim($_POST['nRemitente'])) <8 ){   
                    $arrResponse= array('status' => false, 'msg' => 'Introduce el nombre completo del remitente >:{ ');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $strRemitente =  ucwords(strtolower(strClean($_POST['nRemitente'])));
                    $intTipo = intval($_POST['listStatus']);

                    //se manda la peticion al metodo insert que revisara si el email ya esta registrado en la DB             
                    $request_rem = $this->model->insertRemitente($strRemitente, $intTipo, $_SESSION['userData']['user_id']);
                    $accion= 45; //Registrar remitente;
                    $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                    
                    //mandamos respuesta 
                    if($request_rem >0){
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        $arrResponse = array('status' => true, 'msg' => 'Remitente agregado correctamente (◕‿◕)');
                    }
                    else if($request_rem == 0){
                        $arrResponse = array('status' => false, 'msg' => 'Este remitente ya se encuentra registrado (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible agregar información a la DB ┌∩┐(◣_◢)┌∩┐');
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
    
        } //end function

         //agregar nuevo remitente
         public function setCargo(){
            //dep($_POST);
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['cargo']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                else if(strlen(trim($_POST['cargo'])) <8 ){   
                    $arrResponse= array('status' => false, 'msg' => 'Introduce un nombre de cargo valido >:{ ');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $strCargo =  ucwords(strtolower(strClean($_POST['cargo'])));
                    $intTipo = intval($_POST['listStatus']);

                    //se manda la peticion al metodo insert que revisara si el email ya esta registrado en la DB             
                    $request_cargo = $this->model->insertCargo($strCargo, $intTipo, $_SESSION['userData']['user_id']);
                    $accion= 18; //Registrar cargo;
                    $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                    
                    //mandamos respuesta 
                    if($request_cargo >0){
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        $arrResponse = array('status' => true, 'msg' => 'Cargo agregado correctamente (◕‿◕)');
                    }
                    else if($request_cargo == 0){
                        $arrResponse = array('status' => false, 'msg' => 'Este cargo ya se encuentra registrado (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible agregar información a la DB ┌∩┐(◣_◢)┌∩┐');
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
    
        } //end function

        //agregar nueva empresa
        public function setEmpresa(){
            //dep($_POST);
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['empresa']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                else if(strlen(trim($_POST['empresa'])) <8 ){   
                    $arrResponse= array('status' => false, 'msg' => 'Introduce un nombre de empresa valido >:{ ');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $strEmpresa =  ucwords(strtolower(strClean($_POST['empresa'])));
                    $intTipo = intval($_POST['listStatus']);

                    //se manda la peticion al metodo insert que revisara si el email ya esta registrado en la DB             
                    $request_empresa = $this->model->insertEmpresa($strEmpresa, $intTipo, $_SESSION['userData']['user_id']);
                    $accion= 48; //Registrar empresa;
                    $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                    
                    //mandamos respuesta 
                    if($request_empresa >0){
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        $arrResponse = array('status' => true, 'msg' => 'Empresa agregada correctamente (◕‿◕)');
                    }
                    else if($request_empresa == 0){
                        $arrResponse = array('status' => false, 'msg' => 'Esta empresa ya se encuentra registrada (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible agregar información a la DB ┌∩┐(◣_◢)┌∩┐');
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
    
        } //end function

        public function getDestinatario(){
            require_once 'helpers/DB_conection.php';
            $htmlD = '';
            $destinatario = $_POST['destinatario'];
        
            $queryDest=('SELECT ente_id as destId, ente_nom as destinatario FROM entes WHERE ente_nom LIKE "%'.strip_tags($destinatario).'%" AND ente_estado=1 AND ente_categoria=1 ORDER BY ente_nom DESC LIMIT 0,15');
            $destinatarios = $DB_conection->query($queryDest);
            if ($destinatarios->num_rows > 0) {
                while ($destinatario = $destinatarios->fetch_assoc()) {                
                    $htmlD.='
                    <div>
                        <a class="destinatario input-search" data="'.$destinatario['destinatario'].'" id="'.$destinatario['destId'].'">'.$destinatario['destinatario'].'</a>
                    </div>
                        <input type="hidden" id="idDest" name="idDest" value="'.$destinatario['destId'].'">
                    ';
                }
            }
            else{
                $htmlD.='<div><a class="destinatario input-search">No hay resultados similares a tu busqueda</div>';
            }
            echo $htmlD;
            die();          
        }

        public function getCargoDest(){
            require_once 'helpers/DB_conection.php';
            $htmlCD = '';
            $cargoD = $_POST['cargoDest'];
        
            $queryCargoD=('SELECT cargo_id as cdId, cargo_nom as cargo FROM cargos WHERE cargo_nom LIKE "%'.strip_tags($cargoD).'%" AND cargo_estado=1 ORDER BY cargo_nom DESC LIMIT 0,15');
            $cargosD = $DB_conection->query($queryCargoD);
            if ($cargosD->num_rows > 0) {
                while ($cargoDest = $cargosD->fetch_assoc()) {                
                    $htmlCD.='
                    <div>
                        <a class="cargo-destinatario input-search" data="'.$cargoDest['cargo'].'" id="'.$cargoDest['cdId'].'">'.$cargoDest['cargo'].'</a>
                    </div>
                        <input type="hidden" id="idCargoD" name="idCargoD" value="'.$cargoDest['cdId'].'">
                    ';
                }
            }
            else{
                $htmlCD.='<div><a class="cargo-destinatario input-search">No hay resultados similares a tu busqueda</div>';
            }
            echo $htmlCD;
            die();          
        }

        public function getEmpresaDest(){
            require_once 'helpers/DB_conection.php';
            $htmlED = '';
            $empD = $_POST['empDest'];
        
            $queryEmpD=('SELECT ente_id as edId, ente_nom as empresa FROM entes WHERE ente_nom LIKE "%'.strip_tags($empD).'%" AND ente_estado=1 AND ente_categoria=3 ORDER BY ente_nom DESC LIMIT 0,15');
            $empresasD = $DB_conection->query($queryEmpD);
            if ($empresasD->num_rows > 0) {
                while ($empresaDest = $empresasD->fetch_assoc()) {
                    $htmlED.='
                    <div>
                        <a class="empresa-destinatario input-search" data="'.$empresaDest['empresa'].'" id="'.$empresaDest['edId'].'">'.$empresaDest['empresa'].'</a>
                    </div>
                        <input type="hidden" id="idEmpD" name="idEmpD" value="'.$empresaDest['edId'].'">
                    ';
                }
            }
            else{
                $htmlED.='<div><a class="empresa-destinatario input-search">No hay resultados similares a tu busqueda</div>';
            }
            echo $htmlED;
            die();          
        }

        public function getRemitente(){
            require_once 'helpers/DB_conection.php';
            $htmlR = '';
            $remitente = $_POST['remitente'];
        
            $queryRem=('SELECT ente_id as id, ente_nom as remitente FROM entes WHERE ente_nom LIKE "%'.strip_tags($remitente).'%" AND ente_estado=1 AND ente_categoria=2 ORDER BY ente_nom DESC LIMIT 0,15');
            $remitentes = $DB_conection->query($queryRem);
            if ($remitentes->num_rows > 0) {
                while ($remitente = $remitentes->fetch_assoc()) {                
                    $htmlR.='
                    <div>
                        <a class="remitente input-search" data="'.$remitente['remitente'].'" id="'.$remitente['id'].'">'.$remitente['remitente'].'</a>
                    </div>
                        <input type="hidden" id="idRem" name="idRem" value="'.$remitente['id'].'">
                    ';
                }
            }
            else{
                $htmlR.='<div><a class="remitente input-search">No hay resultados similares a tu busqueda</div>';
            }
            echo $htmlR;
            die();          
        }

        public function getCargoRem(){
            require_once 'helpers/DB_conection.php';
            $htmlCR = '';
            $cargoR = $_POST['cargoRem'];
        
            $queryCargoR=('SELECT cargo_id as id, cargo_nom as cargo FROM cargos WHERE cargo_nom LIKE "%'.strip_tags($cargoR).'%" AND cargo_estado=1 ORDER BY cargo_nom DESC LIMIT 0,15');
            $cargosR = $DB_conection->query($queryCargoR);
            if ($cargosR->num_rows > 0) {
                while ($cargoRem = $cargosR->fetch_assoc()) {                
                    $htmlCR.='
                    <div>
                        <a class="cargo-remitente input-search" data="'.$cargoRem['cargo'].'" id="'.$cargoRem['id'].'">'.$cargoRem['cargo'].'</a>
                    </div>
                        <input type="hidden" id="idCargoR" name="idCargoR" value="'.$cargoRem['id'].'">
                    ';
                }
            }
            else{
                $htmlCR.='<div><a class="cargo-remitente input-search">No hay resultados similares a tu busqueda</div>';
            }
            echo $htmlCR;
            die();          
        }

        public function getEmpresaRem(){
            require_once 'helpers/DB_conection.php';
            $htmlER = '';
            $empR = $_POST['empRem'];
        
            $queryEmpR=('SELECT ente_id as id, ente_nom as empresa FROM entes WHERE ente_nom LIKE "%'.strip_tags($empR).'%" AND ente_estado=1 AND ente_categoria=3 ORDER BY ente_nom DESC LIMIT 0,15');
            $empresasR = $DB_conection->query($queryEmpR);
            if ($empresasR->num_rows > 0) {
                while ($empresaRem = $empresasR->fetch_assoc()) {
                    $htmlER.='
                    <div>
                        <a class="empresa-remitente input-search" data="'.$empresaRem['empresa'].'" id="'.$empresaRem['id'].'">'.$empresaRem['empresa'].'</a>
                    </div>
                        <input type="hidden" id="idEmpR" name="idEmpR" value="'.$empresaRem['id'].'">
                    ';
                }
            }
            else{
                $htmlER.='<div><a class="empresa-remitente input-search">No hay resultados similares a tu busqueda</div>';
            }
            echo $htmlER;
            die();          
        }
        

        public function setOficio(){
            //dep($_POST);
            
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['destinatario']) ||empty($_POST['cargoDest']) || empty($_POST['empDest']) || empty($_POST['remitente']) || empty($_POST['cargoRem']) || empty($_POST['empRem']) || empty($_POST['fechaElaboracion']) || empty($_POST['fechaRecepcion']) || empty($_POST['asunto']) || empty($_POST['descripcion']) ||empty($_POST['numero']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $intIdDestinatario = intval($_POST['idDest']);
                    $intIdCargoD = intval($_POST['idCargoD']);
                    $intIdEmpD = intval($_POST['idEmpD']);
                    $intIdRemitente = intval($_POST['idRem']);
                    $intIdCargoR = intval($_POST['idCargoR']);
                    $intIdEmpR = intval($_POST['idEmpR']);
                    $intIdOficio = intval($_POST['idOfi']);
                    $strFechaElab =  $_POST['fechaElaboracion'];
                    $strFechaRecep = $_POST['fechaRecepcion'];
                    $strAsunto = $_POST['asunto'];
                    $strNumOfi = $_POST['numero'];
                    $strObservacion = $_POST['descripcion'];
                    $_SESSION['userData']['user_id'];
                    $_FILES['archivoOficio'];

                    $strDestinatario = $_POST['destinatario'];
                    $strRemitente =  $_POST['remitente'];
                    $urlDB = '';
                    //variables para conseguir año y mes y hacer directorios
                    $anho=strftime('%Y');
                    $mes= ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'][date('n')-1];

                    //Subir la prueba al servidor
                    //restringimos que solo queremos documentos con extension pdf
                    $extension = array('application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation');
                    //convertir bytes a Unidades de almacenamiento de archivo
                    $TB = pow(1024, 4);  // = 1TB en bytes
                    $GB = pow(1024, 3);  // = 1GB en bytes
                    $MB = pow(1024, 2);  // = 1MB en bytes
                    //ponemos el limite máximo que debe pesar cada archivo en MB
                    $docSize= $MB * 5;
                    $p=1;

                    //verificamos los archivos y evitamos que suba cualquier documento si alguno pesa mas de 50MB
                    foreach ($_FILES['archivoOficio']['tmp_name'] as $key => $value){
                        if($_FILES['archivoOficio']['size'][$key] > $docSize){
                            $arrResponse = array('status' => false, 'msg' => 'La prueba no puede pesar más de 50MB ●︿●');
                            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                            exit();
                        }
                    }

                    //volvemos a recorrer el $_files ahora para guardar el oficio
                    foreach ($_FILES['archivoOficio']['tmp_name'] as $key => $value){
                    //Validamos que el archivo exista
                        if($_FILES['archivoOficio']['error'][$key]>0 ){
                            //mandamos un mensaje notificando que se envio el formulario sin cargar ningun oficio
                            $arrResponse = array('status' => false, 'msg' => 'ERROR No seleccionaste ningún archivo HDPM >:(');
                            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                            exit();
                        }
                        if(in_array($_FILES['archivoOficio']['type'][$key], $extension)){  
                            $root='../PAM/resources/';                    //regresamos al directorio raiz
                            $oficiosDir=$root.'oficios';    //Creamos la carpeta oficios en la carpeta raiz si no existe
                            if(!is_dir($oficiosDir)){
                                mkdir($oficiosDir);
                            }
                            $idDir=$oficiosDir.'/'.$_SESSION['userData']['user_id'].'/';     //Creamos la carpeta del usuario si no existe
                            if(!is_dir($idDir)){
                                mkdir($idDir);
                            }
                            $anhoDir=$oficiosDir.'/'.$_SESSION['userData']['user_id'].'/'.$anho;   //Creamos la carpeta del año en curso
                            if(!is_dir($anhoDir)){
                                mkdir($anhoDir);
                            }
                            $urlDir=$oficiosDir.'/' .$_SESSION['userData']['user_id'] .'/'.$anho. '/'.$mes.'/';    //Creamos la carpeta del mes del año en curso
                            if(!is_dir($urlDir)){
                                mkdir($urlDir);
                            }
                            $fecha = date('d-m-y'); 
                            $random = rand(99999, 999999999);
                            //Extraemos la extension del oficio
                            $ext = pathinfo($_FILES['archivoOficio']['name'][$key], PATHINFO_EXTENSION);
                            $urlDoc =$urlDir.$fecha.'_'.$random.'.'.$ext;
                        
                            if(!file_exists($urlDoc)){
                                $oficioUrl=@move_uploaded_file($_FILES['archivoOficio']['tmp_name'][$key], $urlDoc);    
                                $urlDB .= ',resources/oficios/'.$_SESSION['userData']['user_id'].'/'.$anho.'/'.$mes.'/'.$fecha.'_'.$random.'.'.$ext;

                            }
                        }
                        else{
                            $arrResponse = array('status' => false, 'msg' => 'Extensión no valida: Solo se aceptan archivos de Word, Excel, Power Point o PDF'); 
                            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                            exit();               
                        }
                    } //fin Foreach
                    if($urlDB){
                        $request_ofi = $this->model->insertOficio($_SESSION['userData']['user_id'], $intIdDestinatario, $intIdCargoD, $intIdEmpD, $intIdRemitente, $intIdCargoR, $intIdEmpR, $strFechaElab, $strFechaRecep, $strAsunto, $strNumOfi, $strObservacion, $urlDB, $intIdOficio);
                        $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                        $accion= 51; //subir Oficio;
                    }

                    //mandamos respuesta 
                    if($request_ofi >0){
                        $arrResponse = array('status' => true, 'msg' => '¡El oficio se ha subido con éxito! (◕‿◕)');
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        //subir las cadenas de evidencia con sus respectivas pruebas
                    }
                    else if($request_ofi == 0){
                        $arrResponse = array('status' => false, 'msg' => 'No se pudo subir el oficio (¯ ヘ ¯)');
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