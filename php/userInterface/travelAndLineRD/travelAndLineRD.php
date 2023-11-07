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
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <title>ViaUY - Administrar viajes y lineas</title>
</head>

<body>
    <?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
    include '../navBar/navBar.php';
    $rolPermitido = "Administrador Maestro";
    ?>
    <main class="container">
        <div id="errorContainer" class="confirmationMessage container shadow">
            <p></p>
        </div>
        <h2 class="title">Administrar viajes y líneas</h2>
        <?php
        if (!isset($_SESSION["userData"]) || $_SESSION["userData"]->getNombreRol() !== $rolPermitido) {
            echo "<p class = 'errorMessage'> Inicie sesión como administrador para ver esta pagina </p>";
            exit;
        }
        ?>
        <div class="desplegableSection container shadow">
            <div class="desplegableTitle">
                <div>
                    <h3>Mapa de líneas</h3>
                    <p>Ver líneas y paradas disponibles</p>
                </div>
                <div id="toggleArrow"></div>
            </div>
            <div class="desplegableContent" style="padding: 0px;">
                <div id="stopsMap" class="shadow"></div>
            </div>
        </div>

        <div class="container linesSubtitle">
            <h3>Líneas</h3>
            <a class=button>Ver unidades</a>
        </div>
        <div class="desplegableSection shadow">
            <div class=desplegableTitle>
                <div class=lineLeft>
                    <h3 class=subtitle> Agregar linea</h3>
                    <p>Creación de lineas</p>
                </div>
                <div id="toggleArrow"></div>
            </div>
            <div class="desplegableContent container" id=form>
                <form id="lineForm" action="#" method="post">
                    <label for="lineName">
                        <span>Nombre de la línea:</span>
                        <input type="text" id="lineName" name="lineName" autocomplete="off" />
                    </label>
                    <fieldset>
                        <legend>Paradas:</legend>
                        <ul id="stopsList">
                        </ul>
                        <label for="addStop">
                            <input type="number" id="addStop" name="addStop" autocomplete="off" placeholder="Ej. 1" />
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-plus" id="addStopButton">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </label>
                    </fieldset>
                    <input type="submit" value="Confirmar" class="button" />
                </form>
            </div>
        </div>
        <?php
        include_once("../../dataAccess/paradaLink.php");
        $paradaLink = new ParadaLink($conn);
        $jsonParadas = json_encode($paradaLink->getAllParadas());
        include_once("../../dataAccess/recorreLink.php");
        $recorreLink = new RecorreLink($conn);
        $jsonRecorridos = json_encode($recorreLink->getAllRecorridos());
        ?>
        <script>
            var paradasArray = <?php echo $jsonParadas; ?>;
            var recorridosArray = <?php echo $jsonRecorridos; ?>;
        </script>
        <?php
        include 'showLineas.php';
        ?>
    </main>
    <?php
    include '../footer.php';
    ?>
</body>

<script src="../../../js/lineToggleSelector.js"></script>
<script src="../../../js/toggleSelector.js"></script>
<script type="module" src="../../../js/linesMap.js"></script>
<script type="module">
    import { agregarParada, lineFormSubmit } from '../../../js/linesMap.js';

    var paradas = [];
    window.addEventListener('load', () => {
        document.getElementById("addStop").onkeydown = function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
                stops(paradas);
            }
        };
        document.getElementById("addStopButton").onclick = () => {
            stops(paradas);
        }

        lineFormSubmit(paradas);
    });

    function stops(paradas) {
        const stop = agregarParada(paradas);
        if (stop) {
            paradas.push(stop);

            stopSpanOnClick();

            function stopSpanOnClick() {
                document.querySelectorAll("#stopsList li span").forEach((span, i) => {
                    span.onclick = () => {
                        paradas.splice(i, 1);
                        span.parentElement.parentElement.removeChild(span.parentElement);
                        stopSpanOnClick();
                    }
                });
            }
        }
    }
</script>

</html>