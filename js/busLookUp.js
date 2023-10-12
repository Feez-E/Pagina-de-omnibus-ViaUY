document.addEventListener("DOMContentLoaded", function () {
    // Función para mostrar el mensaje de error
    function showError(message) {
        const errorContainer = document.getElementById("errorContainer");
        const errorMessages = errorContainer.querySelector("p");
        errorMessages.textContent = message;
        errorContainer.classList.remove("slideIn");
         // Agrega la clase slideIn para mostrar el error, timeout para poder recargar la clase
        setTimeout(() => {
            errorContainer.classList.add("slideIn");
        }, .1);
    }

    const busLookUpForm = document.getElementById("busLookUpForm");
    busLookUpForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const startStop = document.getElementById("startStop").value;
            const endStop = document.getElementById("endStop").value;
            const date = document.getElementById("date").value;
            const time = document.getElementById("time").value;

            // Realiza la validación (puedes agregar tus propias condiciones)
            if (startStop.trim() === "" || endStop.trim() === "" || date.trim() === "" || time.trim() === "") {
                showError("Por favor, complete todos los campos.");
                return;
            }

            // Si la validación es exitosa, prepara los datos para la solicitud AJAX
            let dataToSend = {
                startStop: startStop,
                endStop: endStop,
                date: date,
                time: time
            };

            $.ajax({
                url: "linesSearch.php",
                type: "POST",
                data: dataToSend,
                success: (response) => {
                    if (response.status === "success") {
                        console.log(response.lineas)
                    } else {
                        console.log("Error al procesar la solicitud.");
                        console.error(response);
                    }
                },
                error: (_xhr, _status, error) => {
                    console.log("Error en la solicitud AJAX.");
                    console.error(error);
                },
            });

        });
});