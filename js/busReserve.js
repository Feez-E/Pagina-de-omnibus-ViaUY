import { showError } from "./components.js";

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

let precio = 0;
let precioTotal = 0;
let asientosSeleccionados = [];

const payButton = document.querySelector(".button.payButton")
const dataToSend = {
    nombreLinea: params["nombreLinea"],
    unidad: parseInt(unidad['numero']),
    idInicial: parseInt(params['subida']),
    idFinal: parseInt(params['bajada']),
    fecha: params["dia"],
    horaSalida: params["horaSalida"],
    horaLlegada: params["horaLLegada"],
};

reservationsAJAX(dataToSend)
calcularPrecios();
payButtonOnClick(payButton);
const checkOutForm = document.getElementById("form");
checkOutFormSubmit(checkOutForm)


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



    AJAX();
    setInterval(() => {
        AJAX();
    }, 2000); // Realiza una solicitud cada 5 segundos (ajusta el intervalo según tus necesidades)


    function AJAX() {
        $.ajax({
            url: "getReservations.php",
            type: "POST",
            data: dataToSend,
            success: (response) => {
                if (response.status === "success") {
                    if (response.tramos) {
                        // Actualiza la página con los datos recibidos
                        actualizarPaginaConDatos(response.tramos);
                    }
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
}

let occupiedSeats = []

function actualizarPaginaConDatos(tramos) {
    // Procesa los datos de tramos y actualiza la página según tus necesidades
    tramos.forEach((tramo) => {
        // Aquí puedes realizar las actualizaciones en la página
        const numeroAsiento = tramo.numeroAsiento;
        const asiento = document.getElementById("seat_" + numeroAsiento);

        // Realiza las actualizaciones necesarias en la página
        asiento.firstElementChild.classList.add("notValid");


        if (!(occupiedSeats.includes(`${numeroAsiento}, ${tramo.idInicial},  ${tramo.idFinal}`))) {
            occupiedSeats.push(`${numeroAsiento}, ${tramo.idInicial},  ${tramo.idFinal}`);
            const reserveParagraph = document.createElement("p");
            reserveParagraph.className = "seatReserve";
            reserveParagraph.innerHTML = ` (${tramo.idInicial}, ${tramo.idFinal})`;
            asiento.lastElementChild.appendChild(reserveParagraph);
        }


    });

    const reserves = document.querySelectorAll(".reserves");
    const seatsAndPrices = document.getElementById("seatsAndPrices");
    reserves.forEach((reserve) => {
        if (reserve.innerHTML.trim() == '<p class="subtitle">Tramos reservados:</p>') {
            seatOnClick(reserve.previousElementSibling, seatsAndPrices);
        } else {
            reserve.previousElementSibling.onclick = null;
        }
    });
}

function seatOnClick(seat, seatsDiv) {
    seat.onclick = function seatOnClick() {
        if (!seat.className) {
            seat.classList.add("semiValid");

            if (seatsDiv.innerHTML.trim() === "<p>Seleccione uno o más asientos</p>") {
                seatsDiv.innerHTML = `<div class = "seatAndPrice title"><p class = seat>Asiento</p><p class = price>Precio</p></div>`;
            }

            const seatSplit = seat.parentElement.id.split("_");
            const seatNumber = seatSplit[1];

            const seatDiv = document.createElement("div");
            seatDiv.className = `seatAndPrice ${seat.parentElement.id}`;
            seatDiv.innerHTML = `<p class = seat>${seatNumber}</p><p class = price>$<span>${precio.toFixed(2)}</span></p>`;
            asientosSeleccionados.push(seatNumber);
            precioTotal += precio;

            const totalDiv = document.createElement("div");
            totalDiv.className = `seatAndPrice total`;
            totalDiv.innerHTML = `<p class = seat> Total</p><p class = price>$${precioTotal.toFixed(2)}</p>`;

            const actualTotalDiv = seatsDiv.querySelector(`.total`);
            if (actualTotalDiv) {
                seatsDiv.removeChild(actualTotalDiv);
            }

            seatsDiv.appendChild(seatDiv);
            seatsDiv.appendChild(totalDiv);
        } else {
            precioTotal -= precio;
            seat.classList.remove("semiValid");
            const seatDiv = seatsDiv.querySelector(`.${seat.parentElement.id}`);
            const seatSplit = seat.parentElement.id.split("_");
            const seatNumber = seatSplit[1];

            asientosSeleccionados.splice(asientosSeleccionados.indexOf(seatNumber), 1);
            seatsDiv.removeChild(seatDiv);

            const actualTotalDiv = seatsDiv.querySelector(`.total`);
            if (actualTotalDiv) {
                seatsDiv.removeChild(actualTotalDiv);
            }


            if (seatsDiv.innerHTML.trim() === `<div class="seatAndPrice title"><p class="seat">Asiento</p><p class="price">Precio</p></div>`) {
                seatsDiv.innerHTML = "<p>Seleccione uno o más asientos</p>";
                payButton.parentElement.classList.remove("active");
            } else {

                const totalDiv = document.createElement("div");
                totalDiv.className = `seatAndPrice total`;
                totalDiv.innerHTML = `<p class = seat> Total</p><p class = price>$${precioTotal.toFixed(2)}</p>`;

                seatsDiv.appendChild(totalDiv);
            }


        }
    }
}

function seatPriceAJAX(unitNumber, startId, endId) {
    return new Promise((resolve, reject) => {
        const dataToSend = {
            unidad: unitNumber,
            idInicial: startId,
            idFinal: endId
        };

        $.ajax({
            url: "getPrice.php",
            type: "POST",
            data: dataToSend,
            success: (response) => {
                if (response.status === "success" && response.precio) {
                    resolve(response.precio);
                } else {
                    reject("Error al obtener el precio.");
                }
            },
            error: (xhr, _status, error) => {
                reject("Error en la solicitud AJAX: " + error);
            },
        });
    });
}

async function calcularPrecios() {
    precio = 0;

    for (let i = 0; i < params["paradas"].length - 1; i++) {
        try {
            const precioTramo = await seatPriceAJAX(unidad["numero"], params["paradas"][i], params["paradas"][i + 1]);
            precio += precioTramo;
        } catch (error) {
        }
    }
}

function payButtonOnClick(payButton) {
    payButton.nextElementSibling.onclick = () => {
        payButton.parentElement.classList.remove("active");
    };
    payButton.onclick = () => {

        if (precioTotal.toFixed(1) > 0) {
            console.log(precioTotal)
            console.log(asientosSeleccionados)
            payButton.parentElement.classList.add("active");

        } else {
            showError("No hay asientos seleccionados");
        }
    }
}

function checkOutFormSubmit(form) {
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        var metodosDePago = document.getElementById("metodosDePago").value;

        if (metodosDePago != "Default") {
            // Crea campos de entrada ocultos para los datos
            var precioTotalInput = document.createElement('input');
            precioTotalInput.type = 'hidden';
            precioTotalInput.name = 'precioTotal';
            precioTotalInput.value = JSON.stringify(precioTotal);
            form.appendChild(precioTotalInput);

            var paramsInput = document.createElement('input');
            paramsInput.type = 'hidden';
            paramsInput.name = 'params';
            paramsInput.value = JSON.stringify(params);
            form.appendChild(paramsInput);

            var unidadInput = document.createElement('input');
            unidadInput.type = 'hidden';
            unidadInput.name = 'unidad';
            unidadInput.value = JSON.stringify(unidad);
            form.appendChild(unidadInput);

            var asientosInput = document.createElement('input');
            asientosInput.type = 'hidden';
            asientosInput.name = 'asientos';
            asientosInput.value = JSON.stringify(asientosSeleccionados);
            form.appendChild(asientosInput);

            // Envía el formulario
            form.submit();
        } else {
            showError("Por favor, seleccione un método de pago")
        }

    });
}