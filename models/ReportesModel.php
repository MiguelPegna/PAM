<?php
    class ReportesModel extends Mysql{
        public $intIdUser;
        public $intIdPersona;
        public $intTipo;
        public $intConsentimiento;
        public $strTitulo;
        public $strNombre;
        public $strFechaInc;
        public $strIncidente;
        public $strCaso;
        public $strEtiqueta;
        public $strModelo;
        public $strFabricante;
        public $strNumSerie;
        public $intPersona;
        public $strDescripcion;
        public $strOrigen;
        public $strFechaCad;
        public $strRazon;
        public $strDestino;
        public $strDisposicion;
        public $strFechaF;
        public $intIdReporte;
        public $intIdAccion;
        public $strIpUser;
        public $strUrlDB;

        public $strPersona;

        public function __construct(){
            parent::__construct();
        }

        //guardar minuta
        public function insertReporte(string $titulo, string $fechaInc, string $incidente, string $caso, int $consentimiento, string $etiqueta, string $modelo, string $fabricante, string $numSerie, int $persona, string $descripcion, string $disposicion, string $fechaF, int $idUser, int $idReporte){
            $return ='';
            $this->intIdUser =$idUser;
            $this->strTitulo =$titulo;
            $this->strFechaInc =$fechaInc;
            $this->strIncidente =$incidente;
            $this->strCaso =$caso;
            $this->intConsentimiento =$consentimiento;
            $this->strEtiqueta =$etiqueta;
            $this->strModelo =$modelo;
            $this->strFabricante =$fabricante;
            $this->strNumSerie =$numSerie;
            $this->intIdPersona =$persona;
            $this->strDescripcion =$descripcion;
            $this->strDisposicion =$disposicion;
            $this->strFechaF =$fechaF;
            $this->intIdReporte =$idReporte;
            $return=0;
            $sql ="SELECT reporte_id FROM reportes WHERE reporte_id=$this->intIdReporte;";
            $request = $this->select_all($sql);
            
            if(empty($request)){
                $query_insert = "INSERT INTO reportes(reporte_titulo, reporte_fecha_incidente, reporte_incidente, reporte_caso, reporte_consentimiento, reporte_etiqueta, reporte_modelo, reporte_fabricante, reporte_num_serie, reporte_descripcion, reporte_persona, reporte_disp_final, reporte_fecha_final, reporte_madeBy) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
                $arrData = array($this->strTitulo, $this->strFechaInc, $this->strIncidente, $this->strCaso, $this->intConsentimiento, $this->strEtiqueta, $this->strModelo, $this->strFabricante, $this->strNumSerie, $this->strDescripcion, $this->intIdPersona, $this->strDisposicion, $this->strFechaF, $this->intIdUser);
                $request_insert= $this->insert($query_insert, $arrData);
                $return = $request_insert;
            }
            else{
                $return = 0;
            }
            return $return;
        }

        //consultar el ultimo id de reporte registrado
        public function selectIdReporte(){
            $sql="SELECT MAX(reporte_id) AS id FROM reportes;";
            $request = $this->select($sql);
            return $request;
        }

        //consultar receptores para mostrar en pantalla de reportes
        public function selectReceptoresC(){
            $sql="SELECT receptor_id, receptor_nom FROM receptores WHERE receptor_estado=1";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar receptores para mostrar en pantalla de reportes
        public function selectReceptoresInput(string $recep){
            $this->strPersona =$recep;
            $sql='SELECT receptor_id as id, receptor_nom as receptor FROM receptores WHERE receptor_nom LIKE "%'.strip_tags($this->strPersona).'%" AND receptor_estado=1 ORDER BY receptor_nom DESC LIMIT 0,1';
            $request = $this->select($sql);
            return $request;
        }

        //guardar cadena de evidencias
        public function insertEvidencia(string $origen, string $fechaCad, string $razon, string $destino, int $idReporte, string $urlDB){
            $return ='';
            $this->strOrigen =$origen;
            $this->strFechaCad =$fechaCad;
            $this->strRazon =$razon;
            $this->strDestino =$destino;
            $this->intIdReporte = $idReporte;
            $this->strUrlDB = $urlDB;
            $return=0;

            $query_insert = "INSERT INTO evidencias(evidencia_origen, evidencia_fecha, evidencia_razon, evidencia_destino, evidencia_reporte, evidencia_prueba) VALUES(?,?,?,?,?,?);";
            $arrData = array($this->strOrigen, $this->strFechaCad, $this->strRazon, $this->strDestino, $this->intIdReporte, $this->strUrlDB);
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

        //guardar invitado
        public function insertPersona(string $nombre, int $tipo, int $idUser){
            $return ='';
            $this->strNombre = $nombre;
            $this->intTipo = $tipo;
            $this->intIdUser =$idUser;
            $return=0;

            $sql ="SELECT receptor_nom FROM receptores WHERE receptor_nom='$this->strNombre' AND receptor_tipo=1 
            OR receptor_nom='$this->strNombre' AND receptor_tipo=0;";
            $request = $this->select_all($sql);
            
            if(empty($request)){
                $query_insert = "INSERT INTO receptores(receptor_nom, receptor_tipo, receptor_madeBy) VALUES(?,?,?);";
                $arrData = array($this->strNombre, $this->intTipo, $this->intIdUser);
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