<?php

    define('HOST_SERVER', 'localhost');
    define('DB_USUARIO', 'root');
    define('DB_PASSWORD', '1111');
    define('DB_DATABASE', 'loginSencillo');
    
    $conn = new mysqli(HOST_SERVER, DB_USUARIO, DB_PASSWORD, DB_DATABASE);
    

    if ($conn->connect_errno){
        die("Falló la conexión: {$conn->connect_error}");
    }
   
    $setnames = $conn->prepare("SET NAMES 'utf8'");
    $setnames->execute();
    
?>