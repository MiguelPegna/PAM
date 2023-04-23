<?php
    class ListaSofiModel extends Mysql{
        public $intIdUser;
        public $strNom;
        public $strApe_p;
        public $strApe_m;
        public $intUnidad;
        public $intCargo;
        public $intRol;
        public $intTitulo;
        public $strMail;
        public $intStatus;

        public function __construct(){
            parent::__construct();
        }

         //consultar reportes de la DB para mostrarlos en la tabla
         public function selectOficios(){
            $sql="SELECT o.ofi_numero as numOficio, DATE_FORMAT(o.ofi_fechaE,'%d/%m/%Y') as fechaElab, o.ofi_asunto as asunto, 
            ed.ente_nom as destinatario, ee.ente_nom as empresaD, o.ofi_url as urlOfi
            FROM oficios as o 
            INNER JOIN entes as ed ON o.ofi_destinatario = ed.ente_id
            INNER JOIN entes as ee ON o.ofi_unidadDest = ee.ente_id;";
            $request = $this->select_all($sql);
            return $request;
        }
        

        //actualizar registro 
        public function updateUser(int $iduser, string $nombre, string $apellidoP, string $apellidoM, int $unidad, int $cargo, int $rol, int $titulo, string $mail){
            $this->intIdUser = $iduser;
            $this->strNom = $nombre;
            $this->strApe_p = $apellidoP;
            $this->strApe_m = $apellidoM;
            $this->intUnidad = $unidad;
            $this->intCargo = $cargo;
            $this->intRol = $rol;
            $this->intTitulo = $titulo;
            $this->strMail = $mail;
            $sql="SELECT * FROM usuarios WHERE user_mail= '$this->strMail' AND user_id != $this->intIdUser";
            $request=$this->select_all($sql);

            if(empty($request)){
                $sql="UPDATE usuarios SET user_nom =?, user_ap =?, user_am =?, user_unidad =?, user_cargo =?, user_rol =?, user_titulo =?, user_mail =? WHERE user_id= $this->intIdUser";
                $arrData= array($this->strNom, $this->strApe_p, $this->strApe_m, $this->intUnidad, $this->intCargo, $this->intRol, $this->intTitulo, $this->strMail);
                $request= $this->update($sql, $arrData);
            }
            else{
                $request= 0;
            }
            return $request;
        }

        //inactivar user
        public function deleteUser(int $iduser){
            $this->intIdUser = $iduser;
            $sql ="SELECT user_id, user_estado FROM usuarios WHERE user_id= $this->intIdUser";
            $request= $this->select_all($sql);
            if($request){
                $sql = "UPDATE usuarios SET user_estado=? WHERE user_id= $this->intIdUser";
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
    }
?>