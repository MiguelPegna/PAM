<?php
    class TitulosModel extends Mysql{
        public $intIdTitulo;
        public $strTitulo;
        public $strAbr;


        public function __construct(){
            parent::__construct();
        }

        //consultar todos los titulos de la DB
        public function selectTitulos(){
            $sql="SELECT * FROM titulos WHERE titulo_estado=1";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar titulo de usuario
        public function selectTitulo(int $idtitulo){
            $this->intIdTitulo = $idtitulo;
            $sql="SELECT * FROM titulos WHERE titulo_id = $this->intIdTitulo";
            $request = $this->select($sql);
            return $request;
        }

        //guardar titulos
        public function insertTitulo(string $abr, string $titulo){
            $return ='';
            $this->strAbr =$abr;
            $this->strTitulo =$titulo;
            $sql ="SELECT * FROM titulos WHERE titulo_nom='{$this->strTitulo}';";
            $request = $this->select_all($sql);
            
            if(empty($request)){
                $query_insert = "INSERT INTO titulos(titulo_abr, titulo_nom) VALUES(?,?);";
                $arrData = array($this->strAbr, $this->strTitulo);
                $request_insert= $this->insert($query_insert, $arrData);
                $return = $request_insert;
            }
            else{
                $return = 0;
            }
            return $return;
        }

        //actualizar registro 
        public function updateTitulo(int $idtitulo, string $abr, string $titulo){
            $this->intIdTitulo = $idtitulo;
            $this->strAbr = $abr;
            $this->strTitulo = $titulo;
            $sql="SELECT * FROM titulos WHERE titulo_nom= '$this->strTitulo' AND titulo_id != $this->intIdTitulo";
            $request=$this->select_all($sql);

            if(empty($request)){
                $sql="UPDATE titulos SET titulo_abr =?, titulo_nom= ? WHERE titulo_id= $this->intIdTitulo";
                $arrData= array($this->strAbr, $this->strTitulo);
                $request= $this->update($sql, $arrData);
            }
            else{
                $request= 0;
            }
            return $request;
        }

        //borrar titulo
        public function deleteTitulo(int $idtitulo){
            $this->intIdTitulo = $idtitulo;
            $sql ="SELECT user_titulo FROM usuarios WHERE user_titulo= $this->intIdTitulo";
            $request= $this->select_all($sql);
            if(empty($request)){
                $sql = "UPDATE titulos SET titulo_estado=? WHERE titulo_id= $this->intIdTitulo";
                $arrData = array(0);
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