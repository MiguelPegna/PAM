<?php
    class SofiModel extends Mysql{

        public $intIdUser;
        public $intIdDest;
        public $intIdCargoD;
        public $intIdEmpD;
        public $intIdRem;
        public $intCargoR;
        public $intIdEmpR;
        public $strFechaElab;
        public $strFechaRecep;
        public $strAsunto;
        public $strNumero;
        public $strObservacion;
        public $strUrlDB;
        public $intIdOficio;

        public $strDestinatario;
        public $strRemitente;
        public $strCargo;
        public $strEmpresa;

        public function __construct(){
            parent::__construct();
        }

        //guardar oficio
        public function insertOficio(int $idUser, int $idDestinatario, int $idCargoD, int $idEmpD, int $idRemitente, int $idCargoR, int $idEmpR, string $fechaElab, string $fechaRecep, string $asunto, string $numero, string $observacion, string $urlDB, int $idOfi){
            $return ='';
            $this->intIdUser = $idUser;
            $this->intIdDest = $idDestinatario;
            $this->intIdCargoD = $idCargoD;
            $this->intIdEmpD = $idEmpD;
            $this->intIdRem = $idRemitente;
            $this->intIdCargoR = $idCargoR;
            $this->intIdEmpR = $idEmpR;
            $this->strFechaElab = $fechaElab;
            $this->strFechaRecep = $fechaRecep;
            $this->strAsunto = $asunto;
            $this->strNumero = $numero;
            $this->strObservacion = $observacion;
            $this->strUrlDB = $urlDB;
            $this->intIdOficio = $idOfi;
            $return=0;
            $sql ="SELECT ofi_id FROM oficios WHERE ofi_id=$this->intIdOficio;";
            $request = $this->select_all($sql);
            
            if(empty($request)){
                $query_insert = "INSERT INTO oficios(ofi_subidoPor, ofi_destinatario, ofi_cargoDest, ofi_unidadDest, ofi_remitente, ofi_cargoRem, ofi_unidadRem, ofi_fechaE, ofi_fechaRecep, ofi_asunto, ofi_numero, ofi_observacion, ofi_url) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);";
                $arrData = array($this->intIdUser, $this->intIdDest, $this->intIdCargoD, $this->intIdEmpD, $this->intIdRem, $this->intIdCargoR, $this->intIdEmpR, $this->strFechaElab, $this->strFechaRecep, $this->strAsunto, $this->strNumero, $this->strObservacion, $this->strUrlDB);
                $request_insert= $this->insert($query_insert, $arrData);
                $return = $request_insert;
            }
            else{
                $return = 0;
            }
            return $return;
        }

        //guardar Destinatario
        public function insertDestinatario(string $destinatario, int $tipo, int $idUser){
            $return ='';
            $this->strDestinatario = $destinatario;
            $this->intTipo = $tipo;
            $this->intIdUser =$idUser;
            $return=0;

            $sql ="SELECT ente_nom FROM entes WHERE ente_nom='$this->strDestinatario' AND ente_tipo=1 AND ente_categoria=1
            OR ente_nom='$this->strDestinatario' AND ente_tipo=0 AND ente_categoria=1;";
            $request = $this->select_all($sql);
            
            if(empty($request)){
                $query_insert = "INSERT INTO entes(ente_nom, ente_tipo, ente_categoria, ente_madeBy) VALUES(?,?,?,?);";
                $arrData = array($this->strDestinatario, $this->intTipo, 1, $this->intIdUser);
                $request_insert= $this->insert($query_insert, $arrData);
                $return = $request_insert;
            }
            else{
                $return = 0;
            }
            return $return;
        }

        //guardar Remitente
        public function insertRemitente(string $remitente, int $tipo, int $idUser){
            $return ='';
            $this->strRemitente = $remitente;
            $this->intTipo = $tipo;
            $this->intIdUser =$idUser;
            $return=0;

            $sql ="SELECT ente_nom FROM entes WHERE ente_nom='$this->strRemitente' AND ente_tipo=1 AND ente_categoria=2 
            OR ente_nom='$this->strRemitente' AND ente_tipo=0 AND ente_categoria=2;";
            $request = $this->select_all($sql);
            
            if(empty($request)){
                $query_insert = "INSERT INTO entes(ente_nom, ente_tipo, ente_categoria, ente_madeBy) VALUES(?,?,?,?);";
                $arrData = array($this->strRemitente, $this->intTipo, 2, $this->intIdUser);
                $request_insert= $this->insert($query_insert, $arrData);
                $return = $request_insert;
            }
            else{
                $return = 0;
            }
            return $return;
        }

        //guardar Destinatario
        public function insertCargo(string $cargo, int $tipo, int $idUser){
            $return ='';
            $this->strCargo = $cargo;
            $this->intTipo = $tipo;
            $this->intIdUser =$idUser;
            $return=0;

            $sql ="SELECT cargo_nom FROM cargos WHERE cargo_nom='$this->strCargo' AND cargo_tipo=1 
            OR cargo_nom='$this->strCargo' AND cargo_tipo=0;";
            $request = $this->select_all($sql);
            
            if(empty($request)){
                $query_insert = "INSERT INTO cargos(cargo_nom, cargo_tipo, cargo_madeBy) VALUES(?,?,?);";
                $arrData = array($this->strCargo, $this->intTipo, $this->intIdUser);
                $request_insert= $this->insert($query_insert, $arrData);
                $return = $request_insert;
            }
            else{
                $return = 0;
            }
            return $return;
        }

        //guardar Empresa
        public function insertEmpresa(string $empresa, int $tipo, int $idUser){
            $return ='';
            $this->strEmpresa = $empresa;
            $this->intTipo = $tipo;
            $this->intIdUser =$idUser;
            $return=0;

            $sql ="SELECT ente_nom FROM entes WHERE ente_nom='$this->strEmpresa' AND ente_tipo=1 AND ente_categoria=3
            OR ente_nom='$this->strEmpresa' AND ente_tipo=0 AND ente_categoria=3;";
            $request = $this->select_all($sql);
            
            if(empty($request)){
                $query_insert = "INSERT INTO entes(ente_nom, ente_tipo, ente_categoria, ente_madeBy) VALUES(?,?,?,?);";
                $arrData = array($this->strEmpresa, $this->intTipo, 3, $this->intIdUser);
                $request_insert= $this->insert($query_insert, $arrData);
                $return = $request_insert;
            }
            else{
                $return = 0;
            }
            return $return;
        }

        //consultar destinatarios para mostrar en pantalla de sofi
        public function selectDestinatariosC(){
            $sql='SELECT ente_id as id, ente_nom as destinatario FROM entes WHERE ente_estado=1 AND ente_categoria=1 ORDER BY ente_nom DESC LIMIT 0,15';
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar el ultimo id de reporte registrado
        public function selectIdOfi(){
            $sql="SELECT MAX(ofi_id) AS id FROM oficios;";
            $request = $this->select($sql);
            return $request;
        }

        //consultar si el destinatario enviado existe en la DB
        public function selectDestinatario(string $destinatario){
            $return ='';
            $this->$strDestinatario =$destinatario;

            $sql="SELECT ente_nom WHERE ente_nom=$this->strDestinatario AND ente_categoria=1 FROM entes;";
            $request = $this->select($sql);
            return $request;
        }

        //consultar si el remitente enviado existe en la DB
        public function selectRemitente(string $remitente){
            $this->$strRemitente =$remitente;

            $sql="SELECT ente_nom WHERE ente_nom=$this->strRemitente AND ente_categoria=2 FROM entes;";
            $request = $this->select($sql);
            return $request;
        }

        //consultar si la empresa enviado existe en la DB
        public function selectEmpresa(string $empresa){
            $this->$strEmpresa =$empresa;

            $sql="SELECT ente_nom WHERE ente_nom=$this->strEmpresa AND ente_categoria=3 FROM entes;";
            $request = $this->select($sql);
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