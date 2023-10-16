<?php
 include_once ($_SERVER['DOCUMENT_ROOT'].'/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'linea.php');
include_once(DATA_PATH . 'lineaLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lineaLink = new LineaLink($conn);

    $codigo = $_POST['codigo'];

    $lineaName = $lineaLink->getNombreLineaByCodigo($codigo);
    
    if ($lineaName !== null) {

       // Crear un arreglo asociativo para la respuesta JSON
       $response = array('status' => 'success', 'lineName' => $lineaName);

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