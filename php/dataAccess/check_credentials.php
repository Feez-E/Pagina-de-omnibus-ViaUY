<?php
include('./connection.php');

$username = $_POST['usernameL'];
$password = $_POST['passwordL'];

$mysqli_query = mysqli_query($conn,"SELECT apodo, contrasena FROM Usuario;");
$isValid = false;

while ($user = mysqli_fetch_assoc($mysqli_query)) {
    if ($user['apodo'] === $username && $user['contrasena'] === $password) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $isValid = true;
        break;
    }
}

header("Content-Type: application/json");
$response = array("isValid" => $isValid);
echo json_encode($response);
?>