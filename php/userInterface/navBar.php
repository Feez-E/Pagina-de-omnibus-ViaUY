<header>

    <nav>
        <h1><a href='index.php'><img src='img/Logo.png' class=logo></a></h1>
        
            <?php
            include("./php/businessLogic/usuario.php");
            session_start();
            if (isset($_SESSION["userData"])) {
                echo ("<a class='userName button logged'>");
                echo ("<p id='userNameText'>");
                echo ($_SESSION["userData"]->getApodo());
            } else {
                echo ("<a class='userName button'>");
                echo ("<p id='userNameText'>");
                echo ('Iniciar Sesión');
            }
            echo ("</p>");
            ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-user">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </a>
        <?php
        include_once('loginAndRegiser.php');
        ?>
    </nav>

    <div class='menu'>
        <div class='menuToggle <?php if (isset($_SESSION["userData"])) {echo "active";}?>' ></div>
        <ul class='menuOpt'>
            <?php
                include_once('userOptions.php');
            ?>
        </ul>
        <ul id='userOpt' class='menuOpt'>
            <li> <a href='#' class=opt> Ajustes de cuenta</a></li>
            <li> <a href='./php/dataAccess/logout.php' id="logout" class="opt"> Cerrar Sesion</a></li>
        </ul>
    </div>
</header>
<script src="js/selector.js"> </script>