<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Century+Gothic&display=swap" rel="stylesheet">
    <link rel="icon" href="../../../ico/icon.ico">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.awesome-markers@2.0.4/dist/leaflet.awesome-markers.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://unpkg.com/leaflet.awesome-markers@2.0.4/dist/leaflet.awesome-markers.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>ViaUY - Reservar</title>
</head>

<body>
    <?php
    include '../navBar/navBar.php';
    ?>
    <main class="container">
    <div id="errorContainer" class="confirmationMessage container shadow">
    <p></p>
</div>
        <!--  <?php
        try {
            if (!isset($_SESSION["userData"])) {
                echo "<p>Inicie sesión para continuar</p>";
                exit;
            }
        } catch (Exception) {
            echo "<p>Usuario incorrecto</p>";
            exit;
        }
        ?> -->
        <div id="reservationSpecification">
            <h2 class="title">Reservar</h2>
            <div class="container shadow" id="form">
                <form id="busLookUpForm" action="#" method="post">
                    <section class ="tripleLabel">
                    <label for="startStop" class="top-left">
                        <span> Subida </span>
                        <input type="number" id="startStop" name="startStop" list="startStopsList" autocomplete="off" />
                        <datalist id=startStopsList>
                        </datalist>
                    </label>
                    <label for="endStop" class="top-right">
                        <span> Bajada </span>
                        <input type="number" id="endStop" name="endStop" list="endStopsList" autocomplete="off" />
                        <datalist id=endStopsList>
                        </datalist>
                    </label>
                    <div class="desplegableSection mapSection bottom">
                        <div class="desplegableTitle">
                            <div class="desplegableSectionLeft">
                                <h3 class="subtitle">Mapa de paradas</h3>
                                <p>Seleccione sus paradas</p>
                            </div>
                            <div id="toggleArrow"></div>
                        </div>
                        <div class="desplegableContent">
                            <div id="stopsMap" class ="tiny"></div>
                        </div>
                    </div>
                    </section>
                    <section class ="doubleLabel">
                    <label for="date" class="left">
                        <span> Día </span>
                        <input type="date" id="date" name="date" autocomplete="off" />
                    </label>
                    <label for="time" class="right">
                        <span> Hora </span>
                        <input type="time" id="time" name="time" autocomplete="off" />
                    </label>
                    </section>
                    <input type="submit" value="Buscar viajes" class="button">
                </form>
            </div>
        </div>

        <div id="betterLines">
        </div>
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
<script src="../../../js/toggleSelector.js"></script>
<script src="../../../js/busLookUp.js"></script>
<script type="module" src="../../../js/reservationMap.js"></script>

</html>