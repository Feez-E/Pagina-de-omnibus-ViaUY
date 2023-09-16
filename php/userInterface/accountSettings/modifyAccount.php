<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'usuario.php');
include(DATA_PATH . 'userLink.php');
ob_start();
include('../navBar/navBar.php');
$navBarContent = ob_get_clean();

if (
    isset($_POST['nameAccSettings']) &&
    isset($_POST['lastnameAccSettings']) &&
    isset($_POST['emailAccSettings']) &&
    isset($_POST['phoneNumberAccSettings']) &&
    isset($_POST['birthdateAccSettings']) &&
    !empty($_POST['nameAccSettings']) &&
    !empty($_POST['lastnameAccSettings']) &&
    !empty($_POST['emailAccSettings']) &&
    !empty($_POST['phoneNumberAccSettings']) &&
    !empty($_POST['birthdateAccSettings'])
) {
    $birthdate = new DateTime($_POST['birthdateAccSettings']);
    $fechaActual = new DateTime();
    $diferencia = $fechaActual->diff($birthdate)->y;

    // Edadedes maximas y minimas que tiene que tener el usuario para poder registrarse
    $edadMinima = 5;
    $edadMaxima = 120;

    if (
        substr($_POST['emailAccSettings'], -4) === '.com' &&
        strlen(ltrim(strval($_POST['phoneNumberAccSettings']), "0")) === 8 &&
        $edadMinima <= $diferencia &&
        $diferencia <= $edadMaxima
    ) {
        // Crear una instancia de UserLink con la conexión a la base de datos
        $userLink = new UserLink($conn);
        $executed = $userLink->modifyUser(
            new Usuario(
                $_SESSION['userData']->getId(),
                $_SESSION['userData']->getApodo(),
                $_POST['nameAccSettings'],
                $_POST['lastnameAccSettings'],
                $_POST['emailAccSettings'],
                '0',
                $_POST['phoneNumberAccSettings'],
                new DateTime($_POST['birthdateAccSettings']),
                '0'
            )
        );
        if ($executed) {
            $_SESSION['userData']->setNombre($_POST['nameAccSettings']);
            $_SESSION['userData']->setApellido($_POST['lastnameAccSettings']);
            $_SESSION['userData']->setCorreo($_POST['emailAccSettings']);
            $_SESSION['userData']->setTelefono($_POST['phoneNumberAccSettings']);
            $_SESSION['userData']->setFechaNac(new DateTime($_POST['birthdateAccSettings']));
            $_SESSION['message'] = "Datos cambiados con exito";
            header("Location: accountSettings.php");
            exit;
        }
    }
}
$_SESSION['message'] = "Error al cambiar los datos";
header("Location: accountSettings.php");
?>