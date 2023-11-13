<?php
include_once('../../dataAccess/connection.php');
include_once('../../dataAccess/reservaLink.php');
include_once('../../dataAccess/paradaLink.php');
include_once('../../dataAccess/tiquetLink.php');
include_once('../../dataAccess/unidadLink.php');
include_once('../../dataAccess/userLink.php');
include_once('../../dataAccess/lineaLink.php');
include_once('../../businessLogic/reserva.php');



$reservaLink = new ReservaLink($conn);
$reservasArr = $reservaLink->getReservasByUserId($_SESSION['userData']->getId());

$previousTiquetFlag = 0;
$previousReserva;
$firstTime = true;

$lineaLink = new LineaLink($conn);
/* echo "<pre>";
print_r($reservasArr);
echo "</pre>"; */

foreach ($reservasArr as $key => $reserva) {

    $tiquetFlagReserva = $reserva->getCodigo_Tiquet();

    if ($tiquetFlagReserva != $previousTiquetFlag) {

        if (!$firstTime) {

            echo " 

                </div>
            </div>";
        } else {
            $firstTime = false;
        }

        echo "
            <div class = 'desplegableSection shadow' id = 'id_" . $reserva->getCodigo_Tiquet() . "'>
                <div class= 'desplegableTitle'>
                    <div>
                        <h3>" . $reserva->getCodigo_Tiquet() . "</h3>
                        <p>" . $reserva->getCodigo_Tiquet() . "</p>
                    </div>
                    <div id = toggleArrow></div>
                </div>
                <div class = 'desplegableContent ticketContent'>
                    <p class='subtitle'>Información</p>
                    <p>Línea: " . $lineaLink->getNombreLineaByCodigo($reserva->getAsiento()->getCodigo_L_R_Transita()) . "</p>
                    <p>Unidad: " . $reserva->getAsiento()->getNumero_U_Transita() . "</p>
                    <p>Fecha: " . $reserva->getFecha() . "</p>
                    <p class = 'seatNumber'>Asientos: </p>
                    <p class='subtitle'>Viaje</p>
                    <p>↑ " . $reserva->getAsiento()->getIdInicial_T_R_Transita() . "</p>";

        $previousTiquetFlag = $tiquetFlagReserva;

    }

    $previousReserva = $reserva;

    echo '/';


}
?>