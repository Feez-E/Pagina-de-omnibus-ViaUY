<?php
 include_once ($_SERVER['DOCUMENT_ROOT'].'/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'linea.php');
include_once(DATA_PATH . 'lineaLink.php');
include_once(BUSINESS_PATH . 'linea_diaHabil.php');
include_once(DATA_PATH . 'linea_diaHabilLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lineaLink = new LineaLink($conn);
    $linea_diaHabilLink = new Linea_diaHabilLink($conn);

    $nombre = $_POST['nombre'];
    $diaHabil = $_POST['diaHabil'];

    $codigo = $lineaLink->getCodigoLineaByNombre($nombre);
    
    $response = $linea_diaHabilLink->updateLineaDiaHabil($codigo, $diaHabil); 
    if($response == "deletedLineaDiaHabil"){
        echo "deletedLineaDiaHabil";
    } else if ($response == "addedLineaDiaHabil"){
        echo "addedLineaDiaHabil";
    } else {
        echo "error";
    }

    
} else {
    echo 'Método no permitido';
}
?>