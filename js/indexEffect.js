let sun = document.querySelector(".sun");
let buttons = document.querySelector(".indexButtons");

window.addEventListener("scroll", () => {
    let value = this.window.scrollY;
    sun.style.marginTop = value + "px";
    buttons.style.marginTop = value + "px";

    if (value > 300) {



        buttons.style.display = "none"; // Ocultar los botones
    } else {
        buttons.style.display = ""; // Mostrar los botones usando el valor predeterminado del estilo
    }
});