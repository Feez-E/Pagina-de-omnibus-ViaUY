<?php
 include_once ($_SERVER['DOCUMENT_ROOT'].'/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'linea.php');
include_once(DATA_PATH . 'lineaLink.php');
include_once(DATA_PATH . 'connection.php');
include_once(BUSINESS_PATH . 'transita.php');
include_once(DATA_PATH . 'transitaLink.php');
include_once(BUSINESS_PATH . 'linea_diaHabil.php');
include_once(DATA_PATH . 'linea_diaHabilLink.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $LineaLink = new LineaLink($conn);

    if ($lineas = $LineaLink->getLineas()) {
        // Crear un arreglo asociativo para la respuesta JSON
       $response = array('status' => 'success', 'lineas' => $lineas);
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