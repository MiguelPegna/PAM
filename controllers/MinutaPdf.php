<?php
    class MinutaPdf extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function minutaPdf ($params){
            $data['page_id'] = 'p_minutaPdf';
            $data['page_title'] = '.:Minuta:.';
            $data['page_tag'] = 'Minuta pdf';
            $data['page_name'] = 'Minuta pdf';
            $this->views->getView($this, 'minutaPdf', $data);
        }

        //mostrar todas las minutas de la DB
        /*
        public function getMinuta(){
            $arrData = $this->model->selectMinuta();
            //dep($arrData);
            for($i=0; $i<count($arrData); $i++){
                if($arrData[$i]['estado']==1){
                    $arrData[$i]['estado'] = '<span class="badge">Minuta Activa <img src="'.assets().'img/icons/1.png" width="15"></span>';
                }
                
                $arrData[$i]['minuta_actions'] ='<div class="text-center"> 
                                                        <a href="" title="GENERAR PDF" role="button" class="btn btn-default bMakeMinPDF"><img src="'.assets().'img/icons/pdf.png" width="25"></a>
                                                        <a data-toggle="modal" data-target="#ver-minuta" title="VER DETALLES" role="button" class="btn btn-default bVerMin" rl="'.$arrData[$i]['id'].'"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                        <a data-toggle="modal" data-target="#minuta" title="EDITAR MINUTA" role="button" class="btn btn-default bEditMin" rl="'.$arrData[$i]['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>
                                                        '//<button title="BORRAR USUARIO" role="button" class="btn btn-default bDelMin" rl="'.$arrData[$i]['id'].'"><span class="glyphicon glyphicon-trash"></span></button>
                                                    .'</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }*/

    } //end class
?>