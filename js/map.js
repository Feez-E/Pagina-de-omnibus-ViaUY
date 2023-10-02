
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

function stopsMapOnClick(e, map, customIcon, id) {
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
            buttonOnClick(map, isValid, latlng, direccion, customIcon, id);
        };
    
   
}

function paradasLoopThrough(map, customIcon, customIconFalse) {
    for (const parada of paradasArray) {
        var id = parada.id;
        const direccion = parada.direccion;
        const vigencia = parada.vigencia;

        const [latitud, longitud] = parada.coordenadas.split(",").map(parseFloat);

        if (!isNaN(latitud) && !isNaN(longitud)) {
            const marker = L.marker([latitud, longitud], { icon: vigencia ? customIcon : customIconFalse }).addTo(map);

            marker.bindPopup(`<b>${id}</b><p>${direccion}</p><p>${latitud}, ${longitud}</p><div class ='buttons'><a class ='button' id='deleteButton'><img src='/Proyecto Final/img/UnidadIcono.png'><div class='busIcons minus'></div></a><a class ='button' id='deregisterButton'><img src='/Proyecto Final/img/UnidadIcono.png'><div class='busIcons slash'></div></a></div>`);
        }
    }
    return { id };
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
function buttonOnClick(map, isValid, latlng, direccion, customIcon, id) {
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
                if (response === "success") {
                    console.log("Parada insertada con éxito.");

                    // Crea un nuevo marcador en el mapa
                    const marker = L.marker([latlng.lat, latlng.lng], {
                        icon: customIcon,
                    }).addTo(map);

                    // Actualiza el ID y agrega una ventana emergente al marcador
                    id += 1;
                    marker.bindPopup("<b>" + id + "</b><p>" + direccion + "</p><p>" + latlng.lat + ", " + latlng.lng + "</p>");

                    // Cierra la ventana emergente actual
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
        // Agregar un mensaje personalizado para el usuario o eliminar el botón
    }
}

export { stopsMapOnClick, paradasLoopThrough, paradasCustomIcons, newMap };
