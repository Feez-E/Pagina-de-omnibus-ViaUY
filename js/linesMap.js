import { showLine, removeLine, paradasLoopThrough, paradasCustomIcons, newMap, recorridosLoopThrough } from './map.js';

// Crea un mapa Leaflet y establece la vista en una ubicación específica
var map = newMap("stopsMap");
// Crea íconos personalizados para los marcadores
var { customIcon, customIconFalse } = paradasCustomIcons();
// Itera a través de un array de paradas y crea marcadores en el mapa para cada una
var { stopsArray } = paradasLoopThrough(map, customIcon, customIconFalse, "lines");


var { rutasVisibles, waypointsForLines, routeControls } = recorridosLoopThrough(map, stopsArray);





/* showLine( map, waypointsForLines["4"],"4", routeControls, rutasVisibles); */
console.log(rutasVisibles)

let control = document.querySelector("#stopsMap .leaflet-control-container .leaflet-bottom.leaflet-left")
control.innerHTML = "<div class = 'control-content show'><div class =control-container></div></div>";
control = document.querySelector("#stopsMap .leaflet-control-container .leaflet-bottom.leaflet-left>div>div")
rutasVisibles.forEach((ruta, i) => {
    removeLine(i, routeControls, map, rutasVisibles)

    const buttonsDiv = document.createElement("div");
    buttonsDiv.className = "leaflet-control";

    ajaxForName(i, function (name) {
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




