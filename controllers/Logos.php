<?php
    class Logos extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function logos ($params){
            $data['page_id'] = 'p_logos';
            $data['page_title'] = '.:Subir Logos:.';
            $data['page_tag'] = 'logos';
            $data['page_name'] = 'Subir Logos';
            $data['page_scripts']='<script src="'.assets().'js/logos.js"></script><script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>'; 
            $this->views->getView($this, 'logos', $data);
        }

        public function setLogo(){
            //dep($_POST);
            
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['nombreLogo']) ||empty($_POST['anho']) || empty($_POST['usoPara']) || empty($_FILES['logo']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $strNomLogo =  $_POST['nombreLogo'];
                    $intAnho = intval($_POST['anho']);
                    $intLogoPara = intval($_POST['usoPara']);
                    $_SESSION['userData']['user_id'];
                    $_FILES['logo'];

                    //Subir la prueba al servidor
                    //restringimos que tipo de documentos se pueden subir
                    $extension = array('image/png', 'image/jpeg', 'image/svg+xml', 'image/webp', 'image/gif', 'image/bmp');
                    //convertir bytes a Unidades de almacenamiento de archivo
                    $TB = pow(1024, 4);  // = 1TB en bytes
                    $GB = pow(1024, 3);  // = 1GB en bytes
                    $MB = pow(1024, 2);  // = 1MB en bytes
                    //ponemos el limite máximo que debe pesar cada archivo en MB
                    $docSize= $MB * 5;
                    
                    if($_FILES['logo']['size'] > $docSize){
                        $arrResponse = array('status' => false, 'msg' => 'El logo no puede pesar más de 5MB ●︿●');
                        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                        exit();
                    }
                    else if(!in_array($_FILES['logo']['type'],  $extension)){
                        $arrResponse = array('status' => false, 'msg' => 'Extensión no valida: Solo se aceptan archivos de imagen'); 
                        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                        exit(); 
                    }
                    
                    
                    if(in_array($_FILES['logo']['type'], $extension)){
                        $clearStrLogo=str_replace(' ', '-',$strNomLogo);
                        $app = '';
                        if($intLogoPara ==1){
                            $app='logos-minutas';
                        }
                        else if($intLogoPara ==2){
                            $app='logos-reportes';
                        }
                        else if($intLogoPara ==3){
                            $app='pie-pagina';
                        }

                        $root='../PAM/resources/';                    //regresamos al directorio raiz
                        $logosDir=$root.'logos';    //Creamos la carpeta pruebas en la carpeta raiz si no existe
                        if(!is_dir($logosDir)){
                            mkdir($logosDir);
                        }
                        $tipoDir=$logosDir.'/'.$app;    //Creamos la carpeta pruebas en la carpeta raiz si no existe
                        if(!is_dir($tipoDir)){
                            mkdir($tipoDir);
                        }
                        
                        $anhoDir=$logosDir.'/'.$app.'/'.$intAnho.'/';     //Creamos la carpeta del reporte para sus pruebas
                        if(!is_dir($anhoDir)){
                            mkdir($anhoDir);
                        }
                         //Extraemos la extension d
                        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                        $urlLogo =$anhoDir.$clearStrLogo. '.'.$ext;

                        if(!file_exists($urlLogo)){
                            $pruebaUrl=@move_uploaded_file($_FILES['logo']['tmp_name'], $urlLogo);
                            if($pruebaUrl){
                                $request_logo= $this->model->insertLogos($strNomLogo, $intAnho, $intLogoPara, $urlLogo);
                            }  
                        }
                    }

                    //mandamos respuesta 
                    if(!empty($request_logo)){
                        $accion= 54;  //Subir logo
                        $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        $arrResponse = array('status' => true, 'msg' => 'El logo se ha subido correctamente (◕‿◕)');
                    }
                    else if(empty($request_logo)){
                        $arrResponse = array('status' => false, 'msg' => 'La información del logo que tratas de subir ya existe (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible agregar información a la DB ┌∩┐(◣_◢)┌∩┐');
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end function

        //obtener los logos de minuta por select
        public function getSelectLogosMin(){
            $options ='';
            $arrData= $this->model->selectLogosMinC();
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    $options .='<option value="" selected disabled hidden>-- Selecciona logo --</option>
                                <option value="'.$arrData[$i]['logo_id'] .'">'.$arrData[$i]['logo_nombre']. '</option> ';
                }
            }
            echo $options;
            die();
        }

        public function chooseLogoMinuta(){
            if($_POST){
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['logoMin']) ||empty($_POST['piePagMin']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Selecciona un logo y pie de pag. >=[ ');
                }
                else{
                    //declaracion de variables recibidas por POST

                    $intLogoMin =  intval($_POST['logoMin']);
                    $intPiePagMin = intval($_POST['piePagMin']);

                    //se manda la peticion al metodo insert que revisara si el email ya esta registrado en la DB             
                    $request_min = $this->model->selectLogoMin($intLogoMin, $intPiePagMin);
                    $accion= 55; //cambiar logo;
                    $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                    
                    //mandamos respuesta 
                    if($request_min >0){
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        $arrResponse = array('status' => true, 'msg' => 'Se ha asignado el logo por defecto a las minutas (◕‿◕)');
                    }
                    else if($request_min == 0){
                        $arrResponse = array('status' => false, 'msg' => 'No se ha podido cambiar el logo (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible realizar la acción ┌∩┐(◣_◢)┌∩┐');
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end function

        //obtener los logos de reporte lado Izquierdo por select
        public function getSelectLogosRepIzq(){
            $options ='';
            $arrData= $this->model->selectLogosRepCI();
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    $options .='<option value="" selected disabled hidden>-- Selecciona logo --</option>
                                <option value="'.$arrData[$i]['logo_id'] .'">'.$arrData[$i]['logo_nombre']. '</option> ';
                }
            }
            echo $options;
            die();
        }

        //obtener los logos de reporte lado Izquierdo por select
        public function getSelectLogosRepDer(){
            $options ='';
            $arrData= $this->model->selectLogosRepCD();
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    $options .='<option value="" selected disabled hidden>-- Selecciona logo --</option>
                                <option value="'.$arrData[$i]['logo_id'] .'">'.$arrData[$i]['logo_nombre']. '</option> ';
                }
            }
            echo $options;
            die();
        }

        public function chooseLogoReporte(){
            if($_POST){
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['logoRepIzq']) || empty($_POST['logoRepDer']) || empty($_POST['piePagRep']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Selecciona los logos y pie de pag. >=[ ');
                }
                else{
                    //declaracion de variables recibidas por POST

                    $intLogoRepIzq =  intval($_POST['logoRepIzq']);
                    $intLogoRepDer =  intval($_POST['logoRepDer']);
                    $intPiePagRep = intval($_POST['piePagRep']);

                    //se manda la peticion al metodo insert que revisara si el email ya esta registrado en la DB             
                    $request_rep = $this->model->selectLogoRep($intLogoRepIzq, $intLogoRepDer, $intPiePagRep);
                    $accion= 55; //cambiar logo;
                    $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                    
                    //mandamos respuesta 
                    if($request_rep >0){
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        $arrResponse = array('status' => true, 'msg' => 'Se han asignado los logos por defecto a los reportes (◕‿◕)');
                    }
                    else if($request_rep == 0){
                        $arrResponse = array('status' => false, 'msg' => 'No se han podido cambiar los logos (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible realizar la acción ┌∩┐(◣_◢)┌∩┐');
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end function

        //obtener los pie de pagina
        public function getSelectPiePag(){
            $options ='';
            $arrData= $this->model->selectPiePagC();
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    $options .='<option value="" selected disabled hidden>-- Selecciona pie pag. --</option>
                                <option value="'.$arrData[$i]['logo_id'] .'">'.$arrData[$i]['logo_nombre']. '</option> ';
                }
            }
            echo $options;
            die();
        }

    } //end class
?>