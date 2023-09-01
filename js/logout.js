document.getElementById('logout').addEventListener('click', function() {
    localStorage.removeItem("username");
    localStorage.removeItem("password");
    document.getElementById('userNameText').textContent = "Iniciar Sesión";
    document.getElementById('userNameText').parentElement.classList.toggle('logged');
    document.querySelector('.menu').classList.toggle('active');
    document.querySelector('.menuToggle').classList.toggle('active');
});