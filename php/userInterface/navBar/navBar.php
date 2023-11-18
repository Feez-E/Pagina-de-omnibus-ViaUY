<header>
    <?php

    include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
    ?>

    <nav>
        <h1><a href="/Proyecto Final/index.php"><img src='/Proyecto Final/img/Logo.png' class="logo" alt="logo"
                    name="logo"></a></h1>
        <section class="right">
            <label class="switch">
                <?php

                include_once(BUSINESS_PATH . "usuario.php");
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                echo "<input type='checkbox' id='changeLanguage'";
                if (isset($_SESSION["lang"]) && $_SESSION["lang"] == "en") {
                    echo "checked";
                }
                echo " ><span class='slider round'></span></label>";

                if (isset($_SESSION["userData"])) {
                    echo ("<a class='userName button logged shadow'>");
                    echo ("<span id='userNameText'>");
                    echo ($_SESSION["userData"]->getApodo());
                } else {
                    echo ("<a class='userName button shadow'>");
                    echo ("<span id='userNameText' data-section='navBar' data-value='loginText'>");
                    echo ('Iniciar Sesión');
                }
                echo ("</span>");
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-user">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                </a>

                <?php
                include_once(INTERFACE_PATH . 'navBar/loginAndRegiser.php');
                ?>

        </section>
    </nav>

    <div class='menu'>
        <div class='menuToggle <?php if (isset($_SESSION["userData"])) {
            echo "active";
        } ?>'></div>
        <ul class='menuOpt'>
            <?php
            include_once(INTERFACE_PATH . 'navBar/userOptions.php');
            ?>
        </ul>
        <ul id='userOpt' class='menuOpt'>
            <li> <a href='/Proyecto Final/php/userInterface/accountSettings/accountSettings.php' class=opt
                    data-section='options' data-value='accountSettings'> Ajustes de
                    cuenta</a></li>
            <li> <a href='/Proyecto Final/php/dataAccess/logout.php' id="logout" class="opt" data-section='options'
                    data-value='logOut'> Cerrar Sesion</a></li>
        </ul>
    </div>
</header>
<script src="/Proyecto Final/js/selector.js"> </script>
<script src="/Proyecto Final/js/translator.js"> </script>