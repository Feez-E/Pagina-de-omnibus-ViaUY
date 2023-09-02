<?php
include_once("./php/dataAccess/connection.php");
include_once("./php/businessLogic/usuario.php");
include_once("./php/dataAccess/permisoLink.php");

    if(isset($_SESSION["userData"])){
        $rol = $_SESSION["userData"]->getNombreRol();
        $permiso = new PermisoLink($conn);
        $permisos = $permiso->getRolByUsernameRol($rol);

        foreach ($permisos as $nombre => $url) {
            echo "<li> <a class = 'opt' href = ./php/userInteface/". $url .">" . $nombre . "</a></li>";
        }
    }

?>
