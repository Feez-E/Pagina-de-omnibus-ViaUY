<?php
require './busInfo.php';

foreach ($unidades as $key => $unidad) {

    echo '
    <div class="desplegableSection shadow unitSection">
        <div class="desplegableTitle">
            <label class="switch">
                <input type="checkbox"' . ($unidad["vigencia"] ? "checked" : "") . ' class="unitValidation">
                <span class="slider round"></span>
            </label>   
            <div>

                <h3>N° ' . $unidad["numero"] . '</h3>
                <p>Amplíe para más información</p>
            </div>
            <div id="toggleArrow"></div>
        </div>
        <div class="desplegableContent">
            <p class ="subtitle">General </p> 
            <section class ="general">
                <p>Matrícula: ' . $unidad["matricula"] . '</p>
                <p>N° chasis: ' . $unidad["numeroChasis"] . '</p>
                <p>Capacidad 1° piso: ' . $unidad["capacidadPrimerPiso"] . '</p>
                <p>capacidad 2° piso: ' . $unidad["capacidadSegundoPiso"] . '</p>
            </section>
            <section class ="caracts">
                <p class="subtitle">Características</p>';
    foreach ($unidad["caracteristicas"] as $key => $caracteristica) {
        echo '
                <p> 
                    <span class = caract>' . $caracteristica["caracteristica"] . '</span>
                    <span class = multiplyer> ×' . $caracteristica["multiplicador"] . '</span> 
                </p>
        ';
    }


    echo '
            </section>
        </div>
    </div>
    ';
}