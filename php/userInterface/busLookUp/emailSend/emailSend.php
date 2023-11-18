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
                        reserveAccepted($tiquet, $params["dia"], $horaInicial, $asientosJSON, $params["nombreLinea"], $precioTotal, $unidad["numero"], $params["subida"], $direccionParadaSubida, $params["bajada"], $direccionParadaBajada);
                    } else {
                        reserveNotAccepted($result);
                    }
                    ?>
                </p>
            </div>
            <div class=bottom>
                <a href="../../../../index.php" class="button inlineFlex" data-section='emailSend'
                    data-value='indexButton'>Inicio</a>
                <?php if ($result == 1) { ?>
                    <a href="../../userReservations/userReservations.php" class="button inlineFlex" data-section='emailSend'
                        data-value='seeReserve'>Ver reserva</a>
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

function reserveAccepted($tiquet, $dia, $hora, $asientos, $nombreLinea, $precioTotal, $unidad, $idSubida, $direccionParadaSubida, $idBajada, $direccionParadaBajada)
{

    ?>
    <script>
        msg = `
        <body style="width: 100%; text-align: center;">

    <h3 style="font-family: Tahoma; font-size: 1rem; font-weight: 400;">
        Reserva realizada exitósamente en ViaUY.<br>
        Si usted está recibiendo esta información por error, contáctanos a través de nuestras redes sociales.
    </h3>

    <br>

    <h3 style="font-family: Tahoma; font-size: 1rem; font-weight: 400;">
        Gracias por preferir nuestros servicios, a continuación se le proporcionan los detalles de la reserva:
    </h3>

    <div style="border: 3px solid rgb(223, 223, 223); border-radius: 20px; padding: 20px; justify-content: center; margin: 0 auto; width: 40%; margin-top: 20px; margin-bottom: 20px;">

        <header style="text-align: left;">
            <p style="font-size: 1.4rem; color: rgb(0, 113, 188);"><b>Código de la Reserva</b></p>
            <p style="font-size: 1.2rem;">`+ `<?php echo $tiquet; ?>` +`</p>
        </header>

        <p><b style="display: block; font-size: 1.3rem; color: rgb(0, 113, 188);">Información</b></p>

        <section style="display: inline-block; padding: 15px; display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">

            <p style="width: calc(50% - 5px);">Línea: `+ `<?php echo $nombreLinea; ?>` +`</p>
            <p style="width: calc(50% - 5px);">Unidad: `+ `<?php echo $unidad; ?>` +`</p>
            <p style="width: calc(50% - 5px);">Día: `+ `<?php echo $dia; ?>` +`</p>
            <p style="width: calc(50% - 5px);">Hora: `+ `<?php echo $hora; ?>` +`</p>

        </section>

        <div style="background-color: rgba(210, 210, 210, 0.4); border: none; border-radius: 15px; padding: 10px; margin: 20px;">
            <p style="text-align: left;">Asientos: `+ `<?php echo $asientos; ?>`.replace(/["()\[\]]/g, '') +`</p>
        </div>

        <div style="background-color: rgba(210, 210, 210, 0.4); border: none; border-radius: 15px; padding: 10px; margin: 20px;">
            <p style="display: block; font-size: 1.3rem; color: rgb(0, 113, 188);"><b>Viaje</b></p>
            <p style="text-align: left;"><b>⇧</b> `+ `<?php echo $idSubida; ?>` +`- `+ `<?php echo $direccionParadaSubida; ?>` +`</p>
            <p style="text-align: left;"><b>⇩</b> `+ `<?php echo $idBajada; ?>` +`- `+ `<?php echo $direccionParadaBajada; ?>` +`</p>
        </div>

        <section style="display: inline-block; padding: 15px; display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">

            <p style="width: calc(50% - 5px);">$`+ `<?php echo $precioTotal; ?>` +`</p>
            <p style="width: calc(50% - 5px);">Pagado</p>

        </section>

    </div>

    <footer>
        <a href="https://viauy-snowsouls.000webhostapp.com/php/userInterface/userReservations/userReservations.php" style="display: inline-block; padding: 10px; color: white; background: rgb(54, 113, 190); font-size: 1.3rem; font-weight: 500; border: 1px solid transparent; cursor: pointer; border-radius: 30px; transition: all 0.55s ease; text-decoration: none; filter: drop-shadow(0.2rem 0.2rem 0.25rem rgba(20, 42, 74, 0.25));" onmouseover="this.style.background='transparent'; this.style.border='1px solid rgb(54, 113, 190)'; this.style.color='rgb(54, 113, 190)'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='rgb(54, 113, 190)'; this.style.border='1px solid transparent'; this.style.color='white'; this.style.transform='translateX(0px)'" class="footer">Ver Reservas</a>
    </footer>
    <br>
    <a href="https://viauy-snowsouls.000webhostapp.com">
        <img src="https://viauy-snowsouls.000webhostapp.com/img/Logo.png" style="padding-bottom: 20px; width: 20%; cursor: pointer;">
    </a>
    <h3>
        <a href="https://www.facebook.com" style="display: inline-block; margin: 20px; transition: all 0.55s ease; fill: rgb(0, 113, 188); stroke: white; stroke-width: 1;" class="titleText">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
            </svg>
        </a>
    </h3>
</body>`;
        tiquet = <?php echo $tiquet; ?>;
        email = `<?php echo $_SESSION['userData']->getCorreo(); ?>`;
    </script>
    <?php
    echo "
    <span class = 'thanksMessage' data-section='emailSend' data-value='thanksMessage'>¡Gracias por usar nuestros servicios!</span>
    <span id='message' data-section='emailSend' data-value='waitMessage'>Espere mientras se le envía un email con la información de su reserva...</span>
    <script src='../../../../js/emailSend.js'></script>
    ";
}

function reserveNotAccepted($result)
{
    if ($result == 1062) {
        echo " 
        <span class = 'thanksMessage' data-section='emailSend' data-value='sorryMessage'>Lo sentimos, hubo un error con su reserva</span>
        <span  id='message' data-section='emailSend' data-value='duplicatedKeyMessage'>Alguno de los tramos de su viaje ya fue reservado, intente nuevamente</span>";
    } else {
        echo " 
        <span class = 'thanksMessage' data-section='emailSend' data-value='unexpectedMessage'>Lo sentimos, hubo un error inesperado con su reserva</span>
        <span  id='message' data-section='emailSend' data-value='tryLater'>Intente nuevamente más tarde</span>";
    }

}

?>