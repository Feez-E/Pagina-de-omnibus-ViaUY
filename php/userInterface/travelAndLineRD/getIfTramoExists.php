<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'tramo.php');
include_once(DATA_PATH . 'tramoLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tramoLink = new TramoLink($conn);


    $coordsInicio = $_POST['coordsInicio'];
    $coordsFinal = $_POST['coordsFinal'];



    if ($tramoLink->getIfTramoExistsByCoords($coordsInicio, $coordsFinal)) {
        $response = array('status' => 'success', 'tramo' => true);
    } else {
        $response = array('status' => 'success', 'tramo' => false);
    }

    header('Content-Type: application/json');
    echo json_encode($response);


} else {
    echo 'Método no permitido';
}
?>