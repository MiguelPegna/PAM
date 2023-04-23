<?php
    class RolesModel extends Mysql{
        public $intIdRol;
        public $strRol;
        public $intStatus;

        public function __construct(){
            parent::__construct();
        }

        //consultar roles de la DB
        public function selectRoles(){
            $sql="SELECT * FROM roles WHERE rol_estado !=2";
            $request = $this->select_all($sql);
            return $request;
        }
        //consultar rol de usuario
        public function selectRol(int $idrol){
            $this->intIdRol = $idrol;
            $sql="SELECT * FROM roles WHERE rol_id = $this->intIdRol";
            $request = $this->select($sql);
            return $request;
        }

        //guardar roles
        public function insertRol(string $rol){
            $return ='';
            $this->strRol =$rol;
            $sql ="SELECT * FROM roles WHERE rol_nombre='{$this->strRol}';";
            $request = $this->select_all($sql);
            
            if(empty($request)){
                $query_insert = "INSERT INTO roles(rol_nombre) VALUES(?);";
                $arrData = array($this->strRol);
                $request_insert= $this->insert($query_insert, $arrData);
                $return = $request_insert;
            }
            else{
                $return = 0;
            }
            return $return;
        }

        //actualizar registro 
        public function updateRol(int $idrol, string $rol, int $status){
            $this->intIdRol = $idrol;
            $this->strRol = $rol;
            $this->intStatus = $status;
            $sql="SELECT * FROM roles WHERE rol_nombre= '$this->strRol' AND rol_id != $this->intIdRol";
            $request=$this->select_all($sql);

            if(empty($request)){
                $sql="UPDATE roles SET rol_nombre =?, rol_estado= ? WHERE rol_id= $this->intIdRol";
                $arrData= array($this->strRol, $this->intStatus);
                $request= $this->update($sql, $arrData);
            }
            else{
                $request= 0;
            }
            return $request;
        }

        //borrar rol
        public function deleteRol(int $idrol){
            $this->intIdRol = $idrol;
            $sql ="SELECT user_rol FROM usuarios WHERE user_rol= $this->intIdRol";
            $request= $this->select_all($sql);
            if(empty($request)){
                $sql = "UPDATE roles SET rol_estado=? WHERE rol_id= $this->intIdRol";
                $arrData = array(2);
                $request= $this->update($sql, $arrData);
                if($request){
                    $request=1;
                }
                else{
                    $request=2;
                }
            }
            else{
                $request= 0;
            }
            return $request;
        }

         //registrar accion hecha
         public function historial(int $idUser, int $idAccion, string $ipUser){
            $return ='';
            $this->intIdUser =$idUser;
            $this->intIdAccion =$idAccion;
            $this->strIpUser =$ipUser;
            $return=0;

            $query_insert = "INSERT INTO historial(hist_user, hist_accion, hist_ip) VALUES(?,?,?);";
            $arrData = array($this->intIdUser, $this->intIdAccion, $this->strIpUser);
            $request_insert= $this->insert($query_insert, $arrData);
            $return = $request_insert;

            if($return){
                $return = 1;  
            }
            else{
                $return = 0;
            }
            return $return;
        }
    }
?>