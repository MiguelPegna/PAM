<?php
    class ReceptoresModel extends Mysql{
        public $intIdReceptor;
        public $strReceptor;
        public $intTipo;
        public $intIdUser;

        public function __construct(){
            parent::__construct();
        }

        //consultar todos los receptores de la DB
        public function selectReceptores(){
            $sql="SELECT * FROM receptores";
            $request = $this->select_all($sql);
            return $request;
        }
        //consultar todos los receptores internos de la DB
        public function selectReceptoresUtic(){
            $sql="SELECT * FROM receptores WHERE receptor_tipo = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        //consultar receptor de usuario
        public function selectReceptor(int $idreceptor){
            $this->intIdReceptor = $idreceptor;
            $sql="SELECT * FROM receptores WHERE receptor_id = $this->intIdReceptor";
            $request = $this->select($sql);
            return $request;
        }

        //guardar receptores
        public function insertReceptor(string $receptor, int $tipo, int $idUser){
            $return ='';
            $this->strReceptor =$receptor;
            $this->intTipo =$tipo;
            $this->intIdUser =$idUser;
            $sql ="SELECT * FROM receptores WHERE receptor_nom='{$this->strReceptor}';";
            $request = $this->select_all($sql);
            
            if(empty($request)){
                $query_insert = "INSERT INTO receptores(receptor_nom, receptor_tipo, receptor_MadeBy) VALUES(?,?,?);";
                $arrData = array($this->strReceptor, $this->intTipo, $this->intIdUser);
                $request_insert= $this->insert($query_insert, $arrData);
                $return = $request_insert;
            }
            else{
                $return = 0;
            }
            return $return;
        }

        //actualizar registro 
        public function updateReceptor(int $idreceptor, string $receptor, int $tipo){
            $this->intIdReceptor = $idreceptor;
            $this->strReceptor = $receptor;
            $this->intTipo = $tipo;
            $sql="SELECT * FROM receptores WHERE receptor_nom= '$this->strReceptor' AND receptor_id != $this->intIdReceptor";
            $request=$this->select_all($sql);

            if(empty($request)){
                $sql="UPDATE receptores SET receptor_nom =?, receptor_tipo= ? WHERE receptor_id= $this->intIdReceptor";
                $arrData= array($this->strReceptor, $this->intTipo);
                $request= $this->update($sql, $arrData);
            }
            else{
                $request= 0;
            }
            return $request;
        }

        //borrar rol
        public function deleteReceptor(int $idreceptor){
            $this->intIdReceptor = $idreceptor;
            $sql ="SELECT user_rol FROM usuarios WHERE user_rol= $this->intIdReceptor";
            $request= $this->select_all($sql);
            if(empty($request)){
                $sql = "UPDATE receptores SET rol_estado=? WHERE receptor_id= $this->intIdReceptor";
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