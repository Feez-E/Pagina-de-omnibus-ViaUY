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
    use Vtiful\Kernel\Format;

    include '../../navBar/navBar.php';
    ?>
    <main class='container'>
        <h2 class="title">Reservar</h2>

        <?php
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
        echo "<pre>";
        print_r("Ticket: \n");
        print_r((new DateTime())->format("YmdHi") . "\n \n");
        echo "</pre>";

        echo "<pre>";
        print_r("Asientos: \n");
        print_r($asientos);
        print_r($tramos);
        print_r($params["nombreLinea"]);
        print_r($unidad["numero"]);
        print_r($params["horaSalida"]);
        print_r($params["horaLLegada"]);
        echo "</pre>";

        echo "<pre>";
        print_r($unidad);
        print_r($params);
        print_r($asientos);
        print_r($metodoDePago . "\n");
        print_r($precioTotal . "\n");

        print_r($tramos);
        echo "</pre>";
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

    </main>

    <?php
    include '../../footer.php';
    ?>
</body>

</html>