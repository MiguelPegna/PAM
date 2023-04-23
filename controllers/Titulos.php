<?php
    class Titulos extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function titulos ($params){
            $data['page_id'] = 'p_titulos';
            $data['page_title'] = '.:Lista de Titulos:.';
            $data['page_tag'] = 'lista_titulos';
            $data['page_name'] = 'Lista de Titulos';
            $data['page_scripts']='<script src="'.assets().'js/titulos-tab.js"></script>';
            $this->views->getView($this, 'titulos', $data);
        }

        //mostrar todos los titulos de la DB
        public function getTitulos(){
            $arrData = $this->model->selectTitulos();
            //dep($arrData);
            for($i=0; $i<count($arrData); $i++){
                $arrData[$i]['titulo_actions'] ='<div >
                                                        <a data-toggle="modal" data-target="#titulo" title="EDITAR TITULO" role="button" class="btn btn-default bEditTitulo" rl="'.$arrData[$i]['titulo_id'].'"><span class="glyphicon glyphicon-pencil"></span></a>
                                                        <button title="BORRAR TITULO" role="button" class="btn btn-default bDelTitulo" rl="'.$arrData[$i]['titulo_id'].'"><span class="glyphicon glyphicon-trash"></span></button>
                                                    </div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        //obtener titulos para select
        public function getSelectTitulos(){
            $options ='<option value="">N/A</option>';
            $arrData= $this->model->selectTitulos();
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    $options .='<option value="'.$arrData[$i]['titulo_id'] .'">'.$arrData[$i]['titulo_nom'].' </option> ';
                }
            }
            echo $options;
            die();
        }

        //mostrar un titulo de la DB
        public function getTitulo($idtitulo){
			$intIdTitulo = intval(strClean($idtitulo));
			if($intIdTitulo > 0){
				$arrData = $this->model->selectTitulo($intIdTitulo);
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

        public function setTitulo(){
            //dep($_POST);
            $intIdTitulo = intval($_POST['idTitulo']);
			$strTitulo =  strClean($_POST['titulo']);
			$strAbr =  strClean($_POST['abr']);
            $ipUser= $_SERVER['REMOTE_ADDR'];
            
            if($intIdTitulo ==0){
                $request_titulo = $this->model->insertTitulo($strAbr, $strTitulo);
				$option = 1;
                $accion= 21; //Crear Titulo; 
                $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
            }
            else{
                $request_titulo = $this->model->updateTitulo($intIdTitulo, $strAbr, $strTitulo);
				$option = 2;
                $accion= 22; //'Actualizar Titulo';
                $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
            }
            
             //mandamos respuesta 
             if($request_titulo >0){
                if($option == 1){
                    $arrResponse = array('status' => true, 'msg' => 'El titulo se ha agregado correctamente (◕‿◕)');
                }
                else{
                    $arrResponse = array('status' => true, 'msg' => 'El titulo ha sido actualizado (⌒‿⌒)');
                }
            }
            else if($request_titulo == 0){
                $arrResponse = array('status' => false, 'msg' => 'Este titulo ya existe (¯ ヘ ¯)');
            }
            else{
				$arrResponse = array("status" => false, "msg" => 'No fue posible agregar el titulo a la DB ┌∩┐(◣_◢)┌∩┐');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
        }

        public function delTitulo(){
            if($_POST){
                $intIdTitulo = intval($_POST['idtitulo']);
                $requestDel = $this->model->deleteTitulo($intIdTitulo);
                $ipUser= $_SERVER['REMOTE_ADDR'];
                
                if($requestDel ==1){
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el titulo');
                    $accion=23;  //elimar titulo
                    $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                }
                else if($requestDel ==0){
                    $arrResponse = array('status' => false, 'msg' => 'Titulo en uso... No se puede eliminar');
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