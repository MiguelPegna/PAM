<?php
    //regresa la url del proyecto
    function base_url() {
        return BASE_URL;
    }
    function url_full() {
        return URL_FULL;
    }

    function assets(){
        return BASE_URL. 'resources/';
    }

    function assets_full(){
        return URL_FULL. 'resources/';
    }

    function frame(){
        return BASE_URL. 'frame/';
    }
    function frame_full(){
        return URL_FULL. 'frame/';
    }
    //muestra información formateada
    function dep($data){
        $format = print_r('<pre');
        $format .= print_r($data);
        $format .= print_r('<pre');
        return $format;
    }

    //funcion para llamar ventanas modales del proyecto
    function getModal(string $nameModal, $data){
        $viewModal = "views/_templates/modals/{$nameModal}.php";
        require_once $viewModal;
    }

    //funcion para obtenert los permisos por modulo
    function getPermisos(int $idModulo){
        require_once ('models/PermisosModel.php');
        $objPemisos = new PermisosModel();

        //obtenemos el rol_id del usuario
        $idRol = $_SESSION['userData']['user_rol'];
        $arrPermisos = $objPemisos->permisosModulo($idRol);
        $permisos='';
        $permisosMod='';

        if(count($arrPermisos)>0){
            $permisos = $arrPermisos;
            $permisosMod = isset($arrPermisos[$idModulo]) ? $arrPermisos[$idModulo] : '';
        }
        $_SESSION['permisos'] = $permisos;
        $_SESSION['permisosMod'] = $permisosMod;
    }
    
    //Elimina excesos de espacios entre palabras
    function strClean($strCadena){
        $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
        $string = trim($string);  //elimina espacios en blanco al inicio y al final
        $string = stripslashes($string);  // elimina \invertidas
        $string = str_ireplace('<script>', '', $string);
        $string = str_ireplace('</script>', '', $string);
        $string = str_ireplace('<script src>', '', $string);
        $string = str_ireplace('<script type=>', '', $string);
        $string = str_ireplace('SELECT * FROM', '', $string);
        $string = str_ireplace('DELETE FROM', '', $string);
        $string = str_ireplace('INSERT INTO', '', $string);
        $string = str_ireplace('SELECT COUNT(*) FROM', '', $string);
        $string = str_ireplace('DROP TABLE', '', $string);
        $string = str_ireplace("OR '1'='1'", '', $string);
        $string = str_ireplace('OR "1"="1"', '', $string);
        $string = str_ireplace('OR ´1´=´1´', '', $string);
        $string = str_ireplace('OR `1`=`1`', '', $string);
        $string = str_ireplace('is NULL; --', '', $string);
        $string = str_ireplace('is NULL; --', '', $string);
        $string = str_ireplace("LIKE '", '', $string);
        $string = str_ireplace('LIKE "', '', $string);
        $string = str_ireplace('LIKE ´', '', $string);
        $string = str_ireplace("OR 'a'='a'", '', $string);
        $string = str_ireplace('OR "a"="a"', '', $string);
        $string = str_ireplace('OR ´a´=´a´', '', $string);
        $string = str_ireplace('OR `a`=`a`', '', $string);
        $string = str_ireplace('--', '', $string);
        $string = str_ireplace('^', '', $string);
        $string = str_ireplace('[', '', $string);
        $string = str_ireplace(']', '', $string);
        $string = str_ireplace('==', '', $string);
        return $string;
    }

    #Verificamos que se esta igresando una direccion de correo valida
    function esMail ($varCorreo){
        if(filter_var($varCorreo, FILTER_VALIDATE_EMAIL)){
            return true;            
        }
        else {
            return false;
        }
    }

    //genera un password de 10 caracteres
    function passGenerator($length = 10) {
        $pass ='';
        $longPass = $length;
        $cadena = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789-_#';
        $longitudCadena = strlen($cadena);

        for($i=1; $i<=$longPass; $i++){
            $pos = rand(0, $longitudCadena-1);
            $pass .= substr($cadena, $pos,1);
        }
        return $pass;
    }

    //genera token
    function token(){
        $r1 = bin2hex(random_bytes(10));
        $r2 = bin2hex(random_bytes(10));
        $r3 = bin2hex(random_bytes(10));
        $r4 = bin2hex(random_bytes(10));
        $token = $r1. '-'. $r2. '-'. $r3. '-'. $r4;
        return $token;
    }

    //formato para valores moenetarios
    function formatMoney($cantidad){
        $cantidad = number_format($cantidad, 2, SPD, SPM);
        return $cantidad;
    }

    #Funcion que permite enviar correo
    function enviarMail($correo, $nombre, $asunto, $mensaje){
        require 'libraries/PHPMailer/src/Exception.php';
        require 'libraries/PHPMailer/src/PHPMailer.php';
        require 'libraries/PHPMailer/src/SMTP.php';

        try{
            $UTICMail="desarrolloUTIC@outlook.com";
            $pass="unidad713SICT";
            //$myHost="smtp.gmail.com";
            $myHost="smtp.office365.com";
            $puerto= "587";
            $deParte="Asistente SICT-PAM";
            $SMTP_Auth="login";
            $seguridad="tls";

            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isSMTP();
            $mail->SMTPDebug=0;
            $mail->Host = $myHost;
            $mail->Port = $puerto; 
            $mail->SMTPAuth =$SMTP_Auth;      
            $mail->SMTPSecure =$seguridad;  
            $mail->Username = $UTICMail;
            $mail->Password =$pass;  
            $mail->setFrom($UTICMail, $deParte);

            $mail->addAddress($correo, $nombre);
            $mail->Subject =$asunto;
            $mail->Body = $mensaje;
            //$mail->AddAttachment($path);
            $mail->isHTML(true);
            
            if ($mail->send()){
                return true;
            }
            else{
                return false;
            }
        }catch(Exception $e){
        }
    }
?>