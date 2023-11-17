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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>ViaUY - Administrar unidades</title>
</head>

<body>
    <?php
    include '../navBar/navBar.php';

    ?>
    <main class="container">
        <h2 class="title">Administrar unidades</h2>

        <?php
        include './busInfoContainers.php';
        ?>

    </main>

    <?php
    include '../footer.php';
    ?>
</body>
<script src="../../../js/toggleSelector.js"></script>
<script src="../../../js/busRD.js"></script>

</html>