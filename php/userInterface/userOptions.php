<?php
    include('../businessLogic/usuario.php');
    include('../businessLogic/rol.php');
    include('../businessLogic/tiene.php');
    include('../businessLogic/permiso.php');

    $rol = $_SESSION["userData"]->getNombreRol();
?>

<li class= opt><a>1</a></li>
<li class= opt><a>2</a></li>
<li class= opt><a>3</a></li>