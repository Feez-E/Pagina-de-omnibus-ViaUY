<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/Proyecto Final/dirs.php');

include('../../businessLogic/usuario.php');
include('../../dataAccess/userLink.php');


if (isset($_POST['usernameR']) &&
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
 !empty($_POST['passwordConfirm'])) {

    // Crear una instancia de UserLink con la conexión a la base de datos 
    $register = new UserLink($conn);
    $register->registerUser(new Usuario(
        "0",
        $_POST['usernameR'],
        $_POST['name'],
        $_POST['lastname'],
        $_POST['email'],
        $_POST['passwordR'],
        $_POST['phoneNumber'],
        new DateTime($_POST['birthdate']),
        "Cliente"
    ));

}

header("Location: ../../../index.php");
?>