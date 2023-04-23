<?php
    class EditarRep extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function editarRep ($params){
            $data['page_id'] = 'p_reportes';
            $data['page_title'] = '.:Editar Reporte de Evidencia:.';
            $data['page_tag'] = 'reportes';
            $data['page_name'] = 'Formato de Entrega de Evidencias';
            $data['page_scripts']='<script src="'.assets().'js/editarRep.js"></script>'; 
            $this->views->getView($this, 'editarRep', $data);
        }

        //obtener info del reporte
        public function getReporte($idReporte){
            $intIdReporte = intval(strClean($idReporte));
            if($intIdReporte>0){
                $arrData = $this->model->selectReporte($intIdReporte);
                if(empty($arrData))	{
					$arrResponse = array('status' => false, 'msg' => 'Reporte no existente en la base de datos');
                }
                else{
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
           die();
        }

        //obtener cargos para select
        public function getEvidencias($idReporte){
            $intIdReporte = intval(strClean($idReporte));
            $evidencia ='';
            $arrData= $this->model->selectEvidencias($intIdReporte);
            if(count($arrData) > 0){
                $k=0;
                for($i=0; $i < count($arrData); $i++){
                    $evidencia .='<tr>
                    <td class="form-control">
                        <input type="checkbox" class="check" name="chk"/>
                     </td>

                    <td class="col-md-3 td-a"> 			
                        <input type="hidden" id="idEvidencia[]" name="idEvidencia'.$k++.'" value="'.$arrData[$i]['id'].'">
                        
                        <input type="text" class="form-control origen" id="origen[]" name="origen[]" autocomplete="off" value="'.$arrData[$i]['origen'] .'"/>
                     </td>

                    <td class="col-md-3 td-a">
                        <input type="date" class="form-control fechaCad" id="fechaCad[]" name="fechaCad[]" autocomplete="off" value="'.$arrData[$i]['fecha'] .'" />
                     </td>

                     <td class="col-md-3 td-a"> 			
                        <input type="text" class="form-control razon" id="razon[]" name="razon[]" autocomplete="off" value="'.$arrData[$i]['razon'] .'" />
                     </td>

                     <td class="col-md-3 td-a"> 			
                        <input type="text" class="form-control destino" id="destino[]" name="destino[]" autocomplete="off" value="'.$arrData[$i]['destino'] .'" />
                     </td>

                     <td class="col-md-3 td-a"> 			
                        <input type="file" class="form-control prueba" id="prueba[]" name="prueba[]" autocomplete="off" />
                     </td>
                    
                </tr>';
                }
            }
            echo $evidencia;
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
                        <a class="suggest-element" data="'.$persona['receptor'].'" id="'.$persona['id'].'">'.$persona['receptor'].'</a>
                    </div>
                        <input type="hidden" id="idRecep" name="idRecep" value="'.$persona['id'].'">
                    ';
                }
            }
            else{
                $html.='<div><a class="suggest-element">No hay resultados similares a tu busqueda</div>';
            }
            echo $html;
            die();          
        }

        public function updateReporte(){
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
                    //$intIdEvidencia = intval($_POST['idEvidencia']);
                    $strOrigen = $_POST['origen'];
                    $strFechaCad = $_POST['fechaCad'];
                    $strRazon = $_POST['razon'];
                    $strDestino = $_POST['destino'];
                    $strDisposicion = $_POST['disposicion'];
                    $strFechaF = $_POST['fechaFinal'];
                    $intIdReporte = intval($_POST['idReporte']);
                    $_SESSION['userData']['user_id'];
                    $_FILES['prueba'];
                    

                    //Subir la prueba al servidor
                     //restringimos que solo queremos documentos con extension pdf
                    $extension = array('', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation');
                    //convertir bytes a Unidades de almacenamiento de archivo
                    $TB = pow(1024, 4);  // = 1TB en bytes
                    $GB = pow(1024, 3);  // = 1GB en bytes
                    $MB = pow(1024, 2);  // = 1MB en bytes
                    //ponemos el limite máximo que debe pesar cada archivo en MB
                    $docSize= $MB * 5;
                    //validamos los archivos de las cadenas existentes
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
                    }//end foreach validacion los archivos de las cadenas existentes

                    /*NOTA DE SUGERENCIA
                    Estimado proximo colega desarrollador esta parte del codigo es funcional pero es redundante para hacerlo más 
                    practico y optimizado sugiero dividir esta parte en 2 funciones una que actualize y la otra que inserte 
                    los nuevos registros y solo llamarlas debido al tiempo de entrega en que se requeria esta funcionalidad
                    se hizo de esta manera para cubrir con la correcta funcionalidad de lo que se pedia en ese entonces*/

                     //se crean las nuevas cadenas de evidencias si estas existen
                    if(!empty($_POST['nvoOrigen'])){
                        $strNvoOrigen = $_POST['nvoOrigen'];
                        $strNvoFechaCad = $_POST['nvoFechaCad'];
                        $strNvoRazon = $_POST['nvoRazon'];
                        $strNvoDestino = $_POST['nvoDestino'];
                        $_FILES['nvoPrueba'];
                        //validamos los archivos de las nuevas cadenas
                        foreach ($_FILES['nvoPrueba']['tmp_name'] as $key => $value){
                            if($_FILES['nvoPrueba']['size'][$key] > $docSize){
                                $arrResponse = array('status' => false, 'msg' => 'La prueba no puede pesar más de 5MB ●︿●');
                                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                                exit();
                            }
                            else if(!in_array($_FILES['nvoPrueba']['type'][$key],  $extension)){
                                $arrResponse = array('status' => false, 'msg' => 'Extensión no valida: Solo se aceptan archivos de Word, Excel, Power Point o PDF'); 
                                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                                exit(); 
                            }
                        }//end foreach de validacion de los archivos de las nuevas cadenas

                        //Se toma el valor de las cadenas existentes y se le suma uno para continuar la numeracion de las nuevas cadenas
                        $p= sizeof($strOrigen) + 1;
                        $i= 0;
                        //se suben los archivos de las nuevas cadenas
                        foreach ($_FILES['nvoPrueba']['tmp_name'] as $key => $value){
                            //ruta default si no se sube ningun archivo
                            if($_FILES['nvoPrueba']['name'][$key] == ''){
                                $urlDoc = '../PAM/resources/img/icons/docs.png';
                            }
                            //se genera la ruta donde se subiran los archivos y que se guardara en la DB
                            else if(in_array($_FILES['nvoPrueba']['type'][$key], $extension)){  
                                $root='../PAM/resources/';                    //regresamos al directorio raiz
                                $pruebasDir=$root.'pruebas';    //Creamos la carpeta pruebas en la carpeta raiz si no existe
                                if(!is_dir($pruebasDir)){
                                    mkdir($pruebasDir);
                                }
                                $idDir=$pruebasDir.'/Reporte_00'.$intIdReporte.'/';     //Creamos la carpeta del reporte para sus pruebas
                                if(!is_dir($idDir)){
                                    mkdir($idDir);
                                }
                                 //Extraemos la extension del archivo
                                 $ext = pathinfo($_FILES['nvoPrueba']['name'][$key], PATHINFO_EXTENSION);
                                 $urlDoc =$idDir.'Rep_00'.$intIdReporte.'_prueba_'.$p++. '.'.$ext;
                                //Si el archivo no existe se crea en la carpeta
                                if(!file_exists($urlDoc)){
                                    $pruebaUrl=@move_uploaded_file($_FILES['nvoPrueba']['tmp_name'][$key], $urlDoc);                                     
                                }  
                            }
                            //se inserta la informacion de las nuevas evidencias a la db
                            $request_nvaEv = $this->model->insertNewEvidencia($strNvoOrigen[$i], $strNvoFechaCad[$i], $strNvoRazon[$i], $strNvoDestino[$i], $intIdReporte, $urlDoc);
                            $i++;
                            $accion= 35;  //crearCadena de Evidencia 
                            $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                            $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                            //actualizamos la informacion general del reporte
                            $request_rep = $this->model->updateReporte($strTitulo, $strFechaInc, $strIncidente, $strCaso, $intConsentimiento, $strEtiqueta, $strModelo, $strFabricante, $strNumSerie, $intIdPersona, $strDescripcion, $strDisposicion, $strFechaF, $_SESSION['userData']['user_id'], $intIdReporte);
                            $accion= 31; //editar reporte;
                            $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                            $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser); 
                             //actualizamos las cadenas de evidencias existentes
                            $e= 1;
                            $j= 0;

                            //Se actualizan los archivos y rutas de las cadenas existentes si estas son modificadas
                            foreach ($_FILES['prueba']['tmp_name'] as $key => $value){
                                if($_FILES['prueba']['name'][$key] == ''){
                                    //se consulta la ruta del archivo y esta se mantiene si no se sube ningun archivo
                                    $arrData= $this->model->selectEvidencias($intIdReporte);
                                    //var_dump($arrData[$j]['prueba']);
                                    $urlDoc = $arrData[$j]['prueba'];
                                }
                                else if(in_array($_FILES['prueba']['type'][$key], $extension)){  
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
                                     $urlDoc =$idDir.'Rep_00'.$intIdReporte.'_prueba_'.$e++. '.'.$ext;
                                    //subimos o reemplazamos el archivo si ya existe
                                    if(!file_exists($urlDoc) || file_exists($urlDoc) ){
                                        $pruebaUrl=@move_uploaded_file($_FILES['prueba']['tmp_name'][$key], $urlDoc); 
                                    }  
                                }
                                //Se actualiza la informacion de las evidencias existentes
                                $request_ev = $this->model->updateEvidencia($strOrigen[$j], $strFechaCad[$j], $strRazon[$j], $strDestino[$j], intval($_POST['idEvidencia'.$j]), $intIdReporte,  $urlDoc);
                                $j++;
                                $accion= 36;  //crearCadena de Evidencia
                                $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                                $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);             
                            } //fin foreach que actualiza las cadenas y archivos ya existentes del reporte
                        } //fin Foreach cuando se agregan nuevs cadenas al reporte
                    }

                    //si no se agregan nuevas cadenas al reporte solo actualizamos la informacion de las ya existentes
                    else{
                        //se actualiza informacion general de reporte
                        $request_rep = $this->model->updateReporte($strTitulo, $strFechaInc, $strIncidente, $strCaso, $intConsentimiento, $strEtiqueta, $strModelo, $strFabricante, $strNumSerie, $intIdPersona, $strDescripcion, $strDisposicion, $strFechaF, $_SESSION['userData']['user_id'], $intIdReporte);
                        $accion= 31; //editar reporte;
                        $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);    
                        //actualizamos las cadenas de evidencias existentes
                        $e= 1;
                        $j= 0;
                        foreach ($_FILES['prueba']['tmp_name'] as $key => $value){
                            if($_FILES['prueba']['name'][$key] == ''){
                                //se consulta la ruta del archivo y esta se mantiene si no se sube ningun archivo
                                $arrData= $this->model->selectEvidencias($intIdReporte);
                                //var_dump($arrData[$j]['prueba']);
                                $urlDoc = $arrData[$j]['prueba'];
                            }
                            else if(in_array($_FILES['prueba']['type'][$key], $extension)){  
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
                                 $urlDoc =$idDir.'Rep_00'.$intIdReporte.'_prueba_'.$e++. '.'.$ext;
                                 //subimos o reemplazamos el archivo si ya existe
                                if(!file_exists($urlDoc) || file_exists($urlDoc)){
                                    $pruebaUrl=@move_uploaded_file($_FILES['prueba']['tmp_name'][$key], $urlDoc); 
                                }  
                            }
                            $request_ev = $this->model->updateEvidencia($strOrigen[$j], $strFechaCad[$j], $strRazon[$j], $strDestino[$j], intval($_POST['idEvidencia'.$j]), $intIdReporte,  $urlDoc);
                            $j++;
                            $accion= 36;  //crearCadena de Evidencia
                            $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                            $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);             
                        }//fin foreach para actualizar las cedenas deevidencias existentes
                    } //end if
                    /*
                        FIN DE NOTA
                    */

                    //si se actulizan o se crean nuevas cadenas mandamos mensaje de confirmacion                               
                    if($request_rep > 0 || $request_ev >0) {
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        $arrResponse = array('status' => true, 'msg' => 'El reporte y las cadenas de custodía se han actualizado correctamente (◕‿◕)');                       
                    }
                    
                    else if($request_rep == 0){
                        $arrResponse = array('status' => false, 'msg' => 'No se ha podido actualizar el reporte (¯ ヘ ¯)');
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