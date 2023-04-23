<?php
    class Home extends Controllers{
        public function __construct(){
            parent::__construct();
        }

        public function home ($params){
            $data['page_id'] = 'p_001';
            $data['page_title'] = '.:Inicio Sesión:.';
            $data['page_tag'] = 'Home';
            $data['page_name'] = 'home';
            $this->views->getView($this, 'home', $data);
        }
    }
?>