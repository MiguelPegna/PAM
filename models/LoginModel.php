<?php
    class LoginModel extends Mysql{
        private $intIdUser;
        private $strUser;
        private $strPass;
        private $strToken;

        public function __construct(){
            parent::__construct();
        }

        public function loginUser(string $usuario, string $pass){
            $this->strUser= $usuario;
            $this->strPass =$pass;
            //seleccionamos que exista en la DB el mail que se recibe
            $sql="SELECT user_mail FROM usuarios WHERE user_mail = '$this->strUser';";
            $request = $this->select($sql);
            //Si la respuesta es nula el correo no existe en la base de datos
            if(empty($request)){
                //El E-mail no esta asociado a ningun usuario
                $return=0;
                return $return;
            }
            //Verificamos que el usuario tenga su cuenta activa
            $sql="SELECT user_estado FROM usuarios WHERE user_mail = '$this->strUser';";
            $request = $this->select($sql);

            //si el usuario tiene su cuenta activa se consulta su contrseña
            if($request=1){
                $sql="SELECT user_pass FROM usuarios WHERE user_mail = '$this->strUser';";
                $request = $this->select($sql);
                //convertimos el resultado a cadena
                $passDB= implode($request);
                //verificamos que el password enviado coincida con el password de la DB
                $checkPass = password_verify($this->strPass, $passDB);
                if($checkPass){
                    //El nombre de usuario  y Contraseña correctos
                    $return=1;                    
                }
                else{
                    //Contraseña incorrecta
                    $return=2;
                }
            }
            else {
                //Esta cuenta de usuario se encuentra inactiva
                $return=3;
            }
            return $return;
        }

        public function varSessions(string $usuario){
            $this->strUser= $usuario;
            $sql="SELECT user_id, user_estado FROM usuarios WHERE user_mail = '$this->strUser';";
            $request = $this->select($sql);
            return $request;
        }

        //cargamos los datos principales del usuario para llamrlos de manera rapida cuando inicie sesion
        public function sessionData(int $idUsuario){
            $this->intIdUser= $idUsuario;
            $sql="SELECT u.user_id, u.user_nom as nombre, u.user_ap as apellidoP, u.user_am as apellidoM, u.user_mail, u.user_estado,
            c.cargo_nom as cargo, r.rol_nombre as rol, r.rol_id,
            uni.unidad_id, uni.unidad_nom as unidad
            FROM usuarios as u
            INNER JOIN cargos as c ON u.user_cargo = cargo_id
            INNER JOIN roles as r ON u.user_rol= rol_id
            INNER JOIN unidades as uni on u.user_unidad= unidad_id
            WHERE user_id=$this->intIdUser;";
            $request = $this->select($sql);
            return $request;
        }

    }//end class
?>