
<?php
    class Permisos extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function getPermisosRol($idrol){
            $rol_id = intval($idrol);
            if($rol_id > 0){
                $arrModulos = $this->model->selectModulos();
                $arrPermisosRol = $this->model->selectPermisosRol($rol_id);
                $arrPermisos = array('leer' => 0, 'crear' => 0, 'modif' => 0, 'borrar' => 0);
                $arrPermisoRol = array('idRol' => $rol_id);
                

                if(empty($arrPermisosRol)){
                    for($i=0; $i < count($arrModulos); $i++){
                        $arrModulos[$i]['permisos'] = $arrPermisos;
                    }
                }
                else{
                    for($i=0; $i < count($arrModulos); $i++){
                        $arrPermisos = array('leer' => 0, 'crear' => 0, 'modif' => 0, 'borrar' => 0);
                        if(isset($arrPermisosRol[$i])){
                            $arrPermisos = array('leer' => $arrPermisosRol[$i]['permiso_leer'],    //permiso_leer es la columna de la tabla permisos 
                                            'crear' => $arrPermisosRol[$i]['permiso_crear'],
                                            'modif' => $arrPermisosRol[$i]['permiso_modif'],
                                            'borrar' => $arrPermisosRol[$i]['permiso_borrar']
                                            );
                        }
                        $arrModulos[$i]['permisos'] = $arrPermisos;
                        
                    }
                }
                $arrPermisoRol['modulos'] = $arrModulos;
                $html = getModal('rolPermisos', $arrPermisoRol); 
                //dep($arrModulos);
                //dep($arrPermisosRol);
                //dep($arrPermisoRol);
            }
            die();
        }

        public function setPermisos(){
            //dep($_POST);
            if($_POST){
                $intIdRol = intval($_POST['idRol']); //proviene del name del hidden del id rol del form permisos
                $modulos = $_POST['modulos'];  //proviene de los checks del form permisos
                $ipUser= $_SERVER['REMOTE_ADDR'];

                $this->model->deletePermisos($intIdRol);
                foreach ($modulos as $modulo) {
					$idModulo = $modulo['mod_id'];
                    
					$leer = empty($modulo['leer']) ? 0 : 1;
					$crear = empty($modulo['crear']) ? 0 : 1;
					$modif = empty($modulo['modif']) ? 0 : 1;
					$borrar = empty($modulo['borrar']) ? 0 : 1;
                    $requestPermiso = $this->model->insertPermisos($intIdRol, $idModulo, $leer, $crear, $modif, $borrar);
                    $accion=24; //crear permisos
                    $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                }

                if($requestPermiso >0){
                    $arrResponse = array('status' => true, 'msg' => 'Permisos asignados');
                }
                else{
                    $arrResponse = array('status' => true, 'msg' => 'No se pudo realizar ninguna acción');
                }
                //echo $leer. '-' .$crear.'-' .$modif.'-'. $borrar;
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }    
    }
?>