<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/Proyecto Final/dirs.php');
include_once(DATA_PATH."connection.php");
include_once(BUSINESS_PATH."usuario.php");
include_once(DATA_PATH."/permisoLink.php");

    if(isset($_SESSION["userData"])){
        $rol = $_SESSION["userData"]->getNombreRol();
        $permiso = new PermisoLink($conn);
        $permisos = $permiso->getRolByUsernameRol($rol);

        foreach ($permisos as $nombre => $url) {
            echo "<li> <a class = 'opt' href = \"/Proyecto Final/php/userInterface/". $url . "/". $url .".php\">" . $nombre . "</a></li>";
        }
    }

?>
