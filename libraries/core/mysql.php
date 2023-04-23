<?php 
    class Mysql extends DB_conection{
        private $conexion;
        private $strQuery;
        private $arrVal;

        function __construct(){
            $this->conexion = new DB_conection();
            $this->conexion = $this->conexion->conectar();
        }

        //Consultas para el proyecto
        //insertar un registro
        public function insert(string $query, array $arrValues){
            $this->strQuery = $query;
            $this->arrVal = $arrValues;
            $insert = $this->conexion->prepare($this->strQuery);
            $resInsert = $insert->execute($this->arrVal);

            if($resInsert){
                $lastInsert = $this->conexion->lastInsertId();
            }
            else{
                $lastInsert =0;
            }
            return $lastInsert;
        }

        //Buscar un registro
        public function select(string $query){
            $this->strQuery = $query;
            $result = $this->conexion->prepare($this->strQuery);
            $result->execute();
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        //devuelve todos los registros
        public function select_all(string $query){
            $this->strQuery = $query;
            $result = $this->conexion->prepare($this->strQuery);
            $result->execute();
            $data = $result->fetchall(PDO::FETCH_ASSOC);
            return $data;
        }

        //actualiza registros
        public function update(string $query, array $arrValues){
            $this->strQuery = $query;
            $this->arrVal = $arrValues;
            $update = $this->conexion->prepare($this->strQuery);
            $resExecute = $update->execute($this->arrVal);
            return $resExecute;
        }

        //eliminar registros
        public function delete(string $query){
            $this->strQuery = $query;
            $result = $this->conexion->prepare($this->strQuery);
            $drop = $result->execute();
            return $drop;
        }
 
   }
?>