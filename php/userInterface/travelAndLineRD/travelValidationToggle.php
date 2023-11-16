<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'transita.php');
include_once(DATA_PATH . 'transitaLink.php');
include_once(DATA_PATH . 'lineaLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transitaLink = new TransitaLink($conn);
    $lineaLink = new LineaLink($conn);

    $nombreLinea = $_POST['nombreLinea'];
    $numeroLinea = $lineaLink->getCodigoLineaByNombre($nombreLinea);

    $unidad = $_POST['unidad'];
    $hora = $_POST['hora'];


    if ($transitaLink->validationToggleTransita($numeroLinea, $unidad, $hora)) {
        echo 'success';
    } else {
        echo 'error';
    }

} else {
    echo 'Método no permitido';
}
?>