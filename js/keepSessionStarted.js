document.addEventListener("DOMContentLoaded", function() {
    // Verificar si hay información de sesión en localStorage
    try {
        var savedUsername = localStorage.getItem("username");
        var savedPassword = localStorage.getItem("password");

        if (savedUsername && savedPassword) {
            // Si hay información de sesión en localStorage, establecer el texto del botón
            document.getElementById('userNameText').textContent = savedUsername;
            document.getElementById('userNameText').parentElement.classList.add('logged');
            document.querySelector('.menuToggle').classList.toggle('active');
        } else {
            // Si no hay información de sesión en localStorage, establecer el texto predeterminado
            document.getElementById('userNameText').textContent = "Iniciar Sesión";
        }
    } catch (exception) {
        console.log(exception);
    }
});
