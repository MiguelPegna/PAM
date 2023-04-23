<?php
    class Correos extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function correos ($params){
            $data['page_id'] = 'p_correos';
            $data['page_title'] = '.:Enviar Correos:.';
            $data['page_tag'] = 'correos';
            $data['page_name'] = 'Enviar Correos';
            $data['page_scripts']='<script src="'.assets().'js/correos.js"></script><script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>'; 
            $this->views->getView($this, 'correos', $data);
        }

        public function setCorreo(){
            if($_POST){

                if (empty($_POST['correo']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                else{
                    $destinos = $_POST['correo'];
                    $minuta=27;
                    $request_min=1;
                    $destinosId = array_map('intval',$destinos);

                    if($request_min >0){
                        //Se envia el mail a los paticipantes de la minuta
                        foreach($destinosId as $idParticipante){                   
                            $this->Mail($idParticipante, $minuta);
                         }//end
                        $arrResponse = array('status' => true, 'msg' => 'La minuta y acuerdos se han agregado correctamente (◕‿◕)');
    
                    }
                    else if($request_min == 0){
                        $arrResponse = array('status' => false, 'msg' => 'No se pudo crear la minuta (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible agregar información a la DB ┌∩┐(◣_◢)┌∩┐');
                    }
                
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end function

        public function Mail($idParticipante, $minuta){
            $arrDestinatario= $this->model->selectDestinatarioMail($idParticipante);
            $arrMinuta= $this->model->selectMinuta($minuta);
            $arrAcuerdos= $this->model->selectAcuerdos($minuta);

            $infoAcuerdos='';
            $n=0;
            $mensaje ='';
            $numReg= count($arrAcuerdos);
            if(count($arrDestinatario) > 0){
                //Cuerpo del mensaje e informacion de la minuta
                $asunto='Detalles de la minuta: ' .$arrMinuta[0]['titulo'];

                $infoMinuta='Hola! '. $arrDestinatario[0]['nombre']. ' por este medio se te informa que se te ha agregado como participante de la siguiente minuta: <br/>'
                .'<p><b> *** INFORMACION DE LA MINUTA *** </b> <br/>'
                .'<b>Titulo: </b>'.$arrMinuta[0]['titulo']. ' <br/>'
                .'<b>Lugar: </b>'.$arrMinuta[0]['lugar']. ' <br/>'
                .'<b>Fecha: </b>'.$arrMinuta[0]['fecha']. ' <br/>'
                .'<b>Hora apertura: </b>'.$arrMinuta[0]['hora']. '<br/><b> Hora de cierre: </b>' .$arrMinuta[0]['hora_cierre'] .'<br/>'
                .'<b>Desarrollo de la minuta: </b><br/>'
                .nl2br($arrMinuta[0]['desarrollo']) .'<p>'
                .'<b> *** ACUERDOS Y COMPROMISOS *** </b> <br/>';

                for ($a=0; $a< $numReg; $a++){
                    $n++;       
                    $infoAcuerdos.=$n .':<br/><b>Acuerdo: </b>' .$arrAcuerdos[$a]['titulo']. '<br/>'
                    .'<b>Responsable: </b>' .$arrAcuerdos[$a]['responsable'] .'<br/>'
                    .'<b>Fecha Entrega. </b>' .$arrAcuerdos[$a]['fecha'] .'<br/>';
                } 

                $arrPart = explode(',', $arrMinuta[0]['participantes']);
                $printR='';
                foreach ($arrPart as $participante){
                    $arrParticipantes= $this->model->selectParticipantesMin($participante);
                    $printR.= "<b>" .$arrParticipantes[0]['titulo']. " ".  $arrParticipantes[0]['nombre']. "</b><br/>".$arrParticipantes[0]['cargo'] ."<p>";
                
                }
                $mensaje= $infoMinuta .$infoAcuerdos ."<hr><p><b> *** PARTICIPANTES DE LA MINUTA *** </b><br/>" .$printR;
                enviarMail($arrDestinatario[0]['mail'], $arrDestinatario[0]['nombre'], $asunto, $mensaje);
            }
            die();
        }

    }
    