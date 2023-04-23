<?php
    class PrimeroModel extends Mysql{
        public $intIdUser;
        public $strNombre;
        public $strApe_p;
        public $strApe_m;
        public $strMail;
        public $strPass;
        public $intUnidad;
        public $intCargo;
        public $intRol;
        public $intTitulo;

        public function __construct(){
            parent::__construct();
        }

        //consultar unidades de la DB
        public function selectUnidades(){
            $sql="SELECT * FROM unidades WHERE unidad_tipo =1";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar todos los cargos internos de la DB
        public function selectCargosUtic(){
            $sql="SELECT * FROM cargos WHERE cargo_tipo = 1";
            $request = $this->select_all($sql);
            return $request;
        }
         //consultar roles de la DB
         public function selectRoles(){
            $sql="SELECT * FROM roles WHERE rol_estado !=2";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar todos los titulos de la DB
        public function selectTitulos(){
            $sql="SELECT * FROM titulos WHERE titulo_estado=1";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar mail de usuario
        public function selectUserMail(string $mail){
            $this->strMail = $mail;
            $sql="SELECT user_mail FROM usuarios WHERE user_mail = $this->strMail";
            $request = $this->select($sql);
            return $request;
        }

        //guardar registro
        public function insertUser(string $nombre, string $ape_p, string $ape_m, int $unidad, int $cargo, int $rol, int $titulo, string $mail, string $pass){
            $return ='';
            $this->strNombre = $nombre;
            $this->strApe_p = $ape_p;
            $this->strApe_m = $ape_m;
            $this->intUnidad = $unidad;
            $this->intCargo = $cargo;
            $this->intRol = $rol;
            $this->intTitulo = $titulo;
            $this->strMail =$mail;
            $this->strPass = $pass;
            $return=0;
            $sql ="SELECT user_mail FROM usuarios WHERE user_mail='{$this->strMail}';";
            $request = $this->select_all($sql);
            
            if(empty($request)){
                $query_insert = "INSERT INTO usuarios(user_nom, user_ap, user_am, user_unidad, user_cargo, user_rol, user_titulo, user_mail, user_pass) VALUES(?,?,?,?,?,?,?,?,?);";
                $arrData = array($this->strNombre, $this->strApe_p, $this->strApe_m, $this->intUnidad, $this->intCargo, $this->intRol, $this->intTitulo, $this->strMail, $this->strPass);
                $request_insert= $this->insert($query_insert, $arrData);
                $return = $request_insert;
            }
            else{
                $return = 0;
            }
            return $return;
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