<?php
    class Cargos extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function cargos ($params){
            $data['page_id'] = 'p_cargos';
            $data['page_title'] = '.:Lista de Cargos:.';
            $data['page_tag'] = 'lista_cargos';
            $data['page_name'] = 'Lista de Cargos';
            $data['page_scripts']='<script src="'.assets().'js/cargos-tab.js"></script>';
            $this->views->getView($this, 'cargos', $data);
        }

        //mostrar todos los roles de la DB
        public function getCargos(){
            $arrData = $this->model->selectCargos();
            //dep($arrData);
            for($i=0; $i<count($arrData); $i++){
                if($arrData[$i]['cargo_tipo']==1){
                    $arrData[$i]['cargo_tipo'] = '<span class="badge">Cargo Interno <img src="'.assets().'img/icons/1.png" width="15"></span>';
                }
                else{
                    $arrData[$i]['cargo_tipo'] = '<span class="badge">Cargo Externo <img src="'.assets().'img/icons/0.png" width="15"></span>';
                }
                $arrData[$i]['cargo_actions'] ='<div >
                                                        <a data-toggle="modal" data-target="#cargo" title="EDITAR CARGO" role="button" class="btn btn-default bEditCargo" rl="'.$arrData[$i]['cargo_id'].'"><span class="glyphicon glyphicon-pencil"></span></a>
                                                        <button title="BORRAR CARGO" role="button" class="btn btn-default bDelCargo" rl="'.$arrData[$i]['cargo_id'].'"><span class="glyphicon glyphicon-trash"></span></button>
                                                    </div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        //obtener cargos para select
        public function getSelectCargos(){
            $options ='';
            $arrData= $this->model->selectCargosUtic();
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    $options .='<option value="'.$arrData[$i]['cargo_id'] .'">'.$arrData[$i]['cargo_nom'].' </option> ';
                }
            }
            echo $options;
            die();
        }

        //mostrar un rol de la DB
        public function getCargo($idcargo){
			$intIdCargo = intval(strClean($idcargo));
			if($intIdCargo > 0){
				$arrData = $this->model->selectCargo($intIdCargo);
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

        public function setCargo(){
            //dep($_POST);
            $intIdCargo = intval($_POST['idCargo']);
			$strCargo =  strClean($_POST['cargo']);
			$intTipo = intval($_POST['listStatus']);
            $ipUser= $_SERVER['REMOTE_ADDR'];
            
            if($intIdCargo ==0){
                $request_cargo = $this->model->insertCargo($strCargo, $intTipo);
				$option = 1;
                $accion= 18; //Crear Cargo; 
                $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);    
            }
            else{
                $request_cargo = $this->model->updateCargo($intIdCargo, $strCargo, $intTipo);
				$option = 2;
                $accion= 19; //'Actualizar Cargo';
                $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
            }
            
             //mandamos respuesta 
             if($request_cargo >0){
                if($option == 1){
                    $arrResponse = array('status' => true, 'msg' => 'El cargo se ha agregado correctamente (◕‿◕)');
                }
                else{
                    $arrResponse = array('status' => true, 'msg' => 'El cargo ha sido actualizado (⌒‿⌒)');
                }
            }
            else if($request_cargo == 0){
                $arrResponse = array('status' => false, 'msg' => 'El nombre de cargo ya existe (¯ ヘ ¯)');
            }
            else{
				$arrResponse = array("status" => false, "msg" => 'No fue posible agregar el cargo a la DB ┌∩┐(◣_◢)┌∩┐');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
        }

        public function delCargo(){
            if($_POST){
                $intIdCargo = intval($_POST['idcargo']);
                $requestDel = $this->model->deleteCargo($intIdCargo);
                $ipUser= $_SERVER['REMOTE_ADDR'];
                if($requestDel ==1){
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el cargo');
                    $accion=20;
                    $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                }
                else if($requestDel ==0){
                    $arrResponse = array('status' => false, 'msg' => 'Cargo en uso... No se puede eliminar');
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