<?php
    class CorreosModel extends Mysql{
        public $intIdUser;
        public $strFechaMin;
        public $strHoraMin;
        public $strHoraCMin;
        public $strLugar;
        public $strTituloMin;
        public $intUnidadAd;
        public $strDesarrollo;
        public $strParticipantes;
        public $strTituloA;
        public $strFechaA;
        public $intResponsable;
        public $intIdMinuta;

        public $strNombre;
        public $strMail; 
        public $intTipo; 
        public $intTitulo;
        public $intCargo;

        public $intIdAccion;
        public $strIpUser;
        public $intIdParticipante;

        public function __construct(){
            parent::__construct();
        }

        public function selectDestinatarioMail(int $idParticipante){
            $this->intIdParticipante = $idParticipante;           
            //INFO DESTINATARIO nombre y correo
            $sql="SELECT participante_nom as nombre, participante_mail as mail FROM participantes WHERE participante_id=$this->intIdParticipante;";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar info de la minuta registrada
        public function selectMinuta(int $idMinuta){
            $this->intIdMinuta = $idMinuta;
            $sql="SELECT m.minuta_id, m.minuta_titulo as titulo, m.minuta_desarrollo as desarrollo, m.minuta_lugar as lugar, DATE_FORMAT(`minuta_fecha`,'%d/%m/%Y') as fecha , m.minuta_hora as hora, m.minuta_hora_cierre as hora_cierre, m.minuta_participantes as participantes,
            c.cargo_nom as unidad FROM minutas as m
            INNER JOIN cargos as c ON m.minuta_unidad_admin= c.cargo_id WHERE m.minuta_id=$this->intIdMinuta";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar acuerdos de la minuta registrada
        public function selectAcuerdos(int $idMinuta){
            $this->intIdMinuta = $idMinuta;

            $sql="SELECT a.acuerdo_id, a.acuerdo_titulo as titulo, DATE_FORMAT(a.acuerdo_fecha_entrega, '%d/%m/%Y') as fecha,
            p.participante_nom as responsable FROM acuerdos as a 
            INNER JOIN participantes as p ON a.acuerdo_responsable= p.participante_id
            WHERE acuerdo_minuta=$this->intIdMinuta;";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar los participantes de manera individual
        public function selectParticipantesMin(int $idParticipante){
            $this->intIdParticipante= $idParticipante;
            $sql="SELECT p.participante_nom as nombre, c.cargo_nom as cargo, t.titulo_abr as titulo
            FROM participantes as p
            INNER JOIN titulos as t ON p.participante_titulo = titulo_id
            INNER JOIN cargos as c ON p.participante_cargo= cargo_id
            WHERE participante_id=$this->intIdParticipante";
            $request = $this->select_all($sql);
            return $request;
        }

        
        public function selectInfoMinuta(int $idMinuta){
            $this->intIdMinuta = $idMinuta;
            $sql="SELECT m.minuta_titulo as minuta, m.minuta_lugar as lugar, DATE_FORMAT(`minuta_fecha`,'%d/%m/%Y') as fecha , m.minuta_hora as hora, m.minuta_hora_cierre as hora_cierre, m.minuta_desarrollo as desarrollo, u.cargo_nom as unidad,
            a.acuerdo_titulo as acuerdo, DATE_FORMAT(a.acuerdo_fecha_entrega, '%d/%m/%Y') as fechaA,
            t.titulo_abr as titulo, p.participante_nom as responsable, c.cargo_nom as cargo, p.participante_mail as mail
            FROM acuerdos as a 
            INNER JOIN participantes as p ON a.acuerdo_responsable= p.participante_id
            INNER JOIN minutas as m ON a.acuerdo_minuta= m.minuta_id
            INNER JOIN titulos as t ON p.participante_titulo= t.titulo_id
            INNER JOIN cargos as c ON p.participante_cargo= c.cargo_id
            INNER JOIN cargos as u ON m.minuta_unidad_admin=u.cargo_id
            WHERE acuerdo_minuta=$this->intIdMinuta";
            $request = $this->select_all($sql);
            return $request;
        }
        
    }