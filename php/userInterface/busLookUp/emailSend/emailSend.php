<!DOCTYPE html>
<html>

<head>
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
                        reserveAccepted($fechaTiquet);
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

function reserveAccepted($fecha)
{


    ?>
    <script>
        msg = "hola";
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
        <span>Lo sentimos, hubo un error con su reserva</span>
        <span>Alguno de los tramos de su viaje ya fue reservado, intente nuevamente</span>";
    } else {
        echo " 
        <span>Lo sentimos, hubo un error inesperado con su reserva</span>
        <span>Intente nuevamente más tarde</span>";
    }

}

?>