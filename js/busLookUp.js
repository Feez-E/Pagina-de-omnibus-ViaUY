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
                    const betterLines = document.getElementById("betterLines");

                    if (response.lineas && Object.keys(response.lineas).length > 0) {
                        const linesContainer = loadLines(response.lineas);
                        betterLines.innerHTML = ""
                        betterLines.appendChild(linesContainer);
                    } else if (response.error) {
                        showError(response.error);
                    } else {
                        showError("Lo sentimos, no hay viajes disponibles que se ajusten a sus necesidades.");
                    }
                    console.log(response.param);
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
    console.log(lineas);
    const linesContainer = document.createElement("div");
    linesContainer.className = "container";

    for (const key in lineas) {
        if (lineas.hasOwnProperty(key)) {
            const currentLinea = lineas[key];

            const stopsIds = currentLinea.StopsId; // Array of stop IDs
            const days = currentLinea.days; // Array of days

            const lineDiv = document.createElement("div");
            lineDiv.className = "lineAndTravels shadow";

            const lineContent = `
                <div class="line">
                    <div class="lineLeft">
                        <h3 class="subtitle">${key} - ${currentLinea.description}</h3>
                        <p>${days.join(' ')}</p>
                    </div>
                    <div id="lineToggle"></div>
                </div>
                <div class="travels">
                </div>
            `;

            lineDiv.innerHTML = lineContent;

            // Append the Stop IDs to lineDiv
            const travelsDiv = lineDiv.querySelector('.travels');
            const stopsParagraph = document.createElement("div");
            stopsParagraph.className = "travel";
            stopsParagraph.innerHTML = stopsIds.map((stopId, index) => {
                const stopDirection = currentLinea.StopsDirections[index];
                return `<p>${stopId} - ${stopDirection}</p>`;
            }).join('');
            travelsDiv.appendChild(stopsParagraph);

            // Append times for each data property to travelsDiv
            for (const data in currentLinea) {
                if (isFinite(data)) {
                    const timesParagraph = document.createElement("div");
                    timesParagraph.className = "travel";
                    timesParagraph.innerHTML = currentLinea[data].map(time => `<p>${time}</p>`).join('');
                    
                    const nuevoElemento = document.createElement("div");
                    nuevoElemento.className = "travelButtons";
                    nuevoElemento.innerHTML = `
                        <a class = 'buttons busButton'>
                            <img src='/Proyecto Final/img/UnidadIcono.png'>
                        </a>
                        <a class = 'buttons reserveButton'>
                            <img src='/Proyecto Final/img/UnidadIcono.png'>
                        </a>
                    `;

                    timesParagraph.appendChild(nuevoElemento);

                    travelsDiv.appendChild(timesParagraph);
                }
            }

            linesContainer.appendChild(lineDiv);
        }

        const lineToggles = linesContainer.querySelectorAll('#lineToggle');

        // Añade una función para el evento 'click' en cada elemento con el id 'lineToggle'
        lineToggles.forEach(lineToggle => {
            lineToggle.onclick = () => {
                // Alterna la clase 'active' en el elemento padre del elemento padre de 'lineToggle' (dos niveles hacia arriba)
                lineToggle.parentElement.parentElement.classList.toggle('active');
            }
        });
    }

    return linesContainer;
}