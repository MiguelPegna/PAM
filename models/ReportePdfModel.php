<?php
    class ReportePdfModel extends Mysql{
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

        
    }
?>