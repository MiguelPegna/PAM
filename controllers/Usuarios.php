<?php
    class Usuarios extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function usuarios ($params){
            $data['page_id'] = 'p_usuarios';
            $data['page_title'] = '.:Lista Usuarios:.';
            $data['page_tag'] = 'Lista Usuarios';
            $data['page_name'] = 'Lista Usuarios';
            $data['page_scripts']='<script type="text/javascript" src="'.assets().'js/usuarios-tab.js"></script><script type="text/javascript" src="'.assets().'js/validaForm.js"></script><script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>';
            $this->views->getView($this, 'usuarios', $data);
        }

         //mostrar todos los usuarios de la DB
         public function getUsers(){
            $arrData = $this->model->selectUsers();
            //dep($arrData);
            for($i=0; $i<count($arrData); $i++){
                if($arrData[$i]['user_estado']==1){
                    $arrData[$i]['user_estado'] = '<span class="badge">Usuario Activo <img src="'.assets().'img/icons/1.png" width="15"></span>';
                }
                
                $arrData[$i]['user_actions'] ='<div class="text-center"> 
                                                        <a data-toggle="modal" data-target="#usuario" title="EDITAR USUARIO" role="button" class="btn btn-default bEditUser" rl="'.$arrData[$i]['user_id'].'"><span class="glyphicon glyphicon-pencil"></span></a>
                                                        <button title="BORRAR USUARIO" role="button" class="btn btn-default bDelUser" rl="'.$arrData[$i]['user_id'].'"><span class="glyphicon glyphicon-trash"></span></button>
                                                    </div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        //obtener usuarios por select
        public function getSelectUsers(){
            $options ='';
            $arrData= $this->model->selectUsersC();
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    $options .='<option value="'.$arrData[$i]['user_id'] .'">'.$arrData[$i]['user_nom'].' '. $arrData[$i]['user_ap'].' '. $arrData[$i]['user_am'].' </option> ';
                }
            }
            echo $options;
            die();
        }

        //mostrar un usuario de la DB
        public function getUser($iduser){
			$intIdUser = intval($iduser);
			if($intIdUser > 0){
				$arrData = $this->model->selectUser($intIdUser);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

        //actualizar usuario
        public function setUser(){
            //dep($_POST);
            //die();
            //declaracion de variables recibidas por POST
            if(!empty($_POST)){
                $intIdUser = intval($_POST['idUser']);
		    	$strNombre =  ucwords(strtolower(strClean($_POST['nombre'])));
		    	$strApe_p = ucwords(strtolower(strClean($_POST['apellidoP'])));
		    	$strApe_m =  ucwords(strtolower(strClean($_POST['apellidoM'])));
		    	$intUnidad = intval($_POST['unidad']);
		    	$intCargo = intval($_POST['cargo']);
		    	$intRol = intval($_POST['rol']);
		    	$intTitulo = intval($_POST['titulo']);
		    	$strMail = strtolower(strClean($_POST['mail']));

                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if ($strNombre || $strApe_p || $strApe_m || $strMail){    
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                #Se comprueba dirección de correo valida 
                else if(!esMail($strMail)){
                    $arrResponse= array('status' => false, 'msg' => 'Escribe una dirección de correo valida >=[ ');
                }
  
                if($intIdUser >0){
                    $request_user = $this->model->updateUser($intIdUser, $strNombre, $strApe_p, $strApe_m, $intUnidad, $intCargo, $intRol, $intTitulo, $strMail);
                    $accion= 2; //'Actualizar user';
                    $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                    $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                }
                else{
                    $arrResponse = array('status' => true, 'msg' => 'En esta seción no se puede agregar un nuevo usuario');
                }
               
                //mandamos respuesta 
                if($request_user >0){
                    $arrResponse = array('status' => true, 'msg' => 'Los datos de usuario se han actualizado (⌒‿⌒)');
                }
                else if($request_user == 0){
                    $arrResponse = array('status' => false, 'msg' => 'El mail esta asociado a otra cuenta de usuario (¯ ヘ ¯)');
                }
                else{
                    $arrResponse = array("status" => false, "msg" => 'No se pudo ejecutar ninguna acción ┌∩┐(◣_◢)┌∩┐');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function delUser(){
            if($_POST){
                $intIdUser = intval($_POST['idUser']);
                $requestDel = $this->model->deleteUser($intIdUser);
                if($requestDel ==1){
                    $arrResponse = array('status' => true, 'msg' => 'El usuario ha sido inactivado');
                    $accion=3; //inactivar usuario
                    $ipUser= $_SERVER['REMOTE_ADDR']; 
                    $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                }
                else if($requestDel ==0){
                    $arrResponse = array('status' => false, 'msg' => 'Este usuario ya se encuentra inactivo');
                }
                else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al ejecutar la acción');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

    } //end class
?>