<?php
    class CamisasModel extends Mysql{
        public $intIdCargo;
        public $strCargo;
        public $intTipo;

        public function __construct(){
            parent::__construct();
        }
    }