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
<div class=pageCover id=loginPageCover>

    <div id=loginPanel>
        <div id=loginToggle></div>
        <div id=loginContent>
            <div class='loginSide shown active'>
                <p class=loginTitle data-section='navBar' data-value='loginText'> Iniciar Sesión </p>
                <form id=loginForm action="/Proyecto Final/php/userInterface/navBar/auth.php" method="post">
                    <label for="usernameL">
                        <span data-section='navBar' data-value='usernamePH'> Nombre de usuario </span>
                        <input type="text" id="usernameL" name="usernameL" maxlength="32" required />
                    </label> <br>
                    <label for="passwordL">
                        <span data-section='navBar' data-value='passwordPH'> Contraseña </span>
                        <input type="password" id="passwordL" name="passwordL" required />
                        <svg class="eye" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="4" y1="4" x2="20" y2="20"></line>
                        </svg>
                    </label> <br>
                    <input type="submit" value="Confirmar" class='button' data-section='general' data-value='confirm' />
                </form>
            </div>
            <div class='loginSide hidden'>
                <p class=loginSubtitle data-section='navBar' data-value='existingAccount'>¿Ya tienes una cuenta?</p>
                <a class=loginButton data-section='navBar' data-value='loginText'>Iniciar Sesión</a>
            </div>
            <div id=loginSeparator></div>
            <div class='registerSide shown'>
                <p class=loginTitle data-section='navBar' data-value='registerText'> Registrarse </p>
                <form id=registerForm action="/Proyecto Final/php/userInterface/navBar/register.php" method="post">
                    <label for=usernameR>
                        <span data-section='navBar' data-value='usernamePH'> Nombre de usuario </span>
                        <input type="text" id="usernameR" name="usernameR" maxlength="32" required />
                    </label>
                    <label for=name>
                        <span data-section='navBar' data-value='namePH'> Nombre </span>
                        <input type="text" id="name" name="name" maxlength="30" required />
                    </label>
                    <label for=lastname>
                        <span data-section='navBar' data-value='lastnamePH'> Apellido </span>
                        <input type="text" id="lastname" name="lastname" maxlength="30" required />
                    </label>
                    <label for=birthdate>
                        <span data-section='navBar' data-value='birthdatePH'> Fecha de nacimiento </span>
                        <input type="date" id="birthdate" name="birthdate" required />
                    </label>
                    <label for=email>
                        <span data-section='navBar' data-value='emailPH'> Correo electrónico </span>
                        <input type="email" id="email" name="email" maxlength="64" required />
                    </label>
                    <label for=phoneNumber>
                        <span data-section='navBar' data-value='phoneNumberPH'> Teléfono </span>
                        <input type="tel" id="phoneNumber" name="phoneNumber" minlength="8" maxlength="8"
                            pattern="[0-9]+" required />
                    </label>
                    <label for=passwordR>
                        <span data-section='navBar' data-value='passwordPH'> Contraseña </span>
                        <input type="password" id="passwordR" name="passwordR" required />
                        <svg class="eye" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="4" y1="4" x2="20" y2="20"></line>
                        </svg>
                    </label>
                    <label for=passwordConfirm>
                        <span data-section='navBar' data-value='confirmPasswordPH'> Confirmar contraseña </span>
                        <input type="password" id="passwordConfirm" name="passwordConfirm" required />
                    </label><br>
                    <input type="submit" value="Confirmar" class="button" data-section='general' data-value='confirm'>
                </form>
            </div>
            <div class='registerSide hidden active'>
                <p class=loginSubtitle data-section='navBar' data-value='newAccount'>¿No tienes una cuenta?</p>
                <a class=loginButton data-section='navBar' data-value='registerText'>¡Regístrate!</a>
            </div>

        </div>
        <script src="/Proyecto Final/js/labelPlaceholder.js"> </script>
    </div>