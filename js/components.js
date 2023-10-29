function showError(message) {
    try {
        var errorContainer = document.getElementById("errorContainer");
        var errorMessages = errorContainer.querySelector("p");
        errorMessages.textContent = message;
    } catch (error) {
        errorContainer = document.createElement("div")
        errorContainer.id = "errorContainer";
        errorContainer.className = "confirmationMessage container shadow slideIn";
        errorContainer.innerHTML = `<p>${message}</p > `;
        document.body.appendChild(errorContainer);
        console.log("Contenedor de error agregado")
    }

    errorContainer.classList.remove("slideIn");
    // Agrega la clase slideIn para mostrar el error, timeout para poder recargar la clase
    setTimeout(() => {
        errorContainer.classList.add("slideIn");
    }, .1);
}

export { showError };