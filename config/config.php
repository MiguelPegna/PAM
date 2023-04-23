<?php
    /*SE DECLARAN LAS VARIABLES GLOBALES DE DIRECCION
    ESTAS CAMBIARAN DEPENDIENDO LA URL QUE SE REQUIERA COMO DIRECCIONM PRINCIPAL
    */
    //define('BASE_URL', 'http://localhost/PAM/');
    //const BASE_URL = 'http://10.33.142.92/';
    const BASE_URL = '../PAM/';
    const URL_FULL = 'http://localhost/PAM/';
    //const URL_FULL = 'http://10.33.142.92/';

    
    //constante para mandar a llamar el header
    const CAB = 'views/_templates/header.php';
    const FOOT = 'views/_templates/footer.php';

    //zona horaria
    date_default_timezone_set('America/Mexico_City');

    //constantes para la conexion a la DB
    const DB_HOST = '127.0.0.1';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_NAME = 'pam';
    const DB_CHARSET = 'charset=utf8';

    //delimitadores decimal y millar ej 24,1989.00
    const SPD ='.';
    const SPM =',';
    //simbolo de moneda
    const SMONEY ='$'; 
    const TMONEYMEX ='MXN';

?>