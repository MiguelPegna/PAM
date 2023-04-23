<?php
    class ListaRep extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function listaRep ($params){
            $data['page_id'] = 'p_listaRep';
            $data['page_title'] = '.:Lista Reportes:.';
            $data['page_tag'] = 'lista reportes';
            $data['page_name'] = 'Lista Reportes';
            $data['page_scripts']='<script src="'.assets().'js/reportes-tab.js"></script><script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>';
            $this->views->getView($this, 'listaRep', $data);
        }

        //mostrar todas las minutas de la DB
        public function getReportes(){
            $arrData = $this->model->selectReportes();
            //dep($arrData);
            for($i=0; $i<count($arrData); $i++){
                if($arrData[$i]['estado']==1){
                    $arrData[$i]['estado'] = '<span class="badge">Reporte Activo <img src="'.assets().'img/icons/1.png" width="15"></span>';
                }
                
                $arrData[$i]['minuta_actions'] ='<div class="text-center"> 
                                                        <a href="libraries/pdfgen/crearpdfRep.php?idRep='.$arrData[$i]['id']. '" title="GENERAR PDF" role="button" class="btn btn-default bMakeRepPDF"  rl="'.$arrData[$i]['id'].'"><img src="'.assets().'img/icons/pdf.png" width="25"></a>
                                                        <a href="reportePdf?id='.$arrData[$i]['id']. '" target="_blank" title="VER REPORTE" role="button" class="btn btn-default bVerRep" rl="'.$arrData[$i]['id'].'"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                        <a href="editarRep?id='.$arrData[$i]['id']. ' " title="EDITAR REPORTE" role="button" class="btn btn-default bEditRep" rl="'.$arrData[$i]['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>
                                                        '//<button title="BORRAR USUARIO" role="button" class="btn btn-default bDelMin" rl="'.$arrData[$i]['id'].'"><span class="glyphicon glyphicon-trash"></span></button>
                                                    .'</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

    } //end class
?>