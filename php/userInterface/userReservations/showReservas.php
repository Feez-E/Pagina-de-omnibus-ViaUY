<?php
include_once('../../dataAccess/connection.php');
include_once('../../dataAccess/reservaLink.php');
include_once('../../dataAccess/tiquetLink.php');
include_once('../../dataAccess/unidadLink.php');
include_once('../../dataAccess/userLink.php');
include_once('../../businessLogic/reserva.php');



$reservaLink = new ReservaLink($conn);
$reservasArr = $reservaLink->getReservasByUserId($_SESSION['userData']->getId());

$previousTiquetFlag = 0;
$firstTime = true;

echo "<pre>";
print_r($reservasArr);
echo "</pre>";

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
            <div class = 'desplegableSection shadow'>
                <div class= 'desplegableTitle'>
                    <div class = left>
                        <h3  class = subtitle>" . $reserva->getCodigo_Tiquet() . " </h3>
                        <p></p>
                    </div>
                    <div id = toggleArrow></div>
                </div>
                <div class = 'desplegableContent'>";

        $previousTiquetFlag = $tiquetFlagReserva;

    }

    echo $key . ' ';

}
?>