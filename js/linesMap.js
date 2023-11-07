import { showLine, removeLine, paradasLoopThrough, paradasCustomIcons, newMap, recorridosLoopThrough } from './map.js';

// Crea un mapa Leaflet y establece la vista en una ubicación específica
var map = newMap("stopsMap");
// Crea íconos personalizados para los marcadores
var { customIcon, customIconFalse } = paradasCustomIcons();
// Itera a través de un array de paradas y crea marcadores en el mapa para cada una
var { stopsArray } = paradasLoopThrough(map, customIcon, customIconFalse, "lines");


var { rutasVisibles, waypointsForLines, routeControls } = recorridosLoopThrough(map, stopsArray);

console.log(stopsArray)

let control = document.querySelector("#stopsMap .leaflet-control-container .leaflet-bottom.leaflet-left")
control.innerHTML = "<div class = 'control-content show'><div class =control-container></div></div>";
control = document.querySelector("#stopsMap .leaflet-control-container .leaflet-bottom.leaflet-left>div>div")
rutasVisibles.forEach((ruta, i) => {
    removeLine(i, routeControls, map, rutasVisibles)

    const buttonsDiv = document.createElement("div");
    buttonsDiv.className = "leaflet-control";

    ajaxForName(i, (name) => {
        console.log(name);

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

        console.log(paradas);
        let tiempoFinal = 0;

        for (let i = 0; i < paradas.length - 1; i++) {
            try {

                const { distance, duration } = await routeCalc(
                    paradas[i]["latLng"]["lat"],
                    paradas[i]["latLng"]["lng"],
                    paradas[i + 1]["latLng"]["lat"],
                    paradas[i + 1]["latLng"]["lng"]
                );
                tiempoFinal += duration;
                console.log(`Inicio ${paradas[i]["id"]} \n Fin ${paradas[i + 1]["id"]} \n Distancia total: ${distance} \n Tiempo: ${duration}`);
                console.log("tiempoFinal : ", tiempoFinal);

            } catch (error) {

                console.error("Error:", error);
            }
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
                console.log("Ruta eliminada automáticamente.");
            }, 0.1);

            resolve({ distance: parseFloat((totalDistance / 1000).toFixed(2)), duration: parseFloat(((totalDuration / 3600) * 1.3).toFixed(2)) });
        });
    });
}

export { agregarParada, lineFormSubmit }



