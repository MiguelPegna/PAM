<?php
    class ListaMinModel extends Mysql{
        public $intIdUser;
        public $intIdMin;
        public $strIpUser;
        public $intIdAccion;
        public $intAnho;
        public $intStatus;

        public function __construct(){
            parent::__construct();
        }

        //consultar usuarios de la DB para mostrarlos en la tabla
        public function selectMinutas(){
            $sql="SELECT c.cargo_nom as unidad, m.minuta_id as id, m.minuta_titulo as titulo, m.minuta_status as estado, DATE_FORMAT(m.minuta_fecha,'%d/%m/%Y') as fecha FROM minutas as m 
            INNER JOIN cargos as c ON m.minuta_unidad_admin = c.cargo_id
            WHERE NOT minuta_status=0;";
            $request = $this->select_all($sql);
            return $request;
        }

        //obtener año del logo para minuta
        public function selectLogoMinuta($anho){
            $this->intAnho = $anho;
            $sql="SELECT logo_anho, logo_nombre, logo_url FROM logos WHERE logo_anho=$this->intAnho AND logo_para=1 AND logo_estado=1";
            $request = $this->select_all($sql);
            return $request;
        }

        //obtener año del logo para minuta
        public function selectPiePag($anho){
            $this->intAnho = $anho;
            $sql="SELECT logo_anho, logo_nombre, logo_url FROM logos WHERE logo_anho=$this->intAnho AND logo_para=3 AND logo_estado=1";
            $request = $this->select_all($sql);
            return $request;
        }

        //inactivar minuta
        public function deleteMinuta(int $idmin){
            $this->intIdMin = $idmin;
            $sql ="SELECT minuta_id, minuta_status FROM minutas WHERE minuta_id= $this->intIdMin";
            $request= $this->select_all($sql);
            if($request){
                $sql = "UPDATE minutas SET minuta_status=? WHERE minuta_id= $this->intIdMin";
                $arrData = array(0);
                $request= $this->update($sql, $arrData);
                if($request){
                    $request=1; //se ejecuto la consulta de inactivar usuario
                }
            }
            else{
                $request= 0; //este usuario ya se encuentra inactivo
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