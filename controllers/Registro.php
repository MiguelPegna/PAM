<?php
    class Registro extends Controllers{
        public function __construct(){
            parent::__construct();
             //se verifica que se haya iniciado sesion para ver el portal
             session_start();
             if(empty($_SESSION['login'])){
                 header('location: ../pam');
             }
        }

        public function registro ($params){
            $data['page_id'] = 'p_registro';
            $data['page_title'] = '.:Registro Nuevo Usuario:.';
            $data['page_tag'] = 'Registro';
            $data['page_name'] = 'Registrar Nuevo Usuario';
            $data['page_scripts']='<script src="'.assets().'js/validar-reg.js"></script><script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>;
                <script type="text/javascript" src="'.assets().'js/validaForm.js"></script>';
            $this->views->getView($this, 'registro', $data);
        }

        //obtener unidades por select
        public function getSelectUnidades(){
            $options ='';
            $arrData= $this->model->selectUnidades();
            if(count($arrData) > 0){
                for($i=0; $i < count($arrData); $i++){
                    $options .='<option value="'.$arrData[$i]['unidad_id'] .'">'.$arrData[$i]['unidad_num'].' - '.$arrData[$i]['unidad_nom'].' </option> ';
                }
            }
            echo $options;
            die();
        }
        //los cargos, roles y titulos se consultan usando sus respectivos metodos llamdados desde el js valida-reg.js

        public function setRegistro(){
            //dep($_POST);
            
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['nom']) || empty($_POST['ape_p']) || empty($_POST['ape_m']) || empty($_POST['unidad']) || empty($_POST['cargo']) || empty($_POST['rol']) || empty($_POST['titulo']) || empty($_POST['email']) || empty($_POST['pass1']) || empty($_POST['pass2'])){    
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios >=[ ');
                }
                #Se comprueba dirección de correo valida 
                else if(!esMail($_POST['email'])){
                    $arrResponse= array('status' => false, 'msg' => 'Escribe una dirección de correo valida >=[ ');
                }
                 #Se comprueba la longitud del pass
                else if(strlen(trim($_POST['pass1'])) <8 || strlen(trim($_POST['pass2'])) <8){   
                    $arrResponse= array('status' => false, 'msg' => 'La contraseña debe ser minimo de 8 caracteres >=[ ');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $strNombre =  ucwords(strtolower(strClean($_POST['nom'])));
		    	    $strApe_p = ucwords(strtolower(strClean($_POST['ape_p'])));
		    	    $strApe_m =  ucwords(strtolower(strClean($_POST['ape_m'])));
		    	    $intUnidad = intval($_POST['unidad']);
		    	    $intCargo = intval($_POST['cargo']);
		    	    $intRol = intval($_POST['rol']);
		    	    $intTitulo = intval($_POST['titulo']);
		    	    $strMail = strtolower(strClean($_POST['email']));
		    	    $strPass = strClean($_POST['pass1']);
		    	    $strPass2 = strClean($_POST['pass2']);
                    $_SESSION['userData']['user_id'];
                   
                    #se compruba que los dos campos de contraseña sean los mismos
                    if(strcmp($strPass, $strPass2)!==0){
                        $arrResponse= array('status' => false, 'msg' => 'Las contraseñas no son iguales >=[ ');
                    }
                    //codificar la contraseña
                    $passDB = password_hash($strPass, PASSWORD_DEFAULT);
                    //se manda la peticion al metodo insert que revisara si el email ya esta registrado en la DB             
                    $request_reg = $this->model->insertUser($strNombre, $strApe_p, $strApe_m, $intUnidad, $intCargo, $intRol, $intTitulo, $strMail, $passDB, $_SESSION['userData']['user_id']);
                    $accion= 1; //Crear Usuario;
                    $ipUser= $_SERVER['REMOTE_ADDR']; //se obtiene la ip del usuario para registrar desde donde se realizo la accion
                    //mandamos respuesta 
                    if($request_reg >0){
                        $arrResponse = array('status' => true, 'msg' => 'El Usuario se ha registrado correctamente (◕‿◕)');
                        $this->model->historial($_SESSION['userData']['user_id'], $accion, $ipUser);
                    }
                    else if($request_reg == 0){
                        $arrResponse = array('status' => false, 'msg' => 'El E-mail esta asociado a otra cuenta de usuario (¯ ヘ ¯)');
                    }
                    else{
                        $arrResponse = array("status" => false, "msg" => 'No fue posible agregar el usuario a la DB ┌∩┐(◣_◢)┌∩┐');
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end function

    } //end class
?>