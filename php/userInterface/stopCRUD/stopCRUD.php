<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../../css/style.css">
    <link rel="icon" href="../../../ico/icon.ico">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.awesome-markers@2.0.4/dist/leaflet.awesome-markers.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://unpkg.com/leaflet.awesome-markers@2.0.4/dist/leaflet.awesome-markers.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>ViaUY - Administrar paradas</title>
</head>

<body>
    <?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
    include '../navBar/navBar.php';
    $rolPermitido = "Administrador Maestro";
    ?>
    <main class="container">
        <h2 class="title">Administrar paradas</h2>
        <?php
        if (!isset($_SESSION["userData"]) || $_SESSION["userData"]->getNombreRol() !== $rolPermitido) {
            echo "<p class = 'errorMessage'> Inicie sesión como administrador para ver esta pagina </p>";
            exit;
        }
        ?>
        <div id="stopsMap" class="shadow"></div>
        <?php
        include_once("../../dataAccess/paradaLink.php");
        $paradaLink = new ParadaLink($conn);
        $jsonParadas = json_encode($paradaLink->getAllParadas());
        ?>
        <script>
            var paradasArray = <?php echo $jsonParadas; ?>;
        </script>
    </main>
    <?php
    include '../footer.php';
    ?>
</body>
<script type="module" src="../../../js/stopsMap.js"></script>
<script src="../../../js/lineToggleSelector.js"></script>

</html>