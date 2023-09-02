<?php
include('../businessLogic/usuario.php');
include('../dataAccess/userLink.php');

if (isset($_POST['usernameL']) && isset($_POST['passwordL'])) {
    $username = $_POST['usernameL'];
    $password = $_POST['passwordL'];

    // Crear una instancia de AuthenticationService con la conexión a la base de datos
    $authService = new UserLink($conn);
    $user = $authService->getUserByUsernameAndPassword($username, $password);

    if ($user !== null) {
        // Usuario autenticado, realizar acciones adicionales si es necesario
        session_start();
        $_SESSION['userData'] = $user;
    }
}

header("Location: ../../index.php");
?>