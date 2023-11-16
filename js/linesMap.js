import { showLine, removeLine, paradasLoopThrough, paradasCustomIcons, newMap, recorridosLoopThrough } from './map.js';

// Crea un mapa Leaflet y establece la vista en una ubicación específica
var map = newMap("stopsMap");
// Crea íconos personalizados para los marcadores
var { customIcon, customIconFalse } = paradasCustomIcons();
// Itera a través de un array de paradas y crea marcadores en el mapa para cada una
var { stopsArray } = paradasLoopThrough(map, customIcon, customIconFalse, "lines");


var { rutasVisibles, waypointsForLines, routeControls } = recorridosLoopThrough(map, stopsArray);


let control = document.querySelector("#stopsMap .leaflet-control-container .leaflet-bottom.leaflet-left")
control.innerHTML = "<div class = 'control-content show'><div class =control-container></div></div>";
control = document.querySelector("#stopsMap .leaflet-control-container .leaflet-bottom.leaflet-left>div>div")
rutasVisibles.forEach((ruta, i) => {
    removeLine(i, routeControls, map, rutasVisibles)

    const buttonsDiv = document.createElement("div");
    buttonsDiv.className = "leaflet-control";

    ajaxForName(i, (name) => {

        const buttonsDivContent = `
            <a class="showButton">${name}</a>
        `;

        control.appendChild(buttonsDiv);
        buttonsDiv.innerHTML = buttonsDivContent;

        const showButton = buttonsDiv.querySelector(".showButton");

        showButton.onclick = () => {
            if (rutasVisibles[i]) {
                removeLine(i, routeControls, map, rutasVisibles);
            } else {
                showLine(map, waypointsForLines[i], i, routeControls, rutasVisibles);
            }
            showButton.classList.toggle("active");
        };
    });
});

const linesCollapseDiv = document.createElement("div");
linesCollapseDiv.className = "leaflet-control collapseButton";
const linesCollapseDivContent = `
    <div class="showButton leftToRight" id ="toggleArrow"></div>
`;
linesCollapseDiv.innerHTML = linesCollapseDivContent;
control.parentElement.parentElement.appendChild(linesCollapseDiv);

const linesCollapse = linesCollapseDiv.querySelector(".showButton");

linesCollapse.onclick = () => {
    linesCollapse.parentElement.parentElement.classList.toggle("hidden");
    const controlContent = document.querySelector('.leaflet-bottom.leaflet-left .control-content');

    if (controlContent.classList.contains('show')) {
        controlContent.classList.remove('show');
    } else {
        setTimeout(() => {
            controlContent.classList.add('show');
        }, 250);
    }
};

addTravelButtons();

function addTravelButtons() {
    document.querySelectorAll("#addTravelButton").forEach((button, i) => {

        button.onclick = () => {

            const addTravelPageCover = document.createElement("div");
            addTravelPageCover.className = "pageCover active";
            addTravelPageCover.innerHTML = `
            <div class = "pageCoverSection container" id = "form">
            <div class = "pageCoverSectionHeader">
                <h4 class = "subtitle"> Agregar horario </h4> 
                <div id = closeButtonN2></div>
            </div>
                <form id=addTimeForm action="#" method="post">
                    <label for="timeToAdd" class="editable">
                        <span> Hora de Salida </span>
                        <input type="time" id="timeToAdd" name="timeToAdd" autocomplete="off" required />
                    </label>
                    <label for="unit" class="editable">
                        <span> Unidad </span>
                        <input type="number" id="unit" name="unit" autocomplete="off" list="unitsList" required />
                        <datalist id = "unitsList">
                        </datalist>
                    </label>
                    <input type="submit" value="Agregar" class="button">
                </form>
            </div>
            `;
            ajaxForUnits((response) => {
                // Callback function to handle the response
                if (response && response.status === "success") {
                    // Update the datalist or perform other actions
                    const unitsList = addTravelPageCover.querySelector("#unitsList");
                    response.unidades.forEach((unit) => {
                        const option = document.createElement("option");
                        option.value = `${unit.numero}`;
                        option.innerHTML = `1° Piso: ${unit.capacidadPrimerPiso} 2° Piso: ${unit.capacidadSegundoPiso}`;
                        unitsList.appendChild(option);
                    });
                } else {
                    console.log(response);
                }
            });

            document.querySelector("main").appendChild(addTravelPageCover);

            addTravelPageCover.querySelector("#closeButtonN2").onclick = () => {
                document.querySelector("main").removeChild(addTravelPageCover);
            };

            const addTravelForm = addTravelPageCover.querySelector("form");

            addTravelForm.addEventListener("submit", (e) => {
                e.preventDefault();

                const horaSalida = addTravelForm.querySelector("#timeToAdd").value;
                const unidad = addTravelForm.querySelector("#unit").value;
                const nombreLinea = button.previousElementSibling.firstElementChild.innerHTML.split(" - ")[0];
                const tramos = stopsIds[i];


                let tramosForAJAX = [];

                tramos["Salidas"].forEach((salida, i) => {
                    const tramo = {
                        idInicial: salida,
                        idFinal: tramos["Llegadas"][i],
                    }
                    tramosForAJAX[i + 1] = tramo;
                });

                let dataToSend = {
                    unidad: unidad,
                    nombreLinea: nombreLinea,
                    tramos: tramosForAJAX,
                    horaSalida: horaSalida
                };
                $.ajax({
                    url: "insertTransita.php",
                    type: "POST",
                    data: dataToSend,
                    success: (response) => {
                        if (response.status === "success") {
                            showError("Horario insertado con exito, recrague la página para verlo")
                            console.log(response.tiempo)
                        } else {
                            showError(response.message)
                        }
                        document.querySelector("main").removeChild(addTravelPageCover);
                    },
                    error: (xhr) => {
                        console.log("Error en la solicitud AJAX.");
                        console.log(xhr.responseText);
                    },
                });

                console.log(dataToSend);
            });


        }
    });

}

function ajaxForUnits(callback) {
    $.ajax({
        url: "getUnits.php",
        type: "POST",
        success: (response) => {
            if (callback && typeof callback === "function") {
                callback(response);
            }
        },
        error: () => {
            console.log("Error en la solicitud AJAX.");
        },
    });
}

function ajaxForName(lineId, callback) {
    const dataToSend = {
        codigo: lineId,
    };

    $.ajax({
        url: "../busLookUp/getLineName.php",
        type: "POST",
        data: dataToSend,
        success: (response) => {
            if (response["status"] === "success") {

                const name = response["lineName"];
                callback(name);

            } else {

                console.log(response);
                callback(null);
            }
        },
        error: () => {
            console.log("Error en la solicitud AJAX.");
            callback(null);
        },
    });
}

function agregarParada(paradas) {
    const addStopInput = document.getElementById("addStop");
    const id = addStopInput.value.trim();

    if (id !== "" && stopsArray.hasOwnProperty(id)) {
        const stopsList = document.getElementById("stopsList");
        const newStop = document.createElement("li");
        newStop.innerHTML = `<p></p><span>${id}</span>`;
        stopsList.appendChild(newStop);
        addStopInput.value = "";
        const latLng = stopsArray[id];



        return { id, latLng };
    } else {
        showError("Ingrese una parada correcta");
    }
}

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

function lineFormSubmit(paradas) {
    const busLookUpForm = document.getElementById("lineForm");
    busLookUpForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        let lineForm = document.getElementById("addLineForm")

        let loadingPanel = document.createElement("div");
        loadingPanel.classList = "pageCover active";
        loadingPanel.style.borderRadius = "15px"
        loadingPanel.style.flexDirection = "column"
        loadingPanel.innerHTML = "<div class = loadingDiv></div><p style = 'margin-top: 10px; color: var(--button-text-color )'>Cargando tramos...</p>"

        lineForm.appendChild(loadingPanel);

        let tramos = [];

        for (let i = 0; i < paradas.length - 1; i++) {
            try {

                const dataToSend = {
                    coordsInicio: `${paradas[i]["latLng"]["lat"]}, ${paradas[i]["latLng"]["lng"]}`,
                    coordsFinal: `${paradas[i + 1]["latLng"]["lat"]}, ${paradas[i + 1]["latLng"]["lng"]}`
                }

                try {
                    const tramo = await getTramoAJAX(dataToSend);


                    if (!tramo) {

                        const { distance, duration } = await routeCalc(
                            paradas[i]["latLng"]["lat"],
                            paradas[i]["latLng"]["lng"],
                            paradas[i + 1]["latLng"]["lat"],
                            paradas[i + 1]["latLng"]["lng"]
                        );
                        tramos.push({
                            idInicial: paradas[i]["id"],
                            idFinal: paradas[i + 1]["id"],
                            distancia: distance,
                            tiempo: duration,
                        });
                    } else {
                        tramos.push({
                            idInicial: paradas[i]["id"],
                            idFinal: paradas[i + 1]["id"],
                        });
                    }

                } catch (error) {
                    console.log("Error: ", error);

                }

            } catch (error) {

                console.error("Error:", error);
            }
        }

        lineForm.removeChild(loadingPanel);

        const nombreLinea = document.getElementById("lineName").value;
        const origenLinea = document.getElementById("lineOrigin").value;
        const destinoLinea = document.getElementById("lineDestination").value;
        if (origenLinea && destinoLinea && nombreLinea && tramos.length > 1) {
            insertarTramosYLinea(tramos, nombreLinea, origenLinea, destinoLinea);
            document.getElementById("lineName").value = "";
            document.getElementById("lineOrigin").value = "";
            document.getElementById("lineDestination").value = "";
        } else {
            showError("Ingrese todos los datos, y más de dos paradas");
        }

    });
}

async function routeCalc(latStart, lngStart, latEnd, lngEnd) {
    return new Promise((resolve, reject) => {
        var control = L.Routing.control({
            waypoints: [L.latLng(latStart, lngStart), L.latLng(latEnd, lngEnd)],
            routeWhileDragging: true,
            show: false,
            createMarker: function (_i, _waypoint, _n) {
                // Crea marcadores ocultos en los puntos de inicio y final
                return null;
            },
        }).addTo(map);

        // Calcula la ruta
        control.route();

        // Maneja el evento "routesfound" para calcular la distancia y eliminar la ruta
        control.on("routesfound", function (e) {
            var routes = e.routes;
            var totalDistance = 0;
            var totalDuration = 0;

            for (var i = 0; i < routes.length; i++) {
                totalDistance += routes[i].summary.totalDistance;
                totalDuration += routes[i].summary.totalTime;
            }

            setTimeout(() => {
                control.setWaypoints([]); // Elimina la ruta
            }, 0.1);

            resolve({ distance: parseFloat((totalDistance / 1000).toFixed(2)), duration: formatDuration(totalDuration / 3600) });
        });
    });

    function formatDuration(duration) {
        const hours = Math.floor(duration);
        const minutes = Math.floor((duration - hours) * 60);
        const seconds = Math.round(((duration - hours) * 60 - minutes) * 60);

        const formattedHours = hours < 10 ? `0${hours}` : hours.toString();
        const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes.toString();
        const formattedSeconds = seconds < 10 ? `0${seconds}` : seconds.toString();

        return `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
    }

}


function getTramoAJAX(dataToSend) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "getIfTramoExists.php",
            type: "POST",
            data: dataToSend,
            success: (response) => {
                if (response.status === "success") {
                    resolve(response.tramo || false);
                } else {
                    console.log("Error al procesar la solicitud.");
                    console.error(response);
                    reject(response);
                }
            },
            error: (xhr, _status, error) => {
                console.log("Error en la solicitud AJAX.");
                console.error(error);
                console.error(xhr);
                reject(error);
            },
        });
    });
}

function insertarTramosYLinea(tramos, nombreLinea, origenLinea, destinoLinea) {

    tramos.forEach((tramo, i) => {
        const orden = i + 1;



        try {
            if (tramo.hasOwnProperty("distancia") && tramo.hasOwnProperty("tiempo")) {
                ajaxForTramoInsert(
                    tramo["idInicial"],
                    tramo["idFinal"],
                    tramo["distancia"],
                    tramo["tiempo"]
                );
            }

        } catch (error) {
            console.error("error: ", error);
        }
    });
    try {
        ajaxForLineaInsert(
            tramos,
            nombreLinea,
            origenLinea,
            destinoLinea
        );
    } catch (error) {
        console.error("error: ", error);
    }

}

function ajaxForTramoInsert(idIncial, idFinal, distancia, tiempo) {

    const dataToSend = {
        idInicial: idIncial,
        idFinal: idFinal,
        distancia: distancia,
        tiempo: tiempo
    }

    $.ajax({
        url: "insertTramo.php",
        type: "POST",
        data: dataToSend,
        success: (response) => {
            if (response.status === "success" && response.insert === true) {
                console.log("tramo insertado")
            } else {
                console.log("Error al procesar la solicitud.");
                console.error(response);
            }
        },
        error: (xhr, _status, error) => {
            console.log("Error en la solicitud AJAX.");
            console.error(error);
            console.error(xhr);
        },
    });
}

function ajaxForLineaInsert(tramos, nombreLinea, origenLinea, destinoLinea) {

    const dataToSend = {
        tramos: tramos,
        nombreLinea: nombreLinea,
        origenLinea: origenLinea,
        destinoLinea: destinoLinea
    }

    $.ajax({
        url: "insertLinea.php",
        type: "POST",
        data: dataToSend,
        success: (response) => {
            if (response.status === "success") {
                showError(response.message)
                const newLine = document.createElement("div")
                newLine.className = "lineAndTravels travelAndLinePage shadow active";
                newLine.innerHTML = `
                    <div class="line">
                        <div class="lineLeft">
                            <h3 class="subtitle">${nombreLinea} - ${origenLinea} ${destinoLinea}</h3>
                            <div class="days">
                                <label class="switch">
                                    <input type="checkbox" class="lineValidation">
                                    <span class="slider round"></span>
                                </label>
                                <section class="lineDays">
                                    <p>          </p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tool">
                                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                                    </svg>
                                </section>
                            </div>
                        </div>
                        <div> </div>
                    <div id="lineToggle"></div>
                </div>
                <div class="travels travelAndLine">
                    <div class="lineData"><p class="subtitle">Tramos </p><p> ${tramos.map(time => `(${time["idInicial"]}, ${time["idFinal"]})`).join(' ')} </p></div>
                    <div class="desplegableSection travelAndLinePage travelSection"><p class="lineWOTravels"> Recargue la pagina para modificar esta línea</p>
                        </div>
                </div>`
                document.querySelector("main.container").appendChild(newLine);
            } else {
                showError(response.message)
            }
        },
        error: (xhr, _status, error) => {
            console.log("Error en la solicitud AJAX.");
            console.error(error);
            console.error(xhr);
        },
    });
}
export { agregarParada, lineFormSubmit }



