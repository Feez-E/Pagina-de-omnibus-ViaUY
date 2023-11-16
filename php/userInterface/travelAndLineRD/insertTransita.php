<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'tramo.php');
include_once(DATA_PATH . 'tramoLink.php');
include_once(DATA_PATH . 'lineaLink.php');
include_once(DATA_PATH . 'transitaLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tramoLink = new TramoLink($conn);
    $lineaLink = new LineaLink($conn);
    $transitaLink = new TransitaLink($conn);


    $unidad = $_POST['unidad'];
    $nombreLinea = $_POST['nombreLinea'];
    $tramos = $_POST['tramos'];
    $horaSalida = $_POST['horaSalida'];

    $tiempoTotal = $tramoLink->getTiempoTotalByIds($tramos);
    $numeroLinea = $lineaLink->getCodigoLineaByNombre($nombreLinea);

    $horaSalidaDate = new DateTime($horaSalida);
    list($horas, $minutos) = explode(':', $tiempoTotal);
    $horaSalidaDate->add(new DateInterval("PT{$horas}H{$minutos}M"));
    $horaLlegada = $horaSalidaDate->format('H:i');


    try {
        foreach ($tramos as $key => $tramo) {
            if (isset($tramo['idInicial'], $tramo['idFinal'])) {
                $transitaLink->insertTransita(
                    $numeroLinea,
                    $tramo["idInicial"],
                    $tramo["idFinal"],
                    $key,
                    $unidad,
                    $horaSalida,
                    $horaLlegada
                );
            }
        }
        if ($tiempoTotal) {
            $response = array('status' => 'success');
        }
    } catch (Exception $e) {
        $response = array('status' => 'error', 'error' => $e, 'message' => 'Horario no insertado');
    }

} else {
    $response = array('status' => 'error', 'message' => 'Método no permitido');
}

header('Content-Type: application/json');
echo json_encode($response);

?>