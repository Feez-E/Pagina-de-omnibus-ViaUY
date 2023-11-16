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
    ?>
    <main class='container busReserveMain'>
        <div>
            <div class="busAndInfo">
                <?php
                if (isset($_POST['unidad']) && isset($_POST['caracts'])) {
                    // Decodifica los parámetros de URL
                    $unidadJSON = $_POST['unidad'];
                    $caractsJSON = $_POST['caracts'];
                    $paramsJSON = $_POST['params'];

                    // Analiza los objetos JSON en arrays o estructuras de datos
                    $unidad = json_decode($unidadJSON, true); // El segundo parámetro true convierte en array asociativo
                    $caracts = json_decode($caractsJSON, true);
                    $params = json_decode($paramsJSON, true);

                    echo "
            <div class = 'container shadow' id='travelInfo' >
                <div class ='top'>
                    <p><span>Linea: </span>" . $params["nombreLinea"] . "</p>
                    <p><span>Unidad: </span>" . $unidad["numero"] . "</p>
                   
                </div>
                <div class = 'mid'>
                <p><span>Día: </span>" . $params["dia"] . "</p>
                </div>
                <div class ='bottom'>
                    <section>
                        <p>Subida:</p>
                        <p>" . $params["subida"] . "</p>
                        <p><span></span>" . $params["allhoras"][array_search($params["subida"], $params["paradas"])] . "</p>
                    </section>
                    <section>
                        <p>Bajada:</p>
                        <p>" . $params["bajada"] . "</p>
                        <p>" . $params["allhoras"][array_search($params["bajada"], $params["paradas"])] . "</p>
                    </section>
                </div>
            </div>";

                    switch (true) {
                        case $unidad['capacidadSegundoPiso'] != 0 && in_array("Sanitario", array_column($caracts, 'propiedad')):
                            twoFloorsAndBathroom();
                            break;
                        case $unidad['capacidadSegundoPiso'] != 0:
                            twoFloors();
                            break;
                        case in_array("Sanitario", array_column($caracts, 'propiedad')):
                            oneFloorAndBathroom();
                            break;
                        default:
                            oneFloor();
                            break;
                    }
                }
                ?>
            </div>
            <div class='selectedSeats container shadow'>
                <h3 class='pageSubtitle'>Asientos seleccionados:</h3>
                <div id='seatsAndPrices'>
                    <p>Seleccione uno o más asientos</p>
                </div>
                <div class="buttonDesplegableSection">
                    <a class='button payButton'>Pagar</a>
                    <div id="closeButton"></div>
                    <form class="buttonDesplegableSectionContent container" id="form"
                        action="../emailSend/emailSend.php" method="post">
                        <label for="metodosDePago" class="top-left">
                            <select id="metodosDePago" name="metodosDePago">
                                <option value="Default">Seleccione su método de pago</option>
                                <option value="MasterCard">MasterCard</option>
                                <option value="PayPal">PayPal</option>
                                <option value="Visa">Visa</option>
                            </select>
                        </label>
                        <input type="submit" class="button" value="Reservar" />
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php
    include '../../footer.php';
    ?>
</body>

</html>

<?php
function twoFloorsAndBathroom()
{
    echo '
    <div class = "bus" id = "twoFloors" >
        <div  id = "twoFloorsFstFloor" class = "bathroom"></div>
        <div  id = "twoFloorsSndFloor"></div>
    </div>';
}

function twoFloors()
{
    echo '
    <div class = "bus" id = "twoFloors" >
        <div  id = "twoFloorsFstFloor"></div>
        <div  id = "twoFloorsSndFloor"></div>
    </div>';
}

function oneFloorAndBathroom()
{
    echo '<div class = "bus bathroom" id = "oneFloor" ></div>';
}

function oneFloor()
{
    echo '<div class = "bus" id = "oneFloor" ></div>';
}
?>

<script>
    var unidad = <?php echo $unidadJSON; ?>;
    var caracts = <?php echo $caractsJSON; ?>;
    var params = <?php echo $paramsJSON; ?>;

</script>

<script type="module" src="../../../../js/busReserve.js"></script>