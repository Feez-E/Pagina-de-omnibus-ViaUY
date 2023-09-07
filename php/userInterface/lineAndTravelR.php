<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name= "viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Century+Gothic&display=swap" rel="stylesheet">
    <link rel="icon" href="../../ico/icon.ico">
    <title>ViaUY</title>
</head>
<body>
    <main>
        <?php
            include 'navBar.php';
        ?>
        <div class = "container content">
            <h2 class = "title">Lineas y horarios</h2>
        <?php
            include 'showLineas.php';
        ?>
        </div>
</main>
   
    <?php
    include 'footer.php';
    ?>
</body>
<script src="../../js/lineToggleSelector.js"></script>
</html>