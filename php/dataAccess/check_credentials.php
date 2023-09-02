<?php
include('connection.php');
include('../businessLogic/usuario.php');
if (isset($_POST['usernameL']) && isset($_POST['passwordL'])) {
    $username = $_POST['usernameL'];
    $password = $_POST['passwordL'];
    $stmt = $conn->prepare("SELECT * FROM Usuario WHERE apodo = ? AND contrasena = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        session_start();
        $user = $result->fetch_assoc();
        $_SESSION['userData'] = new Usuario(
            $user['id'],
            $user['apodo'],
            $user['nombre'],
            $user['apellido'],
            $user['correo'],
            $user['contrasena'],
            $user['telefono'],
            new DateTime($user['fechaNac']),
            $user['nombre_Rol']
        );
    }
    $stmt->close();
}

header("Location: ../../index.php"); 

?>