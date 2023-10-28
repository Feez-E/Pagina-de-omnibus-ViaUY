console.log(unidad);
console.log(caracts);
console.log(params);

const bus = document.querySelector(".bus");

const id = bus.id;

if (id === "oneFloor") {
    if (bus.classList.contains("bathroom")) {
        oneFloorTable(bus, true);
    } else {
        oneFloorTable(bus, false);
    }
} else {
    const fstFloor = bus.firstElementChild;
    const sndFloor = bus.lastElementChild;
    if (fstFloor.classList.contains("bathroom")) {
        twoFloorsTable(fstFloor, sndFloor, true)
    } else {
        twoFloorsTable(fstFloor, sndFloor, false)
    }
}

dataToSend = {
    nombreLinea: params["nombreLinea"],
    unidad: parseInt(unidad['numero']),
    idInicial: parseInt(params['subida']),
    idFinal: parseInt(params['bajada']),
    fecha: params["dia"],
    horaSalida: params["horaSalida"],
    horaLlegada: params["horaLLegada"],
};

console.log(dataToSend)
reservationsAJAX(dataToSend)

function oneFloorTable(floor, bathroom) {

    // Crea un tableulario dinámico
    var table = document.createElement('table');
    table.className = "busTable fstFloor"

    let seatNumber = 1;

    if (bathroom) {
        // Crear filas y celdas
        for (var i = 0; i < 12; i++) {
            var row = table.insertRow(i);
            for (var j = 0; j < 5; j++) {
                var cell = row.insertCell(j);
                // Verificar las condiciones
                if (j === 2) {
                    if (i < 12) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else if (i === 8 || i === 9 || i === 11) {
                    if (j >= 3) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else {
                    seatNumber = createSeat(cell, seatNumber);
                }
            }
        }
    } else {
        // Crear filas y celdas
        for (var i = 0; i < 12; i++) {
            var row = table.insertRow(i);
            for (var j = 0; j < 5; j++) {
                var cell = row.insertCell(j);
                // Verificar las condiciones
                if (j === 2) {
                    if (i < 11) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else if (i === 8 || i === 9) {
                    if (j >= 3) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else {
                    seatNumber = createSeat(cell, seatNumber);
                }
            }
        }
    }

    // Agrega el tableulario al cuerpo del documento y envíalo
    floor.appendChild(table);

}

function twoFloorsTable(fstFloor, sndFloor, bathroom) {

    // Crea un tableulario dinámico
    var table = document.createElement('table');
    table.className = "busTable fstFloor";
    var sndTable = document.createElement('table');
    sndTable.className = "busTable sndFloor";

    let seatNumber = 1;

    if (bathroom) {
        // Crear filas y celdas
        for (var i = 0; i < 11; i++) {
            var row = table.insertRow(i);
            for (var j = 0; j < 5; j++) {
                var cell = row.insertCell(j);
                // Verificar las condiciones
                if (j === 2) {
                    if (i < 12) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        // Llena la celda con contenido
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else if (i === 8 || i === 9 || i === 11) {
                    if (j >= 3) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        // Llena la celda con contenido
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else {
                    // Llena la celda con contenido
                    seatNumber = createSeat(cell, seatNumber);
                }
            }
        }

        for (var i = 0; i < 13; i++) {
            var row = sndTable.insertRow(i);
            for (var j = 0; j < 5; j++) {
                var cell = row.insertCell(j);
                // Verificar las condiciones
                if (j === 2) {
                    if (i < 13) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        // Llena la celda con contenido
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else if (i > 10) {
                    if (j < 3) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        // Llena la celda con contenido
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else {
                    // Llena la celda con contenido
                    seatNumber = createSeat(cell, seatNumber);
                }
            }
        }
    } else {
        // Crear filas y celdas
        for (var i = 0; i < 12; i++) {
            var row = table.insertRow(i);
            for (var j = 0; j < 5; j++) {
                var cell = row.insertCell(j);
                // Verificar las condiciones
                if (j === 2) {
                    if (i < 12) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        // Llena la celda con contenido
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else if (i === 8 || i === 9) {
                    if (j >= 3) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        // Llena la celda con contenido
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else if (i > 10) {
                    if (j < 3) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        // Llena la celda con contenido
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else {
                    // Llena la celda con contenido
                    seatNumber = createSeat(cell, seatNumber);
                }
            }
        }

        for (var i = 0; i < 13; i++) {
            var row = sndTable.insertRow(i);
            for (var j = 0; j < 5; j++) {
                var cell = row.insertCell(j);
                // Verificar las condiciones
                if (j === 2) {
                    if (i < 13) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        // Llena la celda con contenido
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else if (i === 12) {
                    if (j < 3) {
                        // Deja la celda vacía
                        cell.textContent = "";
                    } else {
                        // Llena la celda con contenido
                        seatNumber = createSeat(cell, seatNumber);
                    }
                } else {
                    // Llena la celda con contenido
                    seatNumber = createSeat(cell, seatNumber);
                }
            }
        }
    }

    // Agrega el tableulario al cuerpo del documento y envíalo
    fstFloor.appendChild(table);
    sndFloor.appendChild(sndTable);

}

function createSeat(cell, seatNumber) {
    cell.id = "seat_" + seatNumber;
    cell.innerHTML = `<span>${seatNumber}</span><div class = reserves><p class = subtitle>Tramos reservados:</p></div>`;
    seatNumber += 1;
    return seatNumber;
}

function reservationsAJAX(dataToSend) {

    $.ajax({
        url: "getReservations.php",
        type: "POST",
        data: dataToSend,
        success: (response) => {

            if (response.status === "success") {

                if (response.tramos) {
                    console.log(response.tramos)
                    response.tramos.forEach(tramo => {
                        const numeroAsiento = tramo["numeroAsiento"]
                        console.log(numeroAsiento);
                        let asiento = document.getElementById("seat_" + numeroAsiento);
                        asiento.firstElementChild.classList.add("notValid");

                        const reserveParagraph = document.createElement("p");
                        reserveParagraph.className = "seatReserve";
                        reserveParagraph.innerHTML = ` (${tramo["idInicial"]}, ${tramo["idFinal"]})`;
                        asiento.lastElementChild.appendChild(reserveParagraph)
                    });

                }
                const reserves = document.querySelectorAll(".reserves")
                reserves.forEach(reserve => {
                    if (reserve.innerHTML.trim() == '<p class="subtitle">Tramos reservados:</p>') {
                        reserve.remove();
                    }
                });

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