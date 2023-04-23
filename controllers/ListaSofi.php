<?php
    class ListaSofi extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function listaSofi ($params){
            $data['page_id'] = 'p_listaSofi';
            $data['page_title'] = '.:Lista Oficios:.';
            $data['page_tag'] = 'lista oficios';
            $data['page_name'] = 'Lista Oficios';
            $data['page_scripts']='<script src="'.assets().'js/sofi-tab.js"></script><script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>';
            $this->views->getView($this, 'listaSofi', $data);
        }

        //mostrar todos los oficios de la DB
        //esta era la menra mas o menos bonita pero el data tables no contaba los registros a pesar de mostrarse bien la info :'(
        public function getOficios(){
            $oficios ='';
            $arrData= $this->model->selectOficios();
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    
                    $oficios .='
                                <tr>
                                    <td>
                                    '.$arrData[$i]['numOficio'] .'
                                    </td>
                                    <td>
                                    '.$arrData[$i]['fechaElab'] .'
                                    </td>
                                    <td>
                                    '.$arrData[$i]['asunto'] .'
                                    </td>
                                    <td>
                                    '.$arrData[$i]['destinatario'] .'
                                    </td>
                                    <td>
                                    '.$arrData[$i]['empresaD'] .'
                                    </td>
                                    <td>
                                    ';
                                //se separa el string de la DB de los oficios para crear sus enlaces
                                    $mUrl = substr($arrData[$i]['urlOfi'], 1);
                                    $arrUrl[$i] = explode(',', $mUrl);
                                    foreach ($arrUrl[$i] as $anexoFile){
                                        $ext= pathinfo($anexoFile, PATHINFO_EXTENSION);
                                        $oficios.='<a href="'.$anexoFile. ' " target="_blank"><img src="../PAM/resources/img/icons/'.$ext.'.png" width="40" height="40"></a><br/>';
                                    }
                                    '</td>
                                </tr>
                                    ';
                }
            }
            echo $oficios;
            die();
        }

    } //end class
?>