
// Crea una ventana emergente Leaflet
const popup = L.popup();

function newMap(div) {
    const map = L.map(div).setView([-34.568537501229486, -56.01135368875827], 9);


    const bounds = L.latLngBounds(
        L.latLng(200.0, -170.0),  // Esquina noroeste de Europa
        L.latLng(-200.0, 190.0)   // Esquina sureste de Europa
    );

    // Agrega una capa de mosaico de OpenStreetMap al mapa
    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        minZoom: 3,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map);



    map.setMaxBounds(bounds);
    map.on('drag', () => {
        map.panInsideBounds(bounds, { animate: false });
    });

    return map;
}

function stopsMapOnClick(e, map, customIcon, customIconFalse) {
    // Inicializa una variable para verificar la validez de la ubicación
    let isValid = false;
    const latlng = e.latlng;
    let direccion;


    // Configura el contenido de la ventana emergente
    popup
        .setLatLng(latlng)
        .setContent("<p>" + latlng.toString() + "</p><div class='buttons'><div class='button' id='addStopButton'><img src='/Proyecto Final/img/UnidadIcono.png'><div class='busIcons plus'></div></div></div>")
        .openOn(map)

    // Construye la URL para la búsqueda inversa de Nominatim
    const nominatimUrl = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}`;

    // Realiza una solicitud AJAX para obtener información de la ubicación
    $.ajax({
        url: nominatimUrl,
        dataType: "json",
        success: (data) => {
            if (data.display_name) {
                // Obtiene información de dirección desde la respuesta JSON
                const address = data.display_name;
                const road = data.address.road;
                const state = data.address.state;

                // Datos mostrados en consola
                console.log("Dirección:", address);
                console.log("Data:", data);
                console.log("Road:", road);
                console.log("Town or City:", data.address.town || data.address.city || data.address.village);
                console.log("State:", state);

                // Registra la dirección y verifica la validez
                if (state !== undefined && road !== undefined) {
                    direccion = data.address.road + ", " + (data.address.town || data.address.city || data.address.village || "-") + ", " + data.address.state;
                    isValid = true;
                } else {
                    button.onclick = null;
                    button.style.pointerEvents = "none";
                }
            } else {
                console.log("Dirección no encontrada.");
                direccion = "Dirección no encontrada.";
            }
        },
        error: (_xhr, _status, error) => {
            console.error("Error al obtener la dirección:", error);
            direccion = "Error al obtener la dirección.";
        },
    });

    // Obtiene el botón de la ventana emergente y le asigna una función de clic
    const button = document.getElementById("addStopButton");
    button.onclick = () => {
        buttonOnClick(map, isValid, latlng, direccion, customIcon, customIconFalse);
    };


}

function paradasLoopThrough(map, customIcon, customIconFalse, buttons) {

    for (const parada of paradasArray) {
        var id = parada.id;
        const direccion = parada.direccion;
        const vigencia = parada.vigencia;

        const [latitud, longitud] = parada.coordenadas.split(",").map(parseFloat);

        if (!isNaN(latitud) && !isNaN(longitud)) {

            var buttonsDiv = null;
            if (buttons) {
                buttonsDiv = createStopsButtons();
            }

            const marker = L.marker([latitud, longitud], { icon: vigencia ? customIcon : customIconFalse }).addTo(map);

            const popupContent = L.DomUtil.create("div");
            popupContent.innerHTML = `
                <b>${id}</b>
                <p>${direccion}</p>
                <p>${latitud}, ${longitud}</p>
            `;

            if (buttons) {
                popupContent.appendChild(buttonsDiv);
            }

            // Bind the popup content to the marker
            marker.bindPopup(popupContent);

            if (buttons) {
                stopsButtonsOnClick(popupContent, marker, map, customIcon, customIconFalse, vigencia);
            }
        }
    }
}

function paradasCustomIcons() {
    const customIcon = L.AwesomeMarkers.icon({
        icon: "bus",
        markerColor: "darkblue",
        prefix: "fa",
    });
    const customIconFalse = L.AwesomeMarkers.icon({
        icon: "times",
        markerColor: "red",
        prefix: "fa",
    });
    return { customIcon, customIconFalse };
}



// Función que se ejecuta al hacer clic en el botón de la ventana emergente
function buttonOnClick(map, isValid, latlng, direccion, customIcon, customIconFalse) {
    console.log("Latitud: " + latlng.lat + " Longitud: " + latlng.lng);

    // Prepara los datos para enviar al servidor
    const coordenadas = latlng.lat + ", " + latlng.lng;

    // Objeto de datos a enviar en la solicitud AJAX
    const dataToSend = {
        direccion: direccion,
        coordenadas: coordenadas,
    };

    // Realiza una solicitud AJAX al servidor
    if (isValid) {
        $.ajax({
            url: "stopInsert.php",
            type: "POST",
            data: dataToSend,
            success: (response) => {
                if (response.status === "success") {
                    console.log("Parada insertada con éxito.");
                    // Crea un nuevo marcador
                    const id = response.maxId;
                    const marker = L.marker([latlng.lat, latlng.lng], {
                        icon: customIcon,
                    }).addTo(map);

                    const buttonsDiv = createStopsButtons();

                    const popupContent = L.DomUtil.create("div");
                    popupContent.innerHTML = `
                        <b>${id}</b>
                        <p>${direccion}</p>
                        <p>${latlng.lat}, ${latlng.lng}</p>
                    `;

                    popupContent.appendChild(buttonsDiv);

                    // Bind the popup content to the marker
                    marker.bindPopup(popupContent);

                    // Attach a click event listener to the "deleteButton" element
                    stopsButtonsOnClick(popupContent, marker, map, customIcon, customIconFalse, true);

                    // Close the current popup
                    map.closePopup(popup);
                } else {
                    console.log("Error al insertar la parada.");
                    console.log(response);
                }
            },
            error: () => {
                console.log("Error en la solicitud AJAX.");
            },
        });
    } else {
        alert("Lugar inválido");
    }
}

function createStopsButtons() {
    // Create the container for popup buttons
    const popupStopsButtonContainer = document.createElement("div");
    popupStopsButtonContainer.className = "buttons";
    popupStopsButtonContainer.id = "latest";
    popupStopsButtonContainer.innerHTML = `
    <a class="button deleteButton">
        <img src='/Proyecto Final/img/UnidadIcono.png'>
        <div class='busIcons minus'></div>
    </a>
    <a class="button deregisterButton">
        <img src='/Proyecto Final/img/UnidadIcono.png'>
        <div class='busIcons slash'></div>
    </a>
    `;

    return (popupStopsButtonContainer);
}


function stopsButtonsOnClick(popupContent, marker, map, customIcon, customIconFalse, vigencia) {
    const deleteButton = popupContent.querySelector(".deleteButton");
    deleteButton.addEventListener("click", () => {
        const id = popupContent.firstElementChild.innerHTML;

        const dataToSend = {
            id: id,
        };

        $.ajax({
            url: "stopDelete.php",
            type: "POST",
            data: dataToSend,
            success: (response) => {
                if (response === "success") {

                    console.log("Parada eliminada con éxito.");

                    map.removeLayer(marker);
                } else {
                    alert("Esta parada no se puede eliminar.");
                    console.log(response);
                }
            },
            error: () => {
                console.log("Error en la solicitud AJAX.");
            },
        });
    });
    const deregisterButton = popupContent.querySelector(".deregisterButton");
    if(!vigencia) {
        deregisterButton.classList.remove("deregisterButton");
        deregisterButton.classList.add("addStopButton");
        deregisterButton.lastElementChild.classList.remove("slash");
        deregisterButton.lastElementChild.classList.add("plus");
    }

    deregisterButton.addEventListener("click", function deregister() {
        const id = popupContent.firstElementChild.innerHTML;
        deregisterButton.classList.toggle("deregisterButton");
        deregisterButton.classList.toggle("addStopButton");
        deregisterButton.lastElementChild.classList.toggle("slash");
        deregisterButton.lastElementChild.classList.toggle("plus");

        const dataToSend = {
            id: id,
            vigencia: vigencia
        };

        console.log(dataToSend.vigencia);
        $.ajax({
            url: "stopValidationToggle.php",
            type: "POST",
            data: dataToSend,
            success: (response) => {
                if (response === "success") {

                    console.log("Parada actualizada con éxito.");

                    marker.setIcon(vigencia ? customIconFalse : customIcon);
                    vigencia = !vigencia;
                } else {
                    alert("Esta parada no se puede eliminar.");
                    console.log(response);
                }
            },
            error: () => {
                console.log("Error en la solicitud AJAX.");
            },
        });
    });
}
export { stopsMapOnClick, paradasLoopThrough, paradasCustomIcons, newMap };
