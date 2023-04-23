<?php
    class Minutas extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
            session_start();
            if(empty($_SESSION['login'])){
                header('location: ../pam');
            }
        }

        public function minutas ($params){
            $data['page_id'] = 'p_minutas';
            $data['page_title'] = '.:Crear Minuta:.';
            $data['page_tag'] = 'minutas';
            $data['page_name'] = 'Crear Minuta';
            $data['page_scripts']='<script src="'.assets().'js/minutas.js"></script><script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>'; 
            $this->views->getView($this, 'minutas', $data);
        }

        //obtener el ultimo id de la minuta
        public function getIdMinuta(){
			$idMin ='';
            $arrData= $this->model->selectIdMinuta();
            if(count($arrData) > 0){
                    $idMin .='<input type="hidden" id="idMin" name="idMin" value="'.$arrData['id']+1 .'"/>';
            }
            echo $idMin;
            die();
        }

        //obtener participantes por select
        public function getSelectParticipantes(){
            $options ='';
            $arrData= $this->model->selectParticipantesC();
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    $options .='<option value="'.$arrData[$i]['participante_id'] .'">'.$arrData[$i]['participante_nom']. '</option> ';
                }
            }
            echo $options;
            die();
        }

        public function setMinuta(){
            //dep($_POST);
            
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['fechaMin']) || empty($_POST['hora']) || empty($_POST['horaC']) || empty($_POST['lugar']) || empty($_POST['tituloMin']) || empty($_POST['cargo']) || empty($_POST['observacion']) || empty($_POST['tituloA']) || empty($_POST['fechaA']) || empty($_POST['responsable']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $strFechaMin =  $_POST['fechaMin'];
                    $strHora = $_POST['hora'];
                    $strHoraC = $_POST['horaC'];
                    $strLugar =  $_POST['lugar'];
                    $strTituloMin = $_POST['tituloMin'];
                    $intUnidadAd = intval($_POST['cargo']);
                    $strDesarrollo = $_POST['observacion'];
                    $strTitulosA = $_POST['tituloA'] ;
                    $strFechasA = $_POST['fechaA'];
                    $strResponsables = $_POST['responsable'];
                    $intIdMinuta = intval($_POST['idMin']);
                    
                    //manipulacion de array de responsables para obtener los participantes
                    //quitamos los participantes repetidos
                    $participantes = array_unique($_POST['responsable']);
                    //convertimos el array en la cadena que se guardara en la DB
                    $participantesDB = implode(',', $participantes); //De array a cadena
                    //$participantes = json_encode($_POST['responsable']); //De array a cadena en json
 
                    $integerID = array_map('intval',$participantes);
                    //se manda la peticion al metodo insert que revisara si el email ya esta registrado en la DB             
                    $request_min = $this->model->insertMinuta($strFechaMin, $strHora, $strHoraC, $strLugar, $strTituloMin, $intUnidadAd, $strDesarrollo, $participantesDB, $intIdMinuta);
                    $accion= 15; //Crear minuta;
                    $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                    
                    //mandamos respuesta 
                    if($request_min >0){
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        $arrResponse = array('status' => true, 'msg' => 'La minuta y acuerdos se han agregado correctamente (◕‿◕)');
                        for($i=0; $i<sizeof($strTitulosA); $i++){
                            $this->model->insertAcuerdo($strTitulosA[$i], $strFechasA[$i], $strResponsables[$i], $intIdMinuta);
                            $accion= 9;  //crearAcuerdo
                            $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        } //end
                        //Se envia el mail a los paticipantes de la minuta
                        //foreach($integerID as $idParticipante){                   
                        //   $this->Mail($idParticipante, $intIdMinuta);
                        //}//end
                    }
                    else if($request_min == 0){
                        $arrResponse = array('status' => false, 'msg' => 'No se pudo crear la minuta (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible agregar información a la DB ┌∩┐(◣_◢)┌∩┐');
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end function


        public function setInvitado(){
            //dep($_POST);
            
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['cargoI']) || empty($_POST['titulo']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                else if(strlen(trim($_POST['nombre'])) <8 ){   
                    $arrResponse= array('status' => false, 'msg' => 'Introduce el nombre completo del invitado >:{ ');
                }
                else if(!esMail($_POST['email'])){
                    $arrResponse= array('status' => false, 'msg' => 'Escribe una dirección de correo valida >=[ ');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $strNombre =  ucwords(strtolower(strClean($_POST['nombre'])));
                    $strMail = strtolower(strClean($_POST['email']));
                    $intTipo = intval($_POST['listStatus']);
                    $intTitulo = intval($_POST['titulo']);
                    $intCargo = intval($_POST['cargoI']);

                    //se manda la peticion al metodo insert que revisara si el email ya esta registrado en la DB             
                    $request_inv = $this->model->insertInvitado($strNombre, $strMail, $intTipo, $intTitulo, $intCargo);
                    $accion= 27; //Registrar invitado;
                    $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                    
                    //mandamos respuesta 
                    if($request_inv >0){
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                        $arrResponse = array('status' => true, 'msg' => 'El nuevo participante se ha agregado correctamente (◕‿◕)');
                    }
                    else if($request_inv == 0){
                        $arrResponse = array('status' => false, 'msg' => 'El correo electronico ya esta registrado (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible agregar información a la DB ┌∩┐(◣_◢)┌∩┐');
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end function

        //se genera el email
        public function Mail($idParticipante, $minuta){
            $arrDestinatario= $this->model->selectDestinatarioMail($idParticipante);
            $arrMinuta= $this->model->selectMinuta($minuta);
            $arrAcuerdos= $this->model->selectAcuerdos($minuta);

            $infoAcuerdos='';
            $n=0;
            $mensaje ='';
            $numReg= count($arrAcuerdos);
            if(count($arrDestinatario) > 0){
                //Cuerpo del mensaje e informacion de la minuta
                $asunto='Detalles de la minuta: ' .$arrMinuta[0]['titulo'];

                $infoMinuta='Hola! '. $arrDestinatario[0]['nombre']. ' por este medio se te informa que se te ha agregado como participante de la siguiente minuta: <br/>'
                .'<p><b> *** INFORMACION DE LA MINUTA *** </b> <br/>'
                .'<b>Titulo: </b>'.$arrMinuta[0]['titulo']. ' <br/>'
                .'<b>Lugar: </b>'.$arrMinuta[0]['lugar']. ' <br/>'
                .'<b>Fecha: </b>'.$arrMinuta[0]['fecha']. ' <br/>'
                .'<b>Hora apertura: </b>'.$arrMinuta[0]['hora']. '<br/><b> Hora de cierre: </b>' .$arrMinuta[0]['hora_cierre'] .'<br/>'
                .'<b>Desarrollo de la minuta: </b><br/>'
                .nl2br($arrMinuta[0]['desarrollo']) .'<p>'
                .'<b> *** ACUERDOS Y COMPROMISOS *** </b> <br/>';

                for ($a=0; $a< $numReg; $a++){
                    $n++;       
                    $infoAcuerdos.=$n .':<br/><b>Acuerdo: </b>' .$arrAcuerdos[$a]['titulo']. '<br/>'
                    .'<b>Responsable: </b>' .$arrAcuerdos[$a]['responsable'] .'<br/>'
                    .'<b>Fecha Entrega. </b>' .$arrAcuerdos[$a]['fecha'] .'<br/>';
                } 

                $arrPart = explode(',', $arrMinuta[0]['participantes']);
                $printR='';
                foreach ($arrPart as $participante){
                    $arrParticipantes= $this->model->selectParticipantesMin($participante);
                    $printR.= "<b>" .$arrParticipantes[0]['titulo']. " ".  $arrParticipantes[0]['nombre']. "</b><br/>".$arrParticipantes[0]['cargo'] ."<p>";
                
                }
                $mensaje= $infoMinuta .$infoAcuerdos ."<hr><p><b> *** PARTICIPANTES DE LA MINUTA *** </b><br/>" .$printR;
                enviarMail($arrDestinatario[0]['mail'], $arrDestinatario[0]['nombre'], $asunto, $mensaje);
            }
            //die();
        }

    } //end class
?>