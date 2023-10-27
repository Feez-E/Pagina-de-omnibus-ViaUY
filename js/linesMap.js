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
        url: "getLineName.php",
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

function agregarParada() {
        const addStopInput = document.getElementById("addStop");
        const id = addStopInput.value.trim();

        if (id !== "" && stopsArray.hasOwnProperty(id)) {
            const stopsList = document.getElementById("stopsList");
            const newStop = document.createElement("li");
            newStop.textContent = id;
            stopsList.appendChild(newStop);
            addStopInput.value = "";
            const latLng = stopsArray[id];

            return {id, latLng};
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

function lineFormSubmit(paradas){
    const busLookUpForm = document.getElementById("lineForm");
    busLookUpForm.addEventListener("submit", (e) => {
        e.preventDefault();

        console.log(paradas)
    });
}


export {agregarParada, lineFormSubmit}



