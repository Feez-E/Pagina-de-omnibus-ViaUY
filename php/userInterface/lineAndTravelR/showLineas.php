<?php
include_once('../../dataAccess/connection.php');
include_once('../../dataAccess/lineaLink.php');
include_once('../../dataAccess/transitaLink.php');
include_once('../../dataAccess/paradaLink.php');
include_once('../../dataAccess/tramoLink.php');
include_once('../../dataAccess/linea_diaHabilLink.php');

$lineaLink = new LineaLink($conn);
$lineasArr = $lineaLink->getLineas();

$transitaLink = new TransitaLink($conn);
$transitasArr = $transitaLink->getTransitas();
$indice = 0;

$paradaLink = new ParadaLink($conn);
$tramoLink = new TramoLink($conn);
$linea_diaHabilLink = new Linea_diaHabilLink($conn);


foreach ($lineasArr as $linea) {


    if (array_key_exists($indice, $transitasArr)) {

        $indicePrevio = $indice;
        if ($linea->getVigencia()) {
            echo "<div class = 'lineAndTravels shadow'><div class = line>";
            echo "<div class = lineLeft><h3  class = subtitle>" . $linea->getNombre() . " - " . $linea->getOrigen() . " / " . $linea->getDestino() . "</h3> ";
            $linea_diasHabilesArr = $linea_diaHabilLink->getLinea_diaHabilByCodigo_Linea($linea->getCodigo());
            echo "<p>";
            foreach ($linea_diasHabilesArr as $linea_diasHabil) {
                echo "<span data-section='lineAndTravelR'
                data-value='" . $linea_diasHabil->getDia() . "'>" . $linea_diasHabil->getDia() . " </span>";
            }
            echo "</p></div><div id = lineToggle></div>";
            echo "</div>";
            $fecha = new DateTime($transitasArr[$indice]->getHoraSalida_Salida());
            $hora_llegada = new DateTime($transitasArr[$indice]->getHoraLlegada_Llegada());
            echo "<div class = travels><div class = travel>";
            echo "<p>" . $transitasArr[$indice]->getIdInicial_T_Recorre() . "- " . $linea->getOrigen() . "</p>";
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
                $direccionInicial = $paradaInicial->getDireccion();
                $direccionFinal = $paradaFinal->getDireccion();
                $direccionInicialSeparada = explode(",", $direccionInicial);
                $direccionFinalSeparada = explode(",", $direccionFinal);
                $ciudadInicial = trim($direccionInicialSeparada[1]);
                $ciudadFinal = trim($direccionFinalSeparada[1]);
                $tramo = $tramoLink->getTramoByIdInicialAndIdFinal($paradaInicial->getId(), $paradaFinal->getId());
                $hora = (($tramo->getTiempo())->format('H:i:s'));
                list($horas, $minutos, $segundos) = explode(':', $hora);
                $fecha->add(new DateInterval("PT{$horas}H{$minutos}M{$segundos}S"));
                if ($ciudadInicial !== $ciudadFinal && $ciudadFinal !== "-") {
                    echo "<p>" . $transitasArr[$indice]->getIdFinal_T_Recorre() . "- " . $ciudadFinal . "</p>";

                }

            }

            $indice += 1;

        }
        if ($linea->getVigencia()) {

            echo "<p> Terminal: </p>";
            echo "</div><div class = travel>";

            $indice = $indicePrevio;
            $fecha = new DateTime($transitasArr[$indice]->getHoraSalida_Salida());
            echo "<p>" . $fecha->format('H:i') . "</p>";
        }
        $fecha = new DateTime($transitasArr[$indice]->getHoraSalida_Salida());
        while ($indice < count($transitasArr) && $transitasArr[$indice]->getCodigo_L_Recorre() == $linea->getCodigo()) {
            if ($linea->getVigencia()) {
                if ((new DateTime($transitasArr[$indice]->getHoraLlegada_Llegada()))->format('H:i:s') !== $hora_llegada->format('H:i:s')) {
                    echo "<p> " . $fecha->format('H:i') . "</p>";
                    echo "</div><div class = travel>";
                    $fecha = new DateTime($transitasArr[$indice]->getHoraSalida_Salida());
                    $hora_llegada = new DateTime($transitasArr[$indice]->getHoraLlegada_Llegada());
                    echo "<p>" . $fecha->format('H:i') . "</p>";

                }
                $paradaInicial = $paradaLink->getParadaById($transitasArr[$indice]->getIdInicial_T_Recorre());
                $paradaFinal = $paradaLink->getParadaById($transitasArr[$indice]->getIdFinal_T_Recorre());
                $direccionInicial = $paradaInicial->getDireccion();
                $direccionFinal = $paradaFinal->getDireccion();
                $direccionInicialSeparada = explode(",", $direccionInicial);
                $direccionFinalSeparada = explode(",", $direccionFinal);
                $ciudadInicial = trim($direccionInicialSeparada[1]);
                $ciudadFinal = trim($direccionFinalSeparada[1]);
                $tramo = $tramoLink->getTramoByIdInicialAndIdFinal($paradaInicial->getId(), $paradaFinal->getId());
                $hora = (($tramo->getTiempo())->format('H:i:s'));
                list($horas, $minutos, $segundos) = explode(':', $hora);
                $fecha->add(new DateInterval("PT{$horas}H{$minutos}M{$segundos}S"));
                if ($ciudadInicial !== $ciudadFinal && $ciudadFinal !== "-") {
                    echo "<p>" . $fecha->format('H:i') . "</p>";

                }

            }
            $indice += 1;

        }
        if ($linea->getVigencia()) {
            echo "<p>" . $fecha->format('H:i') . "<p>";
            echo "</div></div></div>";
        }
    }

}
?>