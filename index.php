<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name= "viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Century+Gothic&display=swap" rel="stylesheet">
    <link rel="icon" href="ico/icon.ico">
    <title>ViaUY - Inicio</title>
</head>
<body>
    <?php
        include 'php/userInterface/navBar/navBar.php';
    ?>
    <main class = indexContent>
            <div class = "container busDivition">
                <img class = busImage src = 'img/BusImg.png'>
            </div>
            <div class ="container reservationDivition">
                <a href = '#' class='reservationButton button'> Reservar </a>
                <a href = 'php/userInterface/lineAndTravelR/lineAndTravelR.php' class='reservationButton button'> Ver Horarios </a>
            </div>
</main>
   
    <?php
    include 'php/userInterface/footer.php';
    ?>
</body>
</html>