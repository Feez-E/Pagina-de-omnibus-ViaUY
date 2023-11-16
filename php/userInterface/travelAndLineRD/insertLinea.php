<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'linea.php');
include_once(DATA_PATH . 'lineaLink.php');
include_once(BUSINESS_PATH . 'recorre.php');
include_once(DATA_PATH . 'recorreLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $lineaLink = new LineaLink($conn);
    $recorreLink = new RecorreLink($conn);


    $tramos = $_POST['tramos'];
    $nombreLinea = $_POST['nombreLinea'];
    $origen = $_POST['origenLinea'];
    $destino = $_POST['destinoLinea'];


    try {
        $codigoLinea = $lineaLink->insertLinea($nombreLinea, $origen, $destino);
        if ($codigoLinea) {
            foreach ($tramos as $key => $tramo) {
                if ($recorreLink->insertRecorre($codigoLinea, $tramo["idInicial"], $tramo["idFinal"], ($key + 1))) {
                    $response = array('status' => 'success', 'message' => "Línea insertada con éxito");
                } else {
                    $response = array('status' => 'success', 'message' => "Hubo un error al insertar la línea");
                    $recorreLink->deleteRecorreByCodigoLinea($codigoLinea);
                    $lineaLink->deleteLineaByCodigo($codigoLinea);
                    break;
                }


            }
        }


    } catch (Exception $e) {
        $response = array('status' => 'error', 'message' => $e->getMessage());
    }

} else {
    $response = array('status' => 'error', 'message' => 'Método no permitido');
}

header('Content-Type: application/json');
echo json_encode($response);

?>