<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name= "viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Century+Gothic&display=swap" rel="stylesheet">
    <link rel="icon" href="ico/icon.ico">
    <title>ViaUY</title>
    <script src = js/keepSessionStarted.js></script>
</head>
<body>
    <main>
        <?php
            include 'php/userInterface/navBar.php';
        ?>
        <div class = content>
            <div class = busDivition>
                <img class = busImage src = 'img/BusImg.png'>
            </div>
            <div class = reservationDivition>
                <a href = '#' class='reservationButton button'> Reservar </a>
            </div>
        </div>
</main>
   
    <?php
    include 'php/userInterface/footer.php';
    ?>
</body>
</html>