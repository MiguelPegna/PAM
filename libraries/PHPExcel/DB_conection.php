<?php
    $DB_host = "127.0.0.1";
    $DB_user = "root";
    $DB_pass = "";
    $DB_name = "PAM";

    // Create connection
    $DB_conection = mysqli_connect($DB_host, $DB_user, $DB_pass, $DB_name);
    // Check connection
    $DB_conection = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); 
    if(mysqli_connect_errno()){
        echo'No se pudo hacer la conexion a la DB: ', mysqli_connect_error();
         exit();
    }
    mysqli_query($DB_conection, "SET NAMES 'utf8', lc_time_names = 'es_MX'");
?>