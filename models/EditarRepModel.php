<?php
    class EditarRepModel extends Mysql{
        public $intIdUser;
        public $strTitulo;
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
        public $strNvoOrigen;
        public $strNvoFechaCad;
        public $strNvoRazon;
        public $strNvoDestino;
        public $strDisposicion;
        public $strPrueba;
        public $strUrlDoc;
        public $strNombre;
        public $strFechaF;
        public $intIdReporte;
        public $intIdPersona;
        public $intIdEvidencia;
        public $intTipo;
        public $intIdAccion;
        public $strIpUser;

        public $strPersona;
        public $intConsentimiento;

        public function __construct(){
            parent::__construct();
        }
        //Seleccionar reporte
        public function selectReporte(int $idReporte){
            $this->intIdReporte = $idReporte;
            $sql="SELECT reporte_id as id, reporte_titulo as titulo , reporte_fecha_incidente as fechaInc, reporte_incidente as incidente, reporte_caso as caso, reporte_consentimiento as consentimiento, reporte_etiqueta as etiqueta, reporte_modelo as modelo, reporte_fabricante as fabricante, reporte_num_serie as numSerie, reporte_descripcion as descripcion, reporte_persona as idPersona, reporte_disp_final as disposicion, reporte_fecha_final as fechaFinal
            , receptor_nom as receptor from reportes 
            INNER JOIN receptores ON `reporte_persona` = receptor_id WHERE reporte_id=$this->intIdReporte AND reporte_estado=1; ";
            $request = $this->select($sql);
            return $request;
        }
        //seleccionar las evidencias del reporte
        public function selectEvidencias(int $idReporte){
            $this->intIdReporte = $idReporte;
            $sql="SELECT evidencia_id as id,  evidencia_origen as origen, evidencia_fecha as fecha, evidencia_razon as razon, evidencia_destino as destino, evidencia_prueba as prueba
            FROM evidencias WHERE evidencia_reporte=$this->intIdReporte; ";
            $request = $this->select_all($sql);
            return $request;
        }
        //actualizar reporte
        public function updateReporte(string $titulo, string $fechaInc, string $incidente, string $caso, int $consentimiento, string $etiqueta, string $modelo, string $fabricante, string $numSerie, int $persona, string $descripcion, string $disposicion, string $fechaF, int $idUser, int $idReporte){
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
            $sql ="SELECT reporte_id FROM reportes WHERE reporte_id=$this->intIdReporte;";
            $request = $this->select_all($sql);
            
            if($request >0){
                $sql = "UPDATE reportes SET 
                                reporte_titulo =?, 
                                reporte_fecha_incidente =?, 
                                reporte_incidente =?,
                                reporte_caso =?, 
                                reporte_consentimiento =?, 
                                reporte_etiqueta =?, 
                                reporte_modelo =?, 
                                reporte_fabricante =?, 
                                reporte_num_serie =?, 
                                reporte_descripcion =?, 
                                reporte_persona =?, 
                                reporte_disp_final =?, 
                                reporte_fecha_final =?, 
                                reporte_madeBy =?
                                WHERE reporte_id=$this->intIdReporte;";
                $arrData = array($this->strTitulo, $this->strFechaInc, $this->strIncidente, $this->strCaso, $this->intConsentimiento, $this->strEtiqueta, $this->strModelo, $this->strFabricante, $this->strNumSerie, $this->strDescripcion, $this->intIdPersona, $this->strDisposicion, $this->strFechaF, $this->intIdUser);
                $request= $this->update($sql, $arrData);
            }
            else{
                $request = 0;
            }
            return $request;
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

        //actualizar cadena de evidencias
        public function updateEvidencia(string $origen, string $fechaCad, string $razon, string $destino, int $idEvidencia, int $idReporte, string $urlDoc){
            $this->strOrigen =$origen;
            $this->strFechaCad =$fechaCad;
            $this->strRazon =$razon;
            $this->strDestino =$destino;
            $this->intIdEvidencia =$idEvidencia;
            $this->intIdReporte =$idReporte;
            $this->strUrlDoc =$urlDoc;
            $sql ="SELECT evidencia_id, evidencia_reporte FROM evidencias WHERE evidencia_id=$this->intIdEvidencia AND evidencia_reporte=$this->intIdReporte;";
            $request = $this->select($sql);
            
            if($request >0){
                $sql = "UPDATE evidencias SET 
                        evidencia_origen =?, 
                        evidencia_fecha =?, 
                        evidencia_razon =?, 
                        evidencia_destino =?,
                        evidencia_prueba =?
                        WHERE evidencia_id=$this->intIdEvidencia AND evidencia_reporte=$this->intIdReporte;";
                $arrData = array($this->strOrigen, $this->strFechaCad, $this->strRazon, $this->strDestino, $this->strUrlDoc);
                $request= $this->update($sql, $arrData);
            }
            else{
                $request = 0;
            }
            return $request;
        }

        //guardar cadena de  nuevas evidencias que se agreguen al reporte
        public function InsertNewEvidencia(string $nvoOrigen, string $nvoFechaCad, string $nvoRazon, string $nvoDestino, int $idReporte, string $urlDoc){
            $return ='';
            $this->strNvoOrigen =$nvoOrigen;
            $this->strNvoFechaCad =$nvoFechaCad;
            $this->strNvoRazon =$nvoRazon;
            $this->strNvoDestino =$nvoDestino;
            $this->intIdReporte = $idReporte;
            $this->strUrlDoc = $urlDoc;
            $return=0;

            $query_insert = "INSERT INTO evidencias(evidencia_origen, evidencia_fecha, evidencia_razon, evidencia_destino, evidencia_reporte, evidencia_prueba) VALUES(?,?,?,?,?,?);";
            $arrData = array($this->strNvoOrigen, $this->strNvoFechaCad, $this->strNvoRazon, $this->strNvoDestino, $this->intIdReporte, $this->strUrlDoc);
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