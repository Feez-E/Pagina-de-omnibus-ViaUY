<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'unidad.php');
include_once(DATA_PATH . 'unidadLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unidadLink = new UnidadLink($conn);

    $unidades = $unidadLink->getUnidadesVigentes();

    if ($unidades !== null) {

        // Crear un arreglo asociativo para la respuesta JSON
        $response = array('status' => 'success', 'unidades' => $unidades);

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