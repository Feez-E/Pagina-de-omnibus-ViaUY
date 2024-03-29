<!DOCTYPE html>
<html lang="es">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../../css/style.css">
    <link rel="icon" href="../../../ico/icon.ico">
    <title>ViaUY - Ajustes de cuenta</title>
</head>

<body>
    <?php
    include '../navBar/navBar.php';
    ?>
    <main class=container>
        <?php
        if (isset($_SESSION['message'])) { ?>
            <div class="confirmationMessage container shadow slideIn">
                <p>
                    <?php echo $_SESSION['message'] ?>
                </p>
            </div>
            <?php
            unset($_SESSION['message']); // Eliminar el mensaje de confirmación para que no se muestre nuevamente
        }
        ?>
        <h2 class="title" data-section='accountSettings' data-value='title'>Ajustes de cuenta</h2>
        <div class="container" id="user">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="21.2" viewBox="0 0 24 21.2" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-user shadow">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
                <line x1="4" y1="21.2" x2="20" y2="21.2"></line>
            </svg>
            <?php
            try {
                if (isset($_SESSION["userData"])) {
                    include_once(BUSINESS_PATH . "usuario.php");
                    echo ("<p>" . $_SESSION["userData"]->getApodo() . " - <span data-section='accountSettings' data-value='" . $_SESSION["userData"]->getNombreRol() . "'>" . $_SESSION["userData"]->getNombreRol() . "</span></p>");
                } else {
                    echo "Nombre de usuario incorrecto";
                }

            } catch (Exception) {
                echo "Nombre de usuario incorrecto";
            }
            ?>
        </div>
        <div class="container shadow" id="form">
            <?php
            try {
                if (isset($_SESSION["userData"])) {
                    ?>
                    <div class="passwordSection">
                        <a class="button shadow" data-section='accountSettings' data-value='changePassword'>Cambiar
                            contraseña</a>
                        <div id="passwordCancel"></div>
                        <form id=passwordForm action="./changePassword.php" method="post">
                            <label for="oldPassword" class="editable">
                                <span data-section='navBar' data-value='passwordPH'> Contraseña </span>
                                <input type="text" id="oldPassword" name="oldPassword" autocomplete="off" required />
                            </label>
                            <label for="newPassword" class="editable">
                                <span data-section='accountSettings' data-value='newPassword'> Nueva contraseña </span>
                                <input type="text" id="newPassword" name="newPassword" autocomplete="off" required />
                            </label>
                            <label for="confirmPassword" class="editable">
                                <span data-section='navBar' data-value='confirmPasswordPH'> Confirmar contraseña </span>
                                <input type="text" id="confirmPassword" name="confirmPassword" autocomplete="off" required />
                            </label>
                            <input type="submit" value="Confirmar" class="button" data-section='general' data-value='confirm'>
                        </form>
                    </div>
                    <div class="modifyReturn"></div>
                    <form id=accSettingsForm action="./modifyAccount.php" method="post">
                        <label for="nameAccSettings">
                            <span data-section='navBar' data-value='namePH'> Nombre </span>
                            <input type="text" id="nameAccSettings" name="nameAccSettings" autocomplete="off" required
                                value=<?php echo "\"" . ($_SESSION["userData"]->getNombre()) . "\"" ?> readonly />
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-tool">
                                <path
                                    d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                                </path>
                            </svg>
                        </label>
                        <label for="lastnameAccSettings">
                            <span data-section='navBar' data-value='lastnamePH'> Apellido </span>
                            <input type="text" id="lastnameAccSettings" name="lastnameAccSettings" autocomplete="off" required
                                value=<?php echo "\"" . ($_SESSION["userData"]->getApellido()) . "\"" ?> readonly />
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-tool">
                                <path
                                    d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                                </path>
                            </svg>
                        </label>
                        <label for="emailAccSettings">
                            <span data-section='navBar' data-value='emailPH'> Correo electrónico </span>
                            <input type="email" id="emailAccSettings" name="emailAccSettings" autocomplete="off" required
                                value=<?php echo "\"" . ($_SESSION["userData"]->getCorreo()) . "\"" ?> readonly />
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-tool">
                                <path
                                    d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                                </path>
                            </svg>
                        </label>
                        <label for="phoneNumberAccSettings">
                            <span data-section='navBar' data-value='phoneNumberPH'> Teléfono </span>
                            <input type="number" id="phoneNumberAccSettings" name="phoneNumberAccSettings" autocomplete="off"
                                required value=<?php echo "\"" . ($_SESSION["userData"]->getTelefono()) . "\"" ?> readonly />
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-tool">
                                <path
                                    d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                                </path>
                            </svg>
                        </label>
                        <label for="birthdateAccSettings">
                            <span data-section='navBar' data-value='birthdatePH'> Fecha de nacimiento </span>
                            <input type="date" id="birthdateAccSettings" name="birthdateAccSettings" autocomplete="off" required
                                value="<?php echo $_SESSION["userData"]->getFechaNac()->format('Y-m-d'); ?>" readonly />
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-tool">
                                <path
                                    d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                                </path>
                            </svg>
                        </label>
                        <input type="submit" value="Confirmar cambios" class="button" data-section='general'
                            data-value='confirmChanges'>
                    </form>
                    <?php
                }
            } catch (Exception) {
                echo "Error al conectar con el usuario";
            }
            ?>
        </div>


    </main>

    <?php
    include '../footer.php';
    ?>
</body>
<script src="../../../js/accSettingsInputs.js"></script>

</html>