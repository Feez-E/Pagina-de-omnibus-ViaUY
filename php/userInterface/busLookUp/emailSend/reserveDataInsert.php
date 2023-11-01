<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'reserva.php');
include_once(DATA_PATH . 'reservaLink.php');
include_once(DATA_PATH . 'lineaLink.php');
include_once(BUSINESS_PATH . 'asiento.php');
include_once(DATA_PATH . 'asientoLink.php');
include_once(BUSINESS_PATH . 'tiquet.php');
include_once(DATA_PATH . 'tiquetLink.php');
include_once(DATA_PATH . 'connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $lineaLink = new LineaLink($conn);
    $reservaLink = new ReservaLink($conn);
    $asientoLink = new AsientoLink($conn);
    $tiquetLink = new TiquetLink($conn);

    // Ticket
    $fechaTiquet = $_POST['fechaTiquet'];
    $precio = $_POST¨["precio"];


    // Asientos
    $asientos = $_POST["asientos"];
    $tramos = $_POST["tramos"];
    $nombreLinea = $_POST['nombreLinea'];
    $unidad = $_POST["unidad"];
    $horaSalida = $_POST['horaSalida'];
    $horaLlegada = $_POST['horaLlegada'];


    //Reserva
    $idUsuario = $_POST['idUsuario'];
    $metodoDePago = $_POST["metodoDePago"];
    $fechaReserva = $_POST['fecha'];


    $linea = $lineaLink->getCodigoLineaByNombre($nombreLinea);

    $response = array('status' => 'success', 'message' => 'Solicitud procesada con exito.');

    $cantTiquets = $tiquetLink->selectTiquetsFromDate($fechaTiquet);
    $tiquet = (intval($fechaTiquet . $cantTiquets) + 1);
    if ($tiquetLink->insertTiquet(new Tiquet($tiquet, $precio))) {
        foreach ($asientos as $llave => $asiento) {
            foreach ($tramos as $key => $tramo) {
                $asientoObj = new Asiento(
                    $asiento,
                    $tramo["idInicial"],
                    $tramo["idFinal"],
                    $linea,
                    $key,
                    $unidad,
                    new DateTime($horaSalida),
                    new DateTime($horaLLegada)
                );

                if ($asientoLink->insertAsiento($asientoObj)) {
                    $reservaLink->insertReserva(
                        $asiento,
                        $tramo["inicio"],
                        $tramo["fin"],
                        $linea,
                        $key,
                        $unidad,
                        $horaSalida->format('H:i:s'),
                        $horaLLegada->format('H:i:s'),
                        $_SESSION["userData"]->getId(),
                        "",
                        (new DateTime($fechaReserva))->format('Y-m-d'),
                        $metodoDePago,
                        "Pagado",
                        (new DateTime($fechaReserva))->format('Y-m-d'),
                        $tramo["hora"],
                        $tiquet
                    );
                }
            }
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Hubo un error al insertar el tiquet.');
    }
    /*    $response = array('status' => 'error', 'message' => 'Hubo un error al procesar la solicitud.'); */
    header('Content-Type: application/json');
    echo json_encode($response);

} else {
    echo 'Método no permitido';
}
?>