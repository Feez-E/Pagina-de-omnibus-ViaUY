<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'usuario.php');
include(DATA_PATH . 'userLink.php');
ob_start();
include('../navBar/navBar.php');
$navBarContent = ob_get_clean();

if (
    isset($_POST['oldPassword']) &&
    isset($_POST['newPassword']) &&
    isset($_POST['confirmPassword']) &&
    !empty($_POST['oldPassword']) &&
    !empty($_POST['newPassword']) &&
    !empty($_POST['confirmPassword'])
) {

    // Crear una instancia de UserLink con la conexión a la base de datos
    $userLink = new UserLink($conn);
    $executed = $userLink->changeUserPassword(
        $_SESSION['userData']->getId(),
        $_POST['oldPassword'],
        $_POST['newPassword'],
        $_POST['confirmPassword']
    );
    if ($executed) {
        // Mensaje de confirmación
        $_SESSION['message'] = "Contraseña cambiada con éxito";
        header("Location: accountSettings.php"); 
        exit;
    } else {
        $_SESSION['message'] = "Error al cambiar la contraseña";
    }
   
    
}
$_SESSION['message'] = "Error al cambiar la contraseña";
header("Location: accountSettings.php"); 
?>