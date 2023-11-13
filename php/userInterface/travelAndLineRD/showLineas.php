<?php
// Incluir archivos necesarios
include_once('../../dataAccess/connection.php');
include_once('../../dataAccess/lineaLink.php');
include_once('../../dataAccess/transitaLink.php');
include_once('../../dataAccess/paradaLink.php');
include_once('../../dataAccess/tramoLink.php');
include_once('../../dataAccess/linea_diaHabilLink.php');

// Inicializar conexiones a la base de datos
$lineaLink = new LineaLink($conn);
$lineasArr = $lineaLink->getLineas();

$transitaLink = new TransitaLink($conn);
$transitasArr = $transitaLink->getTransitasAndRecorre();
$indice = 0;

$paradaLink = new ParadaLink($conn);
$tramoLink = new TramoLink($conn);
$linea_diaHabilLink = new Linea_diaHabilLink($conn);

$array = array();

foreach ($lineasArr as $linea) {
    $codigoLinea = $linea->getCodigo();

    if (array_key_exists($indice, $transitasArr)) {
        $horaSalida = $transitasArr[$indice]->getHoraSalida_Salida();
    }
    $linea_diasHabilesArr = $linea_diaHabilLink->getLinea_diaHabilByCodigo_Linea($linea->getCodigo());

    // Generar HTML para las líneas de autobuses
    echo "<div class='lineAndTravels travelAndLinePage shadow'>
            <div class='line'>
                <div class='lineLeft'>
                    <h3 class='subtitle'>" . $linea->getNombre() . " - " . $linea->getOrigen() . " " . $linea->getDestino() . "</h3>
                    <div class='days'>";
    $checked = $linea->getVigencia() ? "checked" : "";
    echo "<label class='switch'>
                        <input type='checkbox' $checked class='lineValidation'>
                        <span class='slider round'></span>
                    </label>
                    <section class='lineDays'>
                        <p>";
    foreach ($linea_diasHabilesArr as $linea_diasHabil) {
        echo "" . $linea_diasHabil->getDia() . " ";
    }
    echo "          </p>
                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none'
                            stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'
                            class='feather feather-tool'>
                            <path d='M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z'></path>
                        </svg>
                    </section>
                </div>
            </div>
            <div>
            </div>
            <div id='lineToggle'></div>
        </div>
        <div class='travels travelAndLine'>
            <div class='lineData'></div>
            <div class='desplegableSection travelAndLinePage travelSection'>";
    $fstLine = true;
    $fstTravel = true;
    while ($indice < count($transitasArr)) {
        if ($codigoLinea == $transitasArr[$indice]->getCodigo_L_Recorre()) {
            if ($horaSalida == $transitasArr[$indice]->getHoraSalida_Salida()) {
                if ($fstLine) {
                    $fstLine = false;
                    if ($transitasArr[$indice]->getHoraSalida_Salida()) {
                        transitasContent($transitasArr, $indice);
                    } else {
                        echo "<p class='lineWOTravels'> Esta linea no tiene horarios</p>";
                    }
                }
                if ($fstTravel) {
                    $array[$codigoLinea]["Salidas"][] = $transitasArr[$indice]->getIdInicial_T_Recorre();
                    $array[$codigoLinea]["Llegadas"][] = $transitasArr[$indice]->getIdFinal_T_Recorre();
                }
                //? Trabajar con cada viaje específicamente aquí
            } else {
                echo "
                        </div>
                    </div>
                    <div class='desplegableSection travelAndLinePage travelSection'>";
                if ($transitasArr[$indice]->getHoraSalida_Salida()) {
                    transitasContent($transitasArr, $indice);
                }
                $horaSalida = $transitasArr[$indice]->getHoraSalida_Salida();
                $indice -= 1;
                $fstTravel = false;
            }
        } else {
            $horaSalida = new DateTime($transitasArr[$indice]->getHoraSalida_Salida());
            break;
        }
        $indice += 1;
    }
    echo "
                </div>
            </div>
        </div>
    </div>";

}

function transitasContent($transitasArr, $indice)
{
    echo "
    <div class='desplegableTitle'>
        <div class='desplegableSubtitle'> 
            <p> Unidad: " . $transitasArr[$indice]->getNumero_Unidad() . "</p>
            <p> Salida: " . $transitasArr[$indice]->getHoraSalida_Salida() . "</p>
        </div>
        <div id='toggleArrow'></div>
    </div>
    <div class='desplegableContent'>
        <p class='subtitle'> Horario </p>
        <p class='salida'> Salida: <span>" . $transitasArr[$indice]->getHoraSalida_Salida() . "</span></p>
        <p class='llegada'> Llegada:" . $transitasArr[$indice]->getHoraLlegada_Llegada() . "</p>
        <div class='unitInfo'>
            <p class='subtitle'> Características: </p>
            <p> Caracteristica </p>
        </div>";
}
?>


<script>
    let stopsIds = <?php echo json_encode(array_values($array)); ?>;

    let allLineData = document.querySelectorAll('.lineData');


    console.log(stopsIds);
    allLineData.forEach((lineData, i) => {
        let formattedData = '';

        if (stopsIds[i] && stopsIds[i].Salidas !== undefined) {
            for (let j = 0; j < stopsIds[i].Salidas.length; j++) {
                if (stopsIds[i].Salidas[j] && stopsIds[i].Llegadas[j]) {
                    formattedData += `(${stopsIds[i].Salidas[j]}, ${stopsIds[i].Llegadas[j]})`;
                    if (j < stopsIds[i].Salidas.length - 1) {
                        formattedData += ' ';
                    }
                }
            }
        } else {
            formattedData = "no";
        }
        lineData.innerHTML = `<p class ="subtitle">Tramos </p><p> ${formattedData} </p>`;
    });

    const travelSection = document.querySelectorAll('.travelSection');
    travelSection.forEach(travel => {
        if (travel.querySelector(".salida span") !== null) {
            const horaSalida = travel.querySelector(".salida span").innerHTML;
            const nombreLineaOrigenDestino = travel.parentElement.previousElementSibling.firstElementChild.firstElementChild.innerHTML.split(" - ");
            const nombreLinea = nombreLineaOrigenDestino[0];
            let unitInfo = travel.querySelector(".unitInfo");

            let dataToSend = {
                nombreLinea: nombreLinea,
                horaSalida: horaSalida
            };

            $.ajax({
                url: "../busLookUp/getUnit.php",
                type: "POST",
                data: dataToSend,
                success: (response) => {

                    if (response.status === "success") {

                        if (response.unidad) {
                            unidad = response.unidad;
                            caracts = response.caracteristicas;
                            const caractsHTML = caracts.map(time => `<p class = caract><span>${time.propiedad}</span><span> ×${time.multiplicador}</span></p>`).join('');
                            unitInfo.innerHTML = `
                                <p class = subtitle> Unidad </p>
                                <p> Número: ${response.unidad.numero} </p>
                                <p> Matrícula: ${response.unidad.matricula} </p>
                                <p> N° chasis: ${response.unidad.numeroChasis} </p>
                                <p> Capacidad 1° piso: ${response.unidad.capacidadPrimerPiso} </p>
                                <p> Capacidad 2° piso: ${response.unidad.capacidadSegundoPiso} </p>
                                <div class = caracts>
                                <p class = subtitle> Características </p>
                                    ${caractsHTML}
                                </div>
                             `;
                        } else if (response.error) {
                            showError(response.error);
                        } else {
                            showError("Lo sentimos, hubo un error");
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
    });

    const lineValidations = document.querySelectorAll(".lineValidation")

    lineValidations.forEach(lineValidation => {
        lineValidation.onclick = () => {


            const nombreLineaOrigenDestino = lineValidation.parentElement.parentElement.previousElementSibling.innerHTML.split(" - ");
            const nombreLinea = nombreLineaOrigenDestino[0];
            console.log(nombreLinea);

            const dataToSend = {
                nombre: nombreLinea,
            };

            $.ajax({
                url: "lineValidationToggle.php",
                type: "POST",
                data: dataToSend,
                success: (response) => {

                    if (response === "success") {


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
    });

    const dias = ["L", "M", "X", "J", "V", "S", "D"]
    const dayMods = document.querySelectorAll(".lineDays svg");
    dayMods.forEach(dayMod => {
        dayMod.onclick = () => {
            const lineDays = dayMod.parentElement;
            lineDays.classList.add("active");



            let days = dayMod.previousElementSibling.innerText.split(" ");
            const nombreLineaOrigenDestino = dayMod.parentElement.parentElement.previousElementSibling.innerHTML.split(" - ");
            const nombreLinea = nombreLineaOrigenDestino[0];
            lineDays.innerHTML = "";

            dias.forEach((dia) => {

                daysIncludesDia = days.includes(dia);
                const diaDiv = document.createElement("div");
                diaDiv.className = "";
                diaDiv.innerHTML = `
                    <p>${dia}</p><label class="switch">
                        <input type="checkbox"  class="lineValidation" ${daysIncludesDia ? "checked" : ""}>
                        <span class="slider round"></span>
                    </label>`;
                lineDays.appendChild(diaDiv);

                const daySwitchs = diaDiv.querySelectorAll("input[type=checkbox]")
                daySwitchs.forEach(daySwitch => {
                    daySwitch.onclick = () => {
                        const day = daySwitch.parentElement.previousElementSibling.innerHTML;

                        const dataToSend = {
                            nombre: nombreLinea,
                            diaHabil: day
                        };

                        $.ajax({
                            url: "lineDaysToggle.php",
                            type: "POST",
                            data: dataToSend,
                            success: (response) => {

                                if (response === "deletedLineaDiaHabil") {
                                    console.log("Cambio exitoso");
                                    days = days.filter(item => item !== day);
                                } else if ((response === "addedLineaDiaHabil")) {
                                    console.log("Cambio exitoso");
                                    days.push(day);
                                    days.sort((a, b) => {
                                        return dias.indexOf(a) - dias.indexOf(b);
                                    });
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
                });
            });


            // Agregar un evento de clic al documento para detectar clics fuera de lineDays
            const clickHandler = (e) => {
                if (!lineDays.contains(e.target)) {
                    lineDays.classList.remove("active");
                    document.removeEventListener("click", clickHandler);
                    lineDays.innerHTML = `<p>${days.map(time => `${time}`).join(' ')}</p>`;
                    lineDays.appendChild(dayMod);
                }

            };

            setTimeout(() => {
                document.addEventListener("click", clickHandler);
            }, .1);

        }

    });
</script>