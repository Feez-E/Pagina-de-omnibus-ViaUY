<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(DATA_PATH . 'connection.php');
include_once(DATA_PATH . 'reservaLink.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $reservaLink = new ReservaLink($conn);

    $codigoTiquet = $_POST["codigo"];

    if ($reservaLink->changeStatusReservaByTiquet('Cancelado', $codigoTiquet)) {
        $response = array('status' => 'success', 'message'=> 'Reserva cancelada correctamente', 'codigoTiquet' => $codigoTiquet);
    } else {
        $response = array('status' => 'error', 'message' => 'Hubo un error al procesar la solicitud');
    }

    header('Content-Type: application/json');
    echo json_encode($response);

} else {
    echo 'Método no permitido';
}

?>