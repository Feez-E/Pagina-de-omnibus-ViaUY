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

$lineaLink = new LineaLink($conn);
$reservaLink = new ReservaLink($conn);
$asientoLink = new AsientoLink($conn);
$tiquetLink = new TiquetLink($conn);

// Decodifica los parámetros de URL
$precioTotalJSON = $_POST['precioTotal'];
$unidadJSON = $_POST['unidad'];
$paramsJSON = $_POST['params'];
$metodoDePago = $_POST['metodosDePago'];
$asientosJSON = $_POST['asientos'];

// Analiza los objetos JSON en arrays o estructuras de datos
$precioTotal = json_decode($precioTotalJSON, true); // El segundo parámetro true convierte en array asociativo
$unidad = json_decode($unidadJSON, true);
$params = json_decode($paramsJSON, true);
$asientos = json_decode($asientosJSON, true);

$tramos = [];
foreach ($params["paradas"] as $i => $parada) {
    if ($i < count($params["paradas"]) - 1) {

        if ($parada) {
            $tramos[$i]["inicio"] = $parada;
            $tramos[$i]["fin"] = $params["paradas"][$i + 1];
            $tramos[$i]["hora"] = $params["allhoras"][$i];
        }


    }
}

$fechaTiquet = (new DateTime())->format("YmdHi");
$linea = $lineaLink->getCodigoLineaByNombre($params["nombreLinea"]);
$result = "1";
$cantTiquets = $tiquetLink->selectTiquetsFromDate($fechaTiquet);

$tiquet = (intval($fechaTiquet . $cantTiquets) + 1);

$result = insertarReservaYAsientos($tiquet, $precioTotal, $asientos, $tramos, $linea, $unidad, $params, $metodoDePago, $tiquetLink, $asientoLink, $reservaLink);

function insertarReservaYAsientos($tiquet, $precioTotal, $asientos, $tramos, $linea, $unidad, $params, $metodoDePago, $tiquetLink, $asientoLink, $reservaLink)
{
    $result = null;

    if ($tiquetLink->insertTiquet(new Tiquet($tiquet, $precioTotal))) {
        foreach ($asientos as $asiento) {
            if ($result === 1062) {
                break;
            }
            foreach ($tramos as $key => $tramo) {
                $asientoObj = new Asiento(
                    $asiento,
                    $tramo["inicio"],
                    $tramo["fin"],
                    $linea,
                    $key,
                    $unidad["numero"],
                    new DateTime($params["horaSalida"]),
                    new DateTime($params["horaLLegada"])
                );
                if ($asientoLink->insertAsiento($asientoObj)) {
                    $result = $reservaLink->insertReserva(
                        $asiento,
                        $tramo["inicio"],
                        $tramo["fin"],
                        $linea,
                        $key,
                        $unidad["numero"],
                        $params["horaSalida"],
                        $params["horaLLegada"],
                        $_SESSION["userData"]->getId(),
                        "tiempoReserva",
                        "00-00-000",
                        $metodoDePago,
                        "Pagado",
                        $params["dia"],
                        $tramo["hora"],
                        $tiquet
                    );
                    if ($result === 1062) {
                        if ($reservaLink->deleteReservaByCodigoTiquet($tiquet)) {
                            $tiquetLink->deleteTiquetByCodigo($tiquet);
                        }
                        break;
                    }
                } else {
                    echo "asiento no insertado";
                }
            }
        }
    } else {
        echo "error al insertar el tiquet";
    }
    return $result;
}