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
    <title>ViaUY - Mis reservas</title>
</head>

<body>
    <?php
    include '../navBar/navBar.php';
    ?>
    <main class="container">
        <h2 class="title">Mis reservas</h2>
        <?php
        try {
            if (!isset($_SESSION["userData"])) {
                echo "<p>Inicie sesión para continuar</p>";
                exit;
            }
        } catch (Exception) {
            echo "<p>Usuario incorrecto</p>";
            exit;
        }
        ?> 
        <?php
        include 'showReservas.php';
        ?>
    </main>

    <?php
    include '../footer.php';
    ?>
</body>
<script src="../../../js/toggleSelector.js"></script>
<script src="../../../js/userReservations.js"></script>
</html>