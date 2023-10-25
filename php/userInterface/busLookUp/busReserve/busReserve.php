<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../../../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Century+Gothic&display=swap" rel="stylesheet">
    <link rel="icon" href="../../../../ico/icon.ico">
    <title>ViaUY</title>
</head>

<body>
    <?php
    include '../../navBar/navBar.php';
    ?>
    <main>
        <div class=content>
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

    echo'<pre>';
    print_r($caracts);
    print_r($unidad);
    print_r($params);
    echo'</pre>';

    if ($unidad['capacidadSegundoPiso'] != 0) {
        echo"2 pisos";
    } else {
        echo"1 piso";
    }

}
?>
        </div>
    </main>

    <?php
    include '../../footer.php';
    ?>
</body>

</html>