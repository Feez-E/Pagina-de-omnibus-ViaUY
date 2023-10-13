<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'linea.php');
include_once(DATA_PATH . 'lineaLink.php');
include_once(DATA_PATH . 'connection.php');
include_once(BUSINESS_PATH . 'transita.php');
include_once(DATA_PATH . 'transitaLink.php');
include_once(BUSINESS_PATH . 'linea_diaHabil.php');
include_once(DATA_PATH . 'linea_diaHabilLink.php');
include_once('../../dataAccess/paradaLink.php');
include_once('../../dataAccess/tramoLink.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $lineaLink = new LineaLink($conn);
    $lineasArr = $lineaLink->getLineas();

    $transitaLink = new TransitaLink($conn);
    $transitasArr = $transitaLink->getTransitas();
    $indice = 0;

    $paradaLink = new ParadaLink($conn);
    $tramoLink = new TramoLink($conn);
    $linea_diaHabilLink = new Linea_diaHabilLink($conn);

    $linesAndTimesArray = [];
    $linesArray = [];
    $timesArray = [];
    $returnArray = [];

    $startStop = $_POST["startStop"];
    $endStop = $_POST["endStop"];

    $time = new DateTime($_POST["time"]);
    $formatTime = $time->format("H:i");

    $date = new DateTime($_POST["date"]);
    $dow = $date->format("l");
    $days = [
        'Monday' => 'L', // Lunes
        'Tuesday' => 'M', // Martes
        'Wednesday' => 'X', // Miércoles
        'Thursday' => 'J', // Jueves
        'Friday' => 'V', // Viernes
        'Saturday' => 'S', // Sábado
        'Sunday' => 'D' // Domingo
    ];
    $dayFirstLetter = $days[$dow];

    foreach ($lineasArr as $linea) {


        if (array_key_exists($indice, $transitasArr)) {

            $indicePrevio = $indice;
            if ($linea->getVigencia()) {
                $linea_diasHabilesArr = $linea_diaHabilLink->getLinea_diaHabilByCodigo_Linea($linea->getCodigo());

                $fecha = new DateTime($transitasArr[$indice]->getHoraSalida_Salida());
                $hora_llegada = new DateTime($transitasArr[$indice]->getHoraLlegada_Llegada());
                $timesArray[] = ($paradaLink->getParadaById($transitasArr[$indice]->getIdInicial_T_Recorre())->getId());
                $linesArray = [];
                $diasHabiles = [];

                foreach ($linea_diasHabilesArr as $linea_diaHabil) {
                    $diasHabiles[] = $linea_diaHabil->getDia();
                }
                $linesArray["days"] = $diasHabiles;
            }

            while ($indice < count($transitasArr) && $transitasArr[$indice]->getCodigo_L_Recorre() == $linea->getCodigo()) {
                if ($linea->getVigencia()) {
                    if (
                        (new DateTime($transitasArr[$indice]->getHoraLlegada_Llegada()))->format('H:i:s')
                        !== $hora_llegada->format('H:i:s')
                    ) {
                        break;
                    }
                    $paradaInicial = $paradaLink->getParadaById($transitasArr[$indice]->getIdInicial_T_Recorre());
                    $paradaFinal = $paradaLink->getParadaById($transitasArr[$indice]->getIdFinal_T_Recorre());
                    $tramo = $tramoLink->getTramoByIdInicialAndIdFinal($paradaInicial->getId(), $paradaFinal->getId());
                    $hora = (($tramo->getTiempo())->format('H:i:s'));
                    list($horas, $minutos, $segundos) = explode(':', $hora);
                    $fecha->add(new DateInterval("PT{$horas}H{$minutos}M{$segundos}S"));

                    $timesArray[] = $paradaFinal->getId();

                }

                $indice += 1;

            }

            if ($linea->getVigencia()) {
                $indice = $indicePrevio;
                $linesArray["StopsId"] = $timesArray;
                $timesArray = [];
                $fecha = new DateTime($transitasArr[$indice]->getHoraSalida_Salida());
                $timesArray[] = $fecha->format('H:i');
            }



            $fecha = new DateTime($transitasArr[$indice]->getHoraSalida_Salida());
            while ($indice < count($transitasArr) && $transitasArr[$indice]->getCodigo_L_Recorre() == $linea->getCodigo()) {
                if ($linea->getVigencia()) {
                    if ((new DateTime($transitasArr[$indice]->getHoraLlegada_Llegada()))->format('H:i:s') !== $hora_llegada->format('H:i:s')) {

                        $linesArray[] = $timesArray;
                        $timesArray = [];

                        $fecha = new DateTime($transitasArr[$indice]->getHoraSalida_Salida());
                        $hora_llegada = new DateTime($transitasArr[$indice]->getHoraLlegada_Llegada());
                        $timesArray[] = $fecha->format('H:i');
                    }
                    $paradaInicial = $paradaLink->getParadaById($transitasArr[$indice]->getIdInicial_T_Recorre());
                    $paradaFinal = $paradaLink->getParadaById($transitasArr[$indice]->getIdFinal_T_Recorre());
                    $tramo = $tramoLink->getTramoByIdInicialAndIdFinal($paradaInicial->getId(), $paradaFinal->getId());
                    $hora = (($tramo->getTiempo())->format('H:i:s'));
                    list($horas, $minutos, $segundos) = explode(':', $hora);
                    $fecha->add(new DateInterval("PT{$horas}H{$minutos}M{$segundos}S"));
                    $timesArray[] = $fecha->format('H:i');
                }
                $indice += 1;

            }
            if ($linea->getVigencia()) {
                $linesArray[] = $timesArray;
                $timesArray = [];
                $linesAndTimesArray[$linea->getNombre()] = $linesArray;
            }
        }
    }

    foreach ($linesAndTimesArray as $clave => $lineAndTime) {
        if (in_array($dayFirstLetter, $lineAndTime['days'])) {

            if (in_array($startStop, $lineAndTime['StopsId']) && in_array($endStop, $lineAndTime['StopsId'])) {

                $startStopPosition = array_search($startStop, $lineAndTime['StopsId']);
                $endStopPosition = array_search($endStop, $lineAndTime['StopsId']);

                if ($startStopPosition < $endStopPosition) {
                    $returnArray[$clave] = $lineAndTime;
                }
            }
        }
    }

    // Crear un arreglo asociativo para la respuesta JSON
    $response = array('status' => 'success', 'lineas' => $returnArray);
    // Enviar la respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($response);

} else {
    echo 'Método no permitido';
}
?>