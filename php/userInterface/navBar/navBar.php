<header>
    <?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
    ?>

    <nav>
        <h1><a href="/Proyecto Final/index.php"><img src='/Proyecto Final/img/Logo.png' class="logo" alt="logo"
                    name="logo"></a></h1>
        <!-- 
        <div id="google_translate_element" class="google" style=" overflow:hidden"></div>
        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({ pageLanguage: 'es', includedLanguages: 'es,en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, gaTrack: true }, 'google_translate_element');
            }

            document.addEventListener('DOMContentLoaded', function () {


                function checkIframe() {
                    let translateIframe = document.querySelector('iframe');

                    function hideIframe() {
                        if (translateIframe) {
                            translateIframe.style.display = "none";
                        }
                    }

                    if (translateIframe) {
                        hideIframe();
                    } else {
                        let attempts = 0;
                        const maxAttempts = 100; // Set a maximum number of attempts to avoid infinite loop

                        const checkAndHide = () => {
                            translateIframe = document.querySelector('iframe');
                            attempts++;

                            if (translateIframe || attempts >= maxAttempts) {
                                hideIframe();
                            } else {
                                setTimeout(checkAndHide, 230);
                            }
                        };

                        checkAndHide();
                    }
                }

                checkIframe();

                document.getElementById("google_translate_element").addEventListener("any-event", () => {
                    checkIframe();
                });

            });

        </script>

        <script type="text/javascript"
            src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
 -->
        <?php

        include_once(BUSINESS_PATH . "usuario.php");
        session_start();
        if (isset($_SESSION["userData"])) {
            echo ("<a class='userName button logged shadow'>");
            echo ("<span id='userNameText'>");
            echo ($_SESSION["userData"]->getApodo());
        } else {
            echo ("<a class='userName button shadow'>");
            echo ("<span id='userNameText'>");
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
            <li> <a href='/Proyecto Final/php/userInterface/accountSettings/accountSettings.php' class=opt> Ajustes de
                    cuenta</a></li>
            <li> <a href='/Proyecto Final/php/dataAccess/logout.php' id="logout" class="opt"> Cerrar Sesion</a></li>
        </ul>
    </div>
</header>
<script src="/Proyecto Final/js/selector.js"> </script>