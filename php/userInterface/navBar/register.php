<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include('../../businessLogic/usuario.php');
include('../../dataAccess/userLink.php');
session_start();


if (
    isset($_POST['usernameR']) &&
    isset($_POST['name']) &&
    isset($_POST['lastname']) &&
    isset($_POST['birthdate']) &&
    isset($_POST['email']) &&
    isset($_POST['phoneNumber']) &&
    isset($_POST['passwordR']) &&
    isset($_POST['passwordConfirm']) &&
    !empty($_POST['usernameR']) &&
    !empty($_POST['name']) &&
    !empty($_POST['lastname']) &&
    !empty($_POST['birthdate']) &&
    !empty($_POST['email']) &&
    !empty($_POST['phoneNumber']) &&
    !empty($_POST['passwordR']) &&
    !empty($_POST['passwordConfirm'])
) {

    $birthdate = new DateTime($_POST['birthdate']);
    $fechaActual = new DateTime();
    $diferencia = $fechaActual->diff($birthdate)->y;

    // Edadedes maximas y minimas que tiene que tener el usuario para poder registrarse
    $edadMinima = 5;
    $edadMaxima = 120;

    if (
        substr($_POST['email'], -4) === '.com' &&
        strlen(ltrim(strval($_POST['phoneNumber']), "0")) === 8 && 
         $edadMinima <= $diferencia &&
         $diferencia <= $edadMaxima
    ) {


        // Crear una instancia de UserLink con la conexión a la base de datos 
        $register = new UserLink($conn);
        $executed = $register->registerUser(
            new Usuario(
                "0",
                $_POST['usernameR'],
                $_POST['name'],
                $_POST['lastname'],
                $_POST['email'],
                $_POST['passwordR'],
                $_POST['phoneNumber'],
                new DateTime($_POST['birthdate']),
                "Cliente"
            ),
            $_POST['passwordConfirm']
        );

        if ($executed) {
            $_SESSION['message'] = "Cuenta registrada con exito";
            header("Location: ../../../index.php");
            exit;
        }
    }

}

$_SESSION['message'] = "Error al registrarse, compruebe las credenciales ingresadas";
header("Location: ../../../index.php");
?>