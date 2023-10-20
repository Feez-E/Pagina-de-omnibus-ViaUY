<?php
 include_once ($_SERVER['DOCUMENT_ROOT'].'/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'unidad.php');
include_once(DATA_PATH . 'unidadLink.php');
include_once(BUSINESS_PATH . 'caracteristica.php');
include_once(DATA_PATH . 'caracteristicaLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unidadLink = new UnidadLink($conn);
    $caracteristicaLink = new CaracteristicaLink($conn);

    $nombreLinea = $_POST['nombreLinea'];
    $horaSalida = $_POST['horaSalida'];

    $unidad = $unidadLink->getUnidadesByLineaYHora($nombreLinea, $horaSalida);
    $caracteristicas = $caracteristicaLink->getCaracteristicasByNumeroUnidad($unidad->getNumero());
    
    if ($unidad !== null) {

       // Crear un arreglo asociativo para la respuesta JSON
       $response = array('status' => 'success', 'unidad' => $unidad, 'caracteristicas' => $caracteristicas);

       // Enviar la respuesta JSON
       header('Content-Type: application/json');
       echo json_encode($response);
    } else {
        echo 'error';
    }
    
} else {
    echo 'Método no permitido';
}
?>