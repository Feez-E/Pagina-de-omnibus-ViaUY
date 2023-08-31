document.addEventListener("DOMContentLoaded", function() {
    // Verificar si hay información de sesión en localStorage
    try{
        var savedUsername = localStorage.getItem("username");
        var savedPassword = localStorage.getItem("password");
    
        if (savedUsername && savedPassword) {
            document.getElementById('userNameText').innerHTML = `${savedUsername}`;
            document.getElementById('userNameText').parentElement.classList.toggle('logged');
        }
    } catch (exception){
        console.log(exception)
    }
    
});