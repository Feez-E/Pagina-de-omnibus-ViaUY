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
    ?>
    <main class='container'>
        <h2 class="title">Reservar</h2>

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


        $cantTiquets = $tiquetLink->selectTiquetsFromDate($fechaTiquet);
        $tiquet = (intval($fechaTiquet . $cantTiquets) + 1);
        if ($tiquetLink->insertTiquet(new Tiquet($tiquet, $precioTotal))) {
            foreach ($asientos as $asiento) {
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
                        echo (
                            $reservaLink->insertReserva(
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
                            )
                            . "\n "
                        );
                    } else {
                        echo "asiento no insertado";
                    }
                }
            }
        } else {
            echo "error";
        }

        ?>
        <script>
            var unidad = <?php echo json_encode($unidad); ?>;
            var params = <?php echo json_encode($params); ?>;
            var asientos = <?php echo json_encode($asientos); ?>;
            var metodoDePago = <?php echo json_encode($metodoDePago); ?>;
            var precioTotal = <?php echo json_encode($precioTotal); ?>;
            var fechaActual = "<?php echo (new DateTime())->format('YmdHi'); ?>";
            var tramos = <?php echo json_encode($tramos); ?>;

            console.log(unidad);
            console.log(params);
            console.log(asientos);
            console.log(metodoDePago);
            console.log(precioTotal);
            console.log(fechaActual);
            console.log(tramos);
        </script>


        <script type="module" src="../../../../js/emailSend.js"></script>
    </main>

    <?php
    include '../../footer.php';
    ?>
</body>

</html>