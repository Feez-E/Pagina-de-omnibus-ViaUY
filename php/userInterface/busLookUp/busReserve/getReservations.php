<?php
 include_once ($_SERVER['DOCUMENT_ROOT'].'/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'reserva.php');
include_once(DATA_PATH . 'reservaLink.php');
include_once(BUSINESS_PATH . 'linea.php');
include_once(DATA_PATH . 'lineaLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lineaLink = new LineaLink($conn);

    $reservaLink = new ReservaLink($conn);


    $nombreLinea = $_POST['nombreLinea'];
    $unidad = $_POST["unidad"]; 
    $idInicial = $_POST['idInicial'];
    $idFinal = $_POST['idFinal'];
    $fecha = $_POST['fecha'];
    $horaLlegada = $_POST['horaLlegada'];
    $horaSalida = $_POST['horaSalida'];
    
    
    $linea = $lineaLink->getCodigoLineaByNombre($nombreLinea);

    $tramosOcupados = $reservaLink->getReservasFromTravel($linea, $unidad, $idInicial, $idFinal, $fecha, $horaSalida, $horaLlegada);
    
    if ($tramosOcupados !== null) {
        $response = array('status' => 'success', 'tramos' => $tramosOcupados);
     } else {
         $response = array('status' => 'error', 'message' => 'Hubo un error al procesar la solicitud.');
     }
     
     header('Content-Type: application/json');
     echo json_encode($response);
    
} else {
    echo 'Método no permitido';
}
?>