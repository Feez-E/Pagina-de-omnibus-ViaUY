<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'linea.php');
include_once(DATA_PATH . 'lineaLink.php');
include_once(BUSINESS_PATH . 'recorre.php');
include_once(DATA_PATH . 'recorreLink.php');
include_once(DATA_PATH . 'paradaLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tramoLink = new TramoLink($conn);


    $idInicial = $_POST['idInicial'];
    $idFinal = $_POST['idFinal'];
    $distancia = $_POST['distancia'];
    $tiempo = $_POST['tiempo'];




    try {
        if ($tramoLink->insertTramo($idInicial, $idFinal, $distancia, $tiempo)) {
            $response = array('status' => 'success', 'insert' => true);
        } else {
            $response = array('status' => 'success', 'insert' => false);
        }
    } catch (Exception $e) {
        $response = array('status' => 'error', 'message' => $e->getMessage());
    }

} else {
    $response = array('status' => 'error', 'message' => 'Método no permitido');
}

header('Content-Type: application/json');
echo json_encode($response);

?>