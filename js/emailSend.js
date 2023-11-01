function ajaxForDataInsert() {
    let dataToSend = {
        fechaTiquet: fechaTiquet,
        precio: precio,

        // Asientos
        asientos: asientos,
        tramos: tramos,
        nombreLinea: nombreLinea,
        unidad: unidad,
        horaSalida: horaSalida,
        horaLlegada: horaLlegada,

        //Reserva
        idUsuario: idUsuario,
        metodoDePago: metodoDePago,
        fechaReserva: fecha,

    };

    $.ajax({
        url: "reserveDataInsert.php",
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
}