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
$tiquetLink = new TiquetLink($conn);
$lineaLink = new LineaLink($conn);
$paradaLink = new ParadaLink($conn);

$reservasArr = $reservaLink->getReservasByUserId($_SESSION['userData']->getId());
$previousTiquetFlag = 0;
$previousReserva;
$firstTime = true;
$seatsArray = [];
$fechaActual = new DateTime();


/* echo "<pre>";
print_r($reservasArr);
echo "</pre>"; */

?>
<script>
    let codigoTiquet;
    let fechaLimite;
    let seatsArray = [];
    let ciudadInicial;
    let ciudadFinal;
    let tiquetsReserva = [];
</script>
<?php

if (empty($reservasArr)) {

    echo "<p data-section='userReservations' data-value='noReservesTitle'>No hay reservas que mostrar.</p>
            <p data-section='userReservations' data-value='noReservesInfo'>Puedes hacer una reserva en cualquier momento:</p><br>
            <a href='/Proyecto Final/php/userInterface/busLookUp/busLookUp.php' class='indexButton button' data-section='index' data-value='reserve'>
                Reservar
            </a>";

} else {

    foreach ($reservasArr as $key => $reserva) {

        $tiquetFlagReserva = $reserva->getCodigo_Tiquet();

        if ($tiquetFlagReserva != $previousTiquetFlag) {

            if (!$firstTime) {

                $paradaFinal = $paradaLink->getParadaDirectionById($previousReserva->getAsiento()->getIdFinal_T_R_Transita());
                $direccionFinalSeparada = explode(",", $paradaFinal);
                $ciudadFinal = trim($direccionFinalSeparada[1]);
                citiesScript($previousReserva->getCodigo_Tiquet(), $ciudadInicial, $ciudadFinal);
                seatsScript($seatsArray, $previousReserva->getCodigo_Tiquet());
                $seatsArray = [];

                echo " 
                            <p>
                                <b>⇩</b>" . $previousReserva->getAsiento()->getIdFinal_T_R_Transita() . "<span>" . $paradaFinal . "
                                </span>
                            </p>
                        </div>
                        <section class = 'finalContent'>
                                <p>$" . $tiquetLink->getPrecioByCodigo($previousReserva->getCodigo_Tiquet()) . "</p>
                                <p class = 'ticketStatus'>" . $previousReserva->getEstado() . "</p>";

                if ($previousReserva->getFechaLimite() > $fechaActual && $previousReserva->getEstado() == "Pagado") {
                    echo "
                            <a class = 'button shadow declineReserve' data-section='userReservations' data-value='cancelReserve'>Cancelar reserva</a>";
                } else {
                    echo "
                                        <a class = 'button shadow declineReserve' style = 'display:none;'>Cancelar reserva</a>";
                }

                echo "          
                        </section>
                    </div>
                </div>";
            } else {
                $firstTime = false;
            }

            $paradaInicial = $paradaLink->getParadaDirectionById($reserva->getAsiento()->getIdInicial_T_R_Transita());

            echo "
                <div class = 'desplegableSection shadow' id = 'id_" . $reserva->getCodigo_Tiquet() . "'>
                    <div class= 'desplegableTitle'>
                        <div>
                            <h3></h3>
                            <p>" . $reserva->getCodigo_Tiquet() . "</p>
                        </div>
                        <div id = toggleArrow></div>
                    </div>
                    <div class = 'desplegableContent ticketContent'>
                        <p class='subtitle' data-section='userReservations' data-value='information'>Información</p>
                        <section>
                            <p><span data-section='userReservations' data-value='line'>Línea: </span>" . $lineaLink->getNombreLineaByCodigo($reserva->getAsiento()->getCodigo_L_R_Transita()) . "</p>
                            <p><span data-section='userReservations' data-value='unit'>Unidad: </span>" . $reserva->getAsiento()->getNumero_U_Transita() . "</p>
                            <p>" . $reserva->getFecha()->format("d-m-Y") . "</p>
                            <p>" . $reserva->getHora()->format("H:i") . "</p>
                        </section>
                        <p class = 'seatNumber'></p>
                        <div class= 'travelReservationSection'>
                            <p class='subtitle'data-section='userReservations' data-value='travel'>Viaje</p>
                            <p>
                                <b>⇧</b>" . $reserva->getAsiento()->getIdInicial_T_R_Transita() . "<span>" . $paradaInicial . "
                                </span>
                            </p>";

            $previousTiquetFlag = $tiquetFlagReserva;

            $direccionInicialSeparada = explode(",", $paradaInicial);
            $ciudadInicial = trim($direccionInicialSeparada[1]);

        }

        $previousReserva = $reserva;

        if (!in_array($reserva->getAsiento()->getNumero(), $seatsArray)) {
            $seatsArray[] = $reserva->getAsiento()->getNumero();
        }
        $paradaFinal = $paradaLink->getParadaDirectionById($previousReserva->getAsiento()->getIdFinal_T_R_Transita());
    }


    echo " 
                            <p>
                                <b>⇩</b>" . $previousReserva->getAsiento()->getIdFinal_T_R_Transita() . "<span>" . $paradaFinal . "
                                </span>
                            </p>
                        </div>
                        <section class = 'finalContent'>
                                <p>$" . $tiquetLink->getPrecioByCodigo($previousReserva->getCodigo_Tiquet()) . "</p>
                                <p class = 'ticketStatus' data-section='userReservations' data-value='" . $previousReserva->getEstado() . "'>" . $previousReserva->getEstado() . "</p>";

    if ($previousReserva->getFechaLimite() > $fechaActual && $previousReserva->getEstado() == "Pagado") {
        echo "
                            <a class = 'button shadow declineReserve' data-section='userReservations' data-value='cancelReserve'>Cancelar reserva</a>";
    } else {
        echo "
                            <a class = 'button shadow declineReserve' style = 'display:none;'></a>";
    }

    echo "          
                        </section>
                    </div>
                </div>";

    $direccionFinalSeparada = explode(",", $paradaFinal);
    $ciudadFinal = trim($direccionFinalSeparada[1]);
    citiesScript($reserva->getCodigo_Tiquet(), $ciudadInicial, $ciudadFinal);
    seatsScript($seatsArray, $reserva->getCodigo_Tiquet());

}
function citiesScript($codigoTiquet, $ciudadInicial, $ciudadFinal)
{
    ?>
    <script>
        codigoTiquet = <?php echo $codigoTiquet; ?>;
        ciudadInicial = '<?php echo $ciudadInicial; ?>';
        ciudadFinal = '<?php echo $ciudadFinal; ?>';

        document.querySelector(`#id_${codigoTiquet} h3`).innerHTML = `${ciudadInicial} - ${ciudadFinal}`;
    </script>
    <?php
}

function seatsScript($seatsArray, $codigoTiquet)
{
    ?>
    <script>
        codigoTiquet = <?php echo $codigoTiquet; ?>;
        seatsArray = <?php echo json_encode($seatsArray); ?>;

        document.querySelector(`#id_${codigoTiquet} .seatNumber`).innerHTML = `<span data-section='userReservations' data-value='seats'> Asientos: </span>${seatsArray.map(time => time).join(', ')}`;

        tiquetsReserva.push(<?php echo $codigoTiquet; ?>);
    </script>
    <?php
}

?>