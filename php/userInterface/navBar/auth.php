<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH.'usuario.php');
include(DATA_PATH.'userLink.php');

if (isset($_POST['usernameL']) && isset($_POST['passwordL'])) {
    $username = $_POST['usernameL'];
    $password = $_POST['passwordL'];

    // Crear una instancia de UserLink con la conexión a la base de datos
    $auth = new UserLink($conn);
    $user = $auth->getUserByUsernameAndPassword($username, $password);

    if ($user !== null) {
        // Usuario autenticado
        session_start();
        $_SESSION['userData'] = $user; 
    }
}

header("Location: ../../../index.php"); 
?>