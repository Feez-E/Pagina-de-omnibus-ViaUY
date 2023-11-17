<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'unidad.php');
include_once(DATA_PATH . 'unidadLink.php');
include_once(BUSINESS_PATH . 'caracteristica.php');
include_once(DATA_PATH . 'caracteristicaLink.php');
include_once(DATA_PATH . 'connection.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unidadLink = new UnidadLink($conn);

    $numero = $_POST['numero'];

    if ($unidadLink->validationToggleUnidad($numero)) {
        echo 'success';
    } else {
        echo 'error';
    }

} else {
    echo 'Método no permitido';
}
?>