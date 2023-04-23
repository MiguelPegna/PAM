<?php
    class EditarMin extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function editarMin ($params){
            $data['page_id'] = 'p_minutas';
            $data['page_title'] = '.:Editar Minuta:.';
            $data['page_tag'] = 'minutas';
            $data['page_name'] = 'Editar Minuta';
            $data['page_scripts']='<script src="'.assets().'js/editarMin.js"></script><script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>'; 
            $this->views->getView($this, 'editarMin', $data);
        }

        //obtener info de la minuta
        public function getMinuta($idMinuta){
            $intIdMinuta = intval(strClean($idMinuta));
            if($intIdMinuta>0){
                $arrData = $this->model->selectMinuta($intIdMinuta);
                if(empty($arrData))	{
					$arrResponse = array('status' => false, 'msg' => 'Minuta no existente en la base de datos');
                }
                else{
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
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

        //obtener participantey acuerdos
        public function getAcuerdos($idMinuta){
            $intIdMinuta = intval(strClean($idMinuta));
            $acuerdo ='';
            $arrData= $this->model->selectAcuerdos($intIdMinuta);
            if(count($arrData) > 0){
                $k=0;
                for($i=0; $i < count($arrData); $i++){
                    $evidencia .='<tr>
                    <td class="form-control">
                        <input type="checkbox" class="check" name="chk"/>
                     </td>

                    <td class="col-md-6 td-a"> 			
                        <input type="hidden" id="idAcuerdo[]" name="idAcuerdo'.$k++.'" value="'.$arrData[$i]['id'].'">
                        
                        <input type="text" class="form-control tituloA" id="tituloA[]" name="tituloA[]" autocomplete="off" value="'.$arrData[$i]['origen'] .'"/>
                     </td>

                    <td class="col-md-2 td-a">
                        <input type="date" class="form-control fechaA" id="fechaA[]" name="fechaA[]" autocomplete="off" value="'.$arrData[$i]['fecha'] .'" />
                     </td>

                     <td class="col-md-4 td-a"> 			
                        <input type="text" class="form-control responsable" id="responsable[]" name="responsable[]" autocomplete="off" value="'.$arrData[$i]['razon'] .'" />
                     </td>

                </tr>';
                }
            }
            echo $acuerdo;
            die();
        }

        public function setMinuta(){
            //dep($_POST);
            
            
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

    } //end class
?>