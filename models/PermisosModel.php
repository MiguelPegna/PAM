<?php
    class PermisosModel extends Mysql{
        public $intIdPermiso;
        public $intIdRol;
        public $intIdModulo;
        public $l;
        public $c;
        public $m;
        public $b;

        public function __construct(){
            parent::__construct();
        }

        //consultar modulos de la DB
        public function selectModulos(){
            $sql="SELECT * FROM modulos WHERE mod_estado !=0";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar permisos de rol de la DB
        public function selectPermisosRol(int $idrol){
            $this->intIdRol = $idrol;
            $sql="SELECT * FROM permisos WHERE permiso_rol = $this->intIdRol";
            $request = $this->select_all($sql);
            return $request;
        }

        //remover permisos de los modulos
        public function deletePermisos(int $idrol){
            $this->intIdRol = $idrol;
			$sql = "DELETE FROM permisos WHERE permiso_rol = $this->intIdRol";
			$request = $this->delete($sql);
			return $request;
        }

        //insertar permisos a los roles
        public function insertPermisos(int $idrol, int $idModulo, int $leer, int $crear, int $modif, int $borrar){
            $this->intIdRol = $idrol;
			$this->intIdModulo = $idModulo;
			$this->l = $leer;
			$this->c = $crear;
			$this->m = $modif;
			$this->b = $borrar;
			$query_insert  = "INSERT INTO permisos(permiso_rol, permiso_mod, permiso_leer, permiso_crear, permiso_modif, permiso_borrar) VALUES(?,?,?,?,?,?)";
        	$arrData = array($this->intIdRol, $this->intIdModulo, $this->l, $this->c, $this->m, $this->b);
        	$request_insert = $this->insert($query_insert,$arrData);
            return $request_insert;
        }

        //obtener los permisos a los modulos que el rol puede igresar
        public function permisosModulo(int $idRol){
            $this->intIdRol = $idRol;
            $sql="SELECT p.permiso_rol as idRol, p.permiso_mod as idModulo, m.mod_nombre as modulo, 
                p.permiso_leer as leer, p.permiso_crear as crear, p.permiso_modif as editar, p.permiso_borrar as borrar
                FROM permisos as p
                INNER JOIN modulos as m ON p.permiso_mod = m.mod_id
                WHERE p.permiso_rol = $this->intIdRol";
            $request = $this->select_all($sql);

            $arrPermisos = array();
            for($i=0; $i< count($request); $i++){
                $arrPermisos[$request[$i]['idModulo']] = $request[$i];
            }
            return $arrPermisos;
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