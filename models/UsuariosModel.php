<?php
    class UsuariosModel extends Mysql{
        public $intIdUser;
        public $strNom;
        public $strApe_p;
        public $strApe_m;
        public $intUnidad;
        public $intCargo;
        public $intRol;
        public $intTitulo;
        public $strMail;
        public $intStatus;
        public $intIdAccion;
        public $strIpUser;

        public function __construct(){
            parent::__construct();
        }

        //consultar usuarios de la DB para mostrarlos en la tabla
        public function selectUsers(){
            $sql="SELECT CONCAT(t.titulo_abr, ' ', u.user_nom, ' ', u.user_ap, ' ', u.user_am, '<br/><b>E-mail:</b><br/>', u.user_mail) as info_user,  
            CONCAT('<b>Unidad:</b><br/>', uni.unidad_nom, '<br/><b>Cargo:</b><br/>',c.cargo_nom, '<br/><b>Rol: </b>', r.rol_nombre) as info_sict, user_estado, user_id, user_mail FROM usuarios as u
            INNER JOIN titulos as t ON u.user_titulo = t.titulo_id
            INNER JOIN unidades as uni ON u.user_unidad = uni.unidad_id
            INNER JOIN cargos as c ON u.user_cargo = c.cargo_id
            INNER JOIN roles as r ON u.user_rol = r.rol_id  WHERE user_estado =1";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar usuarios de la DB para mostrarlos en la tabla
        public function selectUsersInactives(){
            $sql="SELECT CONCAT(t.titulo_abr, ' ', u.user_nom, ' ', u.user_ap, ' ', u.user_am, '<br/><b>E-mail:</b><br/>', u.user_mail) as info_user,  
            CONCAT('<b>Unidad:</b><br/>', uni.unidad_nom, '<br/><b>Cargo:</b><br/>',c.cargo_nom, '<br/><b>Rol: </b>', r.rol_nombre) as info_sict, user_estado, user_id, user_mail FROM usuarios as u
            INNER JOIN titulos as t ON u.user_titulo = t.titulo_id
            INNER JOIN unidades as uni ON u.user_unidad = uni.unidad_id
            INNER JOIN cargos as c ON u.user_cargo = c.cargo_id
            INNER JOIN roles as r ON u.user_rol = r.rol_id  WHERE user_estado =0";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar usuarios para mostrar en  pantalla de minutas
        public function selectUsersC(){
            $sql="SELECT t.titulo_abr, u.user_nom, u.user_ap, u.user_am, u.user_mail, 
            u.user_id, FROM usuarios as u 
            INNER JOIN titulos as t ON u.user_titulo = t.titulo_id 
            INNER JOIN roles as r ON u.user_rol = r.rol_id WHERE user_estado=1";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultar usuario para mostrar en el modal usuario
        public function selectUser(int $iduser){
            $this->intIdUser = $iduser;
            $sql="SELECT u.user_nom, u.user_ap, u.user_am, u.user_mail, u.user_unidad, u.user_cargo, u.user_rol, u.user_titulo,
            t.titulo_id, t.titulo_nom, 
            uni.unidad_nom, 
            c.cargo_nom, 
            r.rol_nombre, 
            user_estado, user_id, user_mail FROM usuarios as u 
            INNER JOIN titulos as t ON u.user_titulo = t.titulo_id 
            INNER JOIN unidades as uni ON u.user_unidad = uni.unidad_id 
            INNER JOIN cargos as c ON u.user_cargo = c.cargo_id 
            INNER JOIN roles as r ON u.user_rol = r.rol_id WHERE user_id = $this->intIdUser";
            $request = $this->select($sql);
            return $request;
        }

        //actualizar registro 
        public function updateUser(int $iduser, string $nombre, string $apellidoP, string $apellidoM, int $unidad, int $cargo, int $rol, int $titulo, string $mail){
            $this->intIdUser = $iduser;
            $this->strNom = $nombre;
            $this->strApe_p = $apellidoP;
            $this->strApe_m = $apellidoM;
            $this->intUnidad = $unidad;
            $this->intCargo = $cargo;
            $this->intRol = $rol;
            $this->intTitulo = $titulo;
            $this->strMail = $mail;
            $sql="SELECT * FROM usuarios WHERE user_mail= '$this->strMail' AND user_id != $this->intIdUser";
            $request=$this->select_all($sql);

            if(empty($request)){
                $sql="UPDATE usuarios SET user_nom =?, user_ap =?, user_am =?, user_unidad =?, user_cargo =?, user_rol =?, user_titulo =?, user_mail =? WHERE user_id= $this->intIdUser";
                $arrData= array($this->strNom, $this->strApe_p, $this->strApe_m, $this->intUnidad, $this->intCargo, $this->intRol, $this->intTitulo, $this->strMail);
                $request= $this->update($sql, $arrData);
            }
            else{
                $request= 0;
            }
            return $request;
        }

        //inactivar user
        public function deleteUser(int $iduser){
            $this->intIdUser = $iduser;
            $sql ="SELECT user_id, user_estado FROM usuarios WHERE user_id= $this->intIdUser";
            $request= $this->select_all($sql);
            if($request){
                $sql = "UPDATE usuarios SET user_estado=? WHERE user_id= $this->intIdUser";
                $arrData = array(0);
                $request= $this->update($sql, $arrData);
                if($request){
                    $request=1; //se ejecuto la consulta de inactivar usuario
                }
            }
            else{
                $request= 0; //este usuario ya se encuentra inactivo
            }
            return $request;
        }

        //inactivar user
        public function activeUser(int $iduser){
            $this->intIdUser = $iduser;
            $sql ="SELECT user_id, user_estado FROM usuarios WHERE user_id= $this->intIdUser";
            $request= $this->select_all($sql);
            if($request){
                $sql = "UPDATE usuarios SET user_estado=? WHERE user_id= $this->intIdUser";
                $arrData = array(1);
                $request= $this->update($sql, $arrData);
                if($request){
                    $request=1; //se ejecuto la consulta de activar usuario
                }
            }
            else{
                $request= 0; //este usuario ya se encuentra activo
            }
            return $request;
        }

        //registrar accion hecha
        public function historial(int $idUser, int $idAccion, string $ipUser){
            $return ='';
            $this->intIdUser =$idUser;
            $this->intIdAccion =$idAccion;
            $this->strIpUser =$ipUser;
            $return=0;

            $query_insert = "INSERT INTO historial(hist_user, hist_accion, hist_ip) VALUES(?,?,?);";
            $arrData = array($this->intIdUser, $this->intIdAccion, $this->strIpUser);
            $request_insert= $this->insert($query_insert, $arrData);
            $return = $request_insert;

            if($return){
                $return = 1;  
            }
            else{
                $return = 0;
            }
            return $return;
        }
        
    }
?>