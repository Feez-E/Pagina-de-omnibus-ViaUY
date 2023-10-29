<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(DATA_PATH . 'tramoLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $tramoLink = new TramoLink($conn);


    $unidad = $_POST["unidad"];
    $idInicial = $_POST['idInicial'];
    $idFinal = $_POST['idFinal'];


    $precio = $tramoLink->calcularPrecioTramo($idInicial, $idFinal, $unidad);

    if ($precio !== null) {
        $response = array('status' => 'success', 'precio' => $precio);
    } else {
        $response = array('status' => 'error', 'message' => 'Hubo un error al procesar la solicitud.');
    }

    header('Content-Type: application/json');
    echo json_encode($response);

} else {
    echo 'Método no permitido';
}
?>