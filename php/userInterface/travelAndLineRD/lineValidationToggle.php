<?php
 include_once ($_SERVER['DOCUMENT_ROOT'].'/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'linea.php');
include_once(DATA_PATH . 'lineaLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lineaLink = new LineaLink($conn);

    $nombre = $_POST['nombre'];

    if ($lineaLink->validationToggleLinea($nombre)) {
        echo 'success';
    } else {
        echo 'error';
    }
    
} else {
    echo 'Método no permitido';
}
?>