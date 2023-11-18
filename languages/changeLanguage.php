<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lang'])) {
    // Obtén el idioma de la solicitud POST
    $lang = $_POST['lang'];

    // Actualiza la variable de sesión
    $_SESSION['lang'] = $lang;

    // Envía una respuesta de éxito al cliente
    echo 'success';
} else {
    // La solicitud no es de tipo POST o no se proporcionó el parámetro de idioma
    // Maneja el error según sea necesario
    http_response_code(400); // Bad Request
    echo 'Error: Parámetro de idioma no proporcionado o método de solicitud incorrecto';
}
?>