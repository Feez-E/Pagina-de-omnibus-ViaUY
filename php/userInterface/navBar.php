<header>
    
        <nav>
            <h1><a href = 'index.php'><img src = 'img/Logo.png' class = logo></a></h1>
            <a class='userName button'> 
                <p id='userNameText'>iniciar Sesion</p>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" class="feather feather-user">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </a>
            <?php
            include_once('loginAndRegiser.php');
            ?>
        </nav>
        
        <div class = 'menu'>
            <div class = 'menuToggle'></div>
            <ul class = 'menuOpt'>
                <li><a href='#' class = opt> horarios de salida</a></li>
                <li><a href='#' class = opt> mis reservas</a></li>
                <li><a href='#' class = opt> opt3</a></li>
                <li><a href='#' class = opt> opt4</a></li>
            </ul>
            <ul id = 'userOpt' class = 'menuOpt'>
                <li> <a href='#' class = opt> Ajustes de cuenta</a></li>
                <li> <a id="logout"class ="opt" > Cerrar Sesion</a></li>
            </ul>
        </div>
</header>
<script src="js/selector.js"> </script>
<script src="js/logout.js"> </script>