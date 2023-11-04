<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../../../css/style.css">
    <link rel="icon" href="../../../../ico/icon.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>ViaUY</title>

</head>

<body>
    <?php

    include '../../navBar/navBar.php';
    include './reserveData.php';

    ?>
    <main class='container centeredMain'>

        <div id='reserveMessage'>
            <div class=top>
                <p>
                    <?php
                    if ($result == 1) {
                        reserveAccepted($tiquet, $params["dia"], $horaInicial, $asientosJSON);
                    } else {
                        reserveNotAccepted($result);
                    }
                    ?>
                </p>
            </div>
            <div class=bottom>
                <a href="../../../../index.php" class="button inlineFlex">Inicio</a>
                <?php if ($result == 1) { ?>
                    <a href="../../userReservations/userReservations.php" class="button inlineFlex">Ver reserva</a>
                <?php } ?>
            </div>
        </div>

    </main>

    <?php
    include '../../footer.php';
    ?>
</body>

</html>

<?php

function reserveAccepted($fecha, $dia, $hora, $asientos)
{


    ?>
    <script>
        msg = `<p style="font-weight:bold;font-size: 1.2rem;">Usted tiene una reserva para el <?php echo $dia; ?> a las <?php echo $hora; ?> </p><p>Asiento/s <?php echo $asientos; ?> </p>`;
        fecha = <?php echo $fecha; ?>;
        email = `<?php echo $_SESSION['userData']->getCorreo(); ?>`;
    </script>
    <?php
    echo "
    <span class = 'thanksMessage'>¡Gracias por usar nuestros servicios!</span>
    <span id='message'></span>
    <script src='../../../../js/emailSend.js'></script>
    ";
}

function reserveNotAccepted($result)
{
    if ($result == 1062) {
        echo " 
        <span class = 'thanksMessage'>Lo sentimos, hubo un error con su reserva</span>
        <span  id='message'>Alguno de los tramos de su viaje ya fue reservado, intente nuevamente</span>";
    } else {
        echo " 
        <span class = 'thanksMessage'>Lo sentimos, hubo un error inesperado con su reserva</span>
        <span  id='message'>Intente nuevamente más tarde</span>";
    }

}

?>