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
                        const linesContainer = loadLines(response.lineas);
                        const betterLines = document.getElementById("betterLines");
                        betterLines.innerHTML = "";
                        betterLines.appendChild(linesContainer);
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


function loadLines(lineas) {
    const linesContainer = document.createElement("div");
    linesContainer.className = "lines";
    console.log(lineas);

    for (const key in lineas) {
        if (lineas.hasOwnProperty(key)) {
            const currentLinea = lineas[key];

            const stopsIds = currentLinea.StopsId; // Array of stop IDs
            const days = currentLinea.days; // Array of days

            const lineDiv = document.createElement("div");
            lineDiv.className = "line";

            // Append the Stop IDs to lineDiv
            const stopIdsParagraph = document.createElement("p");
            stopIdsParagraph.textContent = `Stop IDs: ${stopsIds.join(', ')}`;
            lineDiv.appendChild(stopIdsParagraph);

            // Append times for each data property to lineDiv
            for (const data in currentLinea) {
                if (data !== "days" && data !== "StopsId") {
                    const timesParagraph = document.createElement("p");
                    timesParagraph.textContent = `${data}: ${currentLinea[data].join(', ')}`;
                    lineDiv.appendChild(timesParagraph);
                }
            }

            // Append the Days to lineDiv
            const daysParagraph = document.createElement("p");
            daysParagraph.textContent = `Days: ${days.join(', ')}`;
            lineDiv.appendChild(daysParagraph);

            linesContainer.appendChild(lineDiv);
        }
    }

    return linesContainer;
}