<?php
 include_once ($_SERVER['DOCUMENT_ROOT'].'/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'parada.php');
include_once(DATA_PATH . 'paradaLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paradaLink = new ParadaLink($conn);

    $id = $_POST['id'];

    if ($paradaLink->deleteParada($id)) {
        echo 'success';
    } else {
        echo 'error';
    }
    
} else {
    echo 'Método no permitido';
}
?>