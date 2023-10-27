<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name= "viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../../css/style.css">
    <link rel="icon" href="../../../ico/icon.ico">
    <title>ViaUY - Lineas y horarios</title>
</head>
<body>
    <?php
        include '../navBar/navBar.php';
    ?>
    <main class = "container">
            <h2 class = "title">Lineas y horarios</h2>
        <?php
            include 'showLineas.php';
        ?>
    </main>
   
    <?php
    include '../footer.php';
    ?>
</body>
<script src="../../../js/lineToggleSelector.js"></script>
</html>