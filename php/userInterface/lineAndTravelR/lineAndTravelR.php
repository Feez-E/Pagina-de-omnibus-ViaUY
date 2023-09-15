<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name= "viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Century+Gothic&display=swap" rel="stylesheet">
    <link rel="icon" href="../../../ico/icon.ico">
    <title>ViaUY</title>
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