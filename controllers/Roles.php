<?php
    class Roles extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function roles ($params){
            $data['page_id'] = 'p_roles';  //elemto para hcer distincion para llamar los scripts del controlador
            $data['page_title'] = '.:Lista de Roles:.';
            $data['page_tag'] = 'lista_roles';
            $data['page_name'] = 'Roles de Usuario';
            $data['page_scripts']='<script src="'.assets().'js/roles-tab.js"></script>';
            $this->views->getView($this, 'roles', $data);
        }

        //mostrar todos los roles de la DB
        public function getRoles(){
            $arrData = $this->model->selectRoles();
            //dep($arrData);
            for($i=0; $i<count($arrData); $i++){
                if($arrData[$i]['rol_estado']==1){
                    $arrData[$i]['rol_estado'] = '<span class="badge">Rol Activo <img src="'.assets().'img/icons/1.png" width="15"></span>';
                }
                else{
                    $arrData[$i]['rol_estado'] = '<span class="badge">Rol Inactivo <img src="'.assets().'img/icons/0.png" width="15"></span>';
                }
                $arrData[$i]['rol_actions'] ='<div class="text-center">
                                                        <button title="PERMISOS ROL" role="button" class="btn btn-default bKeyRol" rl="'.$arrData[$i]['rol_id'].'"><span class="glyphicon glyphicon-lock"></span></button>
                                                        <a data-toggle="modal" data-target="#rol" title="EDITAR ROL" role="button" class="btn btn-default bEditRol" rl="'.$arrData[$i]['rol_id'].'"><span class="glyphicon glyphicon-pencil"></span></a>
                                                        <button title="INACTIVAR ROL" role="button" class="btn btn-default bDelRol" rl="'.$arrData[$i]['rol_id'].'"><span class="glyphicon glyphicon-trash"></span></button>
                                                    </div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        //obtener roles por select
        public function getSelectRoles(){
            $options ='';
            $arrData= $this->model->selectRoles();
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    $options .='<option value="'.$arrData[$i]['rol_id'] .'">'.$arrData[$i]['rol_nombre'].' </option> ';
                }
            }
            echo $options;
            die();
        }

        //mostrar un rol de la DB
        public function getRol($idrol){
			$intIdrol = intval(strClean($idrol));
			if($intIdrol > 0){
				$arrData = $this->model->selectRol($intIdrol);
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

        public function setRol(){
            //dep($_POST);
            $intIdRol = intval($_POST['idRol']);
			$strRol =  strClean($_POST['rol']);
			$intStatus = intval($_POST['listStatus']);
            $ipUser= $_SERVER['REMOTE_ADDR'];
            
            if($intIdRol ==0){
                $request_rol = $this->model->insertRol($strRol);
				$option = 1;
                $accion= 15; //Crear Rol; 
                $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);     
            }
            else{
                $request_rol = $this->model->updateRol($intIdRol, $strRol, $intStatus);
				$option = 2;
                $accion= 16; //'Actualizar Rol';
                $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
            }
            
            //mandamos respuesta 
            if($request_rol >0){
                if($option == 1){
                    $arrResponse = array('status' => true, 'msg' => 'El rol se ha agregado correctamente (◕‿◕)');
                    $accion=17; //eliminar rol
                    $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                }
                else{
                    $arrResponse = array('status' => true, 'msg' => 'El rol ha sido actualizado (⌒‿⌒)');
                }
            }
            else if($request_rol == 0){
                $arrResponse = array('status' => false, 'msg' => 'El nombre de rol ya existe (¯ ヘ ¯)');
            }
            else{
				$arrResponse = array("status" => false, "msg" => 'No fue posible agregar el rol a la DB ┌∩┐(◣_◢)┌∩┐');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
        }

        public function delRol(){
            if($_POST){
                $intIdRol = intval($_POST['idrol']);
                $requestDel = $this->model->deleteRol($intIdRol);
                if($requestDel ==1){
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el rol');
                }
                else if($requestDel ==0){
                    $arrResponse = array('status' => false, 'msg' => 'Rol en uso... No se puede eliminar');
                }
                else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al ejecutar la acción');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?> 