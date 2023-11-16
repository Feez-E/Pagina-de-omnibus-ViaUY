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


        const startStop = document.getElementById("startStop").value.split(' ')[0];
        const endStop = document.getElementById("endStop").value.split(' ')[0];
        const date = document.getElementById("date").value;
        const time = document.getElementById("time").value;

        const dia = busLookUpForm.children[1].firstElementChild.children[1].value;
        params = { "subida": startStop, "bajada": endStop, "dia": dia };

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
                        console.log(response.lineas);
                        const linesContainer = loadLines(response.lineas);
                        betterLines.innerHTML = ""
                        betterLines.appendChild(linesContainer);
                    } else if (response.error) {
                        showError(response.error);
                    } else {
                        showError("Lo sentimos, no hay viajes disponibles que se ajusten a sus necesidades.");
                        betterLines.innerHTML = ""
                    }
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
                        <a class = 'busButton'>
                            <img src='/Proyecto Final/img/UnidadIcono.png'>
                        </a>
                        <div class = pageCover></div>
                        <a class = 'reserveButton'>
                            <img src='/Proyecto Final/img/ReservaIcono.png'>
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

        const busButtons = linesContainer.querySelectorAll(".busButton");

        busButtons.forEach(busButton => {

            const reserveButton = busButton.parentElement.lastElementChild;
            const pageCover = busButton.nextElementSibling;
            const horaSalida = busButton.parentElement.parentElement.firstElementChild.innerHTML;
            const horaLlegada = busButton.parentElement.parentElement.children[busButton.parentElement.parentElement.children.length - 2].innerHTML;

            const nombreLineaOrigenDestino = busButton.parentElement.parentElement.parentElement.previousElementSibling.firstElementChild.firstElementChild.innerHTML.split(" - ");

            const nombreLinea = nombreLineaOrigenDestino[0];
            console.log(nombreLinea);
            console.log(horaSalida);

            let dataToSend = {
                nombreLinea: nombreLinea,
                horaSalida: horaSalida
            };

            $.ajax({
                url: "getUnit.php",
                type: "POST",
                data: dataToSend,
                success: (response) => {

                    if (response.status === "success") {
                        if (response.unidad) {
                            unidad = response.unidad;
                            caracts = response.caracteristicas;
                            const caractsHTML = caracts.map(time => `<p>${time.propiedad}</p>`).join('');
                            pageCover.innerHTML = `
                             <div class = "unitInfo">
                                <p class = subtitle> Información general </p>
                                <p> Numero de Unidad: ${response.unidad.numero} </p>
                                <p> Matricula: ${response.unidad.matricula} </p>
                                <p> Capacidad del 1° piso: ${response.unidad.capacidadPrimerPiso} </p>
                                <p> Capacidad del 2° piso: ${response.unidad.capacidadSegundoPiso} </p>
                                <div class = caracts>
                                <p class = subtitle> Características </p>
                                    ${caractsHTML}
                                </div>
                             </div>
                             `;
                        } else if (response.error) {
                            showError(response.error);
                        } else {
                            showError("Lo sentimos, hubo un error");
                        }
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

            busButton.onclick = () => {
                pageCover.classList.toggle("active");
            };

            pageCover.style.borderRadius = "15px";
            pageCover.onclick = () => {
                pageCover.classList.toggle("active");
            };

            reserveButton.onclick = () => {
                console.log(unidad)
                console.log(caracts)
                params["nombreLinea"] = nombreLinea;
                params["horaSalida"] = horaSalida;
                params["horaLLegada"] = horaLlegada;

                delete unidad.vigencia;
                delete unidad.numeroChasis;
                delete unidad.matricula;
                caracts.forEach((caract) => {
                    delete caract.numeroUnidad;
                });


                var regexSubida = new RegExp("\\b" + params["subida"] + "\\b");
                var regexBajada = new RegExp("\\b" + params["bajada"] + "\\b");

                var travelElements = reserveButton.parentElement.parentElement.parentElement.firstElementChild.querySelectorAll('p');

                console.log(travelElements);

                params["paradas"] = [];
                params["allhoras"] = [];
                let subida = false;
                let bajada = 1;

                travelElements.forEach((element, i) => {
                    const hora = busButton.parentElement.parentElement.children[i].innerHTML;
                    if (regexSubida.test(element.textContent)) {
                        subida = true;
                    }
                    if (regexBajada.test(element.textContent)) {
                        bajada = 2;
                    }
                    //paradas
                    const startStopsSplit = busButton.parentElement.parentElement.parentElement.firstElementChild.children[i].innerHTML.split("-");
                    const startStop = startStopsSplit["0"];
                    if (subida && bajada !== 0) {
                        params["paradas"][i + 1] = parseInt(startStop.trim());
                        params["allhoras"][i + 1] = hora;
                    }
                    if (subida && bajada === 2) {
                        bajada = 0;
                    }

                });

                var unidadJSON = JSON.stringify(unidad);
                var caractsJSON = JSON.stringify(caracts);
                var paramsJSON = JSON.stringify(params);

                // Crea un formulario dinámico
                var form = document.createElement('form');
                form.action = 'busReserve/busReserve.php'; // URL de la página de destino
                form.method = 'post'; // Utiliza el método POST

                // Crea campos de entrada ocultos para los datos
                var unidadInput = document.createElement('input');
                unidadInput.type = 'hidden';
                unidadInput.name = 'unidad';
                unidadInput.value = unidadJSON;
                form.appendChild(unidadInput);

                var caractsInput = document.createElement('input');
                caractsInput.type = 'hidden';
                caractsInput.name = 'caracts';
                caractsInput.value = caractsJSON;
                form.appendChild(caractsInput);

                var paramsInput = document.createElement('input');
                paramsInput.type = 'hidden';
                paramsInput.name = 'params';
                paramsInput.value = paramsJSON;
                form.appendChild(paramsInput);
                // Agrega el formulario al cuerpo del documento y envíalo
                document.body.appendChild(form);
                form.submit();
            };
        });
    }

    return linesContainer;
}