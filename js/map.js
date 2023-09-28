// Crea un mapa Leaflet y establece la vista en una ubicación específica
var map = L.map("stopAndSectionMap").setView([-34.568537501229486, -56.01135368875827], 9);

// Agrega una capa de mosaico de OpenStreetMap al mapa
L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

// Itera a través de un array de paradas y crea marcadores en el mapa para cada una
for (var i = 0; i < paradasArray.length; i++) {
    var parada = paradasArray[i];

    // Accede a las propiedades de cada objeto 'parada'
    var id = parada.id;
    var direccion = parada.direccion;
    var coordenadas = parada.coordenadas;
    var vigencia = parada.vigencia;

    // Divide las coordenadas en latitud y longitud
    var coordenadasArray = parada.coordenadas.split(",");
    var latitud = parseFloat(coordenadasArray[0]);
    var longitud = parseFloat(coordenadasArray[1]);

    // Crea íconos personalizados para los marcadores
    var customIcon = L.AwesomeMarkers.icon({
        icon: "bus",
        markerColor: "blue",
        prefix: "fa",
    });
    var customIconFalse = L.AwesomeMarkers.icon({
        icon: "times",
        markerColor: "red",
        prefix: "fa",
    });

    // Verifica si las coordenadas son números válidos antes de crear el marcador
    if (!isNaN(latitud) && !isNaN(longitud)) {
        // Crea un marcador con las coordenadas válidas y el ícono personalizado correspondiente
        var marker = L.marker([latitud, longitud], { icon: vigencia ? customIcon : customIconFalse }).addTo(map);

        // Agrega una ventana emergente al marcador con información de la parada
        marker.bindPopup("<b>" + id + "</b><p>"+ direccion +"</p><p>" + latitud + ", " + longitud+ "</p>");
    }
}

// Crea una ventana emergente Leaflet
var popup = L.popup();

// Agrega un evento de clic al mapa
map.on("click", (e) => {
    // Inicializa una variable para verificar la validez de la ubicación
    isValid = false;
    latlng = e.latlng;

    // Configura el contenido de la ventana emergente
    popup
        .setLatLng(latlng)
        .setContent("<p>" + latlng.toString() + "</p><div class='buttons'><a class='button' id='popupButton'>a</a></div>")
        .openOn(map);

    // Construye la URL para la búsqueda inversa de Nominatim
    var nominatimUrl = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}`;

    // Realiza una solicitud AJAX para obtener información de la ubicación
    $.ajax({
        url: nominatimUrl,
        dataType: "json",
        success: function (data) {
            if (data.display_name) {
                // Obtiene información de dirección desde la respuesta JSON
                var address = data.display_name;
                var road = data.address.road;
                var state = data.address.state;

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
                }
            } else {
                console.log("Dirección no encontrada.");
                direccion = "Dirección no encontrada.";
            }
        },
        error: function (xhr, status, error) {
            console.error("Error al obtener la dirección:", error);
            direccion = "Error al obtener la dirección.";
        },
    });

    // Obtiene el botón de la ventana emergente y le asigna una función de clic
    button = document.getElementById("popupButton");
    button.onclick = buttonOnClick;
});

// Función que se ejecuta al hacer clic en el botón de la ventana emergente
function buttonOnClick() {
    console.log("Latitud: " + latlng.lat + " Longitud: " + latlng.lng);

    // Prepara los datos para enviar al servidor
    var coordenadas = latlng.lat + ", " + latlng.lng;

    // Objeto de datos a enviar en la solicitud AJAX
    var dataToSend = {
        direccion: direccion,
        coordenadas: coordenadas,
    };

    // Realiza una solicitud AJAX al servidor
    if (isValid) {
        $.ajax({
            url: "stopInsert.php",
            type: "POST",
            data: dataToSend,
            success: function (response) {
                if (response === "success") {
                    console.log("Parada insertada con éxito.");

                    // Crea un nuevo marcador en el mapa
                    var marker = L.marker([latlng.lat, latlng.lng], {
                        icon: customIcon,
                    }).addTo(map);

                    // Actualiza el ID y agrega una ventana emergente al marcador
                    id += 1;
                    marker.bindPopup("<b>" + id + "</b><p>"+ direccion +"</p><p>" + latlng.lat + ", " + latlng.lng+ "</p>");

                    // Cierra la ventana emergente actual
                    map.closePopup(popup);
                } else {
                    console.log("Error al insertar la parada.");
                    console.log(response);
                }
            },
            error: function () {
                console.log("Error en la solicitud AJAX.");
            },
        });
    } else {
        console.log("Lugar inválido");
        // Agregar un mensaje para el usuario o eliminar el botón
    }
}
