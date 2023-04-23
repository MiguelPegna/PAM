<?php
    class LogosModel extends Mysql{
        public $intIdUser;
        public $intIdAccion;
        public $strIpUser;
        public $strNomLogo;
        public $intAnho;
        public $intLogoPara;
        public $strUrlLogo; 

        public $intIdLogoMin;
        public $intIdPiePagMin;
        
        public $intIdLogoIzqRep;
        public $intIdLogoDerRep;
        public $intIdPiePagRep;


        public function __construct(){
            parent::__construct();
        }

        //guardar logo
        public function insertLogos(string $nomLogo, int $anho, int $logoPara, string $urlLogo){
            $return ='';
            $this->strNomLogo =$nomLogo;
            $this->intAnho =$anho;
            $this->intLogoPara =$logoPara;
            $this->strUrlLogo =$urlLogo;
            $return=0;
            $sql ="SELECT logo_id FROM logos WHERE logo_nombre='$this->strNomLogo' AND logo_anho= $this->intAnho AND logo_estado=1;";
            $request = $this->select_all($sql);
            
            if(empty($request)){
                $query_insert = "INSERT INTO logos(logo_nombre, logo_url, logo_anho, logo_para) VALUES(?,?,?,?);";
                $arrData = array($this->strNomLogo, $this->strUrlLogo, $this->intAnho, $this->intLogoPara);
                $request_insert= $this->insert($query_insert, $arrData);
                $return = $request_insert;
            }
            else{
                $return = 0;
            }
            return $return;
        }

        //actualizar logo de minutas en uso
        public function selectLogoMin(int $logoMin, int $piePag){
            $this->intIdLogoMin= $logoMin;
            $this->intIdPiePagMin= $piePag;
            $sql ="SELECT logo_estado FROM logos WHERE logo_para=1 OR logo_para=4;";
            $request = $this->select_all($sql);
            
            if($request >0){
                $sql = "UPDATE logos SET logo_estado=? WHERE logo_para=1 OR logo_para=4;";
                $arrData = array(0);
                $request= $this->update($sql, $arrData);

                $sql = "UPDATE logos SET logo_estado=1 WHERE logo_id=? OR logo_id=?;";
                $arrData = array($this->intIdLogoMin, $this->intIdPiePagMin);
                $request= $this->update($sql, $arrData);
            }
            else{
                $request = 0;
            }
            return $request;
        }

        //actualizar logos de reportes en uso
        public function selectLogoRep(int $logoIzqRep, int $logoDerRep, int $piePagRep){
            $this->intIdLogoIzqRep= $logoIzqRep;
            $this->intIdLogoDerRep= $logoDerRep;
            $this->intIdPiePagRep= $piePagRep;
            $sql ="SELECT logo_estado FROM logos WHERE logo_para=2 OR logo_para=3 OR logo_para=4;";
            $request = $this->select_all($sql);
            
            if($request >0){
                $sql = "UPDATE logos SET logo_estado=? WHERE logo_para=2 OR logo_para=3 OR logo_para=4;";
                $arrData = array(0);
                $request= $this->update($sql, $arrData);

                $sql = "UPDATE logos SET logo_estado=1 WHERE logo_id=? OR logo_id=? OR logo_id=?;";
                $arrData = array($this->intIdLogoIzqRep, $this->intIdLogoDerRep, $this->intIdPiePagRep);
                $request= $this->update($sql, $arrData);
            }
            else{
                $request = 0;
            }
            return $request;
        }

        //consultar logos para el uso de las minutas
        public function selectLogosMinC(){
            $sql="SELECT logo_id, logo_nombre FROM logos WHERE logo_para=1";
            $request = $this->select_all($sql);
            return $request;
        }       
        //consultar logos para el uso de los reportes
        public function selectLogosRepCI(){
            $sql="SELECT logo_id, logo_nombre FROM logos WHERE logo_para=2";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar logos para el uso de los reportes
        public function selectLogosRepCD(){
            $sql="SELECT logo_id, logo_nombre FROM logos WHERE logo_para=3";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar logos para el uso de los reportes
        public function selectPiePagC(){
            $sql="SELECT logo_id, logo_nombre FROM logos WHERE logo_para=4";
            $request = $this->select_all($sql);
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