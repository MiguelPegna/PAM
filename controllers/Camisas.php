<?php
    class Camisas extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function camisas ($params){
            $data['page_id'] = 'p_camisas';
            $data['page_title'] = '.:Camisas:.';
            $data['page_tag'] = 'lista_camisas';
            $data['page_name'] = 'Lista de Camisas';
            $data['page_scripts']='<script src="'.assets().'js/cargos-tab.js"></script>';
            $this->views->getView($this, 'camisas', $data);
        }
    }