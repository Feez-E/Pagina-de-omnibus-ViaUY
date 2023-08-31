localStorage.setItem("username", null);
localStorage.setItem("password", null);
document.getElementById('userNameText').innerHTML = `Inciar Sesión`;
            document.getElementById('userNameText').parentElement.classList.toggle('logged');