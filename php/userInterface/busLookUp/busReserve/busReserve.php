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
        if (isset($_POST['unidad']) && isset($_POST['caracts'])) {
            // Decodifica los parámetros de URL
            $unidadJSON = urldecode($_POST['unidad']);
            $caractsJSON = urldecode($_POST['caracts']);
            $paramsJSON = urldecode($_POST['params']);

            // Analiza los objetos JSON en arrays o estructuras de datos
            $unidad = json_decode($unidadJSON, true); // El segundo parámetro true convierte en array asociativo
            $caracts = json_decode($caractsJSON, true);
            $params = json_decode($paramsJSON, true);



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
        <div class='selectedSeats container shadow'>
            <h3 class='pageSubtitle'>Asientos seleccionados:</h3>
            <div id='seatsAndPrices'>
                <p>Seleccione uno o más asientos</p>
            </div>
            <a class='button payButton'>Reservar</a>
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

<script src="../../../../js/busReserve.js"></script>