<?php
    class Receptores extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function receptores ($params){
            $data['page_id'] = 'p_receptores';
            $data['page_title'] = '.:Lista de Receptores:.';
            $data['page_tag'] = 'lista_receptores';
            $data['page_name'] = 'Lista de Receptores';
            $data['page_scripts']='<script src="'.assets().'js/receptores-tab.js"></script>';
            $this->views->getView($this, 'receptores', $data);
        }

        //mostrar todos los roles de la DB
        public function getReceptores(){
            $arrData = $this->model->selectReceptores();
            //dep($arrData);
            for($i=0; $i<count($arrData); $i++){
                if($arrData[$i]['receptor_tipo']==1){
                    $arrData[$i]['receptor_tipo'] = '<span class="badge">Receptor Interno <img src="'.assets().'img/icons/1.png" width="15"></span>';
                }
                else{
                    $arrData[$i]['receptor_tipo'] = '<span class="badge">Receptor Externo <img src="'.assets().'img/icons/0.png" width="15"></span>';
                }
                $arrData[$i]['receptor_actions'] ='<div >
                                                        <a data-toggle="modal" data-target="#receptor" title="EDITAR RECEPTOR" role="button" class="btn btn-default bEditReceptor" rl="'.$arrData[$i]['receptor_id'].'"><span class="glyphicon glyphicon-pencil"></span></a>
                                                        <button title="BORRAR RECEPTOR" role="button" class="btn btn-default bDelReceptor" rl="'.$arrData[$i]['receptor_id'].'"><span class="glyphicon glyphicon-trash"></span></button>
                                                    </div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }


        //mostrar un rol de la DB
        public function getReceptor($idreceptor){
			$intIdReceptor = intval(strClean($idreceptor));
			if($intIdReceptor > 0){
				$arrData = $this->model->selectReceptor($intIdReceptor);
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

        public function setReceptor(){
            //dep($_POST);
            $intIdReceptor = intval($_POST['idReceptor']);
			$strReceptor =  strClean($_POST['receptor']);
			$intTipo = intval($_POST['listStatus']);
            $ipUser= $_SERVER['REMOTE_ADDR'];
            
            if($intIdReceptor ==0){
                $request_receptor = $this->model->insertReceptor($strReceptor, $intTipo, $_SESSION['userData']['user_id']);
				$option = 1;
                $accion= 18; //Crear Receptor; 
                $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);    
            }
            else{
                $request_receptor = $this->model->updateReceptor($intIdReceptor, $strReceptor, $intTipo);
				$option = 2;
                $accion= 19; //'Actualizar Receptor';
                $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
            }
            
             //mandamos respuesta 
             if($request_receptor >0){
                if($option == 1){
                    $arrResponse = array('status' => true, 'msg' => 'El receptor se ha agregado correctamente (◕‿◕)');
                }
                else{
                    $arrResponse = array('status' => true, 'msg' => 'El receptor ha sido actualizado (⌒‿⌒)');
                }
            }
            else if($request_receptor == 0){
                $arrResponse = array('status' => false, 'msg' => 'El nombre de receptor ya existe (¯ ヘ ¯)');
            }
            else{
				$arrResponse = array("status" => false, "msg" => 'No fue posible agregar el receptor a la DB ┌∩┐(◣_◢)┌∩┐');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
        }

        public function delReceptor(){
            if($_POST){
                $intIdReceptor = intval($_POST['idreceptor']);
                $requestDel = $this->model->deleteReceptor($intIdReceptor);
                $ipUser= $_SERVER['REMOTE_ADDR'];
                if($requestDel ==1){
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el receptor');
                    $accion=20;
                    $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                }
                else if($requestDel ==0){
                    $arrResponse = array('status' => false, 'msg' => 'Receptor en uso... No se puede eliminar');
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